<?php //-->
/**
 * This file is part of a Custom Package.
 */
use Cradle\Package\System\Schema;
use Cradle\Package\Role\Validator as RoleValidator;

/**
 * Creates a role
 *
 * @param Request $request
 * @param Response $response
 */
$this->on('role-create', function ($request, $response) {
    //----------------------------//
    // 1. Get Data
    $data = [];
    if($request->hasStage()) {
        $data = $request->getStage();
    }

    //set role as schema
    $request->setStage('schema', 'role');

    if (isset($data['role_permissions'])) {
        $request->setStage('role_permissions', json_encode($data['role_permissions']));
    }

    //trigger model create
    $this->trigger('system-model-create', $request, $response);
});

/**
 * Searches access
 *
 * @param Request $request
 * @param Response $response
 */
$this->on('access-search', function ($request, $response) {
    //----------------------------//
    // 1. Get Data
    $data = [];
    if($request->hasStage()) {
        $data = $request->getStage();
    }

    $range = 50;
    $start = 0;

    if (isset($data['range']) && is_numeric($data['range'])) {
        $range = $data['range'];
    }

    if (isset($data['start']) && is_numeric($data['start'])) {
        $start = $data['start'];
    }

    $schema = Schema::i('role');

    $search = $schema->model()->service('sql')->getResource()
        ->search($schema->getName())
        ->setStart($start)
        ->setRange($range)
        ->innerJoinUsing('role_auth', 'role_id')
        ->innerJoinUsing('auth', 'auth_id');

    $results = [
        'rows' => $search->getRows(),
        'total' => $search->getTotal()
    ];

    //set response format
    $response->setError(false)->setResults($results);
});

/**
 * Create access
 *
 * @param Request $request
 * @param Response $response
 */
$this->on('access-link', function ($request, $response) {
    //----------------------------//
    // 1. Get Data
    $data = [];
    if ($request->hasStage()) {
        $data = $request->getStage();
    }

    //----------------------------//
    // 2. Validate Data
    $errors = RoleValidator::getAccessErrors($data);

    //if there are errors
    if (!empty($errors)) {
        return $response
            ->setError(true, 'Invalid Parameters')
            ->set('json', 'validation', $errors);
    }

    $data = $data['role'];

    //----------------------------//
    // 3. Process Data
    $schema = Schema::i('role');

    $results = $schema->model()->service('sql')->getResource()
        ->model()
        ->setRoleId($data['role_id'])
        ->setAuthId($data['auth_id'])
        ->insert('role_auth');

    //return response format
    $response->setError(false)->setResults($results);
});

/**
 * Remove access
 *
 * @param Request $request
 * @param Response $response
 */
$this->on('access-unlink', function ($request, $response) {
    //----------------------------//
    // 1. Get Data
    $data = [];
    if ($request->hasStage()) {
        $data = $request->getStage();
    }

    //----------------------------//
    // 2. Process Data
    $schema = Schema::i('role');

    $results = $schema->model()->service('sql')->getResource()
        ->model()
        ->setRoleId($data['role_id'])
        ->setAuthId($data['role_auth_id'])
        ->remove('role_auth');

    //return response format
    $response->setError(false)->setResults($results);
});

/**
 * Creates a role
 *
 * @param Request $request
 * @param Response $response
 */
$this->on('role-detail', function ($request, $response) {
    //set role as schema
    $request->setStage('schema', 'role');

    //trigger model detail
    $this->trigger('system-model-detail', $request, $response);
});

/**
 * Removes a role
 *
 * @param Request $request
 * @param Response $response
 */
$this->on('role-remove', function ($request, $response) {
    //set role as schema
    $request->setStage('schema', 'role');

    //trigger model remove
    $this->trigger('system-model-remove', $request, $response);
});

/**
 * Restores a role
 *
 * @param Request $request
 * @param Response $response
 */
$this->on('role-restore', function ($request, $response) {
    //set role as schema
    $request->setStage('schema', 'role');

    //trigger model restore
    $this->trigger('system-model-restore', $request, $response);
});

/**
 * Searches role
 *
 * @param Request $request
 * @param Response $response
 */
$this->on('role-search', function ($request, $response) {
    //set role as schema
    $request->setStage('schema', 'role');

    //trigger model search
    $this->trigger('system-model-search', $request, $response);
});

/**
 * Updates a role
 *
 * @param Request $request
 * @param Response $response
 */
$this->on('role-update', function ($request, $response) {
    //set role as schema
    $request->setStage('schema', 'role');
    
    $data = $request->getStage();

    if (isset($data['role_permissions']) && is_array($data['role_permissions'])) {
        $request->setStage('role_permissions', json_encode($data['role_permissions']));
    }

    //trigger model update
    $this->trigger('system-model-update', $request, $response);
});


/**
 * Auth Detail Job
 *
 * @param Request $request
 * @param Response $response
 */
$cradle->on('auth-detail', function ($request, $response) {
    //if the auth-detail from auth returned an error
    //----------------------------//
    // 1. Check Error
    if ($response->isError()) {
        //do nothing
        return;
    }

    //----------------------------//
    // 2. Get Response Data
    $data = $response->getResults();

    // set schema
    $schema = Schema::i('auth');

    // get role
    // filter by auth id
    $search = $schema->model()->service('sql')->getResource()
        ->search($schema->getName())
        ->leftJoinUsing('role_auth', 'auth_id')
        ->leftJoinUsing('role', 'role_id')
        ->addFilter('auth_id = %s', $data['auth_id']);

    $row = $search->getRow();

    // prepare data
    if ($row['role_permissions']) {
        $row['role_permissions'] = json_decode($row['role_permissions'], true);
    } else {
        // set default permissions
        $row['role_permissions'][] = [
            'path'      => '(?!/admin)/**',
            'label'     => 'Guest Access',
            'method'    => 'all'
        ];
    }

    // merge results
    $results = array_merge($data, $row);

    // set response results
    $response->setResults($results);
});
