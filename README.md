# Overseer

Overseer is a framework agnostic [RBAC](http://en.wikipedia.org/wiki/Role-based_access_control) implementation in PHP.

# Example

The following script demonstrates usage (you can find the rest of the code in the [example](example) folder):

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

$write  = new Permission('book.write', 'book');
$author = new Permission('book.author', 'book');
$read   = new Permission('book.read', 'book');

$author->addRule(new AuthorRule);

$writer->addPermission('book.write');
$writer->addPermission('book.author');
$editor->addPermission('book.read');

$overseer->saveRole($writer);
$overseer->saveRole($editor);

$overseer->savePermission($read);
$overseer->savePermission($write);
$overseer->savePermission($author);

$overseer->saveAssignment(new Assignment(1, ['writer', 'editor']));

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

Here is the output from that script:

```
My permissions: book.write, book.read
My permissions to the book: book.author
I am the author of the book.
```
