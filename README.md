# PORTFOLIO

<a rel="license" href="http://creativecommons.org/licenses/by-sa/4.0/"><img alt="Creative Commons License" style="border-width:0" src="https://i.creativecommons.org/l/by-sa/4.0/88x31.png" /></a><br />This work is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-sa/4.0/">Creative Commons Attribution-ShareAlike 4.0 International License</a>.

---

**Author**: Anthony Cecconato

This project use:

- Symfony 4.3
- Webpack-Encore
- Simple landing page designed by **[Denis Novik](https://www.behance.net/novik_denis)**
- EasyAdmin

## You want to use it ? Follow the steps below

### Requirements:

- Composer
- Npm / Yarn
- PHP 7+ (tested with 7.4)

### Download / Installation

1. `git clone git@github.com:acecconato/Portfolio.git portfolio`
2. `cd portfolio`
2. `composer install && yarn install`
3. `cp .env .env.local`
4. Configure your `.env.local` file (For a mysql database configuration, use `DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name`). Read the Symfony doc for more configuration info.
5. `php bin/console d:d:c`
6. `php bin/console d:s:c` or `php bin/console d:s:u --force` (be sure your APP_ENV in .env.local is defined on dev mod for this)
7. `php bin/console app:create:admin`
8. `yarn build`
9. Setup your web server or test it with `php bin/console server:start`


