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
                'title' => 'Jadwal Kelas',
                'description' => 'Melihat jadwal kelas.',
                'route-name' => 'master.class-schedule.index',
                'is-active' => 'master.class-schedule*',
            ],
            [
                'title' => 'Wali Kelas',
                'description' => 'Melihat daftar wali kelas tiap kelas.',
                'route-name' => 'master.advisor-class.index',
                'is-active' => 'master.advisor-class*',
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
        'title' => 'Guru',
        'icon' => 'user-tie',
        'route-name' => 'teacher.index',
        'is-active' => 'teacher*',
        'description' => 'Melihat daftar guru.',
        'roles' => ['admin'],
    ],

    [
        'title' => 'Guru Mata Pelajaran',
        'icon' => 'chalkboard-teacher',
        'route-name' => 'subject-teacher.index',
        'is-active' => 'subject-teacher*',
        'description' => 'Melihat mata pelajaran guru.',
        'roles' => ['admin'],
    ],

    [
        'title' => 'Siswa',
        'icon' => 'graduation-cap',
        'route-name' => 'student.index',
        'is-active' => 'student*',
        'description' => 'Melihat daftar siswa.',
        'roles' => ['admin'],
    ],

    [
        'title' => 'Qr Code',
        'icon' => 'qrcode',
        'route-name' => 'qrcode.index',
        'is-active' => 'qrcode*',
        'description' => 'Melihat daftar qr code.',
        'roles' => ['admin'],
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
