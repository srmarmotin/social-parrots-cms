<?php

namespace App\Filament\Resources\Avatars\Pages;

use App\Filament\Resources\Avatars\AvatarResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
use Filament\Support\Enums\Width;

class ManageAvatars extends ManageRecords
{
    protected static string $resource = AvatarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->modalWidth(Width::Small)
                ->createAnother(false)
        ];
    }
}
