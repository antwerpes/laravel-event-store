<?php declare(strict_types=1);

namespace Antwerpes\LaravelEventStore;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelEventStoreServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        // This class is a Package Service Provider
        $package
            ->name('laravel-event-store')
            ->hasConfigFile();
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(EventStore::class, static fn () => new EventStore);
    }
}
