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

use Behat\MinkExtension\ServiceContainer\Driver\DriverFactory;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\Definition;

/**
 * Factory required to provide facebook webriver support. This must be added to
 * {@see Behat\MinkExtension\ServiceContainer\MinkExtension} via registerDriverFactory().
 *
 * Base factory on older (but compatible config area) selenium 2 factory
 */
class FacebookFactory implements DriverFactory
{
    /**
     * {@inheritdoc}
     */
    public function getDriverName()
    {
        return 'facebook_web_driver';
    }

    /**
     * Guess capabilities from environment
     *
     * @return array
     */
    protected function guessCapabilities()
    {
        if (getenv('TRAVIS_JOB_NUMBER')) {
            return [
                'tunnel-identifier' => getenv('TRAVIS_JOB_NUMBER'),
                'build' => getenv('TRAVIS_BUILD_NUMBER'),
                'tags' => ['Travis-CI', 'PHP ' . phpversion()],
            ];
        }

        if (getenv('JENKINS_HOME')) {
            return [
                'tunnel-identifier' => getenv('JOB_NAME'),
                'build' => getenv('BUILD_NUMBER'),
                'tags' => ['Jenkins', 'PHP ' . phpversion(), getenv('BUILD_TAG')],
            ];
        }

        return [
            'tags' => [php_uname('n'), 'PHP ' . phpversion()],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function supportsJavascript()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function configure(ArrayNodeDefinition $builder)
    {
        $builder
            ->children()
                ->append($this->getCapabilitiesNode())
                ->scalarNode('wd_host')
                    ->defaultValue('http://localhost:4444/wd/hub')
                    ->end()
            ->end()
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function buildDriver(array $config)
    {
        // Build driver definition
        return new Definition(FacebookWebDriver::class, [
            $config['capabilities']['browserName'],
            array_replace($this->guessCapabilities(), $config['capabilities']),
            $config['wd_host'],
        ]);
    }

    /**
     * @return ArrayNodeDefinition
     */
    protected function getCapabilitiesNode()
    {
        $node = new ArrayNodeDefinition('capabilities');

        // https://w3c.github.io/webdriver/#capabilities.
        $node
            ->addDefaultsIfNotSet()
            ->normalizeKeys(false)
            ->ignoreExtraKeys(false)
            ->children()
                ->scalarNode('browserName')
                    ->info('Identifies the user agent.')
                    ->isRequired()
                ->end()
                ->scalarNode('browserVersion')
                    ->info('Identifies the version of the user agent.')
                ->end()
                ->scalarNode('platformName')
                    ->info('Identifies the operating system of the endpoint node.')
                ->end()
                ->booleanNode('acceptInsecureCerts')
                    ->info('Indicates whether untrusted and self-signed TLS certificates are implicitly trusted on navigation for the duration of the session.')
                    ->defaultValue(false)
                ->end()
                ->scalarNode('pageLoadStrategy')
                    ->info('Defines the current session’s page load strategy.')
                ->end()
                ->arrayNode('proxy')
                    ->children()
                        ->enumNode('proxyType')
                            ->values(['pac', 'direct', 'autodetect', 'system', 'manual'])
                            ->info('Indicates the type of proxy configuration.')
                        ->end()
                        ->scalarNode('proxyAutoconfigUrl')
                            ->info('Defines the URL for a proxy auto-config file if proxyType is equal to "pac".	')
                        ->end()
                        ->scalarNode('ftpProxy')
                            ->info('Defines the proxy host for FTP traffic when the proxyType is "manual".')
                        ->end()
                        ->scalarNode('httpProxy')
                            ->info('Defines the proxy host for HTTP traffic when the proxyType is "manual".')
                        ->end()
                        ->arrayNode('noProxy')
                            ->info('Lists the address for which the proxy should be bypassed when the proxyType is "manual".	')
                        ->end()
                        ->scalarNode('sslProxy')
                            ->info('Defines the proxy host for encrypted TLS traffic when the proxyType is "manual".')
                        ->end()
                        ->scalarNode('socksProxy')
                            ->info('Defines the proxy host for a SOCKS proxy when the proxyType is "manual".')
                        ->end()
                        ->integerNode('socksVersion')
                            ->info('Defines the SOCKS proxy version when the proxyType is "manual".')
                            ->min(0)
                            ->max(255)
                        ->end()
                    ->end()
                ->end()
                ->booleanNode('setWindowRect')
                    ->info('Indicates whether the remote end supports all of the resizing and repositioning commands.')
                ->end()
                ->arrayNode('timeouts')
                    ->info('Describes the timeouts imposed on certain session operations.')
                    ->children()
                        ->scalarNode('script')
                            ->info('Specifies when to interrupt a script that is being evaluated. A null value implies that scripts should never be interrupted, but instead run indefinitely.')
                        ->end()
                        ->integerNode('pageLoad')
                            ->info('Provides the timeout limit used to interrupt an explicit navigation attempt.')
                        ->end()
                        ->integerNode('implicit')
                            ->info('Specifies a time to wait for the element location strategy to complete when location an element')
                        ->end()
                    ->end()
                ->end()
                ->booleanNode('strictFileInteractability')
                    ->info('Defines the current session’s strict file interactability.')
                ->end()
                ->scalarNode('unhandledPromptBehavior')
                    ->info('Describes the current session’s user prompt handler. Defaults to the dismiss and notify state.')
                ->end()
            ->end();

        return $node;
    }
}
