<?php

namespace App\Libraries;

use Config\Database;

/**
 * v7: Dua kode rumah sakit umum, sesuai riset (bukan satu nomor saja).
 *
 * - Kode antrean (publik, untuk dipanggil/ditampilkan): huruf poli +
 *   nomor urut 3 digit per jadwal, mis. U012. Huruf = poli.kode_antrean
 *   (U = Poli Umum, G = Poli Gigi). Karena satu jadwal = satu tanggal +
 *   satu dokter, nomor urut per jadwal otomatis berlaku per tanggal.
 *   Catatan jujur: "mulai 001 per jadwal per tanggal" adalah konvensi
 *   implementasi dari pola yang ditemukan di riset, bukan aturan yang
 *   dikutip eksplisit dari situs rumah sakit.
 * - Kode booking (kunci check-in, acak, tidak berurutan): 8 karakter dari
 *   alfabet yang tidak mudah tertukar (tanpa I, O, L, 0, 1), unik di DB.
 *   QR hanya berisi teks kode booking ini saja — tanpa NIK, nama,
 *   diagnosis, atau URL (alasan privasi dari riset).
 * - no_antrean internal tetap dipertahankan untuk urutan panggil; yang
 *   berubah adalah tampilannya, bukan logika antreannya.
 */
class KodeAntrean
{
    /** Alfabet kode booking: A-Z tanpa I/O/L + angka 2-9 tanpa 0/1. */
    public const ALFABET_BOOKING = 'ABCDEFGHJKMNPQRSTUVWXYZ23456789';

    /**
     * Huruf poli untuk kode antrean. Prioritas: kolom kode_antrean poli,
     * lalu huruf pertama nama poli, lalu 'X' sebagai pengaman terakhir.
     */
    public static function hurufPoli(array $poli): string
    {
        // Dua bentuk masukan: baris poli langsung (kode_antrean = huruf)
        // dan baris pendaftaran hasil join (huruf poli dialias
        // kode_antrean_poli; kode_antrean di baris itu adalah kode
        // pendaftaran sendiri, mis. U001, yang TIDAK boleh dipakai
        // sebagai huruf — regex satu huruf di bawah menjaganya).
        foreach (['kode_antrean_poli', 'kode_antrean'] as $kunci) {
            $kode = strtoupper(trim((string) ($poli[$kunci] ?? '')));
            if ($kode !== '' && preg_match('/^[A-Z]$/', $kode)) {
                return $kode;
            }
        }
        $nama = trim((string) ($poli['nama_poli'] ?? ''));
        if ($nama !== '' && preg_match('/^[A-Za-z]/', $nama)) {
            return strtoupper($nama[0]);
        }
        return 'X';
    }

    /** Format kode antrean: huruf + nomor 3 digit (1000+ tetap tampil penuh). */
    public static function format(int $noAntrean, string $huruf): string
    {
        return strtoupper($huruf) . str_pad((string) $noAntrean, 3, '0', STR_PAD_LEFT);
    }

    /** Kode antrean untuk ditampilkan; tidak pernah kosong untuk baris valid. */
    public static function tampil(array $row): string
    {
        $tersimpan = trim((string) ($row['kode_antrean'] ?? ''));
        if ($tersimpan !== '') {
            return $tersimpan;
        }
        return self::format((int) ($row['no_antrean'] ?? 0), self::hurufPoli($row));
    }

    /** Satu kode booking acak (8 karakter, tanpa huruf/angka mudah tertukar). */
    public static function acakBooking(): string
    {
        $alfabet = self::ALFABET_BOOKING;
        $n       = strlen($alfabet);
        $kode    = '';
        for ($i = 0; $i < 8; $i++) {
            $kode .= $alfabet[random_int(0, $n - 1)];
        }
        return $kode;
    }

    /** Kode booking acak yang dijamin belum dipakai (maks 20 percobaan). */
    public static function bookingUnik(): string
    {
        $db = Database::connect();
        for ($i = 0; $i < 20; $i++) {
            $kode = self::acakBooking();
            $ada  = $db->table('pendaftaran')->where('kode_booking', $kode)->countAllResults();
            if ($ada === 0) {
                return $kode;
            }
        }
        // Praktis tidak mungkin tercapai (31^8 kombinasi); pengaman saja.
        return self::acakBooking() . (string) time();
    }

    /**
     * Backfill baris lama tanpa kode, saat baris itu pertama kali
     * ditampilkan. Satu baris saja; bila gagal, baris tetap tampil
     * dengan nilai turunan (kode antrean) dan kode booking kosong
     * (ditampilkan sebagai '-'). Kode antrean turunan ikut disimpan
     * supaya tampilan berikutnya (mis. pesan check-in yang hanya
     * memegang baris pendaftaran) tidak perlu menebak huruf poli lagi.
     * Mengembalikan baris dengan kode_antrean + kode_booking terisi
     * (kode_booking tetap '' bila backfill gagal).
     */
    public static function pastikanKode(array $row): array
    {
        $kodeAntreanLama = trim((string) ($row['kode_antrean'] ?? ''));
        $row['kode_antrean'] = self::tampil($row);
        if (empty($row['id_pendaftaran'])) {
            return $row;
        }
        try {
            $update = [];
            if ($kodeAntreanLama === '') {
                $update['kode_antrean'] = $row['kode_antrean'];
            }
            if (trim((string) ($row['kode_booking'] ?? '')) === '') {
                $update['kode_booking'] = self::bookingUnik();
            }
            if ($update !== []) {
                Database::connect()->table('pendaftaran')
                    ->where('id_pendaftaran', (int) $row['id_pendaftaran'])
                    ->update($update);
                $row = array_merge($row, $update);
            }
        } catch (\Throwable) {
            // Sengaja ditelan: tampilan tidak boleh crash karena backfill.
            if (trim((string) ($row['kode_booking'] ?? '')) === '') {
                $row['kode_booking'] = '';
            }
        }
        return $row;
    }

    /** Terapkan pastikanKode ke setiap baris daftar. */
    public static function pastikanDaftar(array $rows): array
    {
        foreach ($rows as $i => $row) {
            $rows[$i] = self::pastikanKode($row);
        }
        return $rows;
    }
}
