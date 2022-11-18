![Dashboard](https://snipboard.io/pSe0jI.jpg)

# Installation

In order to install all the project dependencies, please make sure to run `composer install`.
This project was made with a simple laravel valet installation using **PHP 8.0**.

To install and compile frontend assets `npm isntall && npm run build`

# Tests

Tests can be executed by running the following command `php artisan test`

# Clearing expired jobs

Expired jobs can be cleared by calling `php artisan urls:clear`. However, in case you want to change the expiry days, it is configurable and can get done from config/services.

# Features

- Long URL shortening.
- Registered users can find all their shortened urls.
- Destination views counter.
- Internal access filtering.
- Prevention measure to avoid potential malicious links.
- Clearing urls that did not get visited in the last 30 days.

# Screenshots

![Dashboard](https://snipboard.io/pSe0jI.jpg)
![New Url](https://snipboard.io/l9EV4b.jpg)
![Tests](https://snipboard.io/MyQx7m.jpg)

# What could be done better

- Pagination.
- Success messages.
- Tracking views to distinguish between unique and repetitive ones.

# Final word
Thank you for giving me the chance to apply to this position.
