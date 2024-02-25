<?php

namespace Proletariat\Template;

interface iTemplate
{
    public function render(string $view, array $data);
}