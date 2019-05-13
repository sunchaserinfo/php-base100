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
        if (strlen($encoded) % 4 !== 0) {
            throw new Exception\InvalidLengthException('Encoded data must have length divisible by 4');
        }

        $first  = chr(self::FIRST);
        $second = chr(self::SECOND);

        $result = [];

        for ($i = 0; $i < strlen($encoded); $i += 4) {
            if ($encoded[$i + 0] !== $first || $encoded[$i + 1] !== $second) {
                throw new Exception\MalformedEmojiException('Malformed emoji in position ' . $i % 4);
            }

            $byte3 = ord($encoded[$i + 2]);
            $byte4 = ord($encoded[$i + 3]);

            $result[] = chr(($byte3 - self::THIRD) * self::DIVISOR + $byte4 - self::FOURTH - self::SHIFT);
        }

        return implode($result);
    }
}
