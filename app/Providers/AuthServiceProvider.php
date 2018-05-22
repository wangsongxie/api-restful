<?php

namespace App\Providers;

use App\Dog;
use App\Orders;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define("dog-publish",function($user){
            $identify =  $user->identify()->first();
            if(!$identify || $identify->is_valid == 0){
                return false;
            }
            return true;
        });

        Gate::define("dog-delete",function($user, $id){
            $dog = Dog::find($id) ;
            if (!$dog) {
                return false;
            }
            if($dog->user_id == $user->id)
            {
                return true;
            }
            return false;
        });

        Gate::define("handle-order",function($user, $order_no){
            if(Orders::where('order_no',$order_no)->where('user_id', $user->id)->exists())
            {
                return true;
            }
            return false;
        });
    }
}
