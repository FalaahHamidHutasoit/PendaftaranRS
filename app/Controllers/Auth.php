<?php

namespace App\Controllers;

class Auth extends BaseController
{
    public function login()
    {
        // Jika sudah login, arahkan ke dashboard
        if (session()->get('isLoggedIn')) {
            return redirect()->to(base_url($this->berandaPeran()));
        }

        return view('auth/login');
    }

    public function prosesLogin()
    {
        $aturan = [
            'email' => 'required|valid_email',
            'password' => 'required',
        ];

        if (!$this->validate($aturan)) {
            return redirect()->back()
                ->withInput()
                ->with('pesan_error', 'Email atau password wajib diisi dengan benar.');
        }

        $email = strtolower(trim($this->request->getPost('email')));
        $password = $this->request->getPost('password');

        $db = \Config\Database::connect();

        $user = $db->table('users')
            ->where('email', $email)
            ->get()
            ->getRowArray();

        // Periksa akun dan password
        if (!$user || !password_verify($password, $user['password'])) {
            return redirect()->back()
                ->withInput()
                ->with('pesan_error', 'Email atau password salah.');
        }

        // Regenerasi session ID setelah login
        session()->regenerate();

        // Simpan informasi login ke session
        session()->set([
            'id_user' => $user['id_user'],
            'nama' => $user['nama'],
            'email' => $user['email'],
            'role' => $user['role'],
            'isLoggedIn' => true,
        ]);

        return redirect()->to(base_url($this->berandaPeran()));
    }

    private function berandaPeran(): string
    {
        return session()->get('role') === 'admin' ? 'dashboard' : 'reservasi';
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to(base_url('login'))
            ->with('pesan_sukses', 'Kamu berhasil logout.');
    }
}
