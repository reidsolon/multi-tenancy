<?php

namespace App\Console\Commands;

use App\Models\Admin;
use App\Models\Tenant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateTenant extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-tenant
        {tenant-domain : Tenant\'s Domain}
        {admin-email? : Tenant\'s Default Admin email}
        {admin-password? : Tenant\'s Default Admin Password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command creates a tenant with options';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $domain = $this->argument('tenant-domain');
        $adminEmail = $this->argument('admin-email') ?: fake()->email;
        $adminPwRaw = Str::random(10);
        $adminPassword = $this->argument('admin-password') ?: bcrypt($adminPwRaw);

        $tenant = Tenant::create();
        $tenant->domains()->create(['domain' => "$domain." . config('app.domain')]);

        $tenant->run(function () use ($adminPassword, $adminEmail) {
            Admin::firstOrCreate([
                'full_name' => "System Administrator",
                'email' => $adminEmail,
                'password' => $adminPassword
            ]);
        });

        $this->info("New tenant created, Domain: $domain, Email: $adminEmail, Password: $adminPwRaw");
    }
}
