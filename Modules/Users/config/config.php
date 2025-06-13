<?php

return [
    'name' => 'Users',


    //CONFIGURATIONS
    'pagination' => 15,//Number of records per page
    'pagination_records' => 1500,//Number of records per page
    'registration_link_valid' => 72,//hours
    'allowed_image_size' => 5,//MB



    // FUNCTIONALITY

    //PASSWORD USED
    'users_password_used' => 1,// Check if passwords are used in past


    //FUNCTIONALITY ENABLE PASSWORD
    'users_enable_pass_new' => 1,// Enable to enter password when created new user
    'users_enable_pass_edit' => 1,// Enable to enter password when created new user

    //FUNCTIONALITY SEND EMAIL
    'users_send_registration_email' => 1,// When create user send  mail for registration




    'user_type' => [
        'user' =>
            [
                'value'=>1,
                'name'=>'User',
                'modules'=>[1,14,15,17],
            ],
        'administrator' =>
            [
                'value'=>2,
                'name'=>'Administrator',
                'modules'=>[1, 2, 11, 12, 13, 14, 15, 16, 18],
            ],
        //17 Reports See All Users
        //18 Users Edit Delete
        'power user' =>
            [
                'value'=>3,
                'name'=>'Power user',
                'modules'=>[1, 2, 14, 15],
            ],
//        'reports' =>
//            [
//                'value'=>3,
//                'name'=>'Reports viewer',
//                'modules'=>[1, 14,15],
//            ],

    ],
];
