<?php

namespace App\Controllers;

class Login extends BaseController
{
    public function index(): string
    {
        return view('login', [
            'title' => 'Dashboard Login - Puihaha Electric',
            'page' => 'login',
        ]);
    }
}
