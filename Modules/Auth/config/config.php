<?php

return [
    'name' => 'Auth',

    'forgotten_link' => 24, //Hours for expiring link for forgotten password
    'registration_link' => 24, //Hours for expiring link for registration password
    'expired_link' => 24, //Hours for expiring link for expired password

    'password_reset_type' => [
        'forgotten' => 'forgotten',
        'expired' => 'expired',
        'registration' => 'registration',
        'mfa' => 'mfa',
    ],

    // 1. LIMITED TIMES OF ATTEMPTS
    'limited_attempts' => 1,
    'limited_attempts_parameters' => [
                                    'max' => 5, //max number of attempts
                                    'decay' => 5, //minutes of decay
                                    ],
    // 2. MULTI FACTOR LOGIN
    'password_multi_factor' => 0,
    'password_multi_factor_parameters' => [
        'time' => 10, //Minutes for expiring code for verification
        'code' => 10,//Number of characters in verification code
    ],

    // 3. IS USER ACTIVE   (logout user if is no active)
    'is_user_active' => 1,

    // 4. PASSWORD EXPIRED
    'password_expired' => 1,
    'password_expired_parameters' => [
        'months' => 3, //default, if it is not defined in DB
    ],

    // 5. LOGOUT OTHER DEVICES
    'logout_other_devices' => 1,


    // 6. MODULE PASSWORD USED
    'password_used' => 0,

    // 7. MODULE ARCHIVE EMAILS
    'archive_emails' => 1,

    'archive_emails_parameters' => [
        'message_1' => 1, //1=REQUEST FOR FORGOTTEN PASSWORD
        'message_3' => 3, //3=SUCCESS RESET FORGOTTEN PASSWORD
        'message_4' => 4, //4=SUCCESS RESET EXPIRED PASSWORD
        'message_5' => 5, //5=SUCCESS FIRS LOGIN PASSWORD
    ],


];
