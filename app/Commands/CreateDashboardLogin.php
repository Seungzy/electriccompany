<?php

namespace App\Commands;

use App\Models\LoginAccountModel;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class CreateDashboardLogin extends BaseCommand
{
    protected $group = 'Accounts';
    protected $name = 'dashboard:create-login';
    protected $description = 'Create a dashboard login with a generated password.';
    protected $usage = 'dashboard:create-login <username>';
    protected $arguments = ['username' => 'Login username (up to 100 characters)'];

    public function run(array $params)
    {
        $username = trim((string) ($params[0] ?? ''));
        if ($username === '' || strlen($username) > 100) {
            CLI::error('Provide a username up to 100 characters.');
            return;
        }

        $model = new LoginAccountModel();
        if ($model->where('username', $username)->first()) {
            CLI::error('That username already exists.');
            return;
        }

        $password = bin2hex(random_bytes(12));
        $model->insert(['username' => $username, 'password' => password_hash($password, PASSWORD_DEFAULT)]);
        CLI::write('Username: ' . $username);
        CLI::write('Password: ' . $password);
        CLI::write('Save this password now; it is not shown again.');
    }
}
