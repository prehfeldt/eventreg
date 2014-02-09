eventreg
========

Project Setup steps
-------------------
* `cd PROJECT_ROOT`
* `vagrant up`
* On the virtual machine
    * `cp app/config/parameters.yml.dist app/config/parameters.yml`
    * adapt the `parameters.yml` file
    * `curl -sS https://getcomposer.org/installer | php`
    * `composer update`
    * `php app/console doctrine:schema:create`

Done.