<?php

use Illuminate\Support\Facades\Config;
use Spatie\Glide\GlideServiceProvider;

class SignKeyTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    protected $serviceProvider;
    protected $app;

    public function _before()
    {
        $this->serviceProvider = new GlideServiceProvider($this->app);
    }

    /**
     * Test is null is returned when useSecureURLs is false.
     */
    public function testFalseSecureURL()
    {
        $glideConfig['useSecureURLs'] = false;

        $result = $this->serviceProvider->getSignKey($glideConfig);

        $this->assertNull($result);
    }

    /**
     * Test if a SignKey is returned when useSecureURLs is not defined.
     */
    public function testSecureURLSettingNotDefined()
    {
        $expectedResult = 'my-key';

        Config::shouldReceive('get')->with('app.key')->andReturn($expectedResult);

        $result = $this->serviceProvider
            ->getSignKey([]);

        $this->assertEquals($expectedResult, $result);
    }

    /**
     * Test if a key is return if useSecureURLs is configured true.
     */
    public function testTrueSecureURL()
    {
        $expectedResult = 'my-key';

        $glideConfig['useSecureURLs'] = true;

        Config::shouldReceive('get')->with('app.key')->andReturn($expectedResult);

        $result = $this->serviceProvider->getSignKey($glideConfig);

        $this->assertEquals($expectedResult, $result);
    }
}
