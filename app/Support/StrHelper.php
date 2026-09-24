<?php

namespace App\Support;

class StrHelper
{
    /**
     * Convert Persian and Arabic digits to standard ASCII digits.
     */
    public static function normalizeDigits(?string $input): ?string
    {
        if ($input === null) {
            return null;
        }

        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $arabic = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
        $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

        $string = str_replace($persian, $english, $input);

        return str_replace($arabic, $english, $string);
    }

    /**
     * Normalize an Iranian phone number to standard 09XXXXXXXXX format.
     */
    public static function normalizePhone(?string $phone): ?string
    {
        if ($phone === null) {
            return null;
        }

        $phone = static::normalizeDigits(trim($phone));
        $phone = preg_replace('/[\s\-\(\)]+/', '', $phone);

        if (str_starts_with($phone, '+98')) {
            $phone = '0'.substr($phone, 3);
        } elseif (str_starts_with($phone, '0098')) {
            $phone = '0'.substr($phone, 4);
        } elseif (str_starts_with($phone, '98') && strlen($phone) === 12) {
            $phone = '0'.substr($phone, 2);
        }

        return $phone;
    }
}
