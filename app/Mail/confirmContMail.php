<?php

namespace App\Mail;

use App\contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class confirmContMail extends Mailable
{
    use Queueable, SerializesModels;


    public $cont;
    public $contact;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($contributor)
    {
        $this->cont=$contributor;
        $this->contact=contact::all()->first();
    }

    public function build()
    {
        return $this->from(env('MAIL_USERNAME'), 'Sanggar ABK')
            ->subject('Konfirmasi Sumbangan Sanggar ABK')
            ->view('mails.admin.confContMail');
    }
}
