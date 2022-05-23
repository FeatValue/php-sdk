<img alt="FeatValue logo" align="right" src="https://www.featvalue.io/wp-content/uploads/2022/02/logo.svg"  width="120" height="120">

# FeatValue PHP SDK
This is the PHP SDK of [FeatValue](https://www.featvalue.io/), a collaboration tool by a&nbsp;coding&nbsp;project&nbsp;GmbH.

## Installation
Install using composer:
```
composer require featvalue/php-sdk
```

## Getting started
Create a new API instance using your API key and token:
```php
$api = new \FeatValue\Api(<YOUR_API_KEY>, <YOUR_TOKEN>);
```
If you want to test locally, add a host as a third parameter:
```php
$api = new \FeatValue\Api(<YOUR_API_KEY>, <YOUR_TOKEN>, "http://localhost/api");
```

## Usage
Get a task:
```php
$task = $api->get("/tasks/1");
```
Get all tasks:
```php
$tasks = $api->tasks();
```
Filter tasks by status:
```php
$tasks = $api->tasks(["status" => "OPEN"]);
```

You can access the complete API documentation [here](https://app.featvalue.io/api/documentation#/).