<?php

namespace App\Service\Widgets;

use Filament\Facades\Filament;
use App\Repository\UserRepository;
use App\Repository\VideoRepository;
use App\Repository\PaymentRepository;
use App\Repository\PaymentProcessRepository;

class StatsOverviewService
{
    public $webId;
    public $userRepository;
    public $videoRepository;
    public $paymentRepository;
    public $paymentProcessRepository;

    public function __construct(
        UserRepository $userRepository,
        VideoRepository $videoRepository,
        PaymentRepository $paymentRepository,
        PaymentProcessRepository $paymentProcessRepository,
    ){
        $this->userRepository = $userRepository;
        $this->videoRepository = $videoRepository;
        $this->paymentRepository = $paymentRepository;
        $this->paymentProcessRepository = $paymentProcessRepository;

        $tenant = Filament::getTenant();
        $this->webId = $tenant?->id;
    }
    public function getDataCountUser()
    {
        $user = $this->userRepository->getAllUserWeb($this->webId);

        return count($user);
    }

    public function getDataCountVideo()
    {
        $data = $this->videoRepository->getVideoByWebsite($this->webId);

        return count($data);
    }

    public function getDataCountPaymnet()
    {
        $data = $this->paymentRepository->getPaymentByWebsite($this->webId);

        return count($data);
    }

    public function getDataCountAmount()
    {
        $allStatus = $this->paymentProcessRepository->getAll($this->webId);
        $status = [];
        foreach ($allStatus as $sta) {
            $status[] = $sta->id;
        }

        $data = $this->paymentRepository->getAmountByWebsite($this->webId, $status);

        return $data;
    }
}
