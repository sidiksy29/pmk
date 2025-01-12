<?php

namespace App\Filament\Resources\DataKaryawanResource\Pages;

use App\Filament\Resources\DataKaryawanResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDataKaryawan extends CreateRecord
{
    protected static string $resource = DataKaryawanResource::class;

    protected static ?string $title = 'Tambah Data Karyawan';

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
