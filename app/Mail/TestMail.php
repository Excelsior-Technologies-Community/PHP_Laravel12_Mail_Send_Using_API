<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class TestMail extends Mailable
{
    // Public property to store mail details (title and body)
    public $details;

    /**
     * Constructor to initialize the Mailable with details
     *
     * @param array $details - Should contain 'title' and 'body' keys
     */
    public function __construct($details)
    {
        $this->details = $details; // Store the details to be accessible in the email view
    }

    /**
     * Build the email message
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->details['title']) // Set the email subject
                    ->view('emails.test');           // Load the Blade view for email content
    }
}

