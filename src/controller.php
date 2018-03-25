<?php //-->
/**
 * This file is part of a Custom Package.
 */

/**
 * Renders a create form
 *
 * @param Request $request
 * @param Response $response
 */
$this->get('/admin/role/create', function ($request, $response) {
    //----------------------------//
    // 1. Prepare Data
    $data = ['item' => $request->getPost()];

    // if has copy
    if ($request->hasStage('copy')) {
        $request->setStage('role_id', $request->getStage('copy'));

        // get role detail
        cradle()->trigger('role-detail', $request, $response);

        $data['item'] = [
            'role_permissions' => $response->getResults('role_permissions')
        ];
    }

    if ($response->isError()) {
        $response->setFlash($response->getMessage(), 'error');
        $data['errors'] = $response->getValidation();
    }

    //----------------------------//
    // 2. Render Template
    //Render body
    $class = 'page-role-create';
    $data['title'] = $this->package('global')->translate('Role Create');

    $body = $this
        ->package('cradlephp/cradle-role')
        ->template('role/form', $data, [
            'role_permission'
        ]);

    //Set Content
    $response
        ->setPage('title', $data['title'])
        ->setPage('class', $class)
        ->setContent($body);

    //if we only want the body
    if ($request->getStage('render') === 'body') {
        return;
    }

    //Render blank page
    $this->trigger('admin-render-page', $request, $response);
});

/**
 * Renders a create form
 *
 * @param Request $request
 * @param Response $response
 */
$this->get('/admin/role/detail/:role_id', function ($request, $response) {
    //----------------------------//
    //set redirect
    $request->setStage('redirect_uri', '/admin/role/search');

    //now let the object detail take over
    $this->routeTo(
        'get',
        sprintf(
            '/admin/system/model/role/detail/%s',
            $request->getStage('role_id')
        ),
        $request,
        $response
    );
});

/**
 * Removes a role
 *
 * @param Request $request
 * @param Response $response
 */
$this->get('/admin/role/remove/:role_id', function ($request, $response) {
    //----------------------------//
    // 2. Prepare Data
    // trigger role detail
    $this->trigger('role-detail', $request, $response);

    // get role details
    $data['item'] = $response->getResults();

    // not removable
    if ($data['item']['role_flag'] == 1) {
        //add a flash
        $this->package('global')->flash('Invalid Action', 'error');
        //redirect
        return $this->package('global')->redirect('/admin/role/search');
    }

    //----------------------------//
    // 3. Process Request
    $this->trigger('role-remove', $request, $response);

    //----------------------------//
    // 4. Interpret Results
    if ($response->isError()) {
        //add a flash
        $this->package('global')->flash($response->getMessage(), 'error');
    } else {
        //add a flash
        $message = cradle('global')->translate('Role was Removed');
        $this->package('global')->flash($message, 'success');
    }

    $this->package('global')->redirect('/admin/role/search');
});

/**
 * Restores a role
 *
 * @param Request $request
 * @param Response $response
 */
$this->get('/admin/role/restore/:role_id', function ($request, $response) {
    // 1. Process Request
    $this->trigger('role-restore', $request, $response);

    //----------------------------//
    // 2. Interpret Results
    if ($response->isError()) {
        //add a flash
        $this->trigger('global')->flash($response->getMessage(), 'error');
    } else {
        //add a flash
        $message = cradle('global')->translate('Role was Restored');
        $this->package('global')->flash($message, 'success');
    }

    $this->package('global')->redirect('/admin/role/search');
});

/**
 * Renders a search page
 *
 * @param Request $request
 * @param Response $response
 */
$this->get('/admin/role/search', function ($request, $response) {
    //----------------------------//
    // 1. Prepare data
    if (!$request->hasStage('filter')) {
        $request->setStage('filter', 'role_active', 1);
    }

    //trigger job
    $this->trigger('role-search', $request, $response);

    //if we only want the raw data
    if ($request->getStage('render') === 'false') {
        return;
    }

    $data = array_merge($request->getStage(), $response->getResults());

    //----------------------------//
    // 2. Render Template
    //Render body
    $class = 'page-role-search';
    $title = $this->package('global')->translate('Role Search');

    $body = $this
        ->package('cradlephp/cradle-role')
        ->template('role/search', $data);

    //Set Content
    $response
        ->setPage('title', $title)
        ->setPage('class', $class)
        ->setContent($body);

    //if we only want the body
    if ($request->getStage('render') === 'body') {
        return;
    }

    //Render blank page
    $this->trigger('admin-render-page', $request, $response);
});

/**
 * Renders an update form
 *
 * @param Request $request
 * @param Response $response
 */
