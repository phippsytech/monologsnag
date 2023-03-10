<?php

namespace PhippsyTech\MonoLogSnag;

use \Monolog\Formatter\JsonFormatter;
use \Monolog\LogRecord;


/**
 * Encodes message information into JSON in a format compatible with LogSnag API.
 *
 * @author Michael Phipps <phippsy@phippsy.tech>
 */
class Formatter extends JsonFormatter
{

    /** @var string */
    private $project;

    /**
     * Overrides the default JSON Formatter for compatibility with the
     * LogSnag API.
     */
    public function __construct(string $project, int $batchMode = self::BATCH_MODE_NEWLINES, bool $appendNewline = false)
    {
        $this->project = $project;
        parent::__construct($batchMode, $appendNewline);
    }


    public function normalizeRecord(LogRecord $record): array
    {

        $recordData = parent::normalizeRecord($record);

        $log_level = trim(strtolower($record->level->name));
        
        switch($log_level){
            case "debug":     $icon = "ðķ"; break;
            case "info":      $icon = "ð"; break;
            case "notice":    $icon = "ðĪ"; break;
            case "warning":   $icon = "ð§"; break;
            case "error":     $icon = "ð "; break;
            case "critical":  $icon = "ðĄ"; break;
            case "alert":     $icon = "ðĪŽ"; break;
            case "emergency": $icon = "ð"; break;
            default:          $icon = "ðĪŠ";
        }

        $recordData = [
            "project"=>$this->project,
            "channel"=>$record->channel,
            "event"=> $record->message,
            "icon"=>$icon,
            "notify"=>true,
        ];

        if(!empty($record->extra)){
            $recordData["tags"]=$record->extra;
        }

        $description ="";

        if(!empty($record->context)){
            foreach ($record->context as $key => $value){
                $description .= "**".$key."**: ".$value .PHP_EOL;
            }
            $recordData["description"]=$description;
            $recordData["parser"]="markdown";
        }

        return $recordData;

    }


}