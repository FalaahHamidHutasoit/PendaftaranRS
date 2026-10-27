<?php

namespace App\Libraries;

use App\Models\AuditLogModel;

/**
 * v8: Pencatat audit best-effort untuk alur pasien dan admisi.
 *
 * Dipakai Auth (login sukses/gagal), PendaftaranPasien (registrasi),
 * Pendaftaran (booking/batal), dan Admin (check-in, ubah status,
 * verifikasi BPJS). Melengkapi audit rekam medis yang sudah ada di
 * Dokter (lihat/buat/ubah) — bukan menggantikannya.
 *
 * Best-effort: kegagalan menulis audit TIDAK PERNAH menggagalkan aksi
 * utama (kegagalan hanya dicatat ke log aplikasi). Keterangan audit
 * TIDAK BOLEH berisi kata sandi, NIK, atau nomor BPJS — hanya id dan
 * status. Jangan memanggil helper ini dari filter (mis. AuthFilter):
 * audit per-request akan membanjiri tabel dan memperlambat setiap
 * halaman.
 */
class AuditTrail
{
    public static function catat(?int $idUser, string $aksi, ?int $idPendaftaran, string $keterangan): void
    {
        try {
            (new AuditLogModel())->insert([
                'id_user'        => $idUser,
                'aksi'           => $aksi,
                'id_pendaftaran' => $idPendaftaran,
                'keterangan'     => $keterangan,
            ]);
        } catch (\Throwable $e) {
            log_message('error', 'Gagal mencatat audit ' . $aksi . ': ' . $e->getMessage());
        }
    }
}
