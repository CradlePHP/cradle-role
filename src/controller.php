<?php //-->
/**
 * This file is part of a package designed for the CradlePHP Project.
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Renders a create form
 *
 * @param Request $request
 * @param Response $response
 */
$this->get('/admin/system/model/role/create', function ($request, $response) {
    //we want to change the links up to use the role routes
    if (!$response->hasPage('template_root')) {
        $response->setPage('template_root', __DIR__ . '/template');
    }

    if (!$response->hasPage('partials_root')) {
        $response->setPage('partials_root', __DIR__ . '/template');
    }
    //lets also add custom partials

    $this
        ->package('global')
        ->handlebars()
        ->registerPartial(
            'form_permissions',
            file_get_contents(__DIR__ . '/template/form/_permissions.html')
        )
        ->registerPartial(
            'form_admin_menu',
            file_get_contents(__DIR__ . '/template/form/_admin_menu.html')
        )
        ->registerPartial(
            'form_menu_item',
            file_get_contents(__DIR__ . '/template/form/menu/_item.html')
        )
        ->registerPartial(
            'form_menu_input',
            file_get_contents(__DIR__ . '/template/form/menu/_input.html')
        );
}, 10);

/**
 * Renders a create form
 *
 * @param Request $request
 * @param Response $response
 */
$this->get('/admin/system/model/role/search', function ($request, $response) {
    if (!$response->hasPage('partials_root')) {
        $response->setPage('partials_root', __DIR__ . '/template');
    }
}, 10);

/**
 * Renders an update form
 *
 * @param Request $request
 * @param Response $response
 */
$this->get('/admin/system/model/role/update/:role_id', function ($request, $response) {
    //we want to change the links up to use the role routes
    if (!$response->hasPage('template_root')) {
        $response->setPage('template_root', __DIR__ . '/template');
    }

    if (!$response->hasPage('partials_root')) {
        $response->setPage('partials_root', __DIR__ . '/template');
    }

    $this
        ->package('global')
        ->handlebars()
        ->registerPartial(
            'form_permissions',
            file_get_contents(__DIR__ . '/template/form/_permissions.html')
        )
        ->registerPartial(
            'form_admin_menu',
            file_get_contents(__DIR__ . '/template/form/_admin_menu.html')
        )
        ->registerPartial(
            'form_menu_item',
            file_get_contents(__DIR__ . '/template/form/menu/_item.html')
        )
        ->registerPartial(
            'form_menu_input',
            file_get_contents(__DIR__ . '/template/form/menu/_input.html')
        );
}, 10);

/**
 * Processes a create form
 *
 * @param Request $request
 * @param Response $response
 */
$this->post('/admin/system/model/role/create', function ($request, $response) {
    //flatten the JSON fields
    $permissions = $request->getStage('role_permissions');
    $adminMenu = $request->getStage('role_admin_menu');

    $request->setStage(
        'role_permissions',
        json_encode($permissions, JSON_PRETTY_PRINT)
    );

    $request->setStage(
        'role_admin_menu',
        json_encode($adminMenu, JSON_PRETTY_PRINT)
    );
}, 10);

/**
 * Processes an update form
 *
 * @param Request $request
 * @param Response $response
 */
$this->post('/admin/system/model/role/update/:role_id', function ($request, $response) {
    //flatten the JSON fields
    $permissions = $request->getStage('role_permissions');
    $adminMenu = $request->getStage('role_admin_menu');

    $request->setStage(
        'role_permissions',
        json_encode($permissions, JSON_PRETTY_PRINT)
    );

    $request->setStage(
        'role_admin_menu',
        json_encode($adminMenu, JSON_PRETTY_PRINT)
    );
}, 10);
