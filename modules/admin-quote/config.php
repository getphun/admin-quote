<?php
/**
 * admin-quote config file
 * @package admin-quote
 * @version 0.0.1
 * @upgrade true
 */

return [
    '__name' => 'admin-quote',
    '__version' => '0.0.1',
    '__git' => 'https://github.com/getphun/admin-quote',
    '__files' => [
        'modules/admin-quote' => [ 'install', 'remove', 'update' ],
        'theme/admin/component/quote' => [ 'install', 'remove', 'update' ]
    ],
    '__dependencies' => [
        'admin'
    ],
    '_services' => [],
    '_autoload' => [
        'classes' => [
            'AdminQuote\\Controller\\QuoteController' => 'modules/admin-quote/controller/QuoteController.php',
            'AdminQuote\\Model\\Quote'                => 'modules/admin-quote/model/Quote.php'
        ],
        'files' => []
    ],
    
    '_routes' => [
        'admin' => [
            'adminQuote' => [
                'rule' => '/quote',
                'handler' => 'AdminQuote\\Controller\\Quote::index'
            ],
            'adminQuoteEdit' => [
                'rule' => '/quote/:id',
                'handler' => 'AdminQuote\\Controller\\Quote::edit'
            ],
            'adminQuoteRemove' => [
                'rule' => '/quote/:id/delete',
                'handler' => 'AdminQuote\\Controller\\Quote::remove'
            ]
        ]
    ],
    
    'admin' => [
        'menu' => [
            'component' => [
                'label'     => 'Component',
                'order'     => 1500,
                'icon'      => 'puzzle-piece',
                'submenu'   => [
                    'quote'     => [
                        'label'     => 'Quote',
                        'perms'     => 'read_quote',
                        'target'    => 'adminQuote',
                        'order'     => 1000
                    ]
                ]
            ]
        ]
    ],
    
    'form' => [
        'admin-quote' => [
            'group' => [
                'type'  => 'text',
                'label' => 'Group',
                'rules' => []
            ],
            'title' => [
                'type'  => 'text',
                'label' => 'Title',
                'rules' => [
                    'required' => true
                ]
            ],
            'text'  => [
                'type'  => 'textarea',
                'label' => 'Text',
                'rules' => []
            ],
            'image' => [
                'type'  => 'file',
                'label' => 'Image',
                'rules' => [
                    'file' => 'image/*'
                ]
            ],
            'sources'   => [
                'type'  => 'text',
                'label' => 'Source',
                'rules' => []
            ]
        ]
    ],
];