# [WIP] RequestQueueBundle

Bundle for queue requests to race condition 🏇

## Purpose

The purpose of this bundle is to prevent race condition in requests (like redeem coupon), because
many services have potential race condition (like https://hackerone.com/reports/759247)
that can corrupt their data. 

## Getting Started

```
composer require axotion/request-quueue-bundle
```
### Prerequisites

Add Bundle to bundles.php
```
// config/bundles.php
return [
    // 'all' means that the bundle is enabled for any Symfony environment
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => ['all' => true],
 ;
```

## Running the tests

```
bin/phpunit Tests/
```

## Contributing

Please read [CONTRIBUTING.md](https://gist.github.com/PurpleBooth/b24679402957c63ec426) for details on our code of conduct, and the process for submitting pull requests to us.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details


