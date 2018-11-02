<?php //-->
/**
 * This file is part of a package designed for the CradlePHP Project.
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

use Cradle\Package\System\Schema\Service;

/**
 * Render admin page
 *
 * @param Request $request
 * @param Response $response
 */
$this->on('admin-render-page', function ($request, $response) {
    $menu = $request->getSession('role', 'role_admin_menu');

    $this->package('global')
        ->handlebars()
        ->registerHelper('nav_match', function (...$args) use ($request) {
            //$haystack, $needle, $options
            $haystack = $request->get('path', 'string');
            $needle = array_shift($args);
            $options = array_pop($args);

            foreach ($args as $path) {
                $needle .= '/' . $path;
            }

            if (strpos($needle, '?') > 0) {
                $needle = substr($needle, 0, strpos($needle, '?'));
            }

            if (strpos($haystack, $needle) === 0) {
                return $options['fn']();
            }

            return $options['inverse']();
        });

    // get the schema name
    $schema = $this
        ->package('global')
        ->config('services', 'sql-main')['name'];

    // get table record count
    $records = Service::get('sql')->getSchemaTableRecordCount($schema);

    // map menu
    $map = function($menu, $records) use (&$map) {
        // iterate on each navigation
        foreach ($menu as $i => $item) {
            // do we have child menu?
            if (isset($item['children']) && is_array($item['children'])) {
                // recurse through child menu
                $menu[$i]['children'] = $map($item['children'], $records);
            }

            // iterate on each record count
            foreach ($records as $count) {
                // build out the criteria
                $criteria = sprintf('/%s/search', $count['table_name']);

                // check the path based on criteria
                if (strpos($item['path'], $criteria) > 0) {
                    // set the record count
                    $menu[$i]['records'] = $count['table_rows'];
                }
            }
        }

        return $menu;
    };

    // map through navigation and set record count
    $data['menu'] = $map($menu, $records);

    $content = $this->package('cradlephp/cradle-system')->template(
        '_menu',
        $data,
        'menu_item',
        __DIR__ . '/template',
        __DIR__ . '/template'
    );

    $response->setPage('aside', 'role_menu', $content);
});
