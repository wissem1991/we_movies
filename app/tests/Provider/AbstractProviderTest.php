<?php

namespace Provider;

use App\Wrapper\TheMovieDBWrapper;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class AbstractProviderTest extends KernelTestCase
{
    protected TheMovieDBWrapper $movieDBWrapper;

    protected function setUp(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        /** @var TheMovieDBWrapper $movieDBWrapper */
        $this->movieDBWrapper = $container->get(TheMovieDBWrapper::class);
    }
}