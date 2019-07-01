<?php

declare(strict_types=1);

namespace Abbadon1334\ATKFastRoute\Route;

use Abbadon1334\ATKFastRoute\Handler\Contracts\iOnRoute;
use Abbadon1334\ATKFastRoute\Handler\HandlerHelper;
use Abbadon1334\ATKFastRoute\Handler\RoutedMethod;
use Abbadon1334\ATKFastRoute\Handler\RoutedUI;

class Route implements iRoute
{
    protected $methods;
    protected $route;
    protected $handler;

    public function __construct(string $route, ?array $methods = null, ?iOnRoute $handler = null)
    {
        $this->methods = $methods ?? [];
        $this->route = $route;
        $this->handler = $handler;
    }

    public static function fromArray(array $route): iRoute
    {
        return new self($route[1], $route[0], HandlerHelper::fromArray($route[2]));
    }

    public function getMethods(): array
    {
        return $this->methods;
    }

    public function getRoute(): string
    {
        return $this->route;
    }

    public function getHandler(): iOnRoute
    {
        return $this->handler;
    }

    public function addMethod(string $method): void
    {
        $this->methods[] = $method;
    }

    public function handleWithUI(string $class, array $defaults = []): void
    {
        $this->handler = new RoutedUI($class, $defaults);
    }

    public function handleWithMethod(string $ControllerClass, string $ControllerMethod): void
    {
        $this->handler = new RoutedMethod($ControllerClass, $ControllerMethod);
    }

    public function toArray(): array
    {
        return [
            $this->getMethods(),
            $this->getRoute(),
            $this->getHandler() /*->toArray()*/,
        ];
    }
}
