<?php

namespace App\Controllers;

use App\Libraries\KodeAntrean;
use App\Models\PasienModel;

// v6: Halaman utama/Home. Ini rumahnya fitur-fitur dan satu-satunya
// tempat kartu hero antrean besar tampil (selama antrean masih aktif).
// Admin dan dokter TIDAK memakai halaman ini: Beranda mereka adalah
// dashboard masing-masing, jadi keduanya di-redirect ke sana.
// Aturan tampil hero (sama seperti kartu v3/v5 dan badge navigasi):
// hanya pendaftaran dengan status menunggu/dikonfirmasi dan tanggal
// jadwal hari ini atau sesudahnya. Begitu status menjadi selesai
// (atau dibatalkan), baris itu otomatis tidak masuk query ini lagi,
// sehingga kartunya HILANG dari Home — tapi tetap tampil di halaman
// Antrean Saya (/pendaftaran), yang menampilkan semua status tanpa
// filter aktif. Satu nomor per jadwal tetap berlaku; pasien boleh
// punya antrean aktif di jadwal berbeda, masing-masing tampil
// sebagai satu kartu hero sendiri, urut tanggal lalu jam lalu nomor.
class Beranda extends BaseController
{
    public function index()
    {
        $role = (string) session()->get('role');
        if (session()->get('isLoggedIn') && $role === 'admin') {
            return redirect()->to('/admin');
        }
        if (session()->get('isLoggedIn') && $role === 'dokter') {
            return redirect()->to('/dokter');
        }
        $antreanAktif = [];
        if (session()->get('isLoggedIn') && $role === 'pasien') {
            $pasien = (new PasienModel())->where('id_user', session()->get('id_user'))->first();
            if ($pasien) {
                $db = \Config\Database::connect();
                $antreanAktif = $db->table('pendaftaran pd')
                    ->select('pd.id_pendaftaran, pd.no_antrean, pd.kode_antrean, pd.kode_booking, pd.status, pd.jenis_kunjungan, j.tanggal, j.jam_mulai, j.jam_selesai, d.nama_dokter, d.spesialisasi, p.nama_poli, p.kode_antrean AS kode_antrean_poli')
                    ->join('jadwal_dokter j', 'j.id_jadwal = pd.id_jadwal')
                    ->join('dokter d', 'd.id_dokter = j.id_dokter')
                    ->join('poli p', 'p.id_poli = d.id_poli')
                    ->where('pd.id_pasien', $pasien['id_pasien'])
                    ->whereIn('pd.status', ['menunggu', 'dikonfirmasi'])
                    ->where('j.tanggal >=', date('Y-m-d'))
                    ->orderBy('j.tanggal', 'ASC')
                    ->orderBy('j.jam_mulai', 'ASC')
                    ->orderBy('pd.no_antrean', 'ASC')
                    ->get()->getResultArray();
                // v7: lengkapi kode untuk baris lama (turunan + backfill
                // kode booking) sebelum hero dirender.
                $antreanAktif = KodeAntrean::pastikanDaftar($antreanAktif);
            }
        }
        return view('beranda/index', [
            'antrean_aktif' => $antreanAktif,
            'jumlah_aktif'  => count($antreanAktif),
            'nama'          => (string) session()->get('nama'),
        ]);
    }
}
