<?php //-->
return [
    'disable' => '1',
    'singular' => 'Role',
    'plural' => 'Roles',
    'name' => 'role',
    'group' => 'Users',
    'icon' => 'fas fa-key',
    'detail' => 'By default, all users are locked out from accessing anything in the system. Roles gives users permission to access certain parts of the system based on URL rules.',
    'fields' => [
        [
            'disable' => '1',
            'label' => 'Name',
            'name' => 'name',
            'field' => [
                'type' => 'text',
                'attributes' => [
                    'placeholder' => 'ex. Guest'
                ]
            ],
            'validation' => [
                [
                    'method' => 'required',
                    'message' => 'Name is required'
                ]
            ],
            'list' => [
                'format' => 'none'
            ],
            'detail' => [
                'format' => 'none'
            ],
            'default' => '',
            'searchable' => '1'
        ],
        [
            'disable' => '1',
            'label' => 'Slug',
            'name' => 'slug',
            'field' => [
                'type' => 'slug',
                'attributes' => [
                    'data-source' => 'input[name="role_name"]',
                    'data-space' => '_',
                    'data-lower' => '1'
                ]
            ],
            'validation' => [
                [
                    'method' => 'required',
                    'message' => 'Slug is required'
                ],
                [
                    'method' => 'unique',
                    'message' => 'Should be unique'
                ]
            ],
            'list' => [
                'format' => 'none'
            ],
            'detail' => [
                'format' => 'none'
            ],
            'default' => '',
            'searchable' => '1'
        ],
        [
            'disable' => '1',
            'label' => 'Locked',
            'name' => 'locked',
            'field' => [
                'type' => 'switch'
            ],
            'validation' => [
                [
                    'method' => 'lte',
                    'parameters' => '1',
                    'message' => 'Should be either 0 or 1'
                ],
                [
                    'method' => 'gte',
                    'parameters' => '0',
                    'message' => 'Should be either 0 or 1'
                ]
            ],
            'list' => [
                'format' => 'yes'
            ],
            'detail' => [
                'format' => 'yes'
            ],
            'default' => '0',
            'filterable' => '1',
            'sortable' => '1'
        ],
        [
            'disable' => '1',
            'label' => 'Permissions',
            'name' => 'permissions',
            'field' => [
                'type' => 'rawjson'
            ],
            'list' => [
                'format' => 'hide'
            ],
            'detail' => [
                'format' => 'hide'
            ],
            'default' => ''
        ],
        [
            'disable' => '1',
            'label' => 'Admin Menu',
            'name' => 'admin_menu',
            'field' => [
                'type' => 'rawjson'
            ],
            'list' => [
                'format' => 'hide'
            ],
            'detail' => [
                'format' => 'hide'
            ],
            'default' => ''
        ],
        [
            'disable' => '1',
            'label' => 'Active',
            'name' => 'active',
            'field' => [
                'type' => 'active'
            ],
            'list' => [
                'format' => 'hide'
            ],
            'detail' => [
                'format' => 'hide'
            ],
            'default' => '1',
            'filterable' => '1',
            'sortable' => '1'
        ],
        [
            'disable' => '1',
            'label' => 'Created',
            'name' => 'created',
            'field' => [
                'type' => 'created'
            ],
            'list' => [
                'format' => 'none'
            ],
            'detail' => [
                'format' => 'none'
            ],
            'default' => 'NOW()',
            'sortable' => '1'
        ],
        [
            'disable' => '1',
            'label' => 'Updated',
            'name' => 'updated',
            'field' => [
                'type' => 'updated'
            ],
            'list' => [
                'format' => 'none'
            ],
            'detail' => [
                'format' => 'none'
            ],
            'default' => 'NOW()',
            'sortable' => '1'
        ]
    ],
    'suggestion' => '{{role_name}}',
    'fixtures' => [
        [
            'role_name' => 'Developer',
            'role_slug' => 'developer',
            'role_locked' => 1,
            'role_permissions' => json_encode([
                [
                    'path' => '**',
                    'label' => 'All Access',
                    'method' => 'all'
                ]
            ]),
            'role_admin_menu' => json_encode([
                [
                    'icon' => 'fas fa-tachometer-alt',
                    'path' => '/admin/dashboard',
                    'label' => 'Dashboard'
                ],
                [
                    'icon' => 'fas fa-coffee',
                    'path' => '#menu-admin',
                    'label' => 'Admin',
                    'children' => [
                        [
                            'icon' => 'fas fa-user',
                            'path' => '/admin/system/model/profile/search',
                            'label' => 'Profiles'
                        ],
                        [
                            'icon' => 'fas fa-lock',
                            'path' => '/admin/system/model/auth/search',
                            'label' => 'Auth'
                        ],
                        [
                            'icon' => 'fas fa-key',
                            'path' => '/admin/system/model/role/search',
                            'label' => 'Roles'
                        ]
                    ]
                ],
                [
                    'icon' => 'fas fa-server',
                    'path' => '#menu-system',
                    'label' => 'System',
                    'children' => [
                        [
                            'icon' => 'fas fa-database',
                            'path' => '/admin/system/schema/search',
                            'label' => 'Schemas'
                        ],
                        [
                            'icon' => 'fas fa-sliders-h',
                            'path' => '/admin/system/fieldset/search',
                            'label' => 'Fieldsets'
                        ],
                        [
                            'icon' => 'fas fa-cogs',
                            'path' => '/admin/configuration',
                            'label' => 'Configuration'
                        ],
                        [
                            'icon' => 'fas fa-plug',
                            'path' => '/admin/package/search',
                            'label' => 'Packages'
                        ]
                    ]
                ],
                [
                    'icon' => 'fas fa-columns',
                    'path' => '#menu-templates',
                    'label' => 'Templates',
                    'children' => [
                        [
                            'icon' => 'fas fa-puzzle-piece',
                            'path' => '/admin/template/ui',
                            'label' => 'UI'
                        ],
                        [
                            'icon' => 'fas fa-search',
                            'path' => '/admin/template/search',
                            'label' => 'Search'
                        ],
                        [
                            'icon' => 'fas fa-sliders-h',
                            'path' => '/admin/template/form',
                            'label' => 'Form'
                        ]
                    ]
                ]
            ]),
            'role_active' => 1,
            'role_created' => date('Y-m-d H:i:s'),
            'role_updated' => date('Y-m-d H:i:s')
        ],
        [
            'role_name' => 'Admin',
            'role_slug' => 'admin',
            'role_locked' => 1,
            'role_permissions' => json_encode([
                [
                    'path' => '/admin',
                    'label' => 'Admin Dashboard',
                    'method' => 'all'
                ],
                [
                    'path' => '/admin/**',
                    'label' => 'All Admin Access',
                    'method' => 'all'
                ],
                [
                    'path' => '(?!/(admin))/**',
                    'label' => 'All Front End Access',
                    'method' => 'all'
                ]
            ]),
            'role_admin_menu' => json_encode([
                [
                    'icon' => 'fas fa-tachometer-alt',
                    'path' => '/admin/dashboard',
                    'label' => 'Dashboard'
                ],
                [
                    'icon' => 'fas fa-coffee',
                    'path' => '#menu-admin',
                    'label' => 'Admin',
                    'children' => [
                        [
                            'icon' => 'fas fa-user',
                            'path' => '/admin/system/model/profile/search',
                            'label' => 'Profiles'
                        ],
                        [
                            'icon' => 'fas fa-lock',
                            'path' => '/admin/system/model/auth/search',
                            'label' => 'Auth'
                        ],
                        [
                            'icon' => 'fas fa-key',
                            'path' => '/admin/system/model/role/search',
                            'label' => 'Roles'
                        ]
                    ]
                ]
            ]),
            'role_active' => 1,
            'role_created' => date('Y-m-d H:i:s'),
            'role_updated' => date('Y-m-d H:i:s')
        ],
        [
            'role_name' => 'Guest',
            'role_slug' => 'guest',
            'role_locked' => 1,
            'role_permissions' => json_encode([
                [
                    'path' => '(?!/(admin))/**',
                    'label' => 'All Front End Access',
                    'method' => 'all'
                ]
            ]),
            'role_admin_menu' => json_encode([]),
            'role_active' => 1,
            'role_created' => date('Y-m-d H:i:s'),
            'role_updated' => date('Y-m-d H:i:s')
        ]
    ]
];
