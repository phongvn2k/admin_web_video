<?php

namespace App\Service;

use App\Repository\AllBankRepository;
use App\Repository\UserFollowRepository;
use App\Repository\WebsiteRepository;
use App\Repository\UserRepository;
use App\Repository\PaymentRepository;
use App\Repository\PaymentProcessRepository;

class UserService
{
    public $allBankRepository;
    public $websiteRepository;
    public $userFollowRepository;
    public $userRepository;
    public $paymentRepository;
    public $paymentProcessRepository;

    public function __construct(
        AllBankRepository $allBankRepository,
        WebsiteRepository $websiteRepository,
        UserFollowRepository $userFollowRepository,
        UserRepository $userRepository,
        PaymentRepository $paymentRepository,
        PaymentProcessRepository $paymentProcessRepository,
    ){
        $this->allBankRepository = $allBankRepository;
        $this->websiteRepository = $websiteRepository;
        $this->userFollowRepository = $userFollowRepository;
        $this->userRepository = $userRepository;
        $this->paymentRepository = $paymentRepository;
        $this->paymentProcessRepository = $paymentProcessRepository;
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

    public function followUser($payload)
    {
        $checkFollow = $this->userFollowRepository->getFollow($payload['user_id'], $payload['user_follow']);
        if ($checkFollow) {
            return [
                "status" => true,
                "mess" => "success"
            ];
        }

        $this->userFollowRepository->createFollow([
            "user_id" => $payload['user_id'],
            "user_follow" => $payload['user_follow'],
        ]);

        $this->userRepository->addFollow($payload['user_id']);

        return [
            "status" => true,
            "mess" => "success"
        ];
    }

    public function unFollowUser($payload)
    {
        $checkFollow = $this->userFollowRepository->getFollow($payload['user_id'], $payload['user_follow']);
        if ($checkFollow) {
            $this->userFollowRepository->deleteFollow($payload['user_id'], $payload['user_follow']);
            $this->userRepository->unFollow($payload['user_id']);
        }

        return [
            "status" => true,
            "mess" => "success"
        ];
    }

    public function getBankUser($userId)
    {
        $userbank = $this->allBankRepository->getUserbankByUser($userId);

        if ($userbank) {
            $bank = $this->allBankRepository->getBankInfo($userbank->bank_id);
            return [
                "bank_name" => $bank->name,
                "bank_code" => $bank->code,
                "user_name" => $userbank->name,
                "bank_number" => $userbank->number,
            ];
        }

        return false;
    }

    public function getProcessPayment()
    {
        $allProcess = $this->paymentProcessRepository->getOne();
        return $allProcess->id;
    }

    public function addPayment($payload)
    {
        $user = $this->userRepository->getUserById($payload['user_id']);

        if ($user){
            $checkBank = $this->getBankUser($payload['user_id']);
            if ($checkBank == false) {
                return [
                    "status" => false,
                    "mess" => "You haven't added a bank yet."
                ];
            }

            if ($user->available_amount >= $payload['amount']) {
                $process = $this->getProcessPayment();

                $payment = $this->paymentRepository->addPayment([
                    "user_id" => $payload['user_id'],
                    "amount" => $payload['amount'],
                    "payment_process_id" => $process,
                ]);

                $this->userRepository->exceptAvailable($payload['user_id'], $payload['amount']);
                $this->userRepository->addHold($payload['user_id'], $payload['amount']);

                $paymnetProcess = $this->getPaymentInfo($payment->id);

                return [
                    "status" => true,
                    "data" => [
                        "bank" => $checkBank,
                        "payment" => [
                            "id" => $payment->id,
                            "amount" => $payment->amount,
                        ],
                        "process" => $paymnetProcess,
                    ]
                ];
            }

            return [
                "status" => false,
                "mess" => "insufficient balance"
            ];
        }

        return [
            "status" => false,
            "mess" => "The user does not exist."
        ];
    }

    public function getPaymentInfo($paymentId)
    {
        $process = $this->paymentProcessRepository->getAll();
        $payment = $this->paymentRepository->getPaymentById($paymentId);

        $data = [];
        foreach ($process as $pro) {
            $status = false;
            if ($pro->id == $payment->payment_process_id) {
                $status = true;
            }

            $data[] = [
                "name" => $pro->name,
                "status" => $status
            ];
        }

        return $data;
    }

    public function viewProcess($payload)
    {
        $checkPayment = $this->paymentRepository->getPaymentById($payload['payment_id']);
        if ($checkPayment) {
            if ($checkPayment->user_id == $payload['user_id']) {
                $pro = $this->getPaymentInfo($payload['payment_id']);
                return [
                    "status" => true,
                    "process" => $pro,
                ];
            }

            return [
                "status" => false,
                "mess" => "No viewing rights"
            ];
        }

        return [
            "status" => false,
            "mess" => "Payment does not exist."
        ];
    }
}
