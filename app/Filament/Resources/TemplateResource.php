<?php

namespace App\Filament\Resources;

use App\Actions\PublishMailAction;
use App\Actions\UnpublishMailAction;
use App\Filament\Resources\TemplateResource\Pages;
use App\Filament\Resources\TemplateResource\RelationManagers;
use App\Models\Template;
use App\Providers\MailServiceProvider;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use FilamentTiptapEditor\Enums\TiptapOutput;
use FilamentTiptapEditor\TiptapEditor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TemplateResource extends Resource
{
    protected static ?string $model = Template::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make([
                    TextInput::make('fallback_to')
                        ->label('To')
                        ->dehydrateStateUsing(fn ($state) => MailServiceProvider::formatMailAddressesAsArray($state, ',')),
                    TextInput::make('fallback_cc')
                        ->label('Cc')
                        ->dehydrateStateUsing(fn ($state) => MailServiceProvider::formatMailAddressesAsArray($state, ',')),
                    TextInput::make('fallback_bcc')
                        ->label('Bcc')
                        ->dehydrateStateUsing(fn ($state) => MailServiceProvider::formatMailAddressesAsArray($state, ',')),
                ])
                    ->collapsible(true)
                    ->heading('Fallback')
                    ->collapsed(true)
                    ->columns(2),
                Section::make([
                    TextInput::make('name')
                        ->required()
                        ->maxLength(50)
                        ->label('Name')
                        ->columnSpanFull()
                        ->maxLength(100),
                    TextInput::make('subject')
                        ->required()
                        ->maxLength(50)
                        ->label('Subject')
                        ->columnSpanFull()
                        ->maxLength(200)
                        ->required(),
                    TextInput::make('content')
                        ->label('Content')
                        ->required()
                        ->columnSpanFull(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->searchable()
                    ->sortable()
                    ->label('Id'),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('Name')
                    ->badge()
                    ->color(fn ($record) => $record->is_published ? 'success' : 'danger'),
                TextColumn::make('subject')
                    ->searchable()
                    ->sortable()
                    ->label('Subject'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Created at')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Updated at')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    ActionGroup::make([
                        Tables\Actions\ViewAction::make(),
                        Tables\Actions\EditAction::make(),
                    ])->dropdown(false),
                    ActionGroup::make([
                        PublishMailAction::make()
                            ->visible(fn ($record) => !$record->is_published),
                        UnpublishMailAction::make()
                            ->visible(fn ($record) => $record->is_published),
                    ])->dropdown(false),
                ]),
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
            'index' => Pages\ListTemplates::route('/'),
            'create' => Pages\CreateTemplate::route('/create'),
            'edit' => Pages\EditTemplate::route('/{record}/edit'),
        ];
    }
}
