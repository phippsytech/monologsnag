# MonoLogSnag

MonoLogSnag is a handler for Monolog that pushes your logs to [LogSnag](https://logsnag.com), a use-case agnostic event tracking and analytics platform.

## Installation

To install MonoLogSnag, run the following command:

```
composer require phippsytech/monologsnag
```

## Usage

To use MonoLogSnag in your PHP code:

```php
use Monolog\Logger;
use PhippsyTech\MonoLogSnag\Handler as MonoLogSnagHandler;

$token = <insert your api key here>;
$project = "test";
$channel = "test";

// Create a log channel
$log = new Logger($channel);

// Push the MonoLogSnagHandler to the log channel
$log->pushHandler(new MonoLogSnagHandler($token, $project));

// Use extra to send tags. LogSnag allows you to add up to 5 tags on a log entry.
$log->pushProcessor(function ($record) {
    $record->extra['level'] = $record->level->name; 
    return $record;
});

// Add records to the log
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

