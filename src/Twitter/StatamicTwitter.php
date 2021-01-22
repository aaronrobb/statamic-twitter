<?php

namespace Pixney\StatamicTwitter\Twitter;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Abraham\TwitterOAuth\TwitterOAuth;

class StatamicTwitter
{
    /**
     * Twitter Cnnection
     *
     * @var \Abraham\TwitterOAuth\TwitterOAuth
     */
    protected $connection;

    /**
     * Endpoint to get tweets
     */
    protected string $endPoint = '/statuses/user_timeline';

    /**
     * Cache Key
     */
    protected string $key;

    /**
     * Number of tweets to get
     */
    protected int $count;

    /**
     * Cache Expiration
     */
    protected int $expiration;

    /**
     * Undocumented function
     *
     * @return string
     */
    private function setCacheKey() :string
    {
        return md5("{$this->count}{$this->expiration}");
    }

    /**
     * @param integer $count
     * @return \Illuminate\Support\Collection
     */
    public function getTweets(int $count, int $expiration)
    {
        $this->count      = $count;
        $this->expiration = $expiration;

        try {
            $this->key = $this->setCacheKey();

            if (Cache::has($this->key)) {
                return Cache::get($this->key);
            }
            $tweetsCollection = $this->makeTweetCollection($this->fetchTweets());
            Cache::put($this->key, $tweetsCollection, $this->expiration);

            return $tweetsCollection;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    /**
     * @param array $tweets
     * @return \Illuminate\Support\Collection
     */
    private function makeTweetCollection(array $tweets) :\Illuminate\Support\Collection
    {
        return collect($tweets)->map(function ($data) {
            $media = [];

            if ((property_exists($data, 'extended_entities') && property_exists($data->extended_entities, 'media'))) {
                $media = collect($data->extended_entities->media)->map(function ($item) {
                    return [
                        'media_url_https' => $item->media_url_https
                    ];
                })->toArray();
            }

            return [
                'text'  => $this->makeLinksOfUrlsIn($data->text),
                'date'  => Carbon::create($data->created_at),
                'media' => $media
               // 'image' => $image
            ];
        });
    }

    private function fetchTweets() :array
    {
        $this->connect();
        $tweets =  $this->connection->get($this->endPoint, ['count' => $this->count, 'trim_user'=>false]);

        // Check for error!
        if ($this->connection->getLastHttpCode() !== 200) {
            throw new \Exception('Error fetching tweets.');
        }

        return $tweets;
    }

    /**
     * @return void
     */
    private function connect() :void
    {
        $this->connection = new TwitterOAuth(
            config('statamic-twitter.consumer_key'),
            config('statamic-twitter.consumer_secret'),
            config('statamic-twitter.access_token'),
            config('statamic-twitter.access_token_secret')
        );
    }

    /**
     * Create a link of any url in the tweet.
     *
     * @param string $text
     * @return string
     */
    private function makeLinksOfUrlsIn(string $text) :string
    {
        $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
        if (preg_match($reg_exUrl, $text, $url)) {
            return preg_replace($reg_exUrl, "<a href='{$url[0]}'>{$url[0]}</a> ", $text);
        } else {
            return $text;
        }
    }
}
