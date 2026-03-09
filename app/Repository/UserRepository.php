<?php

namespace App\Repository;

use App\Models\User;

class UserRepository
{
    public function createUser($data)
    {
        $user = User::create($data);

        return $user;
    }

    public function getUserByGoogleIdAndWeb($googleId, $web)
    {
        $user = User::where('google_id', $googleId)
            ->whereHas('websites', function ($q) use ($web) {
                $q->where('website_id', $web->id);
            })
            ->first();

        if ($user) {
            return $user;
        }

        return false;
    }

    public function getUserByEmailAndWeb($email, $web)
    {
        $user = User::where('email', $email)
            ->whereHas('websites', function ($q) use ($web) {
                $q->where('website_id', $web->id);
            })
            ->first();

        if ($user) {
            return $user;
        }

        return false;
    }

    public function getUserByIdAndWeb($id, $web)
    {
        $user = User::where('id', $id)
            ->whereHas('websites', function ($q) use ($web) {
                $q->where('website_id', $web->id);
            })
            ->first();

        if ($user) {
            return $user;
        }

        return false;
    }

    public function updateUserById($id, $data)
    {
        User::where('id', $id)->update($data);
    }
}
