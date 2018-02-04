# IDCF Cloud PHP Client

A PHP client for [IDCF Cloud](https://www.idcf.jp/cloud/).

## Installation

execute:

    $ composer require idcf/client

## Dependencies
  - PHP 5.3 or later

## Usage

## Infinite LB

```php
<?php
require_once 'vendor/autoload.php';
$api_key = '';
$secret_key = '';
$client = new \Idcf\Client\Ilb($api_key, $secret_key, 'ilb.jp-east.idcfcloud.com');
$client->get('loadbalancers');
```

## DNS

```php
<?php
require_once 'vendor/autoload.php';
$api_key = '';
$secret_key = '';
$client = new \Idcf\Client\Dns($api_key, $secret_key);
$client->get('zones');
```

### Billing

```php
<?php
require_once 'vendor/autoload.php';
$api_key = '';
$secret_key = '';
$client = new \Idcf\Client\Your($api_key, $secret_key);
$client->get('billings/history');
```

### Content Cache

```php
<?php
require_once 'vendor/autoload.php';
$api_key = '';
$secret_key = '';
$client = new \Idcf\Client\CdnZero($api_key, $secret_key);
$args = array('api_key' => $api_key);
$client->get('fqdns', $args);
```

## Contributing

Bug reports and pull requests are welcome on GitHub at https://github.com/nhashiguchi/idcf-client-php. This project is intended to be a safe, welcoming space for collaboration, and contributors are expected to adhere to the [Contributor Covenant](http://contributor-covenant.org) code of conduct.


## License

The library is available as open source under the terms of the [MIT License](http://opensource.org/licenses/MIT).
