# Supervisor API

[![Build Status](https://travis-ci.org/pyjac/Supervisor-API.svg?branch=develop)](https://travis-ci.org/pyjac/Supervisor-API)
[![Coverage Status](https://coveralls.io/repos/github/pyjac/Supervisor-API/badge.svg?branch=develop)](https://coveralls.io/github/pyjac/Supervisor-API?branch=develop)
[![License](http://img.shields.io/:license-mit-blue.svg)](https://github.com/pyjac/Supervisor-API/blob/develop/LICENSE)

An API service that provides access to Supervisor (A Process Control System).

## Setup

You need the following tools:

- Composer
  Visit the [official website](https://getcomposer.org/doc/00-intro.md) for installation instructions.
- Laravel Valet
  Visit [Laravel website](https://laravel.com/docs/5.5/valet) for installation and setup instructions.
- Supervisor
  Visit [Supervisor website](http://supervisord.org/) for installation and setup instructions.

When you have completed the above processes, run:

```bash
$ git clone https://github.com/pyjac/develop
`````
to clone the repository to your Valet site directory. 

Run your supervisor `supervisord` and `supervisorctl`

Provide your Supervisor XML RPC server path.

```
XML_RPC_SERVER=<Your Supervisor RPC Link>
```
Now you are set up and ready to run.

## API Documentation

Visit [Postman Online Documentation](https://documenter.getpostman.com/view/3083588/supervisor-api/77h84JL)

## Testing

``` bash
$ phpunit
```

## Credits

Supervisor API is maintained by `Jacob OYEBANJI`.

## License

Supervisor API is released under the MIT Licence. See the bundled [LICENSE](LICENSE.md) file for details.