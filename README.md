# MonoLogSnag
A handler for monolog that logs to LogSnag

## Example use

```php
<?php

use Monolog\Logger;
use PhippsyTech\MonoLogSnag\Handler as MonoLogSnagHandler;

require '../vendor/autoload.php';

$token = <insert your api key here>;
$project="test";
$channel = "test";

// create a log channel
$log = new Logger($channel);

$log->pushHandler(new MonoLogSnagHandler($token, $project));

// Use extra to send tags.  You can set up to 5 tags on a log entry.
$log->pushProcessor(function ($record) {
    $record->extra['level'] = $record->level->name;
    return $record;
});

// add records to the log
$log->info('Page Visit', [
    'page'=>$_SERVER['REQUEST_URI'],
    'referrer'=>filter_input(INPUT_SERVER, 'HTTP_REFERER', FILTER_SANITIZE_URL),
    'Description'=>"If I remove use Monolog\Level, this should still work"
]);
```
