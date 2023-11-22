<?php 
namespace App\Validators;

use Carbon\Carbon;

class DateValidator
{
    public static function isValidDate($date, $format = 'Y-m-d'): bool
    {
        try {
            $parsedDate = Carbon::createFromFormat($format, $date, 'UTC');
            return $parsedDate && $parsedDate->format($format) === $date;
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function isNotFutureDate($date, $format = 'Y-m-d'): bool
    {
        $parsedDate = Carbon::createFromFormat($format, $date, 'UTC')->startOfDay();
        return !$parsedDate->isAfter(Carbon::now()->startOfDay());
    }

    public static function areValidDates($dateFrom, $dateTo): bool
    {
        return self::isValidDate($dateFrom) && self::isValidDate($dateTo);
    }
}
