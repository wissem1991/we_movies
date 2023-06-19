<?php

namespace App\Provider;

use App\Wrapper\TheMovieDBWrapper;
use DateInterval;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Serializer\SerializerInterface;

abstract class AbstractProvider
{
    public function __construct(
        protected TheMovieDBWrapper $movieDBWrapper,
        protected SerializerInterface $serializer,
        protected AdapterInterface $cache
    ){}

    protected function getCacheExpireAfter(): DateInterval
    {
        return new DateInterval('PT60S');
    }
}