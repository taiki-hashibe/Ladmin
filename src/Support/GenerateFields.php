<?php

namespace LowB\Ladmin\Support;

use LowB\Ladmin\Support\Facades\GenerateValidationRules;
use LowB\Ladmin\Support\Query\LadminQuery;
use Illuminate\Support\Str;
use LowB\Ladmin\Config\Facades\LadminConfig;
use LowB\Ladmin\Fields\Field;

class GenerateFields
{
    public function show(LadminQuery $query): array
    {
        $fields = [];
        foreach ($query->getColumns() as $col) {
            /** @var \Doctrine\DBAL\Schema\Column $col */
            $type = $col->getType();
            $typeName = $type->getTypeRegistry()->lookupName($type);
            $fields[] = $this->handle($col, 'show', $typeName)::column($col->getName())->setValidation(GenerateValidationRules::generateColumn($col));
        }
        return $fields;
    }

    public function detail(LadminQuery $query): array
    {
        $fields = [];
        foreach ($query->getColumns() as $col) {
            /** @var \Doctrine\DBAL\Schema\Column $col */
            $type = $col->getType();
            $typeName = $type->getTypeRegistry()->lookupName($type);
            $fields[] = $this->handle($col, 'detail', $typeName)::column($col->getName())->setValidation(GenerateValidationRules::generateColumn($col));
        }
        return $fields;
    }

    public function edit(LadminQuery $query): array
    {
        $fields = [];
        foreach ($query->getColumns() as $col) {
            /** @var \Doctrine\DBAL\Schema\Column $col */
            $type = $col->getType();
            $typeName = $type->getTypeRegistry()->lookupName($type);
            $fields[] = $this->handle($col, 'editor', $typeName)::column($col->getName(), $typeName)->setValidation(GenerateValidationRules::generateColumn($col));
        }
        return $fields;
    }

    protected function handle(\Doctrine\DBAL\Schema\Column $col, string $action, string $typeName): Field
    {
        $studlyActionName = Str::studly($action);
        $fieldClass = "\LowB\Ladmin\Fields\\$studlyActionName\\$studlyActionName" . "Field";
        if (class_exists(LadminConfig::config('namespace.fields') . "\\$studlyActionName\\$studlyActionName" . Str::studly($typeName) . "Field")) {
            $fieldClass = LadminConfig::config('namespace.fields') . "\\$studlyActionName\\$studlyActionName" . Str::studly($typeName) . "Field";
        } else if (class_exists("\LowB\Ladmin\Fields\\$studlyActionName\\$studlyActionName" . Str::studly($typeName) . "Field")) {
            $fieldClass = "\LowB\Ladmin\Fields\\$studlyActionName\\$studlyActionName" . Str::studly($typeName) . "Field";
        }
        return app()->make($fieldClass);
    }
}
