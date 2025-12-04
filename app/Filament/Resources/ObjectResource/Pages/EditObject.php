<?php

namespace App\Filament\Resources\ObjectResource\Pages;

use App\Filament\Resources\ObjectResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Models\ObjectLocation;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use App\Models\Customer;
use Filament\Support\Enums\MaxWidth;
use Filament\Forms\Get;
use Filament\Forms\Set;
class EditObject extends EditRecord
{
    protected static string $resource = ObjectResource::class;
    protected static ?string $title = 'Object wijzigen';
  
    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('updateAuthor')
            ->fillForm(fn ($record): array => [
                'customer_id' => $record->customer_id,
                'address_id'  => $record->address_id,
            ])
            ->form([
                Select::make('customer_id')
                    ->label("Relatie")
                    ->live()
                    ->searchable()
                    ->options(Customer::whereHas('locations')->pluck('name', 'id'))
                    ->helperText('Allen relaties met locaties worden getoond'),
                Select::make('address_id')
                    ->label("Locatie")
                    ->options(function (Get $get){
                        return ObjectLocation::where('customer_id',$get('customer_id'))->pluck('name', 'id');
                })
                ->preload()
            ])
            ->action(function (array $data,$record): void {
                $record->address_id  = $data['address_id'];
                $record->customer_id = $data['customer_id'];
                $record->save();
            })
                ->icon('heroicon-o-arrows-right-left')
                ->outlined()
                ->link()
                ->label('Verplaats object')
                ->color('secondary')
                ->modalWidth(MaxWidth::Large)
                ->modalHeading('Object verplaatsen')
                ->modalDescription('Verplaatst een object naar een andere relatie en locatie.'),
            Actions\Action::make('cancel_top')
                ->label('Afbreken')
                ->icon('heroicon-o-arrow-uturn-left')
                ->url($this->previousUrl ?? $this->getResource()::getUrl('index'))
                ->iconButton(),
            Actions\DeleteAction::make()
                ->iconButton()
                ->icon('heroicon-o-trash'),
            Actions\Action::make('save_top')
                ->action('save')
                ->label('Opslaan'),
        ];
    }

        
    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }

    public function getSubheading(): ?string
    {       
        if ($this->getRecord()->location) {
            $location_name = NULL;
            if( $this->getRecord()->location?->name){
                $location_name =  " | " .  $this->getRecord()->location?->name;
            }
            return   $this->getRecord()->location->address . " " . $this->getRecord()->location->zipcode . " "  . $this->getRecord()->location->place .  $location_name ;
        } else {
            return "";
        }
    
    }
   
    protected function getFormActions(): array
    {
        return [];
    }
    
}
