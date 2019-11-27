<?php
/*
 * This file is part of the Moodle MinkFacebookWebDriver Driver Extension.
 * (c) Andrew Nicols <andrew@nicols.co.uk>
 *
 * Based on original work by:
 * (c) Konstantin Kudryashov <ever.zet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Moodle\MinkFacebookWebDriver\Driver;

use Moodle\MinkFacebookWebDriver\Tests\Unit\UnitTestCase;

class FacebookWebDriverTest extends UnitTestCase
{
    /**
     * @covers ::getDesiredCapabilities
     * @covers ::initFirefoxCapabilities
     */
    public function testMozFirefoxOptionsLogging()
    {
        $desiredCapabilities = [
            'firefox' => [
                'moz:firefoxOptions' => [
                    'log' => [
                        'level' => 'trace',
                    ],
                ],
            ],
        ];

        $webDriver = new FacebookWebDriver(FacebookWebDriver::DEFAULT_BROWSER, $desiredCapabilities);
        $actualCapabilities = $webDriver->getDesiredCapabilities()->toArray();

        $this->assertArrayHasKey('browserName', $actualCapabilities);
        $this->assertArrayHasKey('platform', $actualCapabilities);
        $this->assertEquals('ANY', $actualCapabilities['platform']);
        $this->assertArrayHasKey('moz:firefoxOptions', $actualCapabilities);

        $this->assertSame(['log' => ['level' => 'trace']], $actualCapabilities['moz:firefoxOptions']);
    }

    /**
     * @covers ::getDesiredCapabilities
     * @covers ::initFirefoxCapabilities
     */
    public function testMozFirefoxOptionsArgs()
    {
        $desiredCapabilities = [
            'firefox' => [
                'moz:firefoxOptions' => [
                    'args' => [
                        '-headless',
                    ],
                ],
            ],
        ];

        $webDriver = new FacebookWebDriver(FacebookWebDriver::DEFAULT_BROWSER, $desiredCapabilities);
        $actualCapabilities = $webDriver->getDesiredCapabilities()->toArray();

        $this->assertArrayHasKey('browserName', $actualCapabilities);
        $this->assertArrayHasKey('platform', $actualCapabilities);
        $this->assertEquals('ANY', $actualCapabilities['platform']);
        $this->assertArrayHasKey('moz:firefoxOptions', $actualCapabilities);

        $this->assertSame(['args' => ['-headless']], $actualCapabilities['moz:firefoxOptions']);
    }

    /**
     * @covers ::getDesiredCapabilities
     * @covers ::initFirefoxCapabilities
     */
    public function testMozFirefoxOptionsBinary()
    {
        $desiredCapabilities = [
            'firefox' => [
                'moz:firefoxOptions' => [
                    'binary' => '/path/to/firefox',
                ],
            ],
        ];

        $webDriver = new FacebookWebDriver(FacebookWebDriver::DEFAULT_BROWSER, $desiredCapabilities);
        $actualCapabilities = $webDriver->getDesiredCapabilities()->toArray();

        $this->assertArrayHasKey('browserName', $actualCapabilities);
        $this->assertArrayHasKey('platform', $actualCapabilities);
        $this->assertEquals('ANY', $actualCapabilities['platform']);
        $this->assertArrayHasKey('moz:firefoxOptions', $actualCapabilities);

        $this->assertSame(['binary' => '/path/to/firefox'], $actualCapabilities['moz:firefoxOptions']);
    }

    /**
     * @covers ::getDesiredCapabilities
     * @covers ::initChromeCapabilities
     */
    public function testChromeOptionsEmpty()
    {
        $desiredCapabilities = [
            'chrome' => [
            ],
        ];

        $webDriver = new FacebookWebDriver(FacebookWebDriver::DEFAULT_BROWSER, $desiredCapabilities);
        $actualCapabilities = $webDriver->getDesiredCapabilities()->toArray();

        $this->assertArrayHasKey('browserName', $actualCapabilities);
        $this->assertArrayHasKey('platform', $actualCapabilities);
        $this->assertEquals('ANY', $actualCapabilities['platform']);
        $this->assertArrayHasKey('chromeOptions', $actualCapabilities);

        $this->assertSame([], $actualCapabilities['chromeOptions']);
    }

    /**
     * @covers ::getDesiredCapabilities
     * @covers ::initChromeCapabilities
     */
    public function testChromeOptionsLegacy()
    {
        $desiredCapabilities = [
            'chrome' => [
                'switches' => [
                    '--no-sandbox',
                    '--headless',
                    '--no-gpu',
                ],
            ],
        ];

        $webDriver = new FacebookWebDriver(FacebookWebDriver::DEFAULT_BROWSER, $desiredCapabilities);
        $actualCapabilities = $webDriver->getDesiredCapabilities()->toArray();

        $this->assertArrayHasKey('browserName', $actualCapabilities);
        $this->assertArrayHasKey('platform', $actualCapabilities);
        $this->assertEquals('ANY', $actualCapabilities['platform']);
        $this->assertArrayHasKey('chromeOptions', $actualCapabilities);

        $this->assertSame(['args' => [
            '--no-sandbox',
            '--headless',
            '--no-gpu',
        ]], $actualCapabilities['chromeOptions']);
    }

    /**
     * @covers ::getDesiredCapabilities
     * @covers ::initChromeCapabilities
     */
    public function testChromeOptionsArgs()
    {
        $desiredCapabilities = [
            'chrome' => [
                'chromeOptions' => [
                    'args' => [
                        '--no-sandbox',
                        '--headless',
                        '--no-gpu',
                    ],
                ],
            ],
        ];

        $webDriver = new FacebookWebDriver(FacebookWebDriver::DEFAULT_BROWSER, $desiredCapabilities);
        $actualCapabilities = $webDriver->getDesiredCapabilities()->toArray();

        $this->assertArrayHasKey('browserName', $actualCapabilities);
        $this->assertArrayHasKey('platform', $actualCapabilities);
        $this->assertEquals('ANY', $actualCapabilities['platform']);
        $this->assertArrayHasKey('chromeOptions', $actualCapabilities);

        $this->assertSame(['args' => [
            '--no-sandbox',
            '--headless',
            '--no-gpu',
        ]], $actualCapabilities['chromeOptions']);
    }

    /**
     * @covers ::getDesiredCapabilities
     * @covers ::initChromeCapabilities
     */
    public function testChromeOptionsMixedLegacyAndArgs()
    {
        $desiredCapabilities = [
            'chrome' => [
                'switches' => [
                    '--start-maximized',
                ],
                'chromeOptions' => [
                    'args' => [
                        '--no-sandbox',
                        '--headless',
                        '--no-gpu',
                    ],
                ],
            ],
        ];

        $webDriver = new FacebookWebDriver(FacebookWebDriver::DEFAULT_BROWSER, $desiredCapabilities);
        $actualCapabilities = $webDriver->getDesiredCapabilities()->toArray();

        $this->assertArrayHasKey('browserName', $actualCapabilities);
        $this->assertArrayHasKey('platform', $actualCapabilities);
        $this->assertEquals('ANY', $actualCapabilities['platform']);
        $this->assertArrayHasKey('chromeOptions', $actualCapabilities);

        $this->assertSame(['args' => [
            '--start-maximized',
            '--no-sandbox',
            '--headless',
            '--no-gpu',
        ]], $actualCapabilities['chromeOptions']);
    }
}
