<?php

declare(strict_types=1);

namespace App\Events;

use App\Contracts\HasVerifySource;
use Illuminate\Queue\SerializesModels;

final class RequestVerification
{
    use SerializesModels;

    public $user;
    public $source;

    public function __construct(HasVerifySource $user, string $source)
    {
        $this->user = $user;
        $this->source = $source;
    }
}
