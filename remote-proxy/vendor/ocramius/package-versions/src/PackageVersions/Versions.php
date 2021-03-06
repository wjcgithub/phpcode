<?php

namespace PackageVersions;

/**
 * This class is generated by ocramius/package-versions, specifically by
 * @see \PackageVersions\Installer
 *
 * This file is overwritten at every run of `composer install` or `composer update`.
 */
final class Versions
{
    const ROOT_PACKAGE_NAME = '__root__';
    const VERSIONS = array (
  'doctrine/annotations' => 'v1.6.0@c7f2050c68a9ab0bdb0f98567ec08d80ea7d24d5',
  'doctrine/lexer' => 'v1.0.1@83893c552fd2045dd78aef794c31e694c37c0b8c',
  'guzzlehttp/guzzle' => '6.3.2@68d0ea14d5a3f42a20e87632a5f84931e2709c90',
  'guzzlehttp/promises' => 'v1.3.1@a59da6cf61d80060647ff4d3eb2c03a2bc694646',
  'guzzlehttp/psr7' => '1.4.2@f5b8a8512e2b58b0071a7280e39f14f72e05d87c',
  'ocramius/package-versions' => '1.3.0@4489d5002c49d55576fa0ba786f42dbb009be46f',
  'ocramius/proxy-manager' => '2.1.1@e18ac876b2e4819c76349de8f78ccc8ef1554cd7',
  'paragonie/random_compat' => 'v2.0.11@5da4d3c796c275c55f057af5a643ae297d96b4d8',
  'pimple/pimple' => 'v3.2.3@9e403941ef9d65d20cba7d54e29fe906db42cf32',
  'psr/container' => '1.0.0@b7ce3b176482dbbc1245ebf52b181af44c2cf55f',
  'psr/http-message' => '1.0.1@f6561bf28d520154e4b0ec72be95418abe6d9363',
  'psr/log' => '1.0.2@4ebe3a8bf773a19edfe0a84b6585ba3d401b724d',
  'silex/silex' => 'v2.2.4@d2531e5b8099c429b752ad2154e85999c3689057',
  'symfony/debug' => 'v4.0.7@5961d02d48828671f5d8a7805e06579d692f6ede',
  'symfony/event-dispatcher' => 'v3.4.7@58990682ac3fdc1f563b7e705452921372aad11d',
  'symfony/http-foundation' => 'v3.4.7@b11e6d165ff4cbf5685d185ab19a90f2f3bb7d1e',
  'symfony/http-kernel' => 'v3.4.7@43cfdad2ca1dba608662db0699c1bbb715d08191',
  'symfony/polyfill-mbstring' => 'v1.7.0@78be803ce01e55d3491c1397cf1c64beb9c1b63b',
  'symfony/polyfill-php70' => 'v1.7.0@3532bfcd8f933a7816f3a0a59682fc404776600f',
  'symfony/routing' => 'v3.4.7@5f90733adbf19ea71468a5761fb8f5a043d424dd',
  'zendframework/zend-code' => '3.3.0@6b1059db5b368db769e4392c6cb6cc139e56640d',
  'zendframework/zend-eventmanager' => '3.2.0@9d72db10ceb6e42fb92350c0cb54460da61bd79c',
  '__root__' => 'No version set (parsed as 1.0.0)@',
);

    private function __construct()
    {
    }

    /**
     * @throws \OutOfBoundsException if a version cannot be located
     */
    public static function getVersion(string $packageName) : string
    {
        if (isset(self::VERSIONS[$packageName])) {
            return self::VERSIONS[$packageName];
        }

        throw new \OutOfBoundsException(
            'Required package "' . $packageName . '" is not installed: cannot detect its version'
        );
    }
}
