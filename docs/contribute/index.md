## Test environment

We try to cover most features and new methods with unit and functional tests. Any pull request submitted on GitHub should have test and will be checked before being merged. Moreover, we strongly encourage adding unit tests for every new method added to the codebase to ensure code stability, and we will probably refuse a pull request if there is no tests for it.


### Setup

To setup the test environment:

- Create a database called `pingtocoffee_test`
- `php artisan migrate --database testing`
- `php artisan db:seed --database testing`

### Run the test suite

The test suite uses phpunit. It's mainly used to perform unit tests or quick, small functional tests.

To run the test suite:

`phpunit` or `./vendor/bin/phpunit` in the root of the folder containing code from GitHub.

### Browser test

We are using Laravel Dusk to help testing with browsers. If it is not intimate with you, please read about it [here](https://laravel.com/docs/5.7/dusk).

The test suite can be run with command: `php artisan dusk`
