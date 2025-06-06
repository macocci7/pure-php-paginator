<?php

namespace Libs;

use DateTime as DateTimeBase;
use DateInterval;
use DateTimeZone;

/**
 * DateTimeラッパー
 * Asia/Tokyo をデフォルトタイムゾーンとすることが目的
 */
class DateTime extends DateTimeBase
{
    public const DEFAULT_TIMEZONE_STRING = "Asia/Tokyo";

    public function __construct(
        public string $datetimeString = "now",
        public DateTimeZone|null $timezone = null,
    ) {
        if (is_null($this->timezone)) {
            $this->timezone = new DateTimeZone(static::DEFAULT_TIMEZONE_STRING);
        }
        parent::__construct($this->datetimeString, $this->timezone);
    }

    /**
     * 相対的に進めた日付のDateTimeオブジェクトを返す
     * サポートする日付と時刻の書式は次のURLの「相対的な書式」を参照
     * https://www.php.net/manual/ja/datetime.formats.php#datetime.formats.relative
     */
    public function forward(string $relativeDateTimeString): self
    {
        $interval = DateInterval::createFromDateString($relativeDateTimeString);
        return $this->add($interval);
    }

    /**
     * 相対的に遡った日付のDateTimeオブジェクトを返す
     * サポートする日付と時刻の書式は次のURLの「相対的な書式」を参照
     * https://www.php.net/manual/ja/datetime.formats.php#datetime.formats.relative
     */
    public function backward(string $relativeDateTimeString): self
    {
        $interval = DateInterval::createFromDateString($relativeDateTimeString);
        return $this->sub($interval);
    }

    public static function isValidDateString(string $dateTimeString): bool
    {
        try {
            new DateTime($dateTimeString);
            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }

    public static function isValidRelativeDateString(string $dateTimeString): bool
    {
        try {
            DateInterval::createFromDateString($dateTimeString);
            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }
}
