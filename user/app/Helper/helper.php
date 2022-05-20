<?php declare(strict_types=1);


use Hyperf\Utils\ApplicationContext;
use Psr\Container\ContainerInterface;

if (!function_exists('di')) {
    /**
     * 容器实例
     * @return ContainerInterface
     */
    function di(): ContainerInterface {
        return ApplicationContext::getContainer();
    }
}