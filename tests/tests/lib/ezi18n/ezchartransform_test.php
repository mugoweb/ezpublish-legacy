<?php
/**
 * File containing the eZCharTransFormTests class
 *
 * @package tests
 */

class eZCharTransFormTests extends ezpTestCase
{

    public function __construct()
    {
        parent::__construct();
        $this->setName( "eZCharTransFormTests" );
    }

    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    public function testCommandUrlCleanupMultipleSpecialCharsAtEnd()
    {
        $objectName = 'test."';
        $transformed = eZCharTransform::commandUrlCleanup( $objectName );
        $this->assertEquals( $transformed, 'test' );

        $objectName = 'te.st."';
        $transformed = eZCharTransform::commandUrlCleanup( $objectName );
        $this->assertEquals( $transformed, 'te.st' );

        $objectName = '.test!"';
        $transformed = eZCharTransform::commandUrlCleanup( $objectName );
        $this->assertEquals( $transformed, 'test' );
    }
}
