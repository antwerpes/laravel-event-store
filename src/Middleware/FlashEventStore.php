<?php declare(strict_types=1);

namespace Antwerpes\LaravelEventStore\Middleware;

use Antwerpes\LaravelEventStore\EventStore;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Session\Store as Session;
use Symfony\Component\HttpFoundation\Response;

class FlashEventStore
{
    public function __construct(
        protected readonly EventStore $eventStore,
        protected readonly Session $session,
    ) {}

    /**
     * Handle an incoming request.
     *
     * @param Closure(Request):Response $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $key = config('event-store.session_key');

        if ($this->session->has($key)) {
            $this->eventStore->setEvents($this->session->get($key));
        }

        $response = $next($request);

        if ($this->eventStore->hasEvents()) {
            $this->session->flash($key, $this->eventStore->getEvents());
        }

        return $response;
    }
}
