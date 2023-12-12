<?php

namespace Antwerpes\LaravelEventStore\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void push(string $name, array $payload = [])
 * @method static string dumpForGTM()
 * @method static array getEvents()
 * @method static void setEvents(array $events)
 * @method static bool hasEvents()
 * @method static array pullEventsForGoogleTagManager()
 * @method static void clear()
 *
 * @see \Antwerpes\LaravelEventStore\EventStore
 */
class EventStore extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Antwerpes\LaravelEventStore\EventStore::class;
    }
}
