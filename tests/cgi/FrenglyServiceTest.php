<?php

class FrenglyServiceTest extends PHPUnit_Framework_TestCase {
    
    public static $lastRequestTime = null;
    
    public static function waitWithNextRequest() {
        if (self::$lastRequestTime != null) {
            $diff = self::$lastRequestTime->diff(new \DateTime());
            while($diff->s < 4) {
                $diff = self::$lastRequestTime->diff(new \DateTime());
                usleep(500000);
            }
        }
        self::$lastRequestTime = new \DateTime();
    }
    
    /**
     * @covers FrenglyService::translate
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid argument type passed
     * @test
     */
    public function translate_NumberPassed_throwException() {
        FrenglyService::translate(1, 4, 'de');
    }
    
    /**
     * @covers FrenglyService::translate
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid argument type passed
     * @test
     */
    public function translate_NullPassed_throwException() {
        FrenglyService::translate(null, 'pl', null);
    }
    
    /**
     * @covers FrenglyService::translate
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Not supported language passed
     * @test
     */
    public function translate_EmptyLanguagePassed_throwException() {
        FrenglyService::translate('Ja', '', '');
    }
    
    /**
     * @covers FrenglyService::translate
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Not supported language passed
     * @test
     */
    public function translate_NotSupportedLanguage_throwException() {
        FrenglyService::translate('Ja', 'fsdaf', 'pl');
    }
    
    /**
     * @covers FrenglyService::translate
     * @test
     */
    public function translate_emptyString_returnEmptyString() {
        $this->assertEquals('', FrenglyService::translate('', 'pl', 'de'));
    }
    
    /**
     * @covers FrenglyService::translate
     * @test
     */
    public function translate_TextWithSpacesPassed_returnTranslatedString() {
        self::waitWithNextRequest();
        $this->assertEquals('Al hat bücherwurm', FrenglyService::translate('Ala ma kota', 'pl', 'de'));
    }

    /**
     * @covers FrenglyService::translate
     * @test
     */
    public function translate_TextWithPolishDiacritics_returnTranslatedString() {
        self::waitWithNextRequest();
        $this->assertEquals('Käfer', FrenglyService::translate('Chrząszcz', 'pl', 'de'));
    }
    
    /**
     * @covers FrenglyService::translate
     * @expectedException \RuntimeException
     * @expectedExceptionMessage The minimum time between API call is 
     * @test
     */
    public function translate_TooSmallTimeBetweenTranslations_throwRuntimeException() {
        self::waitWithNextRequest();
        $this->assertEquals('Käfer', FrenglyService::translate('Chrząszcz', 'pl', 'de'));
        FrenglyService::translate('Chrząszcz', 'pl', 'de');
    }
    
    /**
     * @covers FrenglyService::translate
     * @test
     */
    public function translate_TextWithSpacesPassedDEPL_returnTranslatedString() {
        self::waitWithNextRequest();
        $this->assertEquals('Al ma kota', FrenglyService::translate('Al hat bücherwurm', 'de', 'pl'));
    }

    /**
     * @covers FrenglyService::translate
     * @test
     */
    public function translate_TextWithPolishDiacriticsDEPL_returnTranslatedString() {
        self::waitWithNextRequest();
        $this->assertEquals('Beetle', FrenglyService::translate('Käfer', 'de', 'pl'));
    }
    
    /**
     * @covers FrenglyService::translate
     * @expectedException \RuntimeException
     * @expectedExceptionMessage The minimum time between API call is 
     * @test
     */
    public function translate_TooSmallTimeBetweenTranslationsDEPL_throwRuntimeException() {
        self::waitWithNextRequest();
        $this->assertEquals('Beetle', FrenglyService::translate('Käfer', 'de', 'pl'));
        FrenglyService::translate('Käfer', 'de', 'pl');
    }
}
