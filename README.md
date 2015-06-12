# Overseer

Overseer is a framework agnostic [RBAC](http://en.wikipedia.org/wiki/Role-based_access_control) implementation in PHP. 

## How does Overseer differ from other implementations?

Overseer is developed using PHP OOP best practices and meets the [PHP-FIG](http://www.php-fig.org/) standards. It is not only framework agnostic, but also storage agnostic, which allows you to use it together with your favorite libraries. 

## Features

- Role inhertiance
- Permission business rules
- Resource based permissions
- Configurable

## Work in progress

- Unit tests
- Refactoring
- README

## Usage

Overseer comes bundled with a runtime storage implementation that is suitable for non-production use. If you plan on using Overseer in production we suggest that you implement persistent storage and caching to improve performance.

## Example

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

$myUser = new User(1); // subject
$myBook = new Book(1); // resource

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

echo "My permissions: " . PHP_EOL;
echo "  " . implode(', ', $overseer->getPermissions($myUser)) . PHP_EOL;

echo "My permissions to the book: " . PHP_EOL;
echo "  " . implode(', ', $overseer->getPermissions($myUser, $myBook)) . PHP_EOL;

if ($overseer->hasPermission('book.author', $myUser, $myBook)) {
    echo "I am the author of the book." . PHP_EOL;
} else {
    echo "I am not the author of the book" . PHP_EOL;
}

```

Here is the output from that script:

```
My permissions:
  book.read, book.write
My permissions to the book:
  book.read, book.write, book.author
I am the author of the book.
```
