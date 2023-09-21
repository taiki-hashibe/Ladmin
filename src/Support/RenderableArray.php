<?php

namespace LowB\Ladmin\Support;

use LowB\Ladmin\Contracts\Renderable;

class RenderableArray
{
    public array $items = [];

    public function register(Renderable $renderable): void
    {
        $this->items[] = $renderable;
    }

    public function render(): void
    {
        foreach ($this->items as $item) {
            echo $item->render();
        }
    }
}
