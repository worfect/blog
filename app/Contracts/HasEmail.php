<?php


namespace App\Contracts;


use Illuminate\Mail\Mailable;

interface HasEmail
{
    public function hasEmail();

    public function setEmail($email);

    public function getEmail();

    public function sendToEmail(Mailable $mail);

    public function emailIsVerify();

    public function verifyEmail();
}
