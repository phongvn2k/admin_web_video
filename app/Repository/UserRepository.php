<?php

namespace App\Repository;

use App\Models\User;
use App\Models\UserWebsite;

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

    public function addFollow($userId)
    {
        User::where('id', $userId)->increment('count_follow');
    }

    public function unFollow($userId)
    {
        User::where('id', $userId)->decrement('count_follow');
    }

    public function getUserById($userid)
    {
        $data = User::where("id", $userid)->first();

        return $data;
    }

    public function exceptAvailable($userId, $amount)
    {
        User::where('id', $userId)->decrement('available_amount', $amount);
    }

    public function addHold($userId, $amount)
    {
        User::where('id', $userId)->increment('available_amount', $amount);
    }

    public function getAllUserWeb($webId)
    {
        $data = UserWebsite::where('website_id', $webId)
            ->select('user_id')
            ->groupBy('user_id')
            ->havingRaw('COUNT(user_id) = 1')
            ->get();

        return $data;
    }
}
