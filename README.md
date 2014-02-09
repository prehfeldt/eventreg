eventreg
========

Project Setup
-------------
* adapt the `parameters.yml` file
* `cd PROJECT_ROOT`
* `vagrant up`
* On the virtual machine run
    * `cp app/config/parameters.yml.dist app/config/parameters.yml`
    * `curl -sS https://getcomposer.org/installer | php`
    * `composer update`
    * `php app/console doctrine:schema:create`
    * `php app/console assets:install`
* point your browser to `http://events.dev/`

Done.