<?php

namespace Valourite\FormBuilder;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Valourite\FormBuilder\Filament\Resources\FormResource\FormResource;

final class FormBuilderPlugin implements Plugin
{
    public static function make()
    {
        return new self();
    }

    public function register(Panel $panel): void
    {
        $panel->resources([
            FormResource::class,
        ]);
    }

    public function boot(Panel $panel): void {}

    public function getId(): string
    {
        return 'form-builder';
    }
}
