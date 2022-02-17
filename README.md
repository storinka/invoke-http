# Invoke HTTP

Default HTTP pipeline for Invoke. PSR-7 compatible.

## Installation

```shell
composer require storinka/invoke-http:^2.0
```

## Usage

```php
$invoke->serve(\Invoke\Http\HttpPipeline::class);
```