<?php
namespace Util;

class Logger
{
    private string $logFile;
    private string $channel;

    public function __construct(string $channel = 'app')
    {
        $this->channel = $channel;
        $this->logFile = __DIR__ . '/../../logs/app.log';
        if (!is_dir(dirname($this->logFile))) {
            mkdir(dirname($this->logFile), 0777, true);
        }
    }

    public function info(string $message, array $context = []): void
    {
        $this->write('INFO', $message, $context);
    }

    public function warning(string $message, array $context = []): void
    {
        $this->write('WARNING', $message, $context);
    }

    public function error(string $message, array $context = []): void
    {
        $this->write('ERROR', $message, $context);
    }

    private function write(string $level, string $message, array $context): void
    {
        $date = date('Y-m-d H:i:s');
        $ctx  = empty($context) ? '' : ' ' . json_encode($context, JSON_UNESCAPED_UNICODE);
        $line = "[{$date}] {$this->channel}.{$level}: {$message}{$ctx}" . PHP_EOL;
        file_put_contents($this->logFile, $line, FILE_APPEND);
    }
}