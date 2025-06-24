<?php

return [
    [
        'title' => 'Beranda',
        'icon' => 'home',
        'route-name' => 'home',
        'is-active' => 'home',
        'description' => 'Untuk melihat ringkasan aplikasi.',
        'roles' => ['admin', 'user'],
    ],

    [
        'title' => 'Master',
        'description' => 'Menampilkan data master.',
        'icon' => 'database',
        'route-name' => 'master.admin.index',
        'is-active' => 'master*',
        'roles' => ['admin'],
        'sub-menus' => [
            [
                'title' => 'Admin',
                'description' => 'Melihat daftar admin.',
                'route-name' => 'master.admin.index',
                'is-active' => 'master.admin*',
            ],
            [
                'title' => 'Ruang Kelas',
                'description' => 'Melihat daftar ruang kelas.',
                'route-name' => 'master.classroom.index',
                'is-active' => 'master.classroom*',
            ],
            [
                'title' => 'Mata Pelajaran',
                'description' => 'Melihat daftar ruang kelas.',
                'route-name' => 'master.subject-study.index',
                'is-active' => 'master.subject-study*',
            ],
        ],
    ],

    [
        'title' => 'Pengaturan',
        'description' => 'Menampilkan pengaturan aplikasi.',
        'icon' => 'cog',
        'route-name' => 'setting.profile.index',
        'is-active' => 'setting*',
        'roles' => ['admin', 'user'],
        'sub-menus' => [
            [
                'title' => 'Profil',
                'description' => 'Melihat pengaturan profil.',
                'route-name' => 'setting.profile.index',
                'is-active' => 'setting.profile*',
            ],
            [
                'title' => 'Akun',
                'description' => 'Melihat pengaturan akun.',
                'route-name' => 'setting.account.index',
                'is-active' => 'setting.account*',
            ],
        ],
    ],
];
