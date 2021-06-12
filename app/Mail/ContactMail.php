<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $contact_details;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($contact_details)
    {
        $this->contact_details = $contact_details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
                // view for the shipped email
                return $this->from('noreply@juju.com')
                        ->subject('Automated Reply For Contact Message -'.$this->contact_details->subject)
                        ->view('emails.contact')
                        ->with([
                            'name' => $this->contact_details->name,
                            'number'=>$this->contact_details->number,
                            //! for mail obj cannot be converted to string error don't use message instead you can use anything else like form_message
                            'form_message'=>$this->contact_details->message
                            ]);
    }
}
