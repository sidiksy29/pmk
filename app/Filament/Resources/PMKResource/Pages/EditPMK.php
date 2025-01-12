<?php

namespace App\Filament\Resources\PMKResource\Pages;

use App\Filament\Resources\PMKResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPMK extends EditRecord
{
    protected static string $resource = PMKResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
