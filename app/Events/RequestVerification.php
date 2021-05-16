<?php


namespace App\Events;

use App\Contracts\HasVerifySource;
use Illuminate\Queue\SerializesModels;

class RequestVerification
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
