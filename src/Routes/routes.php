<?php

Route::get(
    'metrics',
    \Triadev\PrometheusExporter\Controller\LaravelController::class . '@metrics'
)->name('metrics');
