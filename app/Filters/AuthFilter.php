<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('login'))
                ->with('pesan_error', 'Silakan login terlebih dahulu.');
        }

        // Jika route meminta role tertentu,
        // pastikan role pengguna sesuai.
        if ($arguments !== null && !in_array(
            session()->get('role'),
            $arguments,
            true
        )) {
            $beranda = session()->get('role') === 'admin' ? 'dashboard' : 'reservasi';

            return redirect()->to(base_url($beranda))
                ->with('pesan_error', 'Kamu tidak memiliki akses ke halaman ini.');
        }
    }

    public function after(
        RequestInterface $request,
        ResponseInterface $response,
        $arguments = null
    ) {
        // Tidak ada proses setelah response.
    }
}
