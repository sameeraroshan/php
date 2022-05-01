<?php
namespace Serato\Tests\Unit\Orm;

use PHPUnit\Framework\TestCase;
use Serato\Orm\DownloadLog;

class DownloadLogTest extends TestCase

{
    /**
     * Task 1
     */
    public static function setUpBeforeClass(): void
    {
        $downloadLog = DownloadLog::create();
        echo ($downloadLog->isModified() ? 'DownloadLog is modified' : 'DownloadLog is not modified'), PHP_EOL;
        $downloadLog->setFileId(1000)->setUserId(2000);
        echo ($downloadLog->isModified() ? 'DownloadLog is modified' : 'DownloadLog is not modified'), PHP_EOL;
        echo ("UserId is: " . $downloadLog->getUserId()), PHP_EOL;
    }
    /**
     * @test
     * check for modified state by setting values for userId and fieldId
     */
    public function modified()
    {
        $downloadLog =  DownloadLog::create();
        self::assertFalse($downloadLog->isModified());
        $downloadLog->setFileId(1000)->setUserId(2000);
        $this->assertTrue($downloadLog->isModified());
        $this->assertEquals(2000, $downloadLog->getUserId());
    }

    /**
     * @test
     * check fiedId is
     */
    public function onlyNumericAllowedFieldId(){
        $this->expectException(\Exception::class);
        $downloadLog =  DownloadLog::create();
        $downloadLog->setFileId("abc");
    }

    /**
     * @test
     */
    public function onlyNumericAllowedUserId(){
        $this->expectException(\Exception::class);
        $downloadLog =  DownloadLog::create();
        $downloadLog->setUserId("def");
    }


}