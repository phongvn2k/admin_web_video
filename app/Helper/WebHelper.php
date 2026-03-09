<?php

namespace App\Helper;

use App\Repository\WebsiteRepository;

class WebHelper
{
    public $websiteRepository;
    public function __construct(
        WebsiteRepository $websiteRepository
    ){
        $this->websiteRepository = $websiteRepository;
    }
    public function checkWeb($auth)
    {
        $web = $this->websiteRepository->getWebsiteByDomainAndKey($auth['web'], $auth['key']);
        if ($web == false) {
            return false;
        }

        return $web;
    }
}
