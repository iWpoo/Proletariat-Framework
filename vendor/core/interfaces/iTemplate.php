<?php

namespace Proletariat\Interfaces;

interface iTemplate
{
    public function render(string $view, array $data);
}