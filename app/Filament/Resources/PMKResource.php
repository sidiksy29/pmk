<?php

namespace App\Filament\Resources;

use App\Models\PMK;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Actions\ResetStars;
use App\Policies\PMKPolicy;
use App\Models\DataKaryawan;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Split;
use function Laravel\Prompts\select;

use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PMKResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PMKResource\RelationManagers;





class PMKResource extends Resource
{
    protected static ?string $model = PMK::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'PMK';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Split::make([
                    Section::make([
                        Select::make('nik')
                            ->label('NIK')
                            ->options(DataKaryawan::pluck('nik', 'nik'))
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($set, $state) {
                                $karyawan = DataKaryawan::where('nik', $state)->first();
                                if ($karyawan) {
                                    $set('nama_lengkap', $karyawan->nama_lengkap);
                                    $set('departemen_id', $karyawan->departemen_id);
                                }
                            })
                            ->searchable('nik')
                            ->placeholder('Masukkan NIK'),

                        Textarea::make('nama_lengkap')
                            ->label('Nama Lengkap')
                            ->readOnly()
                            ->disabled(),

                        Textarea::make('departemen_id')
                            ->label('Departemen')
                            ->readOnly()
                            ->disabled(),


                    ]),
                    Section::make([

                        Datepicker::make('tanggal')
                            ->label('Tanggal')
                            ->native(false)
                            ->default(now())
                            ->displayFormat('d/M/Y')
                            ->required(),


                        TextInput::make('no_pmk')
                            ->label('No PMK')
                            ->required()
                            ->placeholder('Masukkan No PMK'),

                        Select::make('mutasi')
                            ->options([
                                'Ijin Meninggalkan Pekerjaan' => 'Ijin Meninggalkan Pekerjaan',
                                'Perubahan Status' => 'Perubahan Status',
                                'Perubahan Jabatan' => 'Perubahan Jabatan',
                                'Perubahan Gaji' => 'Perubahan Gaji',
                                'Pengunduran Diri' => 'Pengunduran Diri',
                                'Lain-lain' => 'Lain-lain',
                            ])
                            ->label('Mutasi')
                            ->required()
                            ->native(false),

                        Textarea::make('uraian')
                            ->label('Uraian')
                            ->required()
                            ->placeholder('Masukkan Uraian'),

                        Textarea::make('catatan')
                            ->label('Catatan')
                            ->required()
                            ->placeholder('Masukkan Catatan'),




                    ]),
                ])->columnSpan(2),







            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('datakaryawan.nama_lengkap')
                    ->label('Nama Operator'),

                TextColumn::make('no_pmk')
                    ->label('No PMK'),

                textColumn::make('mutasi')
                    ->label('Mutasi'),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                    })

            ])
            ->filters([
                //
            ])
            ->actions([

            Action::make('approve_by_leader')
                ->label('Approve by Leader')
                ->color('success')
                ->icon('heroicon-o-check-circle')
                ->requiresConfirmation()
                ->action(function (PMK $record) {
                    $record->update(['approved_by_leader' => true]);
                })
                // Tombol hanya akan muncul jika belum di-approve oleh leader dan user adalah Leader
                ->visible(fn (PMK $record) => !$record->approved_by_leader && Auth::user()->role === 'Leader'),

            Action::make('approve_by_asst_manager')
                ->label('Approve by Asst Manager')
                ->color('success')
                ->icon('heroicon-o-check-circle')
                ->requiresConfirmation()
                ->action(function (PMK $record) {
                    $record->update(['approved_by_asst_manager' => true]);
                })
                // Tombol hanya akan muncul jika sudah di-approve oleh leader,
                // belum di-approve oleh asst manager, dan user adalah Asst Manager
                ->visible(fn (PMK $record) => $record->approved_by_leader && !$record->approved_by_asst_manager && Auth::user()->role === 'Asst Manager'),

            Action::make('approve_by_hrd')
                ->label('Approve by HRD')
                ->color('success')
                ->icon('heroicon-o-check-circle')
                ->requiresConfirmation()
                ->action(function (PMK $record) {
                    $record->update([
                        'approved_by_hrd' => true,
                        'status' => 'approved',
                    ]);
                })
                // Tombol hanya akan muncul jika sudah di-approve oleh asst manager,
                // belum di-approve oleh HRD, dan user adalah HRD
                ->visible(fn (PMK $record) => $record->approved_by_asst_manager && !$record->approved_by_hrd && Auth::user()->role === 'HRD'),

            Action::make('reject')
                ->label('Reject')
                ->color('danger')
                ->icon('heroicon-o-x-circle')
                ->requiresConfirmation()
                ->action(function (PMK $record) {
                    $record->update(['status' => 'rejected']);
                })
                // Tombol hanya akan muncul jika status masih pending
                ->visible(fn (PMK $record) => $record->status === 'pending'),

            ViewAction::make(),

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
            'index' => Pages\ListPMKS::route('/'),
            'create' => Pages\CreatePMK::route('/create'),
            'edit' => Pages\EditPMK::route('/{record}/edit'),
        ];
    }
}
