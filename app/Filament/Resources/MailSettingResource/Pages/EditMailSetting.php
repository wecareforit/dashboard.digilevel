<?php
namespace App\Filament\Resources\MailSettingResource\Pages;

use App\Filament\Resources\MailSettingResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class EditMailSetting extends EditRecord
{
    protected static string $resource = MailSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function beforeSave(): void
    {
        $data = $this->data;

        // Temporarily configure mail settings
        Config::set('mail.mailers.smtp.host', $data['mail_host']);
        Config::set('mail.mailers.smtp.port', $data['mail_port']);
        Config::set('mail.mailers.smtp.username', $data['mail_username']);
        Config::set('mail.mailers.smtp.password', $data['mail_password']);
        Config::set('mail.mailers.smtp.encryption', $data['mail_encryption']);
        Config::set('mail.default', 'smtp');
        Config::set('mail.from.address', $data['mail_from_address']);
        Config::set('mail.from.name', $data['mail_from_name']);

        try {
            // Attempt to send a test email to the from address
            Mail::raw('Test mail configuration', function ($message) use ($data) {
                $message->to($data['mail_from_address']);
                $message->subject('Mail Configuration Test');
            });
        } catch (\Exception $e) {
            Notification::make()
                ->title('Mail Configuration Failed')
                ->body('Could not send a test email. Please check your settings. Error: ' . $e->getMessage())
                ->danger()
                ->persistent()
                ->send();

            // Prevent saving the form
            $this->halt();
        }
    }

}
