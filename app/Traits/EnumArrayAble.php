<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait EnumArrayAble
{
    public static function array(array $except = []): array
    {
        return array_map(function ($case) use ($except) {
            if (! in_array($case->value, $except)) {
                return [
                    'label' => $case->label(),
                    'value' => $case->value,
                ];
            }
        }, self::cases());
    }

    public static function values(array $except = []): array
    {
        return array_map(function ($case) use ($except) {
            if (! in_array($case->value, $except)) {
                return $case->value;
            }
        }, self::cases());
    }

    public function label(): string
    {
        return Str::title($this->value);
    }
}
