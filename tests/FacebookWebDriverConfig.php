<?php

namespace Moodle\MinkFacebookWebDriver\Tests;

use Moodle\MinkFacebookWebDriver\Driver\FacebookWebDriver;

class FacebookWebDriverConfig extends AbstractConfig
{
    public static function getInstance()
    {
        return new self();
    }

    /**
     * {@inheritdoc}
     */
    public function createDriver()
    {
        $browser = $_SERVER['WEB_FIXTURES_BROWSER'];
        $seleniumHost = $_SERVER['DRIVER_URL'];

        return new FacebookWebDriver($browser, null, $seleniumHost);
    }

    /**
     * {@inheritdoc}
     */
    public function skipMessage($testCase, $test)
    {
        if (
            'Behat\Mink\Tests\Driver\Js\WindowTest' === $testCase
            && 'testWindowMaximize' === $test
            && 'true' === getenv('TRAVIS')
        ) {
            return 'Maximizing the window does not work when running the browser in Xvfb.';
        }

        return parent::skipMessage($testCase, $test);
    }

    /**
     * {@inheritdoc}
     */
    protected function supportsCss()
    {
        return true;
    }
}
