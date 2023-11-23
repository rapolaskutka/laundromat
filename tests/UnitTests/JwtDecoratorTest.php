<?php

namespace App\Tests\UnitTests;

use ApiPlatform\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\OpenApi\Model\Components;
use ApiPlatform\OpenApi\Model\Info;
use ApiPlatform\OpenApi\Model\Paths;
use ApiPlatform\OpenApi\OpenApi;
use App\OpenApi\JwtDecorator;
use PHPUnit\Framework\TestCase;

class JwtDecoratorTest extends TestCase
{
    public function testInvokeAddsTokenAndCredentialsSchemas(): void
    {

        $decoratedStub = $this->createStub(OpenApiFactoryInterface::class);

        $info = new Info(title: 'API', version: '1.0.0');
        $paths = new Paths();
        $components = new Components(new \ArrayObject(), new \ArrayObject(), new \ArrayObject(), new \ArrayObject());


        $openApi = new OpenApi($info, [], $paths, $components);
        $decoratedStub->method('__invoke')->willReturn($openApi);

        $jwtDecorator = new JwtDecorator($decoratedStub);

        $result = $jwtDecorator->__invoke();

        $schemas = $result->getComponents()->getSchemas();


        $this->assertNotNull($schemas, 'Schemas should not be null.');

        $this->assertArrayHasKey('Token', $schemas);
        $this->assertArrayHasKey('Credentials', $schemas);
    }
}
