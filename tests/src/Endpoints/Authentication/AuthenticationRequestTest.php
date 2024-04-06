<?php

namespace Paytic\Smartfintech\Tests\Endpoints\Authentication;

use Paytic\Smartfintech\Endpoints\Authentication\AuthenticationRequest;
use Paytic\Smartfintech\Tests\TestCase;

class AuthenticationRequestTest extends TestCase
{
    public function test_create_from_string()
    {
        $request = AuthenticationRequest::create('client_id');
        self::assertInstanceOf(AuthenticationRequest::class, $request);
        self::assertSame('client_id', $request->client_id);
    }

    public function test_create_from_array()
    {
        $request = AuthenticationRequest::create(
            [
                'client_id' => 'client_id',
                'isLink2Pay' => false,
                'flexibleURL' => false,
                'isHeadless' => false,
            ]);
        self::assertInstanceOf(AuthenticationRequest::class, $request);
        self::assertSame('client_id', $request->client_id);
        self::assertFalse($request->isLink2Pay);
        self::assertFalse($request->flexibleURL);
        self::assertFalse($request->isHeadless);
    }

    public function test_create_from_array_missing_client_id()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Missing client_id");
        AuthenticationRequest::create([]);
    }
}
