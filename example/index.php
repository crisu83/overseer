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

//$writer = new Role('writer');
//$editor = new Role('editor');
//
//$write  = new Permission('book.write');
//$author = new Permission('book.author');
//$read   = new Permission('book.read');
//
//$author->addRule(new AuthorRule);
//
//$writer->addPermission('book.write');
//$writer->addPermission('book.author');
//$editor->addPermission('book.read');
//
//$overseer->saveRole($writer);
//$overseer->saveRole($editor);
//
//$overseer->savePermission($read);
//$overseer->savePermission($write);
//$overseer->savePermission($author);
//
//$overseer->saveAssignment(new Assignment('writer', 1));
//$overseer->saveAssignment(new Assignment('editor', 1));

var_dump($overseer->getPermissions($myUser));

var_dump($overseer->getPermissionsForResource($myUser, $myBook));

var_dump($overseer->hasPermission('book.author', $myUser, $myBook));
