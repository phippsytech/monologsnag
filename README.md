# MonoLogSnag

MonoLogSnag is a handler for Monolog that pushes your logs to [LogSnag](https://logsnag.com), a use-case agnostic event tracking and analytics platform.

## Installation

To install MonoLogSnag, run the following command:

```
composer require phippsytech/monologsnag
```

## Initialising MonoLogSnag

To use MonoLogSnag with Monolog you need to initialise it like this:

```php
use Monolog\Logger;
use PhippsyTech\MonoLogSnag\Handler as MonoLogSnagHandler;

$token = <insert your api key here>;
$project = "test";
$channel = "test";

// Create a log channel
$log = new Logger($channel);

// Push the MonoLogSnagHandler to the log channel
$monoLogSnagHandler = new MonoLogSnagHandler($apiKey, $project);
$log->pushHandler($monoLogSnagHandler);
```

To make things easier to read, in all following code snippets I will refer to the above code with `// --> Initialise MonoLogSnag here <--` 

## Basic Usage

This will send a message with an empty description labeled "Hello World" to LogSnag

```php
// --> Initialise MonoLogSnag here <--

// Send log to LogSnag
$log->info('Hello World');

```

## Adding Description

In Monolog you can add extra data in the logging context.  This is in the form of an array.

MonoLogSnag converts the array into Markdown and sends it via the description:

```php
// --> Initialise MonoLogSnag here <--

// Send log to LogSnag
$log->info('A customer just placed an order', [
    'Product' => "Happy Thoughts",
    'Price' => 1.95
]);
```

## Adding Tags

LogSnag lets you include up to 5 tags on a log entry.  MonoLogSnag uses the `extra` part of a `$record` to hold these tags.  You can then filter on these tags in LogSnag.

To add the tags we use the `pushProcessor()` to modify the `$record->extra` array.

In the following example we are adding the log level as a tag named `level`

```php
// --> Initialise MonoLogSnag here <--

// Add a tag called level that contains the current log level.
$log->pushProcessor(function ($record) {
    $record->extra['level'] = $record->level->name; 
    return $record;
});

// Send log to LogSnag.  This log is recording a page visit.
$page = $_SERVER['REQUEST_URI'] ?? 'unknown';
$log->info('Page Visit', [
    'page' => $_SERVER['REQUEST_URI']
]);

```


## Log Level Icons and Notifications

Currently all log levels have `notify: true`.  

The following icons are used for each log level:

debug: 😶<br>
info: 🙂<br>
notice: 🤔<br>
warning: 🧐<br>
error: 😠<br>
critical: 😡<br>
alert: 🤬<br>
emergency: 💀<br>

## Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

## Looking Ahead

I plan to add the ability to override the default icon and notify settings in the future. If you'd like to see this happen sooner, please get in touch or consider submitting a pull request with the feature added.

## Authors and acknowledgments

Michael Phipps (Author) - [Twitter](https://twitter.com/PhippsyTech)

LogSnag - [Website](https://logsnag.com) - [GitHub](https://github.com/LogSnag) - [Twitter](https://twitter.com/LogSnag)<br>
Shayan Taslim - [Twitter](https://twitter.com/ImSh4yy)

Monolog - [Website](https://seldaek.github.io/monolog/) - [GitHub](https://github.com/Seldaek/monolog)<br>
Jordi Boggiano - [Twitter](http://twitter.com/seldaek)

## License
MonoLogSnag is licensed under the MIT License. See [LICENSE](https://github.com/phippsytech/monologsnag/LICENSE) for more information.

