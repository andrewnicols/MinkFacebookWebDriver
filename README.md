# Mink Facebook WebDriver extension

This is based on a fork of [https://github.com/silverstripe/MinkFacebookWebDriver/] but updated to work with W3C
compliant Facebook\Webdriver.

Note: At this point it is using a fork of the Facebook\Webdriver until the official version includes W3C support.

Key points of this driver are:

 - Supports using W3C Compliant facebook/webdriver
 - Selenium optional - can be used with Chromedriver and Geckodriver directly.

## Using the Facebook WebDriver with behat

A convenience class is provided if you have not many any cusomisation to the default MinkExtension.
If you have customised your MinkExtension, then you wil need to register the FacebookFactory Driver Factory with Mink:

```php
<?php

namespace Moodle\BehatExtension;

use Behat\MinkExtension\ServiceContainer\MinkExtension as BaseMinkExtension;
use Moodle\MinkFacebookWebDriver\Driver\FacebookFactory;

class MinkExtension extends BaseMinkExtension
{
    public function __construct()
    {
        parent::__construct();
        $this->registerDriverFactory(new FacebookFactory());
    }
}
```

Add this extension to your `behat.yml` (see below)

```
default:
  suites: []
  extensions:
    Moodle\BehatExtension\MinkExtension:
      facebook_web_driver:
        wd_host: "http://localhost:4444/wd/hub"
        capabilities:
          # Standard W3C Driver capabilities go here.
          browserName: chrome
```

## Maintainers

* Andrew Nicols <andrew@nicols.co.uk>

Credit to the maintainers of the SilverStripe fork:

* Damian Mooyman [tractorcow](https://github.com/tractorcow)

Credit to original maintainers of MinkSelenium2Driver

* Christophe Coevoet [stof](https://github.com/stof)
* Pete Otaqui [pete-otaqui](http://github.com/pete-otaqui)

## License

MIT License

Copyright (c) 2012 Pete Otaqui <pete@otaqui.com>.
Copyright (c) 2019 Andrew Nicols <andrew@nicols.co.uk>

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
