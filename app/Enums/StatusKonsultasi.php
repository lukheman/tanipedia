<?php

namespace App\Enums;

enum StatusKonsultasi: string
{
    case PENDING = 'pending';
    case ACCEPTED = 'diterima';
    case REJECTED = 'ditolak';
    case COMPLETED = 'selesai';
    case CLOSED = 'ditutup';

    public function getLabel(): ?string
    {
        return $this->value;
    }

    public function getColor(): ?string
    {
        return match ($this) {
            self::PENDING => 'warning',
            self::ACCEPTED => 'primary',
            self::REJECTED => 'danger',
            self::COMPLETED => 'success',
            self::CLOSED => 'secondary',
            default => 'default'
        };
    }

    public static function values(): array
    {
        return array_map(fn ($case) => $case->value, self::cases());
    }
}
