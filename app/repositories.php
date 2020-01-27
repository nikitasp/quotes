<?php
declare(strict_types=1);

use App\Domain\Quote\QuoteCache;
use App\Infrastructure\Persistence\Quote\InMemoryQuoteRepository;
use App\Infrastructure\Persistence\Quote\InMemoryQuoteCache;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        QuoteCache::class => new InMemoryQuoteCache(new InMemoryQuoteRepository()),
    ]);
};
