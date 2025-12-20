<?php

namespace G1c\Culturia\framework;

use DateTime;

class Logger
{
    private ?string $definition;
    private string $env;

    private ?string $channel;

    private array $logs = [];

    public function __construct(string $env, ?string $logfile_definition = null)
    {
        $this->env = $env;
        $this->definition = $logfile_definition;
        $this->init();
    }

    public function setEnv(string $env){
        if($env !== $this->env){
            $this->env = $env;
        }
    }

    public function init(): void
    {
        error_reporting(E_ALL);
        ini_set('error_prepend_string', "<pre>");
        ini_set("error_append_string", "</pre>");
        if ($this->env !== 'production') {
            $display_errors = 'On';
        } else {
            $display_errors = 'Off';

        }
        ini_set('display_errors', $display_errors);
        ini_set('display_startup_errors', $display_errors);
        ini_set("html_errors", $display_errors);

    }

    public function info(string $message): void
    {
        $this->logs[] = $this->writeMessage($message, "INFO");
    }

    public function warning(string $message): void {
        $this->logs[] = $this->writeMessage($message, "WARNING");
    }

    public function error(string $message): void {
        $this->logs[] = $this->writeMessage($message, "ERROR");
    }


    private function writeMessage(string $message, string $type): string {
        $time = (new DateTime())->format("Y-m-d H:i:s");
        $channel = $this->channel ?? "main";
        return "$time $type $channel $message";
    }

    public function write(string ...$lines): void
    {
        if(!$lines){
            $lines = $this->logs;
        }
        if(!is_null($this->definition)){
            $log_file = fopen($this->definition, "a");
        }
        $stream = $log_file ?? fopen("php://output", 'a');
        foreach ($lines ?? $this->logs as $line) {
            fwrite($stream, $line . "\n");
        }
        fclose($stream);
    }

    /**
     * @param mixed $channel
     */
    public function setChannel(mixed $channel): void
    {
        $this->channel = $channel;
    }


}