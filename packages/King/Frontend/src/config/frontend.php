<?php

return [
    'defaultThemeName'         => 'twenty_sixteen',   
    'uploadsFolder'            => 'uploads',
    'avatarsFolder'            => 'uploads/avatars',
    'avatarDefault'            => 'uploads/avatars/__default.jpg',
    'coversFolder'             => 'uploads/covers',
    'coverDefault'             => 'uploads/covers/__default.jpg',
    'avatarMedium'             => 256,
    'avatarMaxFileSize'        => 10000,
    'avatarMaxFileSizeMessage' => 10,
    'coverMaxFileSize'         => 10000,
    'coverMaxFileSizeMessage'  => 10,
    'dayLimitedToChangeSlug'   => 7,
    'unavailableCVUrls'        => [
        'setting',
        'config'
    ],
    'socialUrls' => [
        'facebook'    => 'facebook.com',
        'twitter'     => 'twitter.com',
        'instagram'   => 'instagram.com',
        'google-plus' => 'plus.google.com',
        'tumblr'      => 'tumblr.com',
        'vine'        => 'vine.co',
        'ello'        => 'ello.co',
        'linkedin'    => 'linkedin.com',
        'pinterest'   => 'pinterest.com',
        'vk'          => 'vk.com',
    ],
    'availableSocialIcons' => [
        'facebook'    => 'fa fa-facebook',
        'twitter'     => 'fa fa-twitter',
        'instagram'   => 'fa fa-instagram',
        'google-plus' => 'fa fa-google-plus',
        'tumblr'      => 'fa fa-tumblr',
        'vine'        => 'fa fa-vine',
        'ello'        => 'fa fa-ello',
        'linkedin'    => 'fa fa-linkedin',
        'pinterest'   => 'fa fa-pinterest',
        'vk'          => 'fa fa-vk',
    ],
    'availableSocial' => [
        'facebook'    => 'Facebook',
        'twitter'     => 'Twitter',
        'instagram'   => 'Instagram',
        'google-plus' => 'Google+',
        'tumblr'      => 'Tumblr',
        'vine'        => 'Vine',
        'ello'        => 'Ello',
        'linkedin'    => 'LinkedIn',
        'pinterest'   => 'Pinterest',
        'vk'          => 'VK'
    ],
    'avatarSizes' => array(
        'original' => 'Original',
        'small'  => array(
            'w'  => 128,
            'h'  => 128
        ),
        'medium' => array(
            'w' => 256,
            'h' => 256
        ),
        'big' => array(
            'w' => 512,
            'h' => 512
        )
    ),
    'coverSizes'               => array(
        'original' => 'Original',
        'small'  => array(
            'w'  => 768,
            'h'  => 420
        ),
        'medium' => array(
            'w' => 960,
            'h' => 500
        ),
        'big' => array(
            'w' => 1200,
            'h' => 500
        )
    ),
];
