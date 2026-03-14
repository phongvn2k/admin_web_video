<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Service\Widgets\StatsOverviewService;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Người dùng', number_format(app(StatsOverviewService::class)->getDataCountUser()))
                ->description('Tất cả người dùng trong trang web'),

            Stat::make('Video', number_format(app(StatsOverviewService::class)->getDataCountVideo()))
                ->description('Tổng số video trong trang web'),

            Stat::make('Thanh toán', number_format(app(StatsOverviewService::class)->getDataCountPaymnet()))
                ->description('Tổng số đơn thanh toán'),

            Stat::make('Tiền', number_format(app(StatsOverviewService::class)->getDataCountAmount()))
                ->description('Tổng số tiền chưa thanh toán'),
        ];
    }
}
