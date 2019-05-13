<?php

namespace SunChaser\Base100;

class Base100
{
    const FIRST     = 0xf0;
    const SECOND    = 0x9f;
    const THIRD     = 0x8f;
    const FOURTH    = 0x80;

    const SHIFT     = 55;
    const DIVISOR   = 64;

    public static function encode(string $data): string
    {
        $result = ['']; // use empty string as first element to have string prefixed with glue

        for ($i = 0; $i < strlen($data); $i++) {
            $value = ord($data[$i]) + self::SHIFT;

            $result[] = pack(
                'C2',
                intdiv($value, self::DIVISOR) + self::THIRD,
                $value % self::DIVISOR + self::FOURTH
            );
        }

        $glue = chr(self::FIRST) . chr(self::SECOND);

        return implode($glue, $result);
    }

    public static function decode(string $encoded): string
    {
        return '';
    }
}
