<?php

namespace App\Enums;

enum StatusJadwal: string
{
    case DIJADWALKAN = 'dijadwalkan';
    case SELESAI = 'selesai';
    case DIBATALKAN = 'dibatalkan';
    case DIUNDUR = 'diundur';

    public function getLabel(): string
    {
        return match ($this) {
            self::DIJADWALKAN => 'Dijadwalkan',
            self::SELESAI => 'Selesai',
            self::DIBATALKAN => 'Dibatalkan',
            self::DIUNDUR => 'Diundur',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::DIJADWALKAN => 'primary',
            self::SELESAI => 'success',
            self::DIBATALKAN => 'danger',
            self::DIUNDUR => 'warning',
        };
    }

    public static function values(): array
    {
        return array_map(fn ($case) => $case->value, self::cases());
    }
}
