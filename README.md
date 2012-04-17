1) Installation
---------------

### a) Install the Vendor Libraries

    php composer.phar install

### b) Check your System Configuration

Now make sure that your local system is properly configured
for Symfony. To do this, execute the following:

    php app/check.php

If you get any warnings or recommendations, fix these now before moving on.

2) Run
---------------
### a) Run the unit tests

    phpunit -c app

