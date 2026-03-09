<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Helper\WebHelper;
use App\Service\WebHelperService;

class UserController extends \App\Http\Controllers\Controller
{
    public $webHelper;
    public $webHelperService;
    public function __construct(
        WebHelper $webHelper,
        WebHelperService $webHelperService
    ){
        $this->webHelper = $webHelper;
        $this->webHelperService = $webHelperService;
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
        $addUser = $this->webHelperService->addUser($payload, $webAuth);

        if ($addUser['status'] == false) {
            return response()->json($addUser, 500);
        }

        return response()->json($addUser);
    }

    public function checkUser(Request $request)
    {

    }
}
