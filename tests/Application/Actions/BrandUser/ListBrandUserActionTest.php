<?php

declare(strict_types=1);

namespace Tests\Application\Actions\BrandUser;

use App\Application\Actions\ActionPayload;
use App\Domain\BrandUser\BrandUserRepository;
use App\Domain\BrandUser\BrandUser;
use DI\Container;
use Tests\TestCase;

class ListBrandUserActionTest extends TestCase
{
    public function testAction()
    {
        $app = $this->getAppInstance();

        /** @var Container $container */
        $container = $app->getContainer();

        $branduser = new BrandUser(1, 'microsoft', 'Microsoft', 'bill.gates', 'Bill', 'Gates');

        $brandUserRepositoryProphecy = $this->prophesize(BrandUserRepository::class);
        $brandUserRepositoryProphecy
            ->findAll()
            ->willReturn([$branduser])
            ->shouldBeCalledOnce();

        $container->set(BrandUserRepository::class, $brandUserRepositoryProphecy->reveal());

        $request = $this->createRequest('GET', '/brandusers');
        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedPayload = new ActionPayload(200, [$branduser]);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }
}
