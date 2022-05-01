# PHP Coding Tasks

PHP coding task for web developer candidates.

Candidates are free to use language features from any stable version of PHP.

Candidates may add code comments or provide any supporting documentation they wish.

## Task 1: ActiveRecord-style ORM coding implementation and questions

### Introduction

This task involves some questions and coding implementations with a mock ActiveRecord-style database ORM. The files for this task are contained are contained with the [unit.orm](unit.orm) directory.

Assume that the [ActiveRecord](unit.orm/ActiveRecord.php) base class contains a working implementation of the type of features that you would expect of any database ORM.

The [DownloadLog](unit.orm/DownloadLog.php) model represents a log entry denoting a user (identified by a `user_id`) downloading a file (identified by `file_id`).

### Questions:

1. What does the `final` keyword mean the [DownloadLog](unit.orm/DownloadLog.php) model? What are the implications in removing the `final` declaration?

*Answer*
```php
final keyword in the class indicates that the class cannot be exteded further
.removing it will allow other classes to exted DownloadLog.
```


2. The current of implementation of [DownloadLog](unit.orm/DownloadLog.php) contains a fatal error. What is it, and how would it be resolved?

*Answer*
```php
isModified method is not implemented.it should be implemented either by ActiveRecoed or DownloadLog class.
 ActiveRecord is preferred.
```


### Coding task 1:

Extend the current implementation so that the following code block provides the output as described:

*Code block*
```php
$downloadLog = DownloadLog::create();
echo ($downloadLog->isModified() ? 'DownloadLog is modified' : 'DownloadLog is not modified');
$downloadLog->setFileId(1000)->setUserId(2000);
echo ($downloadLog->isModified() ? 'DownloadLog is modified' : 'DownloadLog is not modified');
echo ("UserId is: " . $downloadLog->getUserId());
```

*Output*
```bash
DownloadLog is not modified
DownloadLog is modified
UserId is: 2000
Destroying DownloadLog
```

### Coding task 2:

Create a `trait` which validates that a value is numeric. Add this `trait` to [DownloadLog](unit.orm/DownloadLog.php) and use it to validate that `user_id` and `file_id` values are numeric. If they are not, throw an exception.

## Task 2: Web application controller implementation

### Introduction

This task outlines some requirements for a one or more base classes that provide controller functionality as commonly found in MVC-style web application frameworks.

### Assumptions:

There is an existing web application framework that:

* Bootstraps an incoming request via a router.
* The router dispatches the request to a controller via a defined entry point method called `execute`.
* The controller `execute` method expects `request` and `response` objects as parameters.
* The `request` object implements the [Psr\Http\Message\ServerRequestInterface](https://github.com/php-fig/http-message/blob/master/src/ServerRequestInterface.php) interface.
* The `response` object implements the [Psr\Http\Message\ResponseInterface](https://github.com/php-fig/http-message/blob/master/src/ResponseInterface.php) interface.
* The controller `execute` method returns a modified `response` object.

### Requirements

The web application framework should provide functionality for handling HTTP requests that output both HTML web pages as well as JSON-encoded data responses (as commonly found in REST APIs, for example).

### Coding task

Create one or more base classes that can be integrated into the existing web application framework and provide the following functionality as outlined below.

*Functional requirements*

* Functionality to return an HTML response body along with any valid HTTP response codes and/or response headers.
* Functionality to return a JSON response body along with any valid HTTP response codes and/or response headers.
* Generic functionality to validate input parameters for a PUT or POST request.

You need not provide a concrete implementation of the base class(es) but can do so if it helps describes the base implementation.

You do *not* need to create concrete implementations of the `request` and `reponse` objects. Assume that these have been created and conform to the relevant interfaces as mentioned above.
