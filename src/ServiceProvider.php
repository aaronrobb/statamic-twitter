<?php

namespace Pixney\StatamicTwitter;

use Statamic\Providers\AddonServiceProvider;
use Pixney\StatamicTwitter\Twitter\StatamicTwitter;
use Pixney\StatamicTwitter\Tags\StatamicTwitter as Tag;

class ServiceProvider extends AddonServiceProvider
{
    protected $tags = [
        Tag::class
    ];

    public function register()
    {
        parent::register();

        $this->mergeConfigFrom(__DIR__ . '/../config/StatamicTwitter.php', 'statamic-twitter');

        $this->app->singleton('twitter', function () {
            return new StatamicTwitter;
        });
    }
}
