<?php


Breadcrumbs::register('dashboard', function($breadcrumbs) {
    $breadcrumbs->push(trans('breadcrumbs.dashboard'), route('dashboard'));
});

//*************** AUTHORS ***************//
Breadcrumbs::register('autores', function($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(trans('breadcrumbs.authors'), route('dashboard.autores.index'));
});

Breadcrumbs::register('autoresEdit', function($breadcrumbs, $id) {
    $breadcrumbs->parent('autores');
    $breadcrumbs->push(trans('breadcrumbs.edit'), route('dashboard.autores.edit', $id));
});

Breadcrumbs::register('autoresCreate', function($breadcrumbs) {
    $breadcrumbs->parent('autores');
    $breadcrumbs->push(trans('breadcrumbs.create'), route('dashboard.autores.create'));
});

//*************** GENRES ***************//
Breadcrumbs::register('generos', function($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(trans('breadcrumbs.genres'), route('dashboard.generos.index'));
});

Breadcrumbs::register('generosEdit', function($breadcrumbs, $id) {
    $breadcrumbs->parent('generos');
    $breadcrumbs->push(trans('breadcrumbs.edit'), route('dashboard.generos.edit', $id));
});

Breadcrumbs::register('generosCreate', function($breadcrumbs) {
    $breadcrumbs->parent('generos');
    $breadcrumbs->push(trans('breadcrumbs.create'), route('dashboard.generos.create'));
});

//*************** MATERIALS ***************//
Breadcrumbs::register('materiales', function($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(trans('breadcrumbs.materials'), route('dashboard.materiales.index'));
});

Breadcrumbs::register('materialesEdit', function($breadcrumbs, $id) {
    $breadcrumbs->parent('materiales');
    $breadcrumbs->push(trans('breadcrumbs.edit'), route('dashboard.materiales.edit', $id));
});

Breadcrumbs::register('materialesCreate', function($breadcrumbs) {
    $breadcrumbs->parent('materiales');
    $breadcrumbs->push(trans('breadcrumbs.create'), route('dashboard.materiales.create'));
});