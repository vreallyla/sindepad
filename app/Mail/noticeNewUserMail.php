<?php

namespace App\Mail;

use App\contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class noticeNewUserMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $contact;

    public function __construct($old)
    {
        $this->user = $old;
        $this->contact = contact::all()->first();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $interval = strpos($this->user['name'], ' ');
        if ($interval) {
            $this->user['short'] = substr($this->user['name'], 0, $interval);
        }
        return $this->from(env('MAIL_USERNAME'), 'Sanggar ABK')
            ->subject('Aktivasi Akun Sanggar ABK')
            ->view('mails.admin.noticeNewUser');
    }
}
