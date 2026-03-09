<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Helper\WebHelper;
use App\Service\AuthService;

class AuthController extends \App\Http\Controllers\Controller
{
    public $webHelper;
    public $authService;
    public function __construct(
        WebHelper $webHelper,
        AuthService $authService
    ){
        $this->webHelper = $webHelper;
        $this->authService = $authService;
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
        $addUser = $this->authService->addUser($payload, $webAuth);

        if ($addUser['status'] == false) {
            return response()->json($addUser, 500);
        }

        return response()->json($addUser);
    }

    public function getUser(Request $request)
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
        $addUser = $this->authService->getUser($payload, $webAuth);

        if ($addUser['status'] == false) {
            return response()->json($addUser, 500);
        }

        return response()->json($addUser);
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
        $user = $this->authService->login($payload, $webAuth);

        if ($user['status'] == false) {
            return response()->json($user, 500);
        }

        return response()->json($user);
    }

    public function getCodeResetPassword(Request $request)
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
        $code = $this->authService->getCodeResetPassword($payload, $webAuth);

        if ($code['status'] == false) {
            return response()->json($code, 500);
        }

        return response()->json($code);
    }

    public function resetPass(Request $request)
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
        $code = $this->authService->resetPassword($payload, $webAuth);

        if ($code['status'] == false) {
            return response()->json($code, 500);
        }

        return response()->json($code);
    }
}
