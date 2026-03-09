<?php

namespace App\Repository;

use App\Models\Website;
use App\Models\UserWebsite;

class WebsiteRepository
{
    public function getWebsiteByDomainAndKey($domain, $key)
    {
        $data = Website::where("domain", $domain)->where("key", $key)->first();

        if ($data) {
            return $data;
        }

        return false;
    }

    public function addWebsite($data)
    {
        $user = UserWebsite::create($data);

        return $user;
    }
}
