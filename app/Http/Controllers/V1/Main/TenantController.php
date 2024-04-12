<?php

namespace App\Http\Controllers\V1\Main;

use App\Http\Controllers\Controller;
use App\Http\Requests\Main\Tenant\StoreRequest;
use App\Models\Admin;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\QueryBuilder\QueryBuilder;

class TenantController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function render()
    {
        return view('tenants');
    }

    public function index(Request $request)
    {
        $collection = QueryBuilder::for(Tenant::class)
            ->allowedSorts('created_at', 'id')
            ->defaultSort('-created_at')
            ->with('domains')
            ->getOrPaginate();

        return JsonResource::collection($collection);
    }

    public function store(StoreRequest $request)
    {
        $request = request();

        $domain = $request->domain;

        $tenant = Tenant::create();
        $tenant->domains()->create(['domain' => "$domain." . config('app.domain')]);

        $email = $request->email ?: fake()->email;
        $password = $request->password ?: Str::random(10);

        $tenant->run(function () use ($password, $email) {
            Admin::firstOrCreate([
                'full_name' => "System Administrator",
                'email' => $email,
                'password' => bcrypt($password)
            ]);
        });

        return JsonResource::make($tenant);
    }

    public function show(Tenant $tenant)
    {
        return JsonResource::make($tenant->load('domains'));
    }

    public function update(Tenant $tenant, Request $request)
    {

    }

    public function destroy(Tenant $tenant)
    {
        $tenant->delete();

        return response()->json([]);
    }
}
