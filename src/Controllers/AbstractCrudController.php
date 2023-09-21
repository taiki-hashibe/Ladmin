<?php

namespace LowB\Ladmin\Controllers;

use Illuminate\Http\Request;
use LowB\Ladmin\Crud\Crud;
use LowB\Ladmin\Facades\Ladmin;
use LowB\Ladmin\Support\Facades\GenerateFields;

class AbstractCrudController extends Controller
{
    public function showFields(): array
    {
        return GenerateFields::show(Ladmin::currentQuery());
    }

    public function detailFields(): array
    {
        return GenerateFields::detail(Ladmin::currentQuery());
    }

    public function editFields(): array
    {
        return GenerateFields::edit(Ladmin::currentQuery());
    }

    protected function validationRules(): array
    {
        $validations = [];
        $editorFields = $this->editFields();
        foreach ($editorFields as $field) {
            $validations[$field->getName()] = $field->getValidation();
        }
        return $validations;
    }

    protected function getRequestValues(Request $request): array
    {
        $values = [];
        $editorFields = $this->editFields();
        foreach ($editorFields as $field) {
            $values[$field->getName()] = $request->{$field->getName()};
        }
        return $values;
    }
}
