# statamic-twitter


## Twitter Credentials
## Available .ENV settings

| Name                         | Default Value | Required |
|------------------------------|---------------|----------|
| TWITTER_CONSUMER_KEY         |               | Yes      |
| TWITTER_CONSUMER_SECRET      |               | Yes      |
| TWITTER_ACCESS_TOKEN         |               | Yes      |
| TWITTER_ACCESS_TOKEN_SECRET  |               | Yes      |
| TWITTER_EXPIRATION           | 86400         | No       |

## Antlers Tag

### Available Fields
| Name                         | Default Value | Required |
|------------------------------|---------------|----------|
| cache                        | 86400         | No       |
| count                        | 3             | No       |

### Recipes
```
{{ statamic_twitter cache="3600" count="6"}}
    {{ date format="Y-m-d" }}
    {{ text }}
{{ /statamic_twitter }}
```

```
<section class="my-16 bg-gray-50 p-24">
    <div class="container mx-auto">
        <div class="grid grid-cols-3 gap-y-8 gap-x-8 ">
            {{ statamic_twitter cache="3600" count="3"}}
            <div class="bg-white p-8 shadow-xl">
                {{ if media }}
                {{ media }}
                <img class="w-full h-72 object-cover" src="{{media_url_https}}" alt="">
                {{ /media }}
                {{ else }}
                <img class="w-full h-72 object-cover" src="https://loremflickr.com/640/360" alt="">
                {{ /if }}
                <div>
                    <p class="my-4 text-sm"> <span class="font-bold">Posted:</span> {{ date format="Y-m-d" }}</p>
                    <p class="leading-snug">{{ text }}</p>
                </div>
            </div>
            {{ /statamic_twitter }}
        </div>
    </div>
</section>
```