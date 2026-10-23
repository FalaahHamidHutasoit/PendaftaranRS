<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        return redirect()->to(base_url(
            session()->get('role') === 'admin' ? 'dashboard' : 'reservasi'
        ));
    }
}
