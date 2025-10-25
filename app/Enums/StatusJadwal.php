<?php

namespace App\Enums;

enum StatusJadwal: string
{
    case TERJADWAL = 'terjadwal';
    case SELESAI = 'selesai';
    case DIBATALKAN = 'dibatalkan';

    public function getLabel(): string
    {
        return match ($this) {
            self::TERJADWAL => 'Terjadwal',
            self::SELESAI => 'Selesai',
            self::DIBATALKAN => 'Dibatalkan',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::TERJADWAL => 'primary',
            self::SELESAI => 'success',
            self::DIBATALKAN => 'danger',
        };
    }

    public static function values(): array
    {
        return array_map(fn ($case) => $case->value, self::cases());
    }

}
