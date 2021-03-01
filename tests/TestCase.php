<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use ReflectionClass;
use ReflectionException;
use ReflectionNamedType;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function withPermissions(int $permissions): self
    {
        $user = User::factory()
            ->create(['permissions' => $permissions]);

        return $this->actingAs($user);
    }

    public function assertRouteUsesFormRequest(string $routeName, string $formRequest)
    {
        $controllerAction = collect(Route::getRoutes())->filter(function (\Illuminate\Routing\Route $route) use ($routeName) {
            return $route->getName() === $routeName;
        })->pluck('action.controller');

        $this->assertNotEmpty($controllerAction, 'Route "'.$routeName.'" is not defined.');
        $this->assertCount(1, $controllerAction, 'Route "'.$routeName.'" is defined multiple times, route names should be unique.');

        $controller = $controllerAction->first();
        $method = '__invoke';

        if (strstr($controllerAction->first(), '@')) {
            [$controller, $method] = explode('@', $controllerAction->first());
        }

        $this->assertActionUsesFormRequest($controller, $method, $formRequest);
    }

    public function assertActionUsesFormRequest(string $controller, string $method, string $formRequest)
    {
        $this->assertTrue(is_subclass_of($formRequest, 'Illuminate\\Foundation\\Http\\FormRequest'), $formRequest.' is not a type of Form Request');

        try {
            $reflector = new ReflectionClass($controller);
            $action = $reflector->getMethod($method);
        } catch (ReflectionException) {
            test()->fail('Controller action could not be found: '.$controller.'@'.$method);
        }

        $this->assertTrue($action->isPublic(), 'Action "'.$method.'" is not public, controller actions must be public.');

        $actual = collect($action->getParameters())->contains(function ($parameter) use ($formRequest) {
            return $parameter->getType() instanceof ReflectionNamedType && $parameter->getType()->getName() === $formRequest;
        });

        $this->assertTrue($actual, 'Action "'.$method.'" does not have validation using the "'.$formRequest.'" Form Request.');
    }
}
