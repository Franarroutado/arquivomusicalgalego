<?php


Breadcrumbs::register('dashboard', function($breadcrumbs) {
    $breadcrumbs->push(trans('breadcrumbs.dashboard'), route('dashboard'));
});


//*************** AUTORES ***************//
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