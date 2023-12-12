<?php declare(strict_types=1);

namespace Antwerpes\LaravelEventStore;

use Illuminate\Support\Arr;

class EventStore
{
    protected array $events = [];

    public function push(string $name, array $payload = []): void
    {
        $this->events[] = [
            'name' => $name,
            'payload' => $payload,
        ];
    }

    public function getEvents(): array
    {
        return $this->events;
    }

    public function setEvents(array $events): void
    {
        $this->events = $events;
    }

    public function hasEvents(): bool
    {
        return ! empty($this->events);
    }

    public function clear(): void
    {
        $this->events = [];
    }

    public function pullEventsForGoogleTagManager(): array
    {
        return Arr::map($this->pullEvents(), static fn (array $event) => array_merge([
            'event' => $event['name'],
        ], $event['payload']));
    }

    public function dumpForGTM(): string
    {
        return json_encode($this->pullEventsForGoogleTagManager(), JSON_UNESCAPED_UNICODE);
    }

    protected function pullEvents(): array
    {
        $events = $this->events;
        $this->events = [];

        return $events;
    }
}
