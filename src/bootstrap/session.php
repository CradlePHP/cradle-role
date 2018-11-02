<?php //-->
/**
 * This file is part of a package designed for the CradlePHP Project.
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

return function ($request, $response) {
    //prevent session in cli mode
    if (php_sapi_name() === 'cli') {
        return;
    }

    $loggedin = $request->hasSession('me');
    //if there's already a role
    if ($request->hasSession('role')) {
        //if logged in
        if ($loggedin) {
            //compare the logged in role with the role assigned
            //we do this instead of listening for login or logout
            $test1 = $request->getSession('role', 'role_slug');
            $test2 = $request->getSession('me', 'role', 'role_slug');
            //if they are the same then we good
            if ($test1 === $test2) {
                //pass
                return;
            }
        //they logged out, so if role assigned is guest, then we good
        } else if ($request->getSession('role', 'role_slug') === 'guest'){
            //pass
            return;
        }
    }

    //so at this point either
    // - the logged in role and the role assigned are not the same
    // - or they are logged out and the role isnt a guest

    //by default role is guest
    $slug = 'guest';
    //if there is an auth type
    if ($request->getSession('me', 'auth_type')) {
        $slug = $request->getSession('me', 'auth_type');
    }

    //look up the role
    $payload = $this->makePayload();

    $payload['request']
        ->setStage('schema', 'role')
        ->setStage('role_slug', $slug);

    $this->trigger(
        'system-model-detail',
        $payload['request'],
        $payload['response']
    );

    $role = $payload['response']->getResults();

    //if no role found
    if (empty($role)) {
        //do it again with guest this time
        $payload['request']
            ->setStage('schema', 'role')
            ->setStage('role_slug', 'guest');

        $this->trigger(
            'system-model-detail',
            $payload['request'],
            $payload['response']
        );

        //this should be guaranteed we have a result now
        $role = $payload['response']->getResults();
    }

    //assign the role
    $request->setSession('role', $role);

    //if logged in
    if ($loggedin) {
        //add role to the login data
        $request->setSession('me', 'role', $role);
    }
};
