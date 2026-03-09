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

    public function addUser(Request $request)
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
        $addUser = $this->userService->addUser($payload, $webAuth);

        if ($addUser['status'] == false) {
            return response()->json($addUser, 500);
        }

        return response()->json($addUser);
    }

    public function checkUser(Request $request)
    {

    }

    public function login(Request $request)
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
        $user = $this->userService->login($payload, $webAuth);

        if ($user['status'] == false) {
            return response()->json($user, 500);
        }

        return response()->json($user);
    }
}
