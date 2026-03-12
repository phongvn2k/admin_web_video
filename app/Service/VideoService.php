<?php

namespace App\Service;

use App\Repository\VideoRepository;
use App\Repository\WebsiteRepository;
use App\Repository\CommentRepository;
use App\Repository\UserLikeVideoRepository;

class VideoService
{
    public $videoRepository;
    public $websiteRepository;
    public $commentRepository;
    public $userLikeVideoRepository;
    public function __construct(
        VideoRepository $videoRepository,
        WebsiteRepository $websiteRepository,
        CommentRepository $commentRepository,
        UserLikeVideoRepository $userLikeVideoRepository
    ){
        $this->videoRepository = $videoRepository;
        $this->websiteRepository = $websiteRepository;
        $this->commentRepository = $commentRepository;
        $this->userLikeVideoRepository = $userLikeVideoRepository;
    }

    public function checkPayloadAddVideo($title, $description, $slug, $hashtag, $authWeb)
    {
        if (strlen($title) > 255) {
            return [
                "status" => False,
                "mess" => "Title not longer than 255 characters"
            ];
        }

        if (strlen($description) > 255) {
            return [
                "status" => False,
                "mess" => "Description not longer than 255 characters"
            ];
        }

        if (strlen($hashtag) > 255) {
            return [
                "status" => False,
                "mess" => "Hashtag not longer than 255 characters"
            ];
        }

        $slug = $this->videoRepository->getVideoByWebAndSlug($authWeb->id, $slug);
        if ($slug) {
            return [
                "status" => False,
                "mess" => "Slug đã tồn tại"
            ];
        }

        return [
            "status" => True,
            "mess" => "ok"
        ];
    }

    public function addVideo($payload, $authWeb)
    {
        $title = $payload['video']['title'];
        $description = $payload['video']['description'];
        $file = $payload['video']['file'];
        $hashtag = $payload['video']['hashtag'];
        $slug = $payload['video']['slug'];

        $statusC = $this->checkPayloadAddVideo($title, $description, $slug, $hashtag, $authWeb);
        if ($statusC['status'] == False) {
            return $statusC;
        }

        $video = $this->videoRepository->createVideo([
            "website_id" => $authWeb->id,
            "title" => $title,
            "description" => $description,
            "file" => $file,
            "hashtag" => $hashtag,
            "user_id" => $payload['user_id'],
            "slug" => $slug,
        ]);

        return [
            "status" => true,
            "data" => $video,
        ];
    }

    public function userGetAllVideo($payload, $authWeb)
    {
        $userId = $payload['user_id'];
        $videos = $this->videoRepository->getVideoByUser($userId, $authWeb->id);

        return [
            "status" => true,
            "data" => $videos,
        ];
    }

    public function videoViewSearch($payload, $authWeb)
    {
        $search = $payload['search'];
        $page = $payload['page'];
        $video = $this->videoRepository->searchVideoByWeb($search, $authWeb->id, $page);

        return [
            "status" => true,
            "data" => $video,
        ];
    }

    public function videoViral($payload, $webAuth)
    {
        $page = $payload['page'];
        $video = $this->videoRepository->getVideoViral($webAuth->id, $page);

        return [
            "status" => true,
            "data" => $video,
        ];
    }

    public function addComment($payload)
    {
        if (strlen($payload['comment']) > 255) {
            return [
                "status" => False,
                "mess" => "Comment not longer than 255 characters"
            ];
        }

        $comment = $this->commentRepository->createComment(["user_id" => $payload['user_id'], "video_id" => $payload['video_id'], "comment" => $payload['comment']]);

        return [
            "status" => true,
            "data" => $comment
        ];
    }

    public function deleteComment($payload)
    {
        $checkC = $this->commentRepository->getCommentById($payload['comment_id'], $payload['user_id']);
        if ($checkC) {
            $this->commentRepository->deleteComment($checkC->id);
            return [
                "status" => true,
                "mess" => "Comment successfully deleted."
            ];
        }

        return [
            "status" => false,
            "mess" => "No comments found."
        ];
    }

    public function getComment($payload)
    {
        $comments = $this->commentRepository->getCommentByVideo($payload['video_id'], $payload['page']);

        return [
            "status" => true,
            "data" => $comments
        ];
    }

    public function viewVideo($payload)
    {
        $video = $this->videoRepository->addView($payload['video_id']);

        return [
            "status" => true,
            "mess" => "successfully"
        ];
    }

    public function getFullInfoVideo($payload)
    {
        $video = $this->videoRepository->getVideoById($payload['video_id']);
        return [
            "status" => true,
            "data" => $video
        ];
    }

    public function addLikeVideo($payload)
    {
        $like = $this->userLikeVideoRepository->addLike(["user_id" => $payload['user_id'], "video_id" => $payload['video_id']]);
        if ($like) {
            $this->videoRepository->addLike($payload['video_id']);
            return [
                "status" => true,
                "mess" => "success"
            ];
        }

        return [
            "status" => false,
            "mess" => "failure"
        ];
    }

    public function unLikeVideo($payload)
    {
        $deleted = $this->userLikeVideoRepository->unLike($payload['user_id'], $payload['video_id']);
        if ($deleted) {
            $this->videoRepository->unLike($payload['video_id']);
        }

        return [
            "status" => true,
            "mess" => "success"
        ];
    }
}
