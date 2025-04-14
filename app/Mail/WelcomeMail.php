<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;
    public $details;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if(array_key_exists("password",$this->details))
        {
            $data = array(
                'name'=>$this->details['name'],
                'email'=>$this->details['email'],
                'password'=>$this->details['password'],
            );
        }
        else
        {
            $data = array(
                'name'=>$this->details['name'],
                'email'=>$this->details['email'],
            );
        }
        return $this->subject('Welcome')
                    ->view('mailable.welcome-mail',compact('data'));
    }
}
