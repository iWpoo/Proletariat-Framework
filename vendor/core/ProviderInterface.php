<?php

namespace Core;
	
use DI\ContainerBuilder;

interface ProviderInterface
{
    public static function register(ContainerBuilder $containerBuilder);
}