<?php

/**
 * Don't change this constants.
 * The only that should be modified are default_password
 * and url_medico_consentido
 */

return [
    /**
     * Attachment types.
     */
    'attachments' => [
        'main_img' => 'main_img',
        'img' => 'img',
        'pdf' => 'pdf',
        'video' => 'video',
        'profile_img' => 'profile_img', 
        'manual' => 'manual',
        'calendar' => 'calendar',
        'resource' => 'resource'
    ],

    'evaluations' => [
        'diagnostic' => 'd',
        'final' => 'f'
    ],

    /**
     * If you want to change this default_password, you must use bcrypt to crypt the password,
     * for example: 
     * 'default_password' = bcrypt('your default password'),
     */
    'default_password' => '$2y$10$qQpVjcmcO5I1XffeZduhPuyAe55ZtEb5yxMUGhDXKI84r4PSKARoS', //secret

    'resources' => [
        'pdf' => 'pdf',
        'image' => 'image',
        'video' => 'video'
    ],

    'resource_types' => [
        'pdf' => 'pdf',
        'image' => 'image',
        'video' => 'video'
    ],

    /**
     * Advance in a course, module or resource.
     */
    'status' => [
        'passed' => 'Aprobado',
        'failed' => 'Reprobado',
        'completed' => 'Completado',
        'incomplete' => 'No completado',
        'browsed' => 'Visto',
        'not_attemped' => 'Pendiente'
    ],

    'url_medico_consentido' => 'http://www.sanofi.com.mx',

    'roles' => [
        'admin' => 'admin',
        'reporter' => 'reporter',
        'editor' => 'editor',
        'tester' => 'tester',
        'teacher' => 'teacher',
        'doctor' => 'doctor'
    ],

    'default_images' => [
        'expert' => 'http://webapplayers.com/inspinia_admin-v2.6/img/a4.jpg',
        'user' => 'https://www.library.caltech.edu/sites/default/files/styles/headshot/public/default_images/user.png',
        'course' => 'https://www.capacityacademy.com/uploads/6/4/8/3/6483237/_________667043846.png',
        'ascription' => 'https://upload.wikimedia.org/wikipedia/en/thumb/2/2c/Sanofi.svg/1200px-Sanofi.svg.png',
        'module' => 'https://upload.wikimedia.org/wikipedia/en/thumb/2/2c/Sanofi.svg/1200px-Sanofi.svg.png',
        'evaluation' => 'https://upload.wikimedia.org/wikipedia/en/thumb/2/2c/Sanofi.svg/1200px-Sanofi.svg.png',
        'category' => 'http://1.bp.blogspot.com/-rGg7seQMfgY/T526kIHkhkI/AAAAAAAAADU/efzshZ8OsEY/s1600/concepto-robado.gif',
        'calendar' => '/img/default-calendar.jpg',
        'certificate' => '/storage/ascriptions/certificado.jpg'
    ],

    'support_email' => 'soporte@paecmexico.com'
];