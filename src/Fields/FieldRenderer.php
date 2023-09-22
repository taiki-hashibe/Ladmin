<?php

namespace LowB\Ladmin\Fields;

use Illuminate\Contracts\View\View as ContractsView;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use LowB\Ladmin\Config\Facades\LadminConfig;
use LowB\Ladmin\Contracts\Renderable;

abstract class FieldRenderer implements Renderable
{
    protected string $columnView = 'fields.show.column-default';

    protected string $view = 'fields.default';

    protected ?string $type;

    protected string $columnName;

    protected string $label;

    protected array $validation = [];

    protected ?int $order;

    protected bool $isCanSort = true;

    protected bool $isCanFilter = true;

    public function __construct(string $columnName, string $view, string $type = null, int $order = null)
    {
        $this->columnName = $columnName;
        $this->label = $columnName;
        $this->view = $view;
        $this->type = $type;
        $this->order = $order;
    }

    public function getName(): string
    {
        return $this->columnName;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getValue(mixed $query): mixed
    {
        return $query->{$this->columnName};
    }

    public function setView(string $view): self
    {
        $this->view = $view;

        return $this;
    }

    public function setColumnView(string $columnView): self
    {
        $this->columnView = $columnView;

        return $this;
    }

    public function setValidation(array $validation): self
    {
        $this->validation = $validation;

        return $this;
    }

    public function getValidation(): array
    {
        return $this->validation;
    }

    public function getOrder(): ?int
    {
        return $this->order;
    }

    public function setIsCanSort(bool $isCanSort): self
    {
        $this->isCanSort = $isCanSort;

        return $this;
    }

    public function setIsCanFilter(bool $isCanFilter): self
    {
        $this->isCanFilter = $isCanFilter;

        return $this;
    }

    public function render(mixed $params = []): ContractsView
    {
        $viewPriority = [];
        if ($this->type) {
            $viewPriority[] = LadminConfig::localView(Str::of($this->view)->replace('default', $this->type));
        }
        $viewPriority[] = LadminConfig::localView($this->view);
        if ($this->type) {
            $viewPriority[] = LadminConfig::localView(Str::of($this->view)->replace('default', $this->type));
        }
        $viewPriority[] = LadminConfig::themeView($this->view);

        return View::first($viewPriority, [
            'field' => $this,
            'label' => $this->getLabel(),
            'name' => $this->columnName,
            'value' => $this->getValue($params),
        ]);
    }

    public function showColumnRender(mixed $params = [])
    {
        $viewPriority = [];
        if ($this->type) {
            $viewPriority[] = LadminConfig::localView(Str::of($this->columnView)->replace('default', $this->type));
        }
        $viewPriority[] = LadminConfig::localView($this->columnView);
        if ($this->type) {
            $viewPriority[] = LadminConfig::localView(Str::of($this->columnView)->replace('default', $this->type));
        }
        $viewPriority[] = LadminConfig::themeView($this->columnView);

        return View::first($viewPriority, [
            'field' => $this,
            'label' => $this->getLabel(),
            'name' => $this->columnName,
            'isCanSort' => $this->isCanSort,
            'isCanFilter' => $this->isCanFilter,
            'params' => $params,
        ]);
    }

    public function isRequired(): bool
    {
        return in_array('required', $this->validation);
    }
}
