<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to($this->dashboardFor((string) session()->get('role')));
        }
        return view('auth/login');
    }

    public function attempt()
    {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()
                ->with('error', 'Email dan kata sandi wajib diisi dengan benar.');
        }
        $user = (new UserModel())->where('email', $this->request->getPost('email'))->first();
        if (! $user || ! password_verify((string) $this->request->getPost('password'), (string) $user['password'])) {
            return redirect()->back()->withInput()
                ->with('error', 'Email atau kata sandi salah.');
        }
        session()->regenerate();
        session()->set([
            'id_user'    => $user['id_user'],
            'nama'       => $user['nama'],
            'email'      => $user['email'],
            'role'       => $user['role'],
            'isLoggedIn' => true,
        ]);
        return redirect()->to($this->dashboardFor((string) $user['role']))
            ->with('success', 'Selamat datang, ' . $user['nama'] . '.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Anda sudah keluar.');
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
