<?php

namespace App\Enums;

enum Role: string
{
    case ADMIN = 'admin';
    case PETANI = 'petani';
    case AHLIPERTANIAN = 'penyuluh';
    case KEPALADINAS = 'kepala_dinas';

    public function getLabel(): ?string
    {
        return $this->value;
    }

    public function getColor(): ?string
    {
        return match ($this) {
            self::ADMIN => 'primary',
            self::PETANI => 'success',
            self::AHLIPERTANIAN => 'danger',
            self::KEPALADINAS => 'warning',
            default => 'default'
        };
    }

    public static function values(): array
    {
        return array_map(fn ($case) => $case->value, self::cases());
    }

    public static function getOptions(): array
    {
        return array_map(
            fn ($case) => $case->value,
            array_filter(self::cases(), fn ($case) => ! in_array($case, [self::ADMIN, self::KEPALADINAS]))
        );
    }

    public static function senders(): array
    {
        return array_map(
            fn ($case) => $case->value,
            array_filter(self::cases(), fn ($case) => in_array($case, [self::PETANI, self::AHLIPERTANIAN]))
        );
    }

}
