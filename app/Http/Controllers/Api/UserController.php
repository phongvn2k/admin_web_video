<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Helper\WebHelper;
use App\Service\UserService;

class UserController extends \App\Http\Controllers\Controller
{
    public $webHelper;
    public $userService;
    public function __construct(
        WebHelper $webHelper,
        UserService $userService
    ){
        $this->webHelper = $webHelper;
        $this->userService = $userService;
    }

    public function getBank(Request $request)
    {
        $auth = $request->input('auth');
        $webAuth = $this->webHelper->checkWeb($auth);

        if ($webAuth == false) {
            return response()->json([
                'code' => 400,
                'messager' => "unauthorized"
            ], 400);
        }

        $addUser = $this->userService->getBank($webAuth);

        if ($addUser['status'] == false) {
            return response()->json($addUser, 500);
        }

        return response()->json($addUser);
    }

    public function addBank(Request $request)
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
        $data = $this->userService->addBank($payload, $webAuth);
        if ($data['status'] == false) {
            return response()->json($data, 500);
        }

        return response()->json($data);
    }

    public function getBankByUserId(Request $request)
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
        $data = $this->userService->getBankByUserId($payload, $webAuth);
        if ($data['status'] == false) {
            return response()->json($data, 500);
        }

        return response()->json($data);
    }

    public function followUser(Request $request)
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
        $data = $this->userService->followUser($payload);
        if ($data['status'] == false) {
            return response()->json($data, 500);
        }

        return response()->json($data);
    }

    public function unFollowUser(Request $request)
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
        $data = $this->userService->unFollowUser($payload);
        if ($data['status'] == false) {
            return response()->json($data, 500);
        }

        return response()->json($data);
    }

    public function addPayment(Request $request)
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
        $data = $this->userService->addPayment($payload, $webAuth);
        if ($data['status'] == false) {
            return response()->json($data, 500);
        }

        return response()->json($data);
    }

    public function viewProcess(Request $request)
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
        $data = $this->userService->viewProcess($payload, $webAuth);
        if ($data['status'] == false) {
            return response()->json($data, 500);
        }

        return response()->json($data);
    }
}
