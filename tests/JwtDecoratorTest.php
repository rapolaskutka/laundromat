<?php

namespace App\Tests\OpenApi;

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
        // Create a stub for the OpenApiFactoryInterface.
        $decoratedStub = $this->createMock(OpenApiFactoryInterface::class);

        // Configure the stub to return an OpenApi object with initialized components.
        $info = new Info(title: 'API', version: '1.0.0');
        $paths = new Paths();
        $components = new Components(new \ArrayObject(), new \ArrayObject(), new \ArrayObject(), new \ArrayObject());

        // Initialize OpenApi with the Components object
        $openApi = new OpenApi($info, [], $paths, $components);
        $decoratedStub->method('__invoke')->willReturn($openApi);

        // Create an instance of JwtDecorator with the stub.
        $jwtDecorator = new JwtDecorator($decoratedStub);

        // Invoke JwtDecorator.
        $result = $jwtDecorator->__invoke();

        // Get the components to check if Token and Credentials schemas were added.
        $schemas = $result->getComponents()->getSchemas();

        // Assert that the Schemas object is not null.
        $this->assertNotNull($schemas, 'Schemas should not be null.');

        // Assert that the Token and Credentials schemas are set.
        $this->assertArrayHasKey('Token', $schemas);
        $this->assertArrayHasKey('Credentials', $schemas);
    }
}
