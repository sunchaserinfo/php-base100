<?php

use PHPUnit\Framework\TestCase;
use SunChaser\Base100\Base100;

class AllTest extends TestCase
{
    const TEST_DECODED = "the quick brown fox jumped over the lazy dog\n";
    const TEST_ENCODED = '👫👟👜🐗👨👬👠👚👢🐗👙👩👦👮👥🐗👝👦👯🐗👡👬👤👧👜👛🐗👦👭👜👩🐗👫👟👜🐗👣👘👱👰🐗👛👦👞🐁';

    public function testEncode()
    {
        $this->assertEquals(
            self::TEST_ENCODED,
            Base100::encode(self::TEST_DECODED)
        );
    }

    public function testDecode()
    {
        $this->assertEquals(
            self::TEST_DECODED,
            Base100::decode(self::TEST_ENCODED)
        );
    }
}
