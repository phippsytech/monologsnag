<?php 

namespace PhippsyTech\MonoLogSnag;

use \Monolog\Handler\AbstractProcessingHandler;
use \Monolog\Formatter\FormatterInterface;
use \PhippsyTech\MonoLogSnag\Formatter as MonoLogSnagFormatter;

use \Monolog\Logger;

/**
 * LogSnag handler
 *
 * @author Michael Phipps <phippsy@phippsy.tech>
 */
class Handler extends AbstractProcessingHandler
{
    
    /** @var string */
    private $api_token;
    private $project;


    public function __construct($api_token, $project, $level = Logger::DEBUG, bool $bubble = true)
    {
        $this->api_token = $api_token;
        $this->project = $project;
        parent::__construct($level, $bubble);
    }

    /**
     * {@inheritDoc}
     */
    protected function write(\Monolog\LogRecord $record): void
    {

        $headers[] = "Authorization: Bearer ".$this->api_token;
        $headers[] = 'Content-type: application/json';

        $url = 'https://api.logsnag.com/v1/log';
        $context = stream_context_create([
            'http' => [
                'method'        => 'POST',
                'content'       => $record['formatted'],
                'ignore_errors' => true,
                'max_redirects' => 10,
                'header'        => $headers
            ],
        ]);

        if (false === @file_get_contents($url, false, $context)) {
            // I am not throwing an error because I want it to fail silently.
            // throw new \RuntimeException(sprintf('Could not connect to %s', $url));
        }

    }


    /**
     * {@inheritDoc}
     */
    protected function getDefaultFormatter(): FormatterInterface
    {
        return new MonoLogSnagFormatter($this->project);
    }


}