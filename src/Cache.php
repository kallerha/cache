<?php

declare(strict_types=1);

namespace FluencePrototype\Cache;

use Memcached;

/**
 * Class Cache
 * @package FluencePrototype\Cache
 */
class Cache implements iCache
{

    /**
     * @inheritDoc
     */
    public function store(string $key, float|object|int|bool|array|string $value, int $ttl = 600): array|bool|float|int|object|string
    {
        if (extension_loaded(extension: 'memcached')) {
            $memcached = new Memcached();

            if (isset($_ENV['MEMCACHED_HOST'], $_ENV['MEMCACHED_PORT'])) {
                if ($memcached->addServer(host: $_ENV['MEMCACHED_HOST'], port: (int)$_ENV['MEMCACHED_PORT'])) {
                    $memcached->set(key: $key, value: $value, expiration: time() + $ttl);

                    return $value;
                }
            }
        }

        if (extension_loaded(extension: 'apcu')) {
            apcu_store($key, $value, $ttl);
        }

        return $value;
    }

    /**
     * @inheritDoc
     */
    public function fetch(string $key): array|bool|float|int|object|null|string
    {
        if (extension_loaded(extension: 'memcached')) {
            $memcached = new Memcached();

            if (isset($_ENV['MEMCACHED_HOST'], $_ENV['MEMCACHED_PORT'])) {
                if ($memcached->addServer(host: $_ENV['MEMCACHED_HOST'], port: (int)$_ENV['MEMCACHED_PORT'])) {
                    if ($value = $memcached->get(key: $key)) {
                        return $value;
                    }
                }
            }
        }

        if (extension_loaded(extension: 'apcu')) {
            if ($value = apcu_fetch($key)) {
                return $value;
            }
        }

        return null;
    }

}