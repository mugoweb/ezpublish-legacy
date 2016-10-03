<?php
/**
 * File containing the eZFileTestSuite class
 *
 * @package tests
 */

class eZFileTestSuite extends ezpTestSuite
{
    public function __construct()
    {
        parent::__construct();
        $this->setName( "eZFile Test Suite" );
        $this->addTestSuite( 'eZCharTransFormTests' );
    }

    public static function suite()
    {
        return new self();
    }

}
