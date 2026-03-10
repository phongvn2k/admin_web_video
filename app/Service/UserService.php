<?php

namespace App\Service;

use App\Repository\AllBankRepository;
use App\Repository\WebsiteRepository;

class UserService
{
    public $allBankRepository;
    public $websiteRepository;
    public function __construct(
        AllBankRepository $allBankRepository,
        WebsiteRepository $websiteRepository
    ){
        $this->allBankRepository = $allBankRepository;
        $this->websiteRepository = $websiteRepository;
    }

    public function getBank($webAuth)
    {
        $banks = $this->allBankRepository->getAllBankActiveByWebId($webAuth->id);
        $datas = [];
        foreach ($banks as $bank) {
            $datas[] = [
                'id' => $bank->id,
                'name' => $bank->name,
                'code' => $bank->code,
            ];
        }

        return [
            "status" => true,
            "data" => $datas,
        ];
    }

    public function checkBank($payload, $webAuth)
    {
        $data = $this->allBankRepository->getBankByUser($payload, $webAuth->id);
        if ($data) {
            return false;
        }

        return true;
    }

    public function addBank($payload, $webAuth)
    {
        $checkBank = $this->checkBank($payload, $webAuth);
        if ($checkBank == false) {
            return [
                "status" => false,
                "messager" => "The account number has already been used."
            ];
        }

        $bank = $this->allBankRepository->addbank([
            "user_id" => $payload['user_id'],
            "bank_id" => $payload['bank_id'],
            "website_id" => $webAuth->id,
            "name" => $payload['name'],
            "number" => $payload['number']
        ]);

        if ($bank) {
            return [
                "status" => true,
                "messager" => "more success",
            ];
        }

        return [
            "status" => false,
            "messager" => "more failures."
        ];
    }

    public function getBankByUserId($payload, $webAuth)
    {
        $bank = $this->allBankRepository->getBankByUserId($payload['user_id'], $webAuth->id);
        if ($bank) {
            $bankInfo = $this->allBankRepository->getBankById($bank->bank_id, $webAuth->id);

            return [
                "status" => true,
                "data" => [
                    "id" => $bank->id,
                    "bank_name" => $bankInfo->name,
                    "bank_code" => $bankInfo->code,
                    "bank_number" => $bank->number,
                    "user_name" => $bank->name
                ]
            ];
        }

        return [
            "status" => false,
            "messager" => "not found"
        ];
    }
}
