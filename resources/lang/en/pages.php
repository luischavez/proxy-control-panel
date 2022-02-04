<?php

return [
    'go_back' => 'Go back',

    'create'    => 'Create',
    'new'       => 'New',

    'creating'  => 'Creating new entry',
    'editing'   => 'Editing: :model',

    'cancel'    => 'Cancel',
    'save'      => 'Save',

    'confirm_dialog' => [
        'delete_title'      => 'Are you sure?',
        'delete_message'    => 'Please confirm if you want to delete :name record',

        'no'    => 'No',
        'yes'   => 'Yes',
    ],

    'success' => [
        'generated_title'   => 'Configuration generated',
        'generated_message' => 'Your configuration was applied correctly',

        'password_changed_title'    => 'Password changed',
        'password_changed_message'  => 'Your password was changed correctly',
    ],

    'errors' => [
        'generated_title'   => 'Configuration error',
        'generated_message' => 'Please check your data',

        'integrity_title'   => 'The record can\'t be deleted',
        'integrity_message' => 'This record is parent of other records, delete childs first.',

        'wrong_password_title'      => 'Wrong Password',
        'wrong_password_message'    => 'Please verify your password',
    ],

    'tables' => [
        'actions_header' => 'Actions',

        'actions' => [
            'edit'      => 'Edit',
            'delete'    => 'Delete',
        ],
    ],

    'login' => [
        'name_label'        => 'Name',
        'password_label'    => 'Password',
        'login_button'      => 'Login',
        'login_error'       => 'Invalid credentials',
    ],

    'panel' => [
        'logout_button' => 'Logout',

        'menus' => [
            'home'          => 'Home',
            'domains'       => 'Domains',
            'subdomains'    => 'Subdomains',
            'users'         => 'Users',
            'logs'          => 'Logs',
            'configuration' => 'Configuration',
        ],
    ],

    'domains' => [
        'table' => [
            'domain'            => 'Domain',
            'subdomain_count'   => '# Subdomains',
        ],

        'form' => [
            'name'              => 'Name',
            'force_https'       => 'Force HTTPS?',
            'enable_ssl'        => 'Enable SSL?',
            'ssl_cert_location' => 'SSL Cert Location',
            'ssl_key_location'  => 'SSL Key Location',
        ],
    ],

    'subdomains' => [
        'locations' => 'Locations',

        'table' => [
            'domain'    => 'Domain',
            'subdomain' => 'Subdomain',
        ],

        'form' => [
            'name'      => 'Name',
            'domain'    => 'Domain',
        ],
    ],

    'locations' => [
        'form' => [
            'path'              => 'Path',
            'type'              => 'Type',
            'subtype'           => 'Sub Type',
            'target'            => 'Target',
            'connect_timeout'   => 'Connect Timeout',
            'send_timeout'      => 'Send Timeout',
            'read_timeout'      => 'Read Timeout',
            'enable_x_headers'  => 'Enable X Headers?'
        ],
    ],

    'users' => [
        'table' => [
            'name' => 'Name',
            'type' => 'Type',
        ],

        'form' => [
            'name'      => 'Name',
            'password'  => 'Password',
            'type'      => 'Type',
        ],
    ],

    'logs' => [
        'table' => [
            'user'          => 'User',
            'model'         => 'Model',
            'action'        => 'Action',
            'data'          => 'Data',
            'created_at'    => 'Date',
        ],
    ],

    'configurations' => [
        'password'              => 'Password',
        'password_confirmation' => 'Confirmation',
        'current_password'      => 'Current Password',
    ],
];
