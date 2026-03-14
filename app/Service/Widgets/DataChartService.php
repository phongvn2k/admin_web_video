<?php

namespace App\Service\Widgets;

use Filament\Facades\Filament;
use App\Models\UserWebsite;
use App\Models\Payment;

class DataChartService
{
    public $webId;

    public function __construct()
    {
        $tenant = Filament::getTenant();
        $this->webId = $tenant?->id;
    }

    public function getDataCountUser()
    {
        return [
            UserWebsite::where('website_id', $this->webId)->whereDate('created_at', now()->subDays(6))->count(),
            UserWebsite::where('website_id', $this->webId)->whereDate('created_at', now()->subDays(5))->count(),
            UserWebsite::where('website_id', $this->webId)->whereDate('created_at', now()->subDays(4))->count(),
            UserWebsite::where('website_id', $this->webId)->whereDate('created_at', now()->subDays(3))->count(),
            UserWebsite::where('website_id', $this->webId)->whereDate('created_at', now()->subDays(2))->count(),
            UserWebsite::where('website_id', $this->webId)->whereDate('created_at', now()->subDays(1))->count(),
            UserWebsite::where('website_id', $this->webId)->whereDate('created_at', now())->count(),
        ];
    }

    public function getDataCountPayment()
    {
        return [
            Payment::where('website_id', $this->webId)->whereDate('created_at', now()->subDays(6))->count(),
            Payment::where('website_id', $this->webId)->whereDate('created_at', now()->subDays(5))->count(),
            Payment::where('website_id', $this->webId)->whereDate('created_at', now()->subDays(4))->count(),
            Payment::where('website_id', $this->webId)->whereDate('created_at', now()->subDays(3))->count(),
            Payment::where('website_id', $this->webId)->whereDate('created_at', now()->subDays(2))->count(),
            Payment::where('website_id', $this->webId)->whereDate('created_at', now()->subDays(1))->count(),
            Payment::where('website_id', $this->webId)->whereDate('created_at', now())->count(),
        ];
    }
}
