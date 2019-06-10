<?php
/*
 * This file is part of the Moodle MinkFacebookWebDriver Driver Extension.
 * (c) Andrew Nicols <andrew@nicols.co.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Moodle\MinkFacebookWebDriver;

use Behat\MinkExtension\ServiceContainer\MinkExtension as BaseMinkExtension;
use Moodle\MinkFacebookWebDriver\Driver\FacebookFactory;

/**
 * Example implementation of a Mink Extension to register the FacebookFactory.
 */
class MinkExtension extends BaseMinkExtension
{
    public function __construct()
    {
        parent::__construct();
        $this->registerDriverFactory(new FacebookFactory());
    }
}
