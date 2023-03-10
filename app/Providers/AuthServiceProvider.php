<?php

namespace App\Providers;

use App\Models\{Board,User};

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
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

        Gate::define('read-board', function (User $user, Board $board) {
            return $user->id === $board->user_id || $user->guestBoards()->where(['board_id'=>$board->id,'read'=>true])->exists();
        });
        Gate::define('write-board', function (User $user, Board $board) {
            return $user->id === $board->user_id || $user->guestBoards()->where(['board_id'=>$board->id,'write'=>true])->exists();
        });
    }
}
