<?php

namespace Pixney\StatamicTwitter\Tags;

use Statamic\Tags\Tags;
use Illuminate\Support\Facades\App;

class StatamicTwitter extends Tags
{
    /**
     * The {{ statamic_twitter }} tag.
     *
     * @return string|array
     */
    public function index()
    {
        $statamicTwitter      = App::make('twitter');
        $count                = $this->params->get('expiration', 3);
        $expiration           = $this->params->get('expiration', config('statamic-twitter.expiration', 3));
        return $statamicTwitter->getTweets($count, $expiration)->toArray();
    }

    /**
     * The {{ statamic_twitter:example }} tag.
     *
     * @return string|array
     */
    public function example()
    {
        //
    }
}
