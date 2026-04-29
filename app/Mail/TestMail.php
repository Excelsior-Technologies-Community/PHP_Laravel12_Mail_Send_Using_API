<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $details;

    public function __construct($details)
    {
        $this->details = $details;
    }

    public function build()
    {
        $mail = $this->subject($this->details['title'])
                     ->view('emails.test');

        if (isset($this->details['file']) && $this->details['file']) {
            $mail->attach($this->details['file']);
        }

        return $mail;
    }
}