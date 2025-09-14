<?php

use App\Enums\Role;
use Illuminate\Support\Facades\Auth;

if (! function_exists('getActiveGuard')) {
    function getActiveGuard()
    {
        foreach (array_keys(config('auth.guards')) as $guard) {
            if (Auth::guard($guard)->check()) {
                return $guard;
            }
        }

        return null;
    }
}

if (! function_exists('getActiveUser')) {
    function getActiveUser()
    {
        $guard = getActiveGuard();

        $user = Auth::guard($guard)->user();

        if($user) {
            return $user;
        }


        return null;
    }
}

if (! function_exists('getActiveUserId')) {
    function getActiveUserId()
    {
        $guard = getActiveGuard();
        $user = getActiveUser();

        if($guard === Role::PETANI->value) {
            return $user->id_petani;
        } else if($guard === Role::AHLIPERTANIAN->value) {
            return $user->id_penyuluh;
        }else if($guard === Role::ADMIN->value) {
            return $user->id_admin;
        } else if($guard === Role::KEPALADINAS->value) {
            return $user->id_kepala_dinas;
        }

        return null;
    }
}
