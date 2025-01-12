<?php

namespace App\Filament\Resources\PMKResource\Pages;

use App\Filament\Resources\PMKResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePMK extends CreateRecord
{
    protected static string $resource = PMKResource::class;

    protected static ?string $title = 'Tambah Data PMK';

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

}
