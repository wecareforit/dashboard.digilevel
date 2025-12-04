<?php
namespace App\Mail;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use app\Enums\TaskTypes ;


class TicketToUser extends Mailable
{
    use Queueable, SerializesModels;


    public $data; 

    public function __construct(
        public $task,
        public string $mailsubject
    ) {
        $this->data = $task; 
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->mailsubject
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.tickettouser',
             with: [
                'data' => $this->data,
            ],
        );
    }
}
