<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class CreateMainUserAccount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'main:create-user {username} {password?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will create a user in main database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $adminUser = $this->argument('username') ?: fake()->email;
        $adminPswd = $this->argument('password') ?: Str::random(10);

        $user = User::firstOrCreate([
            'name' => 'System Administrator',
            'email' => $adminUser,
        ], [
            'password' => bcrypt($adminPswd)
        ]);

        $this->info("New admin $user->name, username: $adminUser, password: $adminPswd");
    }
}
