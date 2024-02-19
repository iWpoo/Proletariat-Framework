<?php

function redirect($to = null)
{
    if ($to !== null) {
        header("Location: $to");
        exit();
    }
}

function route($name): void
{
    $path = \Proletariat\Route::route($name);
    redirect($path);
}

function back(): void
{
    redirect($_SERVER['HTTP_REFERER']);
}