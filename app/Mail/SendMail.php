<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use phpDocumentor\Reflection\Types\This;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $details;
    public $code;
    public $email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details,$code,$email)
    {
        $this->details = $details;
        $this->code=$code;
        $this->email=$email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    
    public function build()
    {
        return $this->subject('Khôi phục mật khẩu')
                    ->view('emails.send-mail');
    }
}