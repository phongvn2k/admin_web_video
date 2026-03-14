<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;
use App\Service\Widgets\DataChartService;

class DataChart extends ChartWidget
{
    protected static ?string $heading = 'Thống kê hoạt động trang web trong 7 ngày';

    protected int | string | array $columnSpan = 2;

    protected function getData(): array
    {
        $users = app(DataChartService::class)->getDataCountUser();

        $payment = app(DataChartService::class)->getDataCountPayment();;

        return [
            'datasets' => [
                [
                    'label' => 'Người dùng',
                    'data' => $users,
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59,130,246,0.2)',
                    'tension' => 0.4,
                ],
                [
                    'label' => 'Thanh toán',
                    'data' => $payment,
                    'borderColor' => '#22c55e',
                    'backgroundColor' => 'rgba(34,197,94,0.2)',
                    'tension' => 0.4,
                ],
            ],
            'labels' => [
                '6 ngày trước',
                '5 ngày trước',
                '4 ngày trước',
                '3 ngày trước',
                '2 ngày trước',
                'Hôm qua',
                'Hôm nay',
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
