<?php


use Spatie\Glide\GlideImage;

class GlideImageTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function _before()
    {
        return new GlideImage();
    }

    // tests
    public function testGlideImageInstance()
    {
        $glide = $this->_before();

        $this->assertInstanceOf('Spatie\Glide\GlideImage', $glide);
    }

    public function testImagePath()
    {
        $glide = $this->_before();

        $imagePath = 'testFile.jpg';

        $glide->load($imagePath);

        $this->assertAttributeContains('testFile.jpg', 'imagePath', $glide);
    }

    public function testBaseURL()
    {
        $glide = $this->_before();

        $baseURL = 'testBaseURL';

        $glide->setBaseURL($baseURL);

        $this->assertAttributeContains('testBaseURL', 'baseURL', $glide);
    }

    public function testSignKey()
    {
        $glide = $this->_before();

        $signKey = 'testSignKey';

        $glide->setSignKey($signKey);

        $this->assertAttributeContains('testSignKey', 'signKey', $glide);
    }

    public function testModificationParameters()
    {
        $glide = $this->_before();

        $modificationParameters = [
            'w' => 300,
            'h' => 300,
            'filt' => 'sepia'
        ];

        $glide->modify($modificationParameters);

        $this->assertAttributeContains($modificationParameters['w'], 'modificationParameters', $glide);

        $this->assertAttributeContains($modificationParameters['h'], 'modificationParameters', $glide);

        $this->assertAttributeContains($modificationParameters['filt'], 'modificationParameters', $glide);
    }

    public function testgetURL()
    {
        $glide = $this->_before();

        $glide->load('testFile.jpg', ['filt' => 'greyscale']);
        
        $glide->getURL();

        $expectedUrl = '/testFile.jpg?filt=greyscale'; //No signKey here.

        $this->assertEquals($expectedUrl, $glide->getURL());
    }


    public function test_toString()
    {
        $glide = $this->_before();

        $glide->load('testFile.jpg', ['filt' => 'greyscale']);

        $expectedUrl = '/testFile.jpg?filt=greyscale'; //No signKey here.

        $this->assertEquals($expectedUrl, $glide->__toString());
    }

    /*public function testSaveMethod()
    {
        // --- Laravel Config doesn't load --- //

        $glide = $this->_before();

        $glide->load('tests/_data/testFile.jpg', ['filt' => 'greyscale']);

        $glide->save('tests/_output/savedFile.jpg');

        $expectedUrl = '/img/testFile.jpg?filt=greyscale'; //No signKey here.

        //$this->assertEquals($expectedUrl, $glide->save('tests/_data/savedFile.jpg'));
    }*/
}