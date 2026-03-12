<?php

namespace App\Repository;

use App\Models\Comment;

class CommentRepository
{
    public function createComment($data)
    {
        $data = Comment::create($data);

        return $data;
    }

    public function getCommentById($id, $userId)
    {
        return Comment::where('id', $id)
            ->where('user_id', $userId)
            ->first();
    }

    public function deleteComment($id)
    {
        Comment::where('id', $id)->delete();
    }

    public function getCommentByVideo($id, $page)
    {
        $limit = 10;
        $offset = ($page - 1) * $limit;

        return Comment::where('video_id', $id)
            ->orderBy('updated_at', 'desc')
            ->limit($limit)
            ->offset($offset)
            ->get();
    }
}
