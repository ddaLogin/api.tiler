<?php

Breadcrumbs::register('admin.index', function ($breadcrumbs) {
    $breadcrumbs->push('Admin', route('admin.index'));
});

Breadcrumbs::register('admin.users.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.index');
    $breadcrumbs->push('Users', route('admin.users.index'));
});

Breadcrumbs::register('admin.categories.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.index');
    $breadcrumbs->push('Categories', route('admin.categories.index'));
});

Breadcrumbs::register('admin.categories.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.categories.index');
    $breadcrumbs->push('New category', route('admin.categories.create'));
});

Breadcrumbs::register('admin.categories.edit', function ($breadcrumbs, $category) {
    $breadcrumbs->parent('admin.categories.index');
    $breadcrumbs->push($category->name, route('admin.categories.edit', $category->id));
});