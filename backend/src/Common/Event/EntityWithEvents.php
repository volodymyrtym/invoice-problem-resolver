<?php

namespace App\Common\Event;

use Symfony\Contracts\EventDispatcher\Event;

class EntityWithEvents extends Event
{
    /** @var array<object> */
    private array $events;

    private function recordEvent(object $event): void
    {
        $this->events[] = $event;
    }

    final public function pullEvents(): array
    {
        $recordedEvents = $this->events;
        $this->events = [];

        return $recordedEvents;
    }

    final public function hasEvents(): bool
    {
        return !empty($this->events);
    }
}
