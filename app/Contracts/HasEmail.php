<?php

declare(strict_types=1);

namespace App\Contracts;

use Illuminate\Contracts\Mail\Mailable as MailableContract;

interface HasEmail
{
    public function setEmail(string $email);

    public function getEmail();

    public function hasEmail(): bool;

    public function sendToEmail(MailableContract $mail);

    public function emailConfirmed(): bool;

    public function confirmEmail();

    public function updateEmail(string $email): bool;
}
