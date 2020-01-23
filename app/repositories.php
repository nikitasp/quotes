<?php
declare(strict_types=1);

use App\Domain\User\UserRepository;
use App\Domain\Quote\QuoteRepository;
use App\Domain\Quote\QuoteCache;
use App\Infrastructure\Persistence\User\InMemoryUserRepository;
use App\Infrastructure\Persistence\Quote\InMemoryQuoteRepository;
use App\Infrastructure\Persistence\Quote\InMemoryQuoteCache;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        QuoteCache::class => new InMemoryQuoteCache(new InMemoryQuoteRepository()),
        QuoteRepository::class => \DI\autowire(InMemoryQuoteRepository::class),
        UserRepository::class => \DI\autowire(InMemoryUserRepository::class),
    ]);
};
