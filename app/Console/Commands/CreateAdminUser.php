<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    protected $signature = 'user:create-admin {--email=} {--password=} {--name=}';

    protected $description = 'Create or update an admin user (role_id=0)';

    public function handle(): int
    {
        $email = (string) ($this->option('email') ?? '');
        $password = (string) ($this->option('password') ?? '');
        $name = (string) ($this->option('name') ?? '');

        if ($email === '' || $password === '') {
            $this->error('Missing required options: --email and --password');
            return self::FAILURE;
        }

        if ($name === '') {
            $name = 'Admin';
        }

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make($password),
                'role_id' => User::ROLE_ADMIN,
            ]
        );

        $this->info('Admin user created/updated: ' . $email);

        return self::SUCCESS;
    }
}

