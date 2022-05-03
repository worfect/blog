<?php

declare(strict_types=1);

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

    public function enableMultiFactor(): bool;

    public function disableMultiFactor(): bool;

    public function isMultiFactor(): bool;
}
