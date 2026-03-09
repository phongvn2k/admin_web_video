<?php

namespace App\Service;

use Illuminate\Support\Facades\Hash;
use App\Repository\UserRepository;
use App\Repository\WebsiteRepository;

class UserService
{
    public $userRepository;
    public $websiteRepository;
    public function __construct(
        UserRepository $userRepository,
        WebsiteRepository $websiteRepository
    ){
        $this->userRepository = $userRepository;
        $this->websiteRepository = $websiteRepository;
    }
    public function getUserByEmail($email, $web)
    {
        $user = $this->userRepository->getUserByEmailAndWeb($email, $web);
        return $user;
    }

    public function getUserByGoogleId($email, $web)
    {
        $user = $this->userRepository->getUserByGoogleIdAndWeb($email, $web);
        return $user;
    }

    public function addUser($data, $webAuth)
    {
        $dataUser = [
            "name" => $data['name'],
            "email" => $data['email'],
            "password" => Hash::make($data['password']),
            "google_id" => $data['google_id']
        ];

        if (empty($data['google_id'])) {
            $check = $this->getUserByEmail($data['email'], $webAuth);
        } else {
            $check = $this->getUserByGoogleId($data['google_id'], $webAuth);
        }

        if ($check == false) {
            $userAdd = $this->userRepository->createUser($dataUser);
            $this->websiteRepository->addWebsite([
                "user_id" => $userAdd->id,
                "website_id" => $webAuth->id,
            ]);
            return [
                "status" => true,
                "code" => 200,
                "messager" => "Account created successfully",
                "user" => $userAdd
            ];
        }

        return [
            "status" => false,
            "code" => 500,
            "messager" => "The account already exists."
        ];
    }

    public function checkLoginEmail($email, $password, $webAuth)
    {
        $user = $this->getUserByEmail($email, $webAuth);

        if ($user && Hash::check($password, $user->password)) {
            return $user;
        }

        return false;
    }

    public function checkLoginGoogle($googleId, $webAuth)
    {
        $user = $this->getUserByGoogleId($googleId, $webAuth);
        if ($user) {
            return $user;
        }

        return false;
    }

    public function login($payload, $webAuth)
    {
        if (empty($payload['google_id'])) {
            $check = $this->checkLoginEmail($payload['email'], $payload['password'], $webAuth);
        } else {
            $check = $this->checkLoginGoogle($payload['google_id'], $webAuth);
        }

        if ($check == false) {
            return [
                "status" => false,
                "code" => 500,
                "messager" => "Login error"
            ];
        }

        return [
            "status" => true,
            "code" => 200,
            "messager" => "Login successfully",
            "user" => [
                "id" => $check->id,
                "name" => $check->name,
                "email" => $check->email,
                "google_id" => $check->google_id,
                "role" => $check->role,
            ]
        ];
    }
}
