<?php

namespace App\Traits;

trait WithNotify
{
    public function notifySuccess(string $message)
    {
        $this->dispatch('toast', variant: 'success', message: $message);
    }

    public function notifyError(string $message)
    {
        $this->dispatch('toast', variant: 'error', message: $message);
    }

    public function notifyWarning(string $message)
    {
        $this->dispatch('toast', variant: 'warning', message: $message);
    }

    public function notifyInfo(string $message)
    {
        $this->dispatch('toast', variant: 'info', message: $message);
    }
}
