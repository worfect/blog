<?php

declare(strict_types=1);

namespace App\Traits;

trait Status
{

    public function getStatusesId(): array
    {
        $statuses = [];
        foreach ($this->statuses as $status){
            $statuses[$status->id] = $status->pivot->expires;
        }
        return $statuses;
    }

    public function getStatuses(): array
    {
        $statuses = [];
        foreach ($this->statuses as $status){
            $statuses[$status->name] = $status->pivot->expires;
        }
        return $statuses;
    }

    public function isDeleted(): bool
    {
        return array_key_exists(\App\Models\Status::DELETED, $this->getStatusesId());
    }

    public function isBanned(): bool
    {
        return array_key_exists(\App\Models\Status::BANNED, $this->getStatusesId());
    }

    public function isActive(): bool
    {
        return array_key_exists(\App\Models\Status::ACTIVE, $this->getStatusesId());
    }

    public function isWait(): bool
    {
        return array_key_exists(\App\Models\Status::WAIT, $this->getStatusesId());
    }



    public function setDeleted(): bool
    {
        $this->statuses()->attach(\App\Models\Status::DELETED);
        return $this->save();
    }

    public function setBanned(): bool
    {
        $this->statuses()->attach(\App\Models\Status::BANNED);
        return $this->save();
    }

    public function setActive(): bool
    {
        $this->statuses()->attach(\App\Models\Status::ACTIVE);
        $this->statuses()->detach(\App\Models\Status::WAIT);
        return $this->save();
    }

    public function setWait(): bool
    {
        $this->statuses()->attach(\App\Models\Status::WAIT);
        $this->statuses()->detach(\App\Models\Status::ACTIVE);
        return $this->save();
    }


    public function removeDeleted(): bool
    {
        $this->statuses()->detach(\App\Models\Status::DELETED);
        return $this->save();
    }

    public function removeBanned(): bool
    {
        $this->statuses()->detach(\App\Models\Status::BANNED);
        return $this->save();
    }

}
