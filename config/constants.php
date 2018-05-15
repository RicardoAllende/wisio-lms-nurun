<?php
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

    'main_domain' => 'localhost',

    'roles' => [
        'admin' => 'admin',
        'reporter' => 'reporter',
        'editor' => 'editor',
        'tester' => 'tester',
        'teacher' => 'teacher',
        'private_doctor' => 'private_doctor',
        'public_doctor' => 'public_doctor',
        'pharmacy_doctor' => 'pharmacy_doctor'
    ]
];