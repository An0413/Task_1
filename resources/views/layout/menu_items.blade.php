{{--@extends('admin.layout.sidebar')--}}
@php
    $menu_items = [
//            [
//                'url' => 'admin.dashboard',
//                'name' => 'dashboard',
//                'label' => 'Dashboard',
//                'params' => null
//            ],
        [
            'url' => 'admin_list',
            'name' => 'admin_list',
            'label' => 'Ադմիններ',
            'params' => null
        ],
        [
            'url' => 'admin_menu_list',
            'name' => 'menu_list',
            'label' => 'Մենյու',
            'params' => null
        ],
         [
            'url' => 'product_list',
            'name' => 'product_list',
            'label' => 'Ապրանք',
            'params' => [0]
        ],
        [
            'url' => 'product_type',
            'name' => 'prod_type_list',
            'label' => 'Ապրանքի տիպ',
            'params' => null
        ],
        [
            'url' => 'companies_list',
            'name' => 'company_list',
            'label' => 'Կազմակերպություններ',
            'params' => null
        ],
        [
            'url' => 'shop_list',
            'name' => 'market_list',
            'label' => 'Խանութներ',
            'params' => [0]
        ],
        [
            'url' => 'admin_category_list',
            'name' => 'category_list',
            'label' => 'Կատեգորիաներ',
            'params' => null
        ],
        [
            'url' => 'product_category',
            'name' => 'prod_category_list',
            'label' => 'Պրոդուկտի կատեգորիաներ',
            'params' => null
        ],
        [
            'url' => 'contract_types',
            'name' => 'contract_type_list',
            'label' => 'Պայմանագրի տիպեր',
            'params' => null
        ],
        [
            'url' => 'contract_request_list',
            'name' => 'contract_list',
            'label' => 'Պայմանագրի հայտեր',
            'params' => null
        ],
        [
            'url' => 'contract_text',
            'name' => 'contract_text_list',
            'label' => 'Պայմանագրի պայմաններ',
            'params' => null
        ],
        [
            'url' => 'clauses_list',
            'name' => 'clauses_list',
            'label' => 'Պայմանների ցուցակ',
            'params' => null
        ]
];
    $page = Session::get('page');
@endphp
