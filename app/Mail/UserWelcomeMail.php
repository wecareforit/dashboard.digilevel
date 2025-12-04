<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserWelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    use Queueable, SerializesModels;

    public $record;

    public function __construct($record)
    {


        
        $this->record = $record;
    }

    public function build()
    {
        return $this->subject('Gebruikers account aangemaakt')
            ->view('emails.user-welcome-mail');
    }

}
