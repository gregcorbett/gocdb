# Prerequisites

1. Install composer
```
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === '48e3236262b34d30969dca3c37281b3b4bbe3221bda826ac6a9a62d6444cdb0dcd0615698a5cbe587c3f0fe57a54d8f5') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
php composer.phar install
```

2. Install php and MariaDB
```
yum install epel-release
rpm -Uvh  https://mirror.webtatic.com/yum/el7/webtatic-release.rpm
yum install php72w mariadb-server php72w-cli.x86_64 php72w-common.x86_64 php72w-dba.x86_64 php72w-devel.x86_64 php72w-mysqlnd.x86_64 php72w-pdo.x86_64 php72w-pdo_dblib.x86_64
```

3. install composer based dependencies
`composer install`

4. start MariaDB
`systemctl start mariadb`

5. create doctrine database
`mysql -u root -p -e "create database doctrine;"`

6. Create schema
`php vendor/bin/doctrine orm:schema-tool:create`

7. `toy_writer.php` assumes some data already exists, so create some.
`php create_first_row.php`

# What the test suite does

You should have a database called doctrine with a numbers table
```
$ mysql -u root doctrine -e "desc numbers;"
+--------+--------------+------+-----+---------+----------------+
| Field  | Type         | Null | Key | Default | Extra          |
+--------+--------------+------+-----+---------+----------------+
| id     | int(11)      | NO   | PRI | NULL    | auto_increment |
| number | int(11)      | NO   |     | NULL    |                |
| parity | varchar(255) | NO   |     | NULL    |                |
+--------+--------------+------+-----+---------+----------------+
```

`./toy_writer.php $1` updates the `number` field in row 1 of the `numbers` table so that it equals `$1` exactly once.
* If `$1` is even, `./toy_writer.php $1` also adds the string "even" to the `parity` field.
* If `$1` is odd, `./toy_writer.php $1` also adds the string "odd" to the `parity` field.

`./toy_writer.php $1` then checks that row 1 of `numbers` is consistent, i.e. `parity`=="even" <==> `number` is even.

`./toy_writer.sh $1` starts a loop at `$1` and calls `./toy_writer.php`, first with the argument `$1` and then every second number until 1000, i.e.:
* `./toy_writer.sh 0` will call `./toy_writer.php 0`, `./toy_writer.php 2`, `./toy_writer.php 4`, `./toy_writer.php 6` ... `./toy_writer.php 998`
* `./toy_writer.sh 1` will call `./toy_writer.php 1`, `./toy_writer.php 3`, `./toy_writer.php 5`, `./toy_writer.php 7` ... `./toy_writer.php 999`

If the consistency check in `./toy_writer.php` writes the `stop` file, which breaks the `./toy_writer.sh` loop.

## TLDR

The test suite is two process, one writing only even numbers and the string "even". The other writing only odd numbers and the string "odd".

# Running the test suite

1. Open two shells

2. In the first, run `./toy_writer.sh 0`. In the second, run `mysql -u root doctrine -e "select * from numbers;"` to convince yourself that the database is being written to.
   While doing this, the first shell should happily print out numbers.
   ```
   $ ./toy_writer.sh 0
   0, 2, 4, 6, 8, 10, 12, 14, ... 998,
   ```

3. In the first, run `./toy_writer.sh 0`. In the second, run `./toy_writer.sh 1`. This time the loops should break before they get to ~1000.

4. Once the loop breaks, run `mysql -u root doctrine -e "select * from numbers;"`. You should now see an inconsistent database.
