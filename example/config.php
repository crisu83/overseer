<?php

return [
    'roles' => [
        'writer' => [
            'permissions' => ['book.write', 'book.author'],
        ],
        'editor' => [
            'permissions' => ['book.read'],
        ],
    ],
    'permissions' => [
        'book.write' => [],
        'book.read' => [],
        'book.author' => [
            'rules' => ['AuthorRule'],
        ],
    ],
    'assignments' => [
        '1' => ['writer', 'editor'],
    ],
];
