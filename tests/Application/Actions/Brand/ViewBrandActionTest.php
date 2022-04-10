<?php

declare(strict_types=1);

namespace Tests\Application\Actions\Brand;

use App\Application\Actions\ActionError;
use App\Application\Actions\ActionPayload;
use App\Application\Handlers\HttpErrorHandler;
use App\Domain\Brand\Brand;
use App\Domain\Brand\BrandNotFoundException;
use App\Domain\Brand\BrandRepository;
use DI\Container;
use Slim\Middleware\ErrorMiddleware;
use Tests\TestCase;

class ViewBrandActionTest extends TestCase
{
    public function testAction()
    {
        $app = $this->getAppInstance();

        /** @var Container $container */
        $container = $app->getContainer();

        $brand = new Brand(1, 'microsoft', 'Microsoft');

        $brandRepositoryProphecy = $this->prophesize(BrandRepository::class);
        $brandRepositoryProphecy
            ->findBrandOfId(1)
            ->willReturn($brand)
            ->shouldBeCalledOnce();

        $container->set(BrandRepository::class, $brandRepositoryProphecy->reveal());

        $request = $this->createRequest('GET', '/brands/1');
        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedPayload = new ActionPayload(200, $brand);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }

    public function testActionThrowsBrandNotFoundException()
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

        $brandRepositoryProphecy = $this->prophesize(BrandRepository::class);
        $brandRepositoryProphecy
            ->findBrandOfId(1)
            ->willThrow(new BrandNotFoundException())
            ->shouldBeCalledOnce();

        $container->set(BrandRepository::class, $brandRepositoryProphecy->reveal());

        $request = $this->createRequest('GET', '/brands/1');
        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedError = new ActionError(ActionError::RESOURCE_NOT_FOUND, 'The brand you requested does not exist.');
        $expectedPayload = new ActionPayload(404, null, $expectedError);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }
}
