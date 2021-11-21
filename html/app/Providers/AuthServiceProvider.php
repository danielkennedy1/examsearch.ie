<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Validator::extend('allowed_domain', function($attribute, $value, $parameters, $validator) {
            //return in_array(explode('@', $value)[1], $this->allowedDomains);
            $domain = substr($value, strpos($value, "@") + 1);
            return DB::table("allowed_domains")->where("domain", "=", $domain)->exists();
        }, 'Domain not valid for registration.  Please use your school email.');
        
    }
}
