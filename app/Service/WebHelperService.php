<?php

namespace App\Service;

use Illuminate\Support\Facades\Hash;
use App\Repository\UserRepository;
use App\Repository\WebsiteRepository;

class WebHelperService
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
            $check = $this->getUserByGoogleId($data['email'], $webAuth);
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
}
