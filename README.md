# Ping to coffee

This is a project that helps you store, update your contact information and connect with friends, relatives and colleagues for their latest information. In addition, this project helps you develop a relationship so it gets better and better.


## Introduction

Currently this project is under development for 2 versions.

1 - The online version is available for free at [https://pingtocoffee.com](https://pingtocoffee.com)

2 - The open source version is available at [github](https://github.com/pingnow/pingtocoffee).

You can register to use the online version, it is currently free and does not require any credit card information.

Also, if you want to run your own local or private environment, you can download the open source version. All code running on the online version is provided open source.


## Features

- Store, update your contact information
- Setting privacy for your information
- Manage contacts
- Add friends and see other people's contact information
- Log your friends' contact history(manual)
- Set task reminders
- Log interactive history

## Development plan

- Develop APIs for other interactive platforms
- Develop web responsive, mobile version (Android, iOS).
- Develop a browser extension that can interact with several features more quickly.
- Develop paid versions. Even if now I'm offering free [https://pingtocoffee.com](https://pingtocoffee.com), but you have to understand that the effort and time will not be free.
 Maybe I will develop a paid version with more advanced features to serve specific user groups in the future, it depends on the market demand for the application.
 Currently, all free first.

## Get started

### Requirements

- PHP >= 7.1.3
- Server support PHP (ex: Apache, Nginx)
- Database: MySQL
- Composer

### Instructions

Follow the steps below if you want to run on your own web hosting, or can run on your local machine for develop.

**Step 1 - Download the latest source code**

You can install it by downloading the latest version at the **master** branch, but it's definitely not stable since it's still under development. Your advice is to download the tagged version. Please select a stable version [here](https://github.com/pingnow/pingtocoffee/releases)

**Step 2 - Create Database**

I'm currently defaulting to the database name **pingtocoffee**. You can create a database by that name or change it according to your preference, remember to update it at the **.env** file with the variable **DB_DATABASE**.

**Step 3 - Install**

a) First create the environment file from the **.env.example** file with the command `cp .env.example .env`.

Then change the information accordingly to the environmental information of the system you have. I've explained what the variables in the `.env.example` file mean. Do not forget to change the database information you created in step 2.

b) Run the `composer install` command to install packages from the packagist. If your environment does not have [composer](https://getcomposer.org/), it is mandatory to install it before running this command.

If you are installing for the **production** environment, add `--no-interaction --prefer-dist --no-suggest --optimize-autoloader` options to optimize the installation.

c) Next, run `php artisan setup:production` to create the database table, create the default data, and create a symbolic link for the storage directory.

Note: The production environment default requires https. If you need to turn it off, please edit it in `routes/web.php`. Or change the APP_ENV to **local** for development.

d) Currently the application is using [task scheduling](https://laravel.com/docs/5.6/scheduling) as background processes to perform tasks(send mail, set next reminder date,...). So you need to install cron job to initialize the necessary background processes.

For example:

```
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

e) OK, now is the time to access the application and use it.

## Support

If you feel this application is useful and would like to assist you in developing it, and of course your help is more or less helpful, and has an impact not only on the individual but for the whole community.

There are many ways that everyone can help.

- The simplest way to do this is to introduce it to your friends, relatives, colleagues,... the people you want to keep in touch with.
- Introduce it on social networks like (Facebook, Twitter, Reddit,...) or other media such as blogs, newspapers, commentary in the article.
- Report bugs or respond to other user issues(if possible) at github's [error page](https://github.com/pingnow/pingtocoffee/issues). It's the best way to fix the problem early on.
- Contribute your ideas on issues such as new feature requests, layout or application colors, etc.

## Contribute

If you are a programmer, and want to contribute to the development, then do the following:

- Please read the [guide line](https://github.com/pingnow/pingtocoffee/blob/master/CONTRIBUTING.md) carefully before starting.
- Search for the label [bug](https://github.com/pingnow/pingtocoffee/issues?q=is%3Aissue+is%3Aopen+label%3Abug) and help resolve if you want ease level.
- Search for [help wanted](https://github.com/pingnow/pingtocoffee/issues?q=is%3Aissue+is%3Aopen+label%3A%22help+wanted%22) to solve a bit harder.
- If you are an advanced programmer, try searching for [feature request](https://github.com/pingnow/pingtocoffee/issues?q=is%3Aissue+is%3Aopen+label%3A%22feature+request%22) to address them. But pay attention, these problems are difficult to solve and require high skills.
 They will be scrutinized to ensure the final product is exactly what we are expect.

Finally, thank you all for the contributions.

## License

Ping to coffee is open source software with license [AGPL-3.0](https://opensource.org/licenses/AGPL-3.0)
