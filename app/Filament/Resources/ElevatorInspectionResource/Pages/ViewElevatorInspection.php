<?php

namespace App\Filament\Resources\ElevatorInspectionResource\Pages;

use App\Filament\Resources\ElevatorInspectionResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Forms\Components\TextInput;
use Filament\Support\Enums\MaxWidth;
use App\Enums\InspectionStatus;
use Filament\Forms;


class ViewElevatorInspection extends ViewRecord
{
    protected static string $resource = ElevatorInspectionResource::class;


    
 protected function getHeaderActions(): array
    {
        return [

            
   Actions\Action::make("Downloadcertificaat")->color("warning")
                ->label("Download certificaat")
                                ->link()
                ->icon("heroicon-o-document-arrow-down")
                ->color('primary')
                ->fillForm(
                    fn($record): array => [
                        'filename' => $record->status_id->getLabel() .
                            ' - Certificaat' .
                            ($record?->elevator?->location?->address
                                ? ' - ' . $record->elevator->location->address . ', ' . $record->elevator->location->place
                                : ''),
                    ]
                )
                ->hidden(fn($record) => $record->certification ? false : true)

                ->action(function ($data, $record) {
                    if ($record->schedule_run_token) {
                        $contents = base64_decode($record->certification);
                        $path     = public_path($data["filename"] . ".pdf");

                        file_put_contents($path, $contents);
                        return response()
                            ->download($path)
                            ->deleteFileAfterSend(true);
                    } else {

                        $path = "storage/" . $record["certification"];

                        return response()
                            ->download($path);

                    }

                })
                ->modalWidth(MaxWidth::Large)
                ->modalHeading("Certificaat downloaden")
                ->modalDescription(
                    "Geef een bestandsnaam om om het bestand te downloaden"
                )

                ->form([
                    TextInput::make("filename")
                        ->label("Bestandsnaam")
                        ->required(),
                ])
                ->visible(fn($record) => $record?->certification ?? true),

            Actions\Action::make("Downloaddocument")->color("warning")
            ->link()
                ->label("Download rapport")
                ->icon("heroicon-o-document-arrow-down")
                ->fillForm(
                    fn($record): array => [
                        'filename' => $record->status_id->getLabel() .
                            ' - Rapport' .
                            ($record?->elevator?->location?->address
                                ? ' - ' . $record->elevator->location->address . ', ' . $record->elevator->location->place
                                : ''),
                    ]
                )
                ->hidden(fn($record) => $record->document ? false : true)

                ->action(function ($data, $record) {
                    if ($record->schedule_run_token) {
                        $contents = base64_decode($record->document);
                        $path     = public_path($data["filename"] . ".pdf");

                        file_put_contents($path, $contents);
                        return response()
                            ->download($path)
                            ->deleteFileAfterSend(true);
                    } else {

                        $path = "storage/" . $record["document"];

                        return response()
                            ->download($path);

                    }

                })
                ->modalWidth(MaxWidth::Large)
                ->modalHeading("Bestand downloaden")
                ->modalDescription(
                    "Geef een bestandsnaam om om het bestand te downloaden"
                )

                ->form([
                    TextInput::make("filename")
                        ->label("Bestandsnaam")
                        ->required(),
                ])
                ->visible(fn($record) => $record?->document ?? true),

             
  // ✅ Change Status action with form
            Actions\Action::make('changeStatus')
                ->label('Status aanpassen')
                ->icon('heroicon-m-adjustments-horizontal')
                ->color('info')
           
                ->form([
                    Forms\Components\Select::make('status_id')
                        ->label('Status aanpassen')
                        ->options(InspectionStatus::class)
                        ->default(fn ($record) => $record->status_id)
                        ->required(),
                ])
                     ->modalWidth(MaxWidth::Small)
                ->modalHeading('Status aanpassen')
                ->modalDescription('Pas de status van deze keuring aan')
                ->action(function (array $data): void {
                  
                    $this->record->update([
                        'status_id' => $data['status_id'],
                    ]);

                   

            
                }),

    
        ];



        

    }

        public function getSubheading(): ?string
    {
        if ($this->getRecord()->schedule_run_token) {
            return "Geimporteerd vanuit de koppeling met " . $this->getRecord()?->inspectioncompany?->name;
        } else {
            return "";
        }

    }


}
