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

    public function sort()
    {
        usort($this->items, function (Renderable $a, Renderable $b) {
            $orderA = $a->getOrder();
            $orderB = $b->getOrder();

            if ($orderA === null && $orderB !== null) {
                return 1;
            } elseif ($orderA !== null && $orderB === null) {
                return -1;
            }

            return $orderA <=> $orderB;
        });
    }

    public function render(): void
    {
        $this->sort();
        foreach ($this->items as $item) {
            echo $item->render();
        }
    }
}
