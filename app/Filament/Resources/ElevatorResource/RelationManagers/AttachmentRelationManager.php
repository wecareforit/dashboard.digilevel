<?php
namespace App\Filament\Resources\ElevatorResource\RelationManagers;

use App\Models\uploadType;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class AttachmentRelationManager extends RelationManager
{
    protected static string $relationship = 'uploads';
    protected static bool $isLazy         = false;

    public static function getBadge($ownerRecord, string $pageClass): ?string
    {
        return $ownerRecord
            ->uploads
            ->count();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Textarea::make('description')
                    ->label('Omschrijving')
                    ->required()
                    ->maxLength(255),

                Select::make("upload_type_id")
                    ->label("Type")
                    ->placeholder("Type")
                    ->options(uploadType::where("is_active", 1)->where('visible_object_attachments', 1)->pluck("name", "id")),

                FileUpload::make('filename')
                    ->label('Bijlage')
                    ->columnSpan(3)
                    ->preserveFilenames()
                    ->required()
                    ->visibility('private')->directory(function () {
                    $parent_id = $this->getOwnerRecord()->id;
                    return '/uploads/elevator/' . $parent_id . '/attachments';
                })
                    ->columnSpan(2),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->groups([
                Group::make('type.name')
                    ->label('Type'),
            ])
            ->defaultGroup('type.name')
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('description'),
                Tables\Columns\TextColumn::make('type.name'),
            ])
            ->filters([
                SelectFilter::make('upload_type_id')
                    ->placeholder('Onbekend')
                    ->label('Onderhoudspartij')
                    ->options(uploadType::where("is_active", 1)->where('visible_object_attachments', 1)->pluck("name", "id")),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $data["add_by_user"] = auth()->id();
                        $data["module_id"]   = 2;
                        $data["item_id"]     = $this->getOwnerRecord()->status_id;
                        return $data;
                    })->label("Upload toevoegen"),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()

                    ->modalHeading('Bijlage toevoegen')
                    ->label('Toevoegen')])->actions([

            Tables\Actions\Action::make('Download')
                ->label('Download bestand')
                ->action(fn($record) => Storage::disk('private')
                        ->download($record->filename))
                ->icon('heroicon-o-document-arrow-down'),

            ActionGroup::make(
                [
                    Tables\Actions\EditAction::make()
                        ->modalHeading('Wijzig bijlage'),
                    Tables\Actions\DeleteAction::make(),
                ]),

        ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
