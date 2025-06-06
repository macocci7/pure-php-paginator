<?php

namespace Libs;

use Libs\DateTime;

class Log
{
    public static string|null $filename;

    public static function debug(string $message): int|false
    {
        return static::write($message, "DEBUG");
    }

    public static function info(string $message): int|false
    {
        return static::write($message, "INFO");
    }

    public static function warn(string $message): int|false
    {
        return static::write($message, "WARN");
    }

    public static function error(string $message): int|false
    {
        return static::write($message, "ERROR");
    }

    public static function exception(\Throwable $throwable): int|false
    {
        $message = $throwable->getMessage() . PHP_EOL
                 . $throwable->getTraceAsString();
        return static::write($message, "EXCEPTION");
    }

    public static function write(string $message, string $level = ""): int|false
    {
        try {
            $filename = static::getFileName();

            $content = sprintf(
                "[%s][%s] %s%s",
                (new DateTime("now"))->format("Y/m/d H:i:s P"),
                $level,
                $message,
                PHP_EOL
            );

            if (file_exists($filename) && ! is_writable($filename)) {
                throw new \Exception("[" . $filename . "] is not writable.");
            }

            return file_put_contents($filename, $content, FILE_APPEND | LOCK_EX);

        } catch(\Throwable $e) {
            echo $e->getMessage() . PHP_EOL;
            echo $e->getTraceAsString() . PHP_EOL;
            exit(1);
        }
    }

    public static function setFileName(): void
    {
        $filename = "app" . (new DateTime)->format("-Y-m-d") . ".log";
        static::$filename = realpath(__DIR__ . "/../logs") . "/" . $filename;
    }

    public static function getFileName(): string
    {
        if (empty(static::$filename)) {
            static::setFileName();
        }
        return static::$filename;
    }
}
