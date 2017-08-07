<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Broadcast;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Broadcast::routes();

        //require base_path('routes/channels.php');

        Broadcast::channel('App.User.*', function($user, $userId){

            //$status =  (int) $user->id === (int) $userId;
            //echo ('in BroadcastServiceProvider Status = ' . $status);

            //return $user;

            return (int) $user->id === (int) $userId;
        });
    }
}
