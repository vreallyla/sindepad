<?php

namespace App\Mail;

use App\contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class feedbackMail extends Mailable
{
    use Queueable, SerializesModels;

    public $set;
    public $contact;

    public function __construct($data)
    {
        $this->set=$data;
        $this->contact=contact::all()->first();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $interval=strpos($this->set,' ');
        if ($interval){
            $this->set=substr($this->set,0,$interval);
        }
        return $this->from(env('MAIL_USERNAME'), 'Sanggar ABK')
            ->subject('Pesan anda kami terima...')
            ->view('mails.feedbackMail');
    }
}
