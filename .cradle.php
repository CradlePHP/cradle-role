<?php //-->
/**
 * This file is part of a package designed for the CradlePHP Project.
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */
require_once __DIR__ . '/package/events.php';
require_once __DIR__ . '/package/helpers.php';
require_once __DIR__ . '/src/events.php';
require_once __DIR__ . '/src/controller.php';

//bootstrap
$this
    ->preprocess(include __DIR__ . '/src/bootstrap/errors.php')
    ->preprocess(include __DIR__ . '/src/bootstrap/permitted.php')
    ->preprocess(include __DIR__ . '/src/bootstrap/session.php');

//lister for role create/update
$this->addLogger(function(
    $message,
    $request = null,
    $response = null,
    $type = null,
    $table = null,
    $id = null
) {
    //ignore cli
    if (php_sapi_name() === 'cli') {
        return;
    }

    //not role?
    if ($table !== 'role') {
        return;
    }

    //if not create or update
    if ($type !== 'create' && $type !== 'update') {
        return;
    }

    //get current session
    $session = $request->getSession('role');

    //skip if current role is not updated
    if ($session['role_id'] !== $id) {
        return;
    }

    //get results
    $results = $response->getResults();
    $session['role_admin_menu'] = $results['role_admin_menu'];

    //update session
    $request->setSession('role', $session);
});
