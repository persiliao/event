# Eventy

One similar to Wordpress filters hook system rolled in to a class to be ported into any PHP-based system

# Requirements

    - PHP >= 7.2
    - JSON PHP extension 

# Installation

#### Use composer

```shell
composer require persiliao/eventy
```

# How to use?

```php
$post = new stdClass;
$post->meta = [];
function addMeta(stdClass $post, string $key, string $value)
{
	$post->meta[$key] = $value;
}

PersiLiao\Eventy\addAction('post','addMeta', 10, 3);
PersiLiao\Eventy\doAction('post');

function deleteMeta(stdClass $post, string $key)
{
	if(isset($post->meta[$key])){
        unset($post->meta[$key]);
    }
  	return $post;
}

PersiLiao\Eventy\addFilter('post','addMeta', 10, 1);
$post = PersiLiao\Eventy\applyFilters('post', $post, 'author');
```

# LICENSE

MIT LICENSE



