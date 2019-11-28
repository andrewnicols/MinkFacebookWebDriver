<?php

namespace Moodle\MinkFacebookWebDriver\Tests;

use Behat\Mink\Tests\Driver\AbstractConfig;
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
        $browser = $_ENV['BROWSER_NAME'];
        $seleniumHost = $_ENV['DRIVER_URL'];
        $capabilities = [
            'chrome' => [
                'args' => [
                    '-headless',
                ],
                'log' => [
                    'level' => 'trace',
                ],

            ],
            'moz:firefoxOptions' => [
                'args' => [
                    '-headless',
                ],
                'log' => [
                    'level' => 'trace',
                ],

            ],
            'moz:webdriverClick' => true,
        ];

        return new FacebookWebDriver($browser, $capabilities, $seleniumHost);
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
