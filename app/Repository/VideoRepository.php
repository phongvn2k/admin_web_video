<?php

namespace App\Repository;

use App\Models\Video;

class VideoRepository
{
    public function createVideo($data)
    {
        $data = Video::create($data);

        return $data;
    }

    public function getVideoByWebAndSlug($webId, $slug)
    {
        $data = Video::where('website_id', $webId)
            ->where('slug', $slug)
            ->exists();

        return $data;
    }

    public function getVideoByUser($userId, $webId)
    {
        $data = Video::where('website_id', $webId)
            ->where('user_id', $userId)
            ->get();

        return $data;
    }

    public function searchVideoByWeb($text, $webId, $page)
    {
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $result = Video::where('website_id', $webId)
            ->where(function ($q) use ($text) {
                $q->where('hashtag', 'like', "%$text%")
                    ->orWhere('title', 'like', "%$text%")
                    ->orWhere('description', 'like', "%$text%");
            })
            ->orderByRaw("
        CASE
            WHEN hashtag LIKE ? THEN 1
            WHEN title LIKE ? THEN 2
            WHEN description LIKE ? THEN 3
            ELSE 4
        END
    ", ["%$text%", "%$text%", "%$text%"])
            ->limit($limit)
            ->offset($offset)
            ->get();

        return $result;
    }

    public function getVideoViral($webId, $page)
    {
        $limit = 10;
        $offset = ($page - 1) * $limit;

        return Video::where('website_id', $webId)
            ->orderByRaw("
            is_viral DESC,
            CASE
                WHEN count_like >= 1000 THEN count_like
                ELSE NULL
            END DESC,
            CASE
                WHEN count_like < 1000 THEN RAND()
                ELSE 0
            END
        ")
            ->limit($limit)
            ->offset($offset)
            ->get();
    }

    public function addView($id)
    {
        Video::where('id', $id)->increment('count_view');
    }

    public function getVideoById($id)
    {
        return Video::find($id);
    }

    public function addLike($videoId)
    {
        Video::where('id', $videoId)->increment('count_like');
    }

    public function unLike($videoId)
    {
        Video::where('id', $videoId)->decrement('count_like');
    }

    public function deleteVideo($videoId)
    {
        $data = Video::where("id", $videoId)->first();

        if ($data) {
            $data->delete();
        }
    }
}
