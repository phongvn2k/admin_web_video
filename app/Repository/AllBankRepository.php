<?php

namespace App\Repository;

use App\Models\AllBank;
use App\Models\Userbank;

class AllBankRepository
{
    public function getAllBankActiveByWebId($webId)
    {
        $data = AllBank::where('website_id', $webId)->where("status", 1)->get();

        return $data;
    }

    public function getBankByUser($data, $webId)
    {
        $data = Userbank::where('bank_id', $data['bank_id'])
            ->where("website_id", $webId)
            ->where("name", strtoupper($data['name']))
            ->where("number", $data['number'])
            ->first();

        return $data;
    }

    public function addbank($bank)
    {
        $data = Userbank::create($bank);

        return $data;
    }

    public function getBankByUserId($userId, $webId)
    {
        $data = Userbank::where('user_id', $userId)
            ->where("website_id", $webId)
            ->first();

        return $data;
    }

    public function getBankById($bankId, $webId)
    {
        $data = AllBank::where('id', $bankId)->first();
        return $data;
    }
}
