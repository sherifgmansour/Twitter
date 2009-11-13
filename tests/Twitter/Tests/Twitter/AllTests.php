<?php

namespace Twitter\Tests\Twitter;

if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'Twitter_AllTests::main');
}

require_once __DIR__ . '/../TestInit.php';

class AllTests
{
    public static function main()
    {
        \PHPUnit_TextUI_TestRunner::run(self::suite());
    }

    public static function suite()
    {
        $suite = new \PHPUnit_Framework_TestSuite('Twitter Twitter Tests');

        $suite->addTestSuite('Twitter\Tests\Twitter\ApiTest');

        return $suite;
    }
}


if (PHPUnit_MAIN_METHOD == 'Twitter_AllTests::main') {
    AllTests::main();
}