<?php

namespace App\Repository;

use App\Models\UserLikeVideo;

class UserLikeVideoRepository
{
    public function addLike($data)
    {
        $data = UserLikeVideo::create($data);

        return $data;
    }

    public function unLike($userId, $videoId)
    {
        $deleted = UserLikeVideo::where('video_id', $videoId)
            ->where("user_id", $userId)
            ->delete();

        return $deleted;
    }
}
