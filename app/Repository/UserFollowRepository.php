<?php

namespace App\Repository;

use App\Models\UserFollow;

class UserFollowRepository
{
    public function createFollow($data)
    {
        $data = UserFollow::create($data);

        return $data;
    }

    public function getFollow($userId, $userFollow)
    {
        $data = UserFollow::where('user_id', $userId)->where('user_follow', $userFollow)->first();

        return $data;
    }

    public function deleteFollow($userId, $userFollow)
    {
        $data = UserFollow::where('user_id', $userId)->where('user_follow', $userFollow)->first();

        if ($data) {
            $data->delete();
        }
    }
}
