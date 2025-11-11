<?php

use Illuminate\Support\Facades\Route;

Route::get('/debug-packages', function () {
    $packages = collect(\Composer\InstalledVersions::getAllRawData())
        ->map(function($package) {
            return $package['name'] ?? 'unknown';
        });
    return response()->json($packages);
});
