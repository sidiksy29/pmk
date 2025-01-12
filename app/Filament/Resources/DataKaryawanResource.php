<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use app\Models\Departemen;
use Filament\Tables\Table;
use App\Models\DataKaryawan;
use Illuminate\Validation\Rule;
use Filament\Resources\Resource;
use function Laravel\Prompts\text;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\DataKaryawanResource\Pages;
use App\Filament\Resources\DataKaryawanResource\RelationManagers;

class DataKaryawanResource extends Resource
{
    protected static ?string $model = DataKaryawan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Data Karyawan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nik')
                    ->label('NIK')
                    ->required()
                    ->unique(DataKaryawan::class, 'nik', ignorable: fn ($record) => $record)
                    ->placeholder('Masukkan NIK'),
                TextInput::make('nama_lengkap')
                    ->label('Nama Lengkap')
                    ->required()
                    ->placeholder('Masukkan Nama Lengkap'),
                TextInput::make('alamat')
                    ->label('Alamat')
                    ->required()
                    ->placeholder('Masukkan Alamat'),
                Datepicker::make('tanggal_lahir')
                    ->label('Tanggal Lahir')
                    ->required()
                    ->placeholder('Pilih Tanggal Lahir'),
                TextInput::make('email')
                    ->label('Email')
                    ->required()
                    ->email()
                    ->placeholder('Masukkan Email'),
                TextInput::make('telepon')
                    ->label('Telepon')
                    ->required()
                    ->placeholder('Masukkan Telepon'),
                Select::make('departemen_id')
                    ->label('Departemen')
                    ->relationship('departemen', 'nama')
                    ->required()
                    ->placeholder('Masukkan Departemen'),
                Datepicker::make('tanggal_masuk')
                    ->label('Tanggal Masuk')
                    ->required()
                    ->placeholder('Pilih Tanggal Masuk'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nik')
                    ->label('NIK'),
                TextColumn::make('nama_lengkap')
                    ->label('Nama Lengkap'),
                TextColumn::make('departemen.nama')
                    ->label('Departemen'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDataKaryawans::route('/'),
            'create' => Pages\CreateDataKaryawan::route('/create'),
            'edit' => Pages\EditDataKaryawan::route('/{record}/edit'),
        ];
    }
}
