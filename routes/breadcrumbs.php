<?php

Breadcrumbs::for('home', function ($trail) {
    $trail->push('Home', route('home'));
});

Breadcrumbs::for('import', function ($trail) {
    $trail->parent('home');
    $trail->push('Import', route('import'));
});

Breadcrumbs::for('records', function ($trail) {

    if(Auth::user()->hasRole('viewer')){
        $trail->push('Records', route('records'));
    } else{
        $trail->parent('home');
        $trail->push('Records', route('records'));
    }

});

Breadcrumbs::for('record', function ($trail, $recordId) {
    $trail->parent('records');
    $trail->push('Record ' . $recordId, route('record', $recordId));
});

Breadcrumbs::for('settings', function ($trail) {
    $trail->parent('home');
    $trail->push('Settings', route('settings'));
});