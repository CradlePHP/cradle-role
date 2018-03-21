<?php //-->
/**
 * This file is part of a Custom Package.
 */

/**
 * Creates a role
 *
 * @param Request $request
 * @param Response $response
 */
$this->on('role-create', function ($request, $response) {
    //set role as schema
    $request->setStage('schema', 'role');

    //trigger model create
    $this->trigger('system-model-create', $request, $response);
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

    //trigger model update
    $this->trigger('system-model-update', $request, $response);
});
