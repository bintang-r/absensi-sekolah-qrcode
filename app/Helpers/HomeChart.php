<?php

namespace App\Helpers;

use Carbon\Carbon;

class HomeChart
{
    protected static $period;

    public static function PERIOD($period)
    {
        self::$period = $period;
    }

    private static function DATE_RANGE()
    {
        $dates = [];
        switch (self::$period) {
            case 'weekly':
                for ($i = 9; $i >= 0; $i--) {
                    $dates[] = Carbon::now()->subWeeks($i)->startOfWeek()->toDateString();
                }
                break;
            case 'monthly':
                for ($i = 9; $i >= 0; $i--) {
                    $dates[] = Carbon::now()->subMonths($i)->startOfMonth()->toDateString();
                }
                break;
            case 'yearly':
                for ($i = 9; $i >= 0; $i--) {
                    $dates[] = Carbon::now()->subYears($i)->startOfYear()->toDateString();
                }
                break;
            default:
                for ($i = 9; $i >= 0; $i--) {
                    $dates[] = Carbon::now()->subDays($i)->toDateString();
                }
                break;
        }
        return $dates;
    }

    private static function SUM_DATA($query, $field)
    {
        $data = [
            'date' => [],
            'data' => [],
        ];

        foreach (self::DATE_RANGE() as $date) {
            $builder = clone $query;

            switch (self::$period) {
                case 'weekly':
                    $builder->whereBetween('created_at', [Carbon::parse($date), Carbon::parse($date)->endOfWeek()]);
                    $label = Carbon::parse($date)->format('W Y');
                    break;
                case 'monthly':
                    $builder->whereBetween('created_at', [Carbon::parse($date), Carbon::parse($date)->endOfMonth()]);
                    $label = Carbon::parse($date)->translatedFormat('F Y');
                    break;
                case 'yearly':
                    $builder->whereBetween('created_at', [Carbon::parse($date), Carbon::parse($date)->endOfYear()]);
                    $label = Carbon::parse($date)->format('Y');
                    break;
                default:
                    $builder->whereDate('created_at', $date);
                    $label = Carbon::parse($date)->format('Y-m-d');
                    break;
            }

            $data['date'][] = $label;
            $data['data'][] = $builder->sum($field);
        }

        return $data;
    }

    private static function FETCH_DATA($query)
    {
        $data = [
            'date' => [],
            'data' => [],
        ];

        foreach (self::DATE_RANGE() as $date) {
            $builder = clone $query;

            switch (self::$period) {
                case 'weekly':
                    $builder->whereBetween('created_at', [Carbon::parse($date), Carbon::parse($date)->endOfWeek()]);
                    $label = Carbon::parse($date)->format('W Y');
                    break;
                case 'monthly':
                    $builder->whereBetween('created_at', [Carbon::parse($date), Carbon::parse($date)->endOfMonth()]);
                    $label = Carbon::parse($date)->translatedFormat('F Y');
                    break;
                case 'yearly':
                    $builder->whereBetween('created_at', [Carbon::parse($date), Carbon::parse($date)->endOfYear()]);
                    $label = Carbon::parse($date)->format('Y');
                    break;
                default:
                    $builder->whereDate('created_at', $date);
                    $label = Carbon::parse($date)->format('Y-m-d');
                    break;
            }

            $data['date'][] = $label;
            $data['data'][] = $builder->count();
        }

        return $data;
    }

    public static function CHART_DATA($model, $period)
    {
        self::PERIOD($period);
        return self::FETCH_DATA($model);
    }

    public static function CHART_SUM($model, $period, $field)
    {
        self::PERIOD($period);
        return self::SUM_DATA($model, $field);
    }

    public static function TOTAL_DATA($model, $period)
    {
        self::PERIOD($period);
        $total = 0;

        foreach (self::DATE_RANGE() as $date) {
            $builder = clone $model;

            switch (self::$period) {
                case 'weekly':
                    $builder->whereBetween('created_at', [Carbon::parse($date), Carbon::parse($date)->endOfWeek()]);
                    break;
                case 'monthly':
                    $builder->whereBetween('created_at', [Carbon::parse($date), Carbon::parse($date)->endOfMonth()]);
                    break;
                case 'yearly':
                    $builder->whereBetween('created_at', [Carbon::parse($date), Carbon::parse($date)->endOfYear()]);
                    break;
                default:
                    $builder->whereDate('created_at', $date);
                    break;
            }

            $total += $builder->count();
        }

        return $total;
    }

    public static function SUM_FIELD($model, $period, $field)
    {
        self::PERIOD($period);
        $sum = 0;

        foreach (self::DATE_RANGE() as $date) {
            $builder = clone $model;

            switch (self::$period) {
                case 'weekly':
                    $builder->whereBetween('created_at', [Carbon::parse($date), Carbon::parse($date)->endOfWeek()]);
                    break;
                case 'monthly':
                    $builder->whereBetween('created_at', [Carbon::parse($date), Carbon::parse($date)->endOfMonth()]);
                    break;
                case 'yearly':
                    $builder->whereBetween('created_at', [Carbon::parse($date), Carbon::parse($date)->endOfYear()]);
                    break;
                default:
                    $builder->whereDate('created_at', $date);
                    break;
            }

            $sum += $builder->sum($field);
        }

        return $sum;
    }
}
