<?php

namespace backend\modules\user\events;

trait EventTrait
{
    private $events = [];

    public function recordEvent($event): void
    {
        $this->events[] = $event;
    }

    public function releaseEvents(): array
    {
        $events = $this->events;
        $this->events = [];
        return $events;
    }
}