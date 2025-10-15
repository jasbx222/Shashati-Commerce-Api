<?php

namespace App\Filament\Widgets;

use App\Models\Client;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class ClientsChart extends ChartWidget
{
    protected static ?string $heading = 'العملاء';

    protected static string $color = 'success';

    protected static ?int $sort = 2;

    protected static bool $isLazy = true;

    protected function getData(): array
    {

        $data = Trend::model(Client::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'العملاء',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
           'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
