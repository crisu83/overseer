# Overseer

Framework agnostic RBAC implementation in PHP

# Example usage

```php
<?php

require(__DIR__ . '/../vendor/autoload.php');

require(__DIR__ . '/User.php');
require(__DIR__ . '/HasAuthor.php');
require(__DIR__ . '/Book.php');
require(__DIR__ . '/AuthorRule.php');

use Crisu83\Overseer\Entity\Assignment;
use Crisu83\Overseer\Entity\Permission;
use Crisu83\Overseer\Entity\Role;
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

$writer = new Role('writer');
$editor = new Role('editor');

$write  = new Permission('book.write');
$author = new Permission('book.author');
$read   = new Permission('book.read');

$author->addRule(new AuthorRule);

$writer->addPermission('book.write');
$writer->addPermission('book.author');
$editor->addPermission('book.read');

$overseer->saveRole($writer);
$overseer->saveRole($editor);

$overseer->savePermission($read);
$overseer->savePermission($write);
$overseer->savePermission($author);

$overseer->saveAssignment(new Assignment('writer', 1));
$overseer->saveAssignment(new Assignment('editor', 1));

$permissions = implode(', ', $overseer->getPermissions($myUser));

echo "permissions: $permissions" . PHP_EOL;

$bookPermissions = implode(', ', $overseer->getPermissionsForResource($myUser, $myBook));

echo "permissions to book: $bookPermissions" . PHP_EOL;

if ($overseer->hasPermission('book.author', $myUser, $myBook)) {
    echo "I am the author of the book." . PHP_EOL;
} else {
    echo "I am not the author of the book" . PHP_EOL;
}

```

Output:

```
permissions: book.write, book.read
permissions to book: book.author
I am the author of the book.
```
