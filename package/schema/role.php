<?php //-->
return [
    'disable' => '1',
    'singular' => 'Role',
    'plural' => 'Roles',
    'name' => 'auth',
    'icon' => 'fas fa-key',
    'detail' => 'An approach to restricting system access to authorized users',
    'fields' => [
        [
            'disable' => '1',
            'label' => 'Name',
            'name' => 'name',
            'field' => [
                'type' => 'text',
            ],
            'validation' => [
                [
                    'method' => 'required',
                    'message' => 'Name is Required'
                ],
                [
                    'method' => 'empty',
                    'message' => 'Cannot be empty'
                ]
            ],
            'list' => [
                'format' => 'none',
            ],
            'detail' => [
                'format' => 'none',
            ],
            'default' => '',
            'searchable' => '1',
            'filterable' => '1'
        ],
        [
            'disable' => '1',
            'label' => 'Permissions',
            'name' => 'permissions',
            'field' => [
                'type' => 'json',
            ],
            'validation' => [
                [
                    'method' => 'required',
                    'message' => 'Permissions is Required'
                ],
                [
                    'method' => 'empty',
                    'message' => 'Cannot be empty'
                ]
            ],
            'list' => [
                'format' => 'hide',
            ],
            'detail' => [
                'format' => 'hide',
            ],
            'default' => '',
        ],
        [
            'disable' => '1',
            'label' => 'Flag',
            'name' => 'flag',
            'field' => [
                'type' => 'int',
            ],
            'list' => [
                'format' => 'hide',
            ],
            'detail' => [
                'format' => 'hide',
            ],
            'default' => '1',
            'filterable' => '1',
            'sortable' => '1'
        ],
        [
            'disable' => '1',
            'label' => 'Type',
            'name' => 'type',
            'field' => [
                'type' => 'text',
            ],
            'list' => [
                'format' => 'hide',
            ],
            'detail' => [
                'format' => 'hide',
            ],
            'default' => '',
            'filterable' => '1',
            'sortable' => '1'
        ],
        [
            'disable' => '1',
            'label' => 'Active',
            'name' => 'active',
            'field' => [
                'type' => 'active',
            ],
            'list' => [
                'format' => 'hide',
            ],
            'detail' => [
                'format' => 'hide',
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
                'type' => 'created',
            ],
            'list' => [
                'format' => 'none',
            ],
            'detail' => [
                'format' => 'none',
            ],
            'default' => 'NOW()',
            'sortable' => '1'
        ],
        [
            'disable' => '1',
            'label' => 'Updated',
            'name' => 'updated',
            'field' => [
                'type' => 'updated',
            ],
            'list' => [
                'format' => 'none',
            ],
            'detail' => [
                'format' => 'none',
            ],
            'default' => 'NOW()',
            'sortable' => '1'
        ]
    ],
    'relations' => [
        [
            'many' => '1',
            'name' => 'auth'
        ]
    ],
    'fixtures' => [
        [
            'role_name'         => 'Guest',
            'role_permissions'  => json_encode([
                [
                    "path": "(?!/admin)/**",
                    "label": "Guest",
                    "method": "all"
                ],
                [
                    "path": "/rest/**",
                    "label": "Rest",
                    "method": "all"
                ]
            ]),
            'role_flag'         => 1
        ]
    ],
    'suggestion' => '{{role_name}}'
];
