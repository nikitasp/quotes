<?php
declare(strict_types=1);

namespace App\Domain\Quote;

interface QuoteCache
{
    /**
     * @return Quote[]
     * @param string $key
     */
    public function get($key): array;

    /**
     * @param string $key
     * @param mixed $data
     */
    public function set($key, $data);

}
