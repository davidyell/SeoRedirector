# Redirect finder
A small library for matching a url and finding a redirect, with an http code.

## Matching urls
An array of redirects is required. With the key being the url to redirect, and the value 
being an array of `target` and `code.

You can use a direct match
```php
// Direct matching
$redirects = [
    '/examples/first' => [
        'target' => '/tutorials/first',
        'code' => 301
    ]
];
```

You can use a slug match
```php
// Slug matching
$redirects = [
    '/examples/:slug/first' => [
        'target' => '/tutorials/:slug/first',
        'code' => 301
    ],
    'examples/:slug' => [
        'target' => '/tutorials/:slug',
        'code' => 302
    ]
];
```

You can also use a greedy match
```php
// Greedy matching
$redirects = [
    '/examples/*' => [
        'target' => '/tutorials',
        'code' => 301
    ]
];
```

More examples can be found in the tests.

# License
MIT