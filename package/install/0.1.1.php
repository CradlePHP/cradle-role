<?php //-->

cradle(function() {
    $source = dirname(__DIR__) . '/admin/src';
    $destination = $this->package('global')->path('root')  . '/app/admin/src';

    //typo on release
    if (file_exists($destination . '/template/_side.php')) {
        unlink($destination . '/template/_side.php');
    }

    copy(
        $source . '/template/_side.html',
        $destination . '/template/_side.html'
    );

    //setup result counters
    $errors = [];
    $processed = [];

    //scan through each file
    foreach (scandir(__DIR__ . '/../schema') as $file) {
        //if it's not a php file
        if (substr($file, -4) !== '.php') {
            //skip
            continue;
        }

        //get the schema data
        $data = include sprintf('%s/../schema/%s', __DIR__, $file);

        //if no name
        if (!isset($data['name'])) {
            //skip
            continue;
        }

        //NOTE: Special way to redo the entire package setup
        //in this version there are major database changes
        //setup a new RnR
        $payload = $this->makePayload();

        //set the data
        $payload['request']->setStage('schema', $data['name']);
        //this will permanently remove the file and table
        $payload['request']->setStage('mode', 'permanent');

        //remove the schema
        $this->trigger(
            'system-schema-remove',
            $payload['request'],
            $payload['response']
        );

        //setup a new RnR
        $payload = $this->makePayload();

        //set the data
        $payload['request']->setStage($data);

        sleep(5);

        //----------------------------//
        // 1. Prepare Data
        //if detail has no value make it null
        if ($payload['request']->hasStage('detail')
            && !$payload['request']->getStage('detail')
        ) {
            $payload['request']->setStage('detail', null);
        }

        //if fields has no value make it an array
        if ($payload['request']->hasStage('fields')
            && !$payload['request']->getStage('fields')
        ) {
            $payload['request']->setStage('fields', []);
        }

        //if validation has no value make it an array
        if ($payload['request']->hasStage('validation')
            && !$payload['request']->getStage('validation')
        ) {
            $payload['request']->setStage('validation', []);
        }

        //----------------------------//
        // 2. Process Request
        //now trigger
        $this->trigger(
            'system-schema-create',
            $payload['request'],
            $payload['response']
        );

        //----------------------------//
        // 3. Interpret Results
        //if the event returned an error
        if ($payload['response']->isError()) {
            //collect all the errors
            $errors[$data['name']] = $payload['response']->getValidation();
            continue;
        }

        $processed[] = $data['name'];
    }

    if (!empty($errors)) {
        $this->getResponse()->set('json', 'validation', $errors);
    }

    $this->getResponse()->setResults('schemas', $processed);
});
