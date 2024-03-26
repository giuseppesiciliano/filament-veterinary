<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PatientResource\Pages;
use App\Filament\Resources\PatientResource\RelationManagers;
use App\Models\Patient;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Carbon\Carbon;
use Closure;
use App\Enums\PatientSex;
use App\Enums\PatientType;



class PatientResource extends Resource
{
    protected static ?string $model = Patient::class;

    protected static ?string $navigationIcon = 'fas-dog';

    public static function getModelLabel(): string
    {
        return __('Patient');
    }
    public static function getPluralModelLabel(): string
    {
        return __('Patients');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make()
                ->columns(3)
                    ->schema([

                        FileUpload::make('image')
                        ->nullable()
                        ->columnSpan(1)
                        ->translateLabel(),


                        Section::make()
                            ->columnSpan(1)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->translateLabel(),
        
                                Forms\Components\Select::make('type')
                                    ->options(PatientType::class)
                                    ->required()
                                    ->translateLabel(),
            
                                Forms\Components\Radio::make('sex')
                                    ->options(PatientSex::class)
                                    ->inLine()
                                    ->inlineLabel(false)
                                    ->translateLabel(),
                            ]),

                        Section::make()
                            ->columnSpan(1)
                            ->schema([
                                Forms\Components\TextInput::make('microchip')
                                    ->nullable()
                                    ->maxLength(20)
                                    ->unique(ignorable: fn ($record) => $record),
        
                                Forms\Components\DatePicker::make('date_of_birth')
                                    ->required()
                                    ->reactive()
                                    ->maxDate(now())
                                    ->translateLabel(),
            

                                Forms\Components\Select::make('owner_id')
                                    ->required()
                                    ->relationship('owner', 'name')
                                        ->required()
                                        ->searchable()
                                        ->preload()
                                        ->translateLabel()
                                        ->createOptionForm([
                                            Forms\Components\TextInput::make('name')
                                                ->required()
                                                ->maxLength(255)
                                                ->translateLabel(),
                                            Forms\Components\TextInput::make('email')
                                                ->label('Email address')
                                                ->email()
                                                ->required()
                                                ->maxLength(255)
                                                ->translateLabel(),
                                            Forms\Components\TextInput::make('phone')
                                                ->label('Phone number')
                                                ->tel()
                                                ->required()
                                                ->translateLabel(),
                                        ])
                                        ->required(),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->translateLabel(),
                Tables\Columns\TextColumn::make('sex')
                    ->badge()
                    ->translateLabel(),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->translateLabel(),
                Tables\Columns\TextColumn::make('age')
                    ->translateLabel()
                    ->formatStateUsing( fn (?string $state) => __(':attribute years', ['attribute' => $state]))
                    ->sortable(),
                Tables\Columns\TextColumn::make('owner.name')
                    ->searchable()
                    ->translateLabel(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options(PatientType::class)
                    ->translateLabel(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            RelationManagers\TreatmentsRelationManager::class,
            RelationManagers\TasksRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPatients::route('/'),
            'create' => Pages\CreatePatient::route('/create'),
            'edit' => Pages\EditPatient::route('/{record}/edit'),
        ];
    }
}
