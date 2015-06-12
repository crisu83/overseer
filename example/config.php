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
        'book.write' => ['resource' => 'book'],
        'book.read' => ['resource' => 'book'],
        'book.author' => [
            'resource' => 'book',
            'rules' => ['AuthorRule'],
        ],
    ],
    'assignments' => [
        '1' => ['writer', 'editor'],
    ],
];
