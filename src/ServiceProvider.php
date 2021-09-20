<?php

namespace Edalzell\ErrorBag;

use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    protected $tags = [
        ErrorBag::class,
    ];
}
