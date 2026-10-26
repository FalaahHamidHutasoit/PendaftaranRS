<?php

namespace App\Libraries;

/**
 * v7: Referensi rekam medis — daftar diagnosis ICD-10 terkurasi untuk
 * klinik kampus (bukan database ICD-10 lengkap, yang tidak realistis
 * untuk UTS), rentang kewajaran tanda vital, dan label field untuk
 * riwayat revisi. Satu sumber kebenaran dipakai form, pratinjau,
 * simpan, ubah, dan detail supaya tidak ada daftar yang menyimpang.
 */
class RekamMedisReferensi
{
    /** ~30 diagnosis umum klinik kampus: kode ICD-10 => label Indonesia. */
    public static function diagnosisList(): array
    {
        return [
            'J00' => 'Nasofaringitis akut (pilek)',
            'J01' => 'Sinusitis akut',
            'J02' => 'Faringitis akut (radang tenggorokan)',
            'J03' => 'Tonsilitis akut (radang amandel)',
            'J06' => 'Infeksi saluran pernapasan atas akut (ISPA atas)',
            'J11' => 'Influenza',
            'J20' => 'Bronkitis akut',
            'J30' => 'Rinitis alergi',
            'J45' => 'Asma',
            'K02' => 'Karies gigi',
            'K05' => 'Gingivitis (radang gusi)',
            'K08' => 'Gangguan gigi dan jaringan penyangga lainnya',
            'L20' => 'Dermatitis atopik (eksim)',
            'L30' => 'Dermatitis lainnya',
            'L50' => 'Urtikaria (biduran)',
            'M54' => 'Nyeri punggung',
            'M79' => 'Mialgia (nyeri otot)',
            'R05' => 'Batuk',
            'R10' => 'Nyeri perut',
            'R11' => 'Mual dan muntah',
            'R42' => 'Pusing',
            'R50' => 'Demam',
            'R51' => 'Sakit kepala',
            'R53' => 'Kelelahan (malaise)',
            'A09' => 'Diare dan gastroenteritis',
            'E11' => 'Diabetes melitus tipe 2',
            'I10' => 'Hipertensi esensial',
            'H10' => 'Konjungtivitis (mata merah)',
            'H66' => 'Otitis media (radang telinga tengah)',
            'G43' => 'Migrain',
        ];
    }

    /** Rentang kewajaran tanda vital (pemeriksaan kewajaran input, bukan alat diagnosis). */
    public static function ttvRanges(): array
    {
        return [
            'ttv_sistolik'  => ['min' => 70, 'max' => 250, 'label' => 'Tekanan darah sistolik', 'satuan' => 'mmHg'],
            'ttv_diastolik' => ['min' => 40, 'max' => 150, 'label' => 'Tekanan darah diastolik', 'satuan' => 'mmHg'],
            'ttv_nadi'      => ['min' => 30, 'max' => 200, 'label' => 'Nadi', 'satuan' => 'x/menit'],
            'ttv_napas'     => ['min' => 8, 'max' => 60, 'label' => 'Laju napas', 'satuan' => 'x/menit'],
            'ttv_suhu'      => ['min' => 35, 'max' => 42, 'label' => 'Suhu tubuh', 'satuan' => '°C'],
            'ttv_spo2'      => ['min' => 70, 'max' => 100, 'label' => 'Saturasi oksigen (SpO2)', 'satuan' => '%'],
        ];
    }

    /** Label Indonesia untuk setiap field rekam medis yang bisa direvisi. */
    public static function fieldLabels(): array
    {
        return [
            'tanggal_periksa'   => 'Tanggal periksa',
            'keluhan'           => 'Keluhan (S)',
            'alergi'            => 'Alergi',
            'ttv_sistolik'      => 'Tekanan darah sistolik',
            'ttv_diastolik'     => 'Tekanan darah diastolik',
            'ttv_nadi'          => 'Nadi',
            'ttv_napas'         => 'Laju napas',
            'ttv_suhu'          => 'Suhu tubuh',
            'ttv_spo2'          => 'SpO2',
            'pemeriksaan_fisik' => 'Pemeriksaan fisik (O)',
            'kode_diagnosis'    => 'Kode diagnosis',
            'diagnosis'         => 'Diagnosis (A)',
            'tindakan'          => 'Tindakan (P)',
            'resep'             => 'Resep (P)',
            'rencana'           => 'Rencana tindak lanjut (P)',
            'catatan'           => 'Catatan',
        ];
    }

    /** Format satu baris resep terstruktur dari komponennya. */
    public static function formatResepBaris(string $obat, string $dosis, string $frekuensi, string $jumlah, string $aturan): string
    {
        $bagian = [trim($obat), trim($dosis), trim($frekuensi)];
        if (trim($jumlah) !== '') {
            $bagian[] = trim($jumlah);
        }
        if (trim($aturan) !== '') {
            $bagian[] = trim($aturan);
        }
        return implode(' — ', $bagian);
    }

    /** Pecah teks resep tersimpan kembali menjadi baris-baris komponen. */
    public static function parseResep(string $resep): array
    {
        $resep = trim($resep);
        if ($resep === '' || $resep === 'Tanpa obat') {
            return [];
        }
        $baris = [];
        foreach (preg_split('/\r\n|\r|\n/', $resep) as $line) {
            $line = trim($line);
            if ($line === '') {
                continue;
            }
            $parts = array_map('trim', explode(' — ', $line));
            $baris[] = [
                'obat'      => $parts[0] ?? '',
                'dosis'     => $parts[1] ?? '',
                'frekuensi' => $parts[2] ?? '',
                'jumlah'    => $parts[3] ?? '',
                'aturan'    => $parts[4] ?? '',
            ];
        }
        return $baris;
    }
}
