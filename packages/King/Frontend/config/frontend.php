<?php

return [
    'defaultThemeName'         => 'twenty_seventeen',   
    'uploadsFolder'            => 'uploads',
    'themesFolder'             => 'uploads/themes',
    'themesTmpFolder'          => 'uploads/themes_tmp',
    'avatarsFolder'            => 'uploads/avatars',
    'avatarDefault'            => 'uploads/avatars/__default.jpg',
    'coversFolder'             => 'uploads/covers',
    'coverDefault'             => 'uploads/covers/__default.jpg',
    'avatarMedium'             => 256,
    'avatarMaxFileSize'        => 5000,
    'avatarMaxFileSizeMessage' => 5,
    'coverMaxFileSize'         => 5000,
    'coverMaxFileSizeMessage'  => 5,
    'themeMaxFileSize'         => 10000,
    'themeMaxFileSizeMessage'  => 10,
    'dayLimitedToChangeSlug'   => 8,
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
        'facebook'    => 'facebook',
        'twitter'     => 'twitter',
        'instagram'   => 'instagram',
        'google-plus' => 'google-plus',
        'tumblr'      => 'tumblr',
        'vine'        => 'vine',
        'ello'        => 'ello',
        'linkedin'    => 'linkedin',
        'pinterest'   => 'pinterest',
        'vk'          => 'vk',
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
    'coverSizes' => array(
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
    'themeFileExtensionsAllow' => ['html', 'js', 'css', 'png', 'jpg', 'gif', 'jpeg', 'otf', 'eot', 'svg', 'ttf', 'woff', 'woff2', 'json', 'txt'],
    'themeFilesRequired'       => ['index.html', 'screenshot.png', 'thumbnail.png'],
    'facebook_api' => [
        'app_id'                => '538490049611394',
        'app_secret'            => 'dcf4d5e733e17edb05de279dbef25a02',
        'default_graph_version' => 'v2.2',
    ]
];
