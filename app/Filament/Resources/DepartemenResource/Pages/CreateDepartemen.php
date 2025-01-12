<?php

namespace App\Filament\Resources\DepartemenResource\Pages;

use App\Filament\Resources\DepartemenResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDepartemen extends CreateRecord
{
    protected static string $resource = DepartemenResource::class;

    protected static ?string $title = 'Tambah Data Departemen';

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

}