$this->get('/admin/role/update/:role_id', function ($request, $response) {
    // 1. Prepare Data
    // trigger role detail
    cradle()->trigger('role-detail', $request, $response);

    // get role details
    $data['item'] = $response->getResults();

    if (!empty($request->getPost())) {
        // get post stored as item
        $data['item'] = $request->getPost();

        // get any errors
        $data['errors'] = $response->getValidation();
    }

    //----------------------------//
    // 2. Render Template
    //Render body
    $class = 'page-role-update';
    $data['title'] = $this->package('global')->translate('Role Update');

    $body = $this
        ->package('cradlephp/cradle-role')
        ->template('role/form', $data, [
            'role_permission'
        ]);

    //Set Content
    $response
        ->setPage('title', $data['title'])
        ->setPage('class', $class)
        ->setContent($body);

    //if we only want the body
    if ($request->getStage('render') === 'body') {
        return;
    }

    //Render blank page
    $this->trigger('admin-render-page', $request, $response);
});

/**
 * Processes a create form
 *
 * @param Request $request
 * @param Response $response
 */
$this->post('/admin/role/create', function ($request, $response) {
    //----------------------------//
    // 1. Prepare Data
    $data = $request->getStage();

    //----------------------------//
    // 2. Process Request
    $this->trigger('role-create', $request, $response);

    //----------------------------//
    // 4. Interpret Results
    if ($response->isError()) {
        //add a flash
        $this->package('global')->flash('Invalid Data', 'error');
        return $this->routeTo('get', '/admin/role/create', $request, $response);
    }

    //it was good
    //add a flash
    $this->package('global')->flash('Role was Created', 'success');

    //redirect
    $this->package('global')->redirect('/admin/role/search');
});

/**
 * Processes an update form
 *
 * @param Request $request
 * @param Response $response
 */
$this->post('/admin/role/update/:role_id', function ($request, $response) {
    //----------------------------//
    // 1. Process Request
    cradle()->trigger('role-update', $request, $response);

    //----------------------------//
    // 2. Interpret Results
    if ($response->isError()) {
        $route = '/admin/role/update/' . $request->getStage('role_id');
        return $this->routeTo('get', $route, $request, $response);
    }

    //it was good
    //add a flash
    $this->package('global')->flash('Role was Updated', 'success');

    //redirect
    $this->package('global')->redirect('/admin/role/search');
});

/**
 * Render the Access Search
 *
 * @param Request $request
 * @param Response $response
 */
$cradle->get('/admin/access/search', function ($request, $response) {
    //----------------------------//
    // 1. Prepare Data
    $data = $request->getStage();

    //----------------------------//
    // 2. Process Request
    $this->trigger('access-search', $request, $response);

    $data = $response->getResults();

    //----------------------------//
    // 3. Render Template
    //Render body
    $class = 'page-access-search';
    $data['title'] = $this->package('global')->translate('Access');

    $body = $this
        ->package('cradlephp/cradle-role')
        ->template('access/search', $data);

    //Set Content
    $response
        ->setPage('title', $data['title'])
        ->setPage('class', $class)
        ->setContent($body);

    //if we only want the body
    if ($request->getStage('render') === 'body') {
        return;
    }

    //Render admin page
    $this->trigger('admin-render-page', $request, $response);
});

/**
 * Render the Access Create
 *
 * @param Request $request
 * @param Response $response
 */
$cradle->get('/admin/access/create', function ($request, $response) {
    // 1. Prepare Data
    // trigger role detail
    $data = ['item' => $request->getPost()];

    if ($response->isError()) {
        $response->setFlash($response->getMessage(), 'error');
        $data['errors'] = $response->getValidation();
    }

    //----------------------------//
    // 2. Render Template
    //Render body
    $class = 'page-access-create';
    $data['title'] = $this->package('global')->translate('Access Create');

    $body = $this
        ->package('cradlephp/cradle-role')
        ->template('access/form', $data);

    //Set Content
    $response
        ->setPage('title', $data['title'])
        ->setPage('class', $class)
        ->setContent($body);

    //if we only want the body
    if ($request->getStage('render') === 'body') {
        return;
    }

    //Render admin page
    $this->trigger('admin-render-page', $request, $response);
});

/**
 * Process the Access Create
 *
 * @param Request $request
 * @param Response $response
 */
$cradle->post('/admin/access/create', function ($request, $response) {
    //----------------------------//
    // 1. Process Request
    cradle()->trigger('access-link', $request, $response);

    //----------------------------//
    // 2. Interpret Results
    if ($response->isError()) {
        $route = '/admin/access/create';
        return $this->routeTo('get', $route, $request, $response);
    }

    //it was good
    //add a flash
    $this->package('global')->flash('Access was Created', 'success');

    //redirect
    $this->package('global')->redirect('/admin/access/search');
});

/**
 * Process the Access Remove
 *
 * @param Request $request
 * @param Response $response
 */
$cradle->get('/admin/access/:role_id/:role_auth_id/remove', function ($request, $response) {
    //----------------------------//
    // 1. Prepare Data
    $data = $request->getStage();

    cradle()->trigger('access-unlink', $request, $response);

    //----------------------------//
    // 4. Interpret Results
    if ($response->isError()) {
        return cradle()->triggerRoute('get', '/admin/access/search', $request, $response);
    }

    //it was good
    //add a flash
    cradle('global')->flash('Access was Removed', 'success');

    //redirect
    cradle('global')->redirect('/admin/access/search');
});
