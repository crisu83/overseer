<?php

require(__DIR__ . '/../vendor/autoload.php');

require(__DIR__ . '/User.php');
require(__DIR__ . '/HasAuthor.php');
require(__DIR__ . '/Book.php');
require(__DIR__ . '/AuthorRule.php');

use Crisu83\Overseer\Overseer;
use Crisu83\Overseer\Runtime\AssignmentStorage;
use Crisu83\Overseer\Runtime\PermissionStorage;
use Crisu83\Overseer\Runtime\RoleStorage;

$roleStorage       = new RoleStorage;
$permissionStorage = new PermissionStorage;
$assignmentStorage = new AssignmentStorage;

$overseer = new Overseer($roleStorage, $permissionStorage, $assignmentStorage);

$myUser = new User(1);
$myBook = new Book(1);

$config = require(__DIR__ . '/config.php');

$overseer->configure($config);

echo "My permissions: " . PHP_EOL;
echo "  " . implode(', ', $overseer->getPermissions($myUser)) . PHP_EOL;

echo "My permissions to the book: " . PHP_EOL;
echo "  " . implode(', ', $overseer->getPermissions($myUser, $myBook)) . PHP_EOL;

if ($overseer->hasPermission('book.author', $myUser, $myBook)) {
    echo "I am the author of the book." . PHP_EOL;
} else {
    echo "I am not the author of the book" . PHP_EOL;
}
