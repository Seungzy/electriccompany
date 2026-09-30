<?php

namespace App\Controllers;

use App\Models\LoginAccountModel;
use CodeIgniter\Database\Exceptions\DatabaseException;

class Login extends BaseController
{
    public function index()
    {
        if (session()->get('dashboard_logged_in') === true) {
            return redirect()->to('/dashboard');
        }

        return view('login', [
            'title' => 'Dashboard Login - Puihaha Electric',
            'page' => 'login',
        ]);
    }

    public function authenticate()
    {
        $username = trim((string) $this->request->getPost('username'));
        $password = (string) $this->request->getPost('password');

        if ($username === '' || strlen($username) > 100 || $password === '') {
            return redirect()->to('/login')->withInput()->with('error', 'Enter a valid username and password.');
        }

        $model = new LoginAccountModel();
        try {
            $account = $model->where('username', $username)->first();
        } catch (DatabaseException $e) {
            log_message('error', 'Dashboard login database error: {message}', ['message' => $e->getMessage()]);
            return redirect()->to('/login')->withInput()->with('error', 'Database unavailable. Start MySQL in XAMPP and try again.');
        }
        $valid = $account !== null && password_verify($password, $account['password']);

        // Existing classroom accounts may have plaintext passwords. Upgrade them on first login.
        if (!$valid && $account !== null && !password_get_info($account['password'])['algo']
            && hash_equals($account['password'], $password)) {
            $valid = true;
            $model->update($account['id'], ['password' => password_hash($password, PASSWORD_DEFAULT)]);
        }

        if (!$valid) {
            return redirect()->to('/login')->withInput()->with('error', 'Invalid username or password.');
        }

        session()->regenerate();
        session()->set([
            'dashboard_logged_in' => true,
            'dashboard_user_id' => $account['id'],
            'dashboard_username' => $account['username'],
        ]);

        return redirect()->to('/dashboard');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'You have been logged out.');
    }
}
