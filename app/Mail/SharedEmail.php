<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SharedEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $mailData;

    public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }

    public function build()
    {
        return $this->from('bb.roger@rcssoft.com.br', 'App Notes')
            ->subject('Convite para fazer parte do App Notes')
            ->view('mails/shared_mail')
            ->with(['mailData' => $this->mailData]);
    }
}
