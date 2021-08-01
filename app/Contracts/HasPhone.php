<?php


namespace App\Contracts;


interface HasPhone
{
    public function setPhone(int $phone);

    public function getPhone();

    public function hasPhone(): bool;

    public function sendToPhone(string $text);

    public function phoneConfirmed(): bool;

    public function confirmPhone();

    public function updatePhone(int $phone): bool;
}
