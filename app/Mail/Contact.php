<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\DB\BusinessInformation;

class Contact extends Mailable
{
    use Queueable, SerializesModels;

    public $contact;
    public $business;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($contact)
    {
        $this->business =  BusinessInformation::first();
        $this->contact = $contact;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.mailers.smtp.username'), $this->business->name)
        ->subject('Nuevo mensaje de contacto')
        ->markdown('email.contact')
        ->with('contact', $this->contact);
    }
}
