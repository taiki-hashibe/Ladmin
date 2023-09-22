<?php

namespace LowB\Ladmin\Contracts;

use Illuminate\Contracts\View\View;

interface Renderable
{
    public function getOrder(): ?int;

    public function render(mixed $params = []): View;
}
