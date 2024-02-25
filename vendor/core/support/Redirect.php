<?php 

namespace Proletariat\Support;

class Redirect
{
    public static function redirect($to = null): self
    {
        if ($to !== null) {
            header("Location: $to");
            exit();
        }

        return new self();
    }

    public function route($name): self
    {
        $path = \Proletariat\Route::route($name);
        self::redirect($path);
        return $this;
    }

    public function back(): self
    {
        self::redirect($_SERVER['HTTP_REFERER']);
        return $this;
    }
}
