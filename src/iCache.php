<?php

declare(strict_types=1);

namespace FluencePrototype\Cache;

/**
 * Interface iCache
 * @package FluencePrototype\Cache
 */
interface iCache
{

    /**
     * @param string $key
     * @param array|bool|float|int|object|string $value
     * @param int $ttl
     * @return array|bool|float|int|object|string
     */
    public function store(string $key, array|bool|float|int|object|string $value, int $ttl): array|bool|float|int|object|string;

    /**
     * @param string $key
     * @return array|bool|float|int|object|string|null
     */
    public function fetch(string $key): array|bool|float|int|object|null|string;

}