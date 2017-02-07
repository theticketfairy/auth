<?php
/**
 * SocialConnect project
 * @author: Patsura Dmitry https://github.com/ovr <talk@dmtry.me>
 */

namespace Test\Providers;

use ReflectionClass;
use SocialConnect\Auth\Provider\Exception\InvalidAccessToken;
use SocialConnect\Auth\Consumer;
use SocialConnect\OAuth2\AccessToken;
use SocialConnect\Common\Http\Client\ClientInterface;
use Test\TestCase;

class AbstractProviderTestCase extends TestCase
{
    /**
     * @param mixed $responseData
     * @param int $responseCode
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function makeIdentityClientResponse($responseData, $responseCode = 200)
    {
        $mockedHttpClient = $this->getMockBuilder(\SocialConnect\Common\Http\Client\Curl::class)
            ->disableProxyingToOriginalMethods()
            ->getMock();

        $response = new \SocialConnect\Common\Http\Response(
            $responseCode,
            $responseData,
            []
        );

        $mockedHttpClient->expects($this->once())
            ->method('request')
            ->willReturn($response);

        return $mockedHttpClient;
    }

    /**
     * @param object $object
     * @param string $name
     * @param array $params
     * @return mixed
     */
    protected static function callProtectedMethod($object, $name, array $params = [])
    {
        $class = new ReflectionClass($object);

        $method = $class->getMethod($name);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $params);
    }
}