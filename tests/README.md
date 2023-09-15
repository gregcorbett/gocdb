DBUnit Testing
==============
This file is best viewed using a browser-plugin for markdown `.md` files.

GocDB comes with a suite of tests that can be run to validate that Doctrine and
your chosen database operate as expected. If the test suite fails against your
chosen DB, then GocDB will not work as expected. It is therefore recommended
that you run the DBUnit tests to ensure GocDB works as expected against your chosen DB.

Install PhpUnit and DBUnit
---------------------------
The tests require PHPUnit ***AND*** its DBUnit extensions be installed. These should be provided by composer. PHPUnit will need to be in your path, however `vendor/bin` should have been added during the installation of GOCDB. To manually install phpunit, see [PhpUnit install](https://phpunit.de).

```bash
$phpunit --version
PHPUnit 4.6.6 by Sebastian Bergmann and contributors.
```

If you see an error like the following, it is likely that you haven't installed the
DBUnit extensions or the phpunit on the path does not have the DBUnit extensions.

```bash
Fatal error: Class 'PHPUnit\DbUnit\TestCase' not found in ...<a test class file>...
```

Install PDO Driver for your test DB
------------------------------------
The tests require installation of the correct php PDO driver, see: http://php.net/manual/en/pdo.installation.php
PDO is used to assert that Doctrine performs the GocDB logic against your
DB in the expected way. It uses Php Data Objects (PDO) to connect to your DB
and runs plain SQL to perform assertions.

### OCIPDO for Oracle
For unix derivative systems, the PDO driver for Oracle (normally) requires compiling into php, see: http://php.net/manual/en/ref.pdo-oci.php
This is inconvenient and so the 'pdooci' util lib (https://github.com/taq/pdooci) is provided as a 'require-dev' dependency in the composer.json file (see INSTALL.md).
This util lib means you don't need to compile the driver --with-pdo-oci

Deploy A Database For Testing
--------------------------
* We ***STRONGLY*** recommend that you deploy a second database account/user with different
connection details that will be used for testing (e.g. GOCDB5TEST).
* See the `gocdbSrc/INSTALL.md` file for details on creating a new DB account/user
for your chosen DB.

Configure Doctrine and PDO for your Test DB
-------------------------------------------
* Copy `tests/doctrine/bootstrap_doctrine_TEMPLATE.php` to `tests/doctrine/bootstrap_doctrine.php`
(note same dir).
* Modify `bootstrap_doctrine.php` to specify your GOCDB5TEST account/user.
* Copy `tests/doctrine/bootstrap_pdo_TEMPLATE.php` to `tests/doctrine/bootstrap_pdo.php`
  and modify the connection details for the ***same test database***. This second
  file is used to assert that Doctrine performs the GocDB logic against your
  DB in the expected way. It uses Php Data Objects (PDO) to connect to your DB
  and runs plain SQL to perform assertions.

Note that the two bootstrap files are linked: the PDOOCI\PDO class in bootstrap_pdo.php is made available by composer's vendor/autoload.php in bootstrap_doctrine.php. So the autoload MUST be uncommented.

Deploy Tables/Schema via Doctrine
---------------------------------------
See the `<gocdbSrc>/INSTALL.md` file for Doctrine installation.
Use the doctrine command line tool to test doctrine's connection to the DB,
then drop and create the DB schema using the doctrine orm:schema-tool:

```bash
$ cd tests/doctrine
$ doctrine orm:schema-tool:drop --dump-sql
... sql shown here
$ doctrine orm:schema-tool:drop --force
Database schema dropped successfully!
$ doctrine orm:schema-tool:create
Creating database schema...
Database schema created successfully!
```

Running the Test Suite
----------------------
A test suite is provided that will test many core functions of GocDB and Doctrine.
This suite itself executes a number of individual tests and can be ran using the
following command. Coverage reporting is configured in the phpunit.xml file and
coverage reports are placed in the coverageReports dir (this dir is added to .gitignore)

```bash
$ cd tests
$ phpunit DoctrineTestSuite1.php --coverage-html coverageReports
```

Running Individual Tests
------------------------
Rather than running the whole test suite, individual tests can be run, e.g:

```
$ cd tests
$ phpunit doctrine/<testName>.php
```
