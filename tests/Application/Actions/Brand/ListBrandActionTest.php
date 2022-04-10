<?php

declare(strict_types=1);

namespace Tests\Application\Actions\Brand;

use App\Application\Actions\ActionPayload;
use App\Domain\Brand\BrandRepository;
use App\Domain\Brand\Brand;
use DI\Container;
use Tests\TestCase;

class ListBrandActionTest extends TestCase
{
    public function testAction()
    {
        $app = $this->getAppInstance();

        /** @var Container $container */
        $container = $app->getContainer();

        $brand = new Brand(1, 'microsoft', 'Microsoft');

        $brandRepositoryProphecy = $this->prophesize(BrandRepository::class);
        $brandRepositoryProphecy
            ->findAll()
            ->willReturn([$brand])
            ->shouldBeCalledOnce();

        $container->set(BrandRepository::class, $brandRepositoryProphecy->reveal());

        $request = $this->createRequest('GET', '/brands');
        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedPayload = new ActionPayload(200, [$brand]);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }
}
