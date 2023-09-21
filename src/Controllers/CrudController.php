<?php

namespace LowB\Ladmin\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use LowB\Ladmin\Config\Facades\LadminConfig;
use LowB\Ladmin\Facades\Ladmin;

class CrudController extends AbstractCrudController
{
    public function show(Request $request)
    {
        return View::first([LadminConfig::config('view.prefix') . '.crud.show', LadminConfig::themeView('crud.show')], [
            'fields' => $this->showFields()
        ]);
    }

    public function detail(Request $request)
    {
        return View::first([LadminConfig::config('view.prefix') . '.crud.detail', LadminConfig::themeView('crud.detail')], [
            'fields' => $this->detailFields()
        ]);
    }

    public function edit(Request $request)
    {
        return View::first([
            LadminConfig::config('view.prefix') . '.crud.detail',
            LadminConfig::themeView('crud.show')
        ], [
            'fields' => $this->editFields()
        ]);
    }

    public function create(Request $request): RedirectResponse
    {
        $request->validate($this->validationRules());
        Ladmin::query()->create($this->getRequestValues($request));
        return redirect()->route(Ladmin::crud()->detail()->create()->routeName(), [
            'primaryKey' => Ladmin::currentPrimaryKey()
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate($this->validationRules());
        Ladmin::currentItemUpdate($this->getRequestValues($request));
        return redirect()->route(Ladmin::getDetailRouteName(), [
            'primaryKey' => Ladmin::currentItemPrimaryKey()
        ]);;
    }

    public function destroy(Request $request): RedirectResponse
    {
        Ladmin::currentItemDelete();
        return redirect()->route(Ladmin::getShowRouteName());
    }
}
