<?php

namespace App\Filament\Resources\PMKResource\Pages;

use App\Filament\Resources\PMKResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPMKS extends ListRecords
{
    protected static string $resource = PMKResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
