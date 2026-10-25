<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        if (! $session->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
        if (! empty($arguments)) {
            $role = (string) $session->get('role');
            if (! in_array($role, $arguments, true)) {
                return redirect()->to($this->dashboardFor($role))
                    ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
            }
        }
        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        return null;
    }

    private function dashboardFor(string $role): string
    {
        return match ($role) {
            'admin'  => '/admin',
            'dokter' => '/dokter',
            default  => '/jadwal',
        };
    }
}
