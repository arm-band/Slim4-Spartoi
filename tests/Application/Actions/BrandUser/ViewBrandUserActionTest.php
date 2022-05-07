<?php

declare(strict_types=1);

namespace Tests\Application\Actions\BrandUser;

use App\Application\Actions\ActionError;
use App\Application\Actions\ActionPayload;
use App\Application\Handlers\HttpErrorHandler;
use App\Domain\BrandUser\BrandUser;
use App\Domain\BrandUser\BrandUserNotFoundException;
use App\Domain\BrandUser\BrandUserRepository;
use DI\Container;
use Slim\Middleware\ErrorMiddleware;
use Tests\TestCase;

class ViewBrandUserActionTest extends TestCase
{
    public function testAction()
    {
        $app = $this->getAppInstance();

        /** @var Container $container */
        $container = $app->getContainer();

        $branduser = new BrandUser(1, 'microsoft', 'Microsoft', 'bill.gates', 'Bill', 'Gates');

        $brandUserRepositoryProphecy = $this->prophesize(BrandUserRepository::class);
        $brandUserRepositoryProphecy
            ->findBrandUserOfId(1)
            ->willReturn($branduser)
            ->shouldBeCalledOnce();

        $container->set(BrandUserRepository::class, $brandUserRepositoryProphecy->reveal());

        $request = $this->createRequest('GET', '/brandusers/1');
        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedPayload = new ActionPayload(200, $branduser);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }

    public function testActionThrowsBrandUserNotFoundException()
    {
        $app = $this->getAppInstance();

        $callableResolver = $app->getCallableResolver();
        $responseFactory = $app->getResponseFactory();

        $errorHandler = new HttpErrorHandler($callableResolver, $responseFactory);
        $errorMiddleware = new ErrorMiddleware($callableResolver, $responseFactory, true, false, false);
        $errorMiddleware->setDefaultErrorHandler($errorHandler);

        $app->add($errorMiddleware);

        /** @var Container $container */
        $container = $app->getContainer();

        $brandUserRepositoryProphecy = $this->prophesize(BrandUserRepository::class);
        $brandUserRepositoryProphecy
            ->findBrandUserOfId(1)
            ->willThrow(new BrandUserNotFoundException())
            ->shouldBeCalledOnce();

        $container->set(BrandUserRepository::class, $brandUserRepositoryProphecy->reveal());

        $request = $this->createRequest('GET', '/brandusers/1');
        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedError = new ActionError(ActionError::RESOURCE_NOT_FOUND, 'The branduser you requested does not exist.');
        $expectedPayload = new ActionPayload(404, null, $expectedError);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }
}
