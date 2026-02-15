<?php

namespace App\Filament\Resources\Avatars;

use App\Filament\Resources\Avatars\Pages\ManageAvatars;
use App\Models\Avatar;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AvatarResource extends Resource
{
    protected static ?string $model = Avatar::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::UserCircle;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1) 
            ->components([
                TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->maxLength(255),
                FileUpload::make('image_url')
                    ->label('Image')
                    ->image()
                    ->disk('public')
                    ->directory('avatars')
                    ->imageEditor()
                    ->maxSize(2048) // 2MB max
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                    ->imageResizeMode('cover')
                    ->imageCropAspectRatio('1:1')
                    ->imageResizeTargetWidth('500')
                    ->imageResizeTargetHeight('500'),
                Toggle::make('active')
                    ->label('Active')
                    ->required(),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->columns(1) 
            ->components([
                TextEntry::make('name'),
                ImageEntry::make('image_url')
                    ->disk('public')
                    ->placeholder('-'),
                IconEntry::make('active')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                ImageColumn::make('image_url')
                    ->disk('public')
                    ->label('Image'),
                ImageColumn::make('thumbnail_url')
                    ->disk('public')
                    ->label('Thumbnail'),
                IconColumn::make('active')
                    ->boolean(),
            ])
            ->recordActions([
                ViewAction::make()
                    ->iconButton()
                    ->modalWidth(Width::Small),
                EditAction::make()
                    ->iconButton(),
                DeleteAction::make()
                    ->iconButton(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageAvatars::route('/'),
        ];
    }
}
