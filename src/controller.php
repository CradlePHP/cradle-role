<?php //-->
/**
 * This file is part of a Custom Package.
 */

// Back End Controllers

/**
 * Renders a create form
 *
 * @param Request $request
 * @param Response $response
 */
$this->get('/admin/role/create', function ($request, $response) {
    //----------------------------//
    //set redirect
    $request->setStage('redirect_uri', '/admin/role/search');

    //now let the object create take over
    $this->routeTo(
        'get',
        '/admin/system/model/role/create',
        $request,
        $response
    );
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
    //set redirect
    $request->setStage('redirect_uri', '/admin/role/search');

    //now let the object remove take over
    $this->routeTo(
        'get',
        sprintf(
            '/admin/system/model/role/remove/%s',
            $request->getStage('role_id')
        ),
        $request,
        $response
    );
});

/**
 * Restores a role
 *
 * @param Request $request
 * @param Response $response
 */
$this->get('/admin/role/restore/:role_id', function ($request, $response) {
    //----------------------------//
    //set redirect
    $request->setStage('redirect_uri', '/admin/role/search');

    //now let the object restore take over
    $this->routeTo(
        'get',
        sprintf(
            '/admin/system/model/role/restore/%s',
            $request->getStage('role_id')
        ),
        $request,
        $response
    );
});

/**
 * Renders a search page
 *
 * @param Request $request
 * @param Response $response
 */
$this->get('/admin/role/search', function ($request, $response) {
    //----------------------------//
    //set redirect
    $request->setStage('redirect_uri', '/admin/role/search');

    //now let the object search take over
    $this->routeTo(
        'get',
        '/admin/system/model/role/search',
        $request,
        $response
    );
});

/**
 * Renders an update form
 *
 * @param Request $request
 * @param Response $response
 */
$this->get('/admin/role/update/:role_id', function ($request, $response) {
    //----------------------------//
    //set redirect
    $request->setStage('redirect_uri', '/admin/role/search');

    //now let the object update take over
    $this->routeTo(
        'get',
        sprintf(
            '/admin/system/model/role/update/%s',
            $request->getStage('role_id')
        ),
        $request,
        $response
    );
});

/**
 * Processes a create form
 *
 * @param Request $request
 * @param Response $response
 */
$this->post('/admin/role/create', function ($request, $response) {
    //----------------------------//
    //set redirect
    $request->setStage('redirect_uri', '/admin/role/search');

    //now let the object post create take over
    $this->routeTo(
        'post',
        '/admin/system/model/role/create',
        $request,
        $response
    );
});

/**
 * Processes an update form
 *
 * @param Request $request
 * @param Response $response
 */
$this->post('/admin/role/update/:role_id', function ($request, $response) {
    //----------------------------//
    //set redirect
    $request->setStage('redirect_uri', '/admin/role/search');

    //now let the object post update take over
    $this->routeTo(
        'post',
        sprintf(
            '/admin/system/model/role/update/%s',
            $request->getStage('role_id')
        ),
        $request,
        $response
    );
});
// Front End Controllers
