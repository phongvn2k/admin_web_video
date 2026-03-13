<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Helper\WebHelper;
use App\Service\VideoService;

class VideoController extends \App\Http\Controllers\Controller
{
    public $webHelper;
    public $videoService;
    public function __construct(
        WebHelper $webHelper,
        VideoService $videoService
    ){
        $this->webHelper = $webHelper;
        $this->videoService = $videoService;
    }

    public function addVideo(Request $request)
    {
        $auth = $request->input('auth');
        $webAuth = $this->webHelper->checkWeb($auth);

        if ($webAuth == false) {
            return response()->json([
                'code' => 400,
                'messager' => "unauthorized"
            ], 400);
        }

        $payload = $request->input('payload');
        $addUser = $this->videoService->addVideo($payload, $webAuth);

        if ($addUser['status'] == false) {
            return response()->json($addUser, 500);
        }

        return response()->json($addUser);
    }

    public function userGetAllVideo(Request $request)
    {
        $auth = $request->input('auth');
        $webAuth = $this->webHelper->checkWeb($auth);

        if ($webAuth == false) {
            return response()->json([
                'code' => 400,
                'messager' => "unauthorized"
            ], 400);
        }

        $payload = $request->input('payload');
        $addUser = $this->videoService->userGetAllVideo($payload, $webAuth);

        if ($addUser['status'] == false) {
            return response()->json($addUser, 500);
        }

        return response()->json($addUser);
    }

    public function videoViewSearch(Request $request)
    {
        $auth = $request->input('auth');
        $webAuth = $this->webHelper->checkWeb($auth);

        if ($webAuth == false) {
            return response()->json([
                'code' => 400,
                'messager' => "unauthorized"
            ], 400);
        }

        $payload = $request->input('payload');
        $addUser = $this->videoService->videoViewSearch($payload, $webAuth);

        if ($addUser['status'] == false) {
            return response()->json($addUser, 500);
        }

        return response()->json($addUser);
    }

    public function videoViral(Request $request)
    {
        $auth = $request->input('auth');
        $webAuth = $this->webHelper->checkWeb($auth);

        if ($webAuth == false) {
            return response()->json([
                'code' => 400,
                'messager' => "unauthorized"
            ], 400);
        }

        $payload = $request->input('payload');
        $addUser = $this->videoService->videoViral($payload, $webAuth);

        if ($addUser['status'] == false) {
            return response()->json($addUser, 500);
        }

        return response()->json($addUser);
    }

    public function addComment(Request $request)
    {
        $auth = $request->input('auth');
        $webAuth = $this->webHelper->checkWeb($auth);

        if ($webAuth == false) {
            return response()->json([
                'code' => 400,
                'messager' => "unauthorized"
            ], 400);
        }

        $payload = $request->input('payload');
        $addUser = $this->videoService->addComment($payload);

        if ($addUser['status'] == false) {
            return response()->json($addUser, 500);
        }

        return response()->json($addUser);
    }

    public function deleteComment(Request $request)
    {
        $auth = $request->input('auth');
        $webAuth = $this->webHelper->checkWeb($auth);

        if ($webAuth == false) {
            return response()->json([
                'code' => 400,
                'messager' => "unauthorized"
            ], 400);
        }

        $payload = $request->input('payload');
        $addUser = $this->videoService->deleteComment($payload);

        if ($addUser['status'] == false) {
            return response()->json($addUser, 500);
        }

        return response()->json($addUser);
    }

    public function getComment(Request $request)
    {
        $auth = $request->input('auth');
        $webAuth = $this->webHelper->checkWeb($auth);

        if ($webAuth == false) {
            return response()->json([
                'code' => 400,
                'messager' => "unauthorized"
            ], 400);
        }

        $payload = $request->input('payload');
        $addUser = $this->videoService->getComment($payload);

        if ($addUser['status'] == false) {
            return response()->json($addUser, 500);
        }

        return response()->json($addUser);
    }

    public function viewVideo(Request $request)
    {
        $auth = $request->input('auth');
        $webAuth = $this->webHelper->checkWeb($auth);

        if ($webAuth == false) {
            return response()->json([
                'code' => 400,
                'messager' => "unauthorized"
            ], 400);
        }

        $payload = $request->input('payload');
        $addUser = $this->videoService->viewVideo($payload);

        if ($addUser['status'] == false) {
            return response()->json($addUser, 500);
        }

        return response()->json($addUser);
    }

    public function getFullInfoVideo(Request $request)
    {
        $auth = $request->input('auth');
        $webAuth = $this->webHelper->checkWeb($auth);

        if ($webAuth == false) {
            return response()->json([
                'code' => 400,
                'messager' => "unauthorized"
            ], 400);
        }

        $payload = $request->input('payload');
        $addUser = $this->videoService->getFullInfoVideo($payload);

        if ($addUser['status'] == false) {
            return response()->json($addUser, 500);
        }

        return response()->json($addUser);
    }

    public function addLikeVideo(Request $request)
    {
        $auth = $request->input('auth');
        $webAuth = $this->webHelper->checkWeb($auth);

        if ($webAuth == false) {
            return response()->json([
                'code' => 400,
                'messager' => "unauthorized"
            ], 400);
        }

        $payload = $request->input('payload');
        $addUser = $this->videoService->addLikeVideo($payload);

        if ($addUser['status'] == false) {
            return response()->json($addUser, 500);
        }

        return response()->json($addUser);
    }

    public function unLikeVideo(Request $request)
    {
        $auth = $request->input('auth');
        $webAuth = $this->webHelper->checkWeb($auth);

        if ($webAuth == false) {
            return response()->json([
                'code' => 400,
                'messager' => "unauthorized"
            ], 400);
        }

        $payload = $request->input('payload');
        $addUser = $this->videoService->unLikeVideo($payload);

        if ($addUser['status'] == false) {
            return response()->json($addUser, 500);
        }

        return response()->json($addUser);
    }

    public function deleteVideo(Request $request)
    {
        $auth = $request->input('auth');
        $webAuth = $this->webHelper->checkWeb($auth);

        if ($webAuth == false) {
            return response()->json([
                'code' => 400,
                'messager' => "unauthorized"
            ], 400);
        }

        $payload = $request->input('payload');
        $addUser = $this->videoService->deleteVideo($payload);

        if ($addUser['status'] == false) {
            return response()->json($addUser, 500);
        }

        return response()->json($addUser);
    }
}
