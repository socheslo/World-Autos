<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class FixUserPasswords extends Command
{
    protected $signature = 'fix:passwords';
    protected $description = 'Ensure all user passwords are properly hashed';

    public function handle()
    {
        $users = User::all();

        foreach ($users as $user) {
            if (!Hash::needsRehash($user->password)) {
                $user->password = Hash::make($user->password);
                $user->save();
                $this->info("Password fixed for user: {$user->username}");
            } else {
                $this->info("Password already hashed for user: {$user->username}");
            }
        }

        $this->info('All passwords checked and fixed if needed.');
    }
}
