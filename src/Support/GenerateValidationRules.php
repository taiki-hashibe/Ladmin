<?php

namespace LowB\Ladmin\Support;

use LowB\Ladmin\Config\Facades\LadminConfig;
use LowB\Ladmin\Crud\Crud;

class GenerateValidationRules
{
    public function generate(Crud $crud): array
    {
        $validations = [];
        foreach ($crud->columns() as $col) {
            /** @var \Doctrine\DBAL\Schema\Column $col */
            if (in_array($col->getName(), LadminConfig::hiddenEditor())) {
                continue;
            }
            $validations[$col->getName()][] = $this->generateColumn($col);
        }
        return $validations;
    }

    public function generateColumn(\Doctrine\DBAL\Schema\Column $column): array
    {
        $rules = [];

        // Check for NOT NULL constraint
        if (!$column->getNotnull()) {
            $rules[] = 'nullable';
        } else {
            $rules[] = 'required';
        }

        // Check for data type and add appropriate rules
        $type = $column->getType()->getTypeRegistry()->lookupName($column->getType());
        switch ($type) {
            case 'string':
                $rules[] = 'string';
                $rules[] = 'max:' . $column->getLength();
                break;
            case 'integer':
                $rules[] = 'integer';
                break;
            case 'float':
                $rules[] = 'numeric';
                $rules[] = 'between:' . (-10 ** 9) . ',' . (10 ** 9); // Example range
                break;
                // Add cases for other data types as needed
        }

        return $rules;
    }
}
