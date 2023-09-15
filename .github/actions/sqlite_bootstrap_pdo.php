<?php

/**
 * Provides a connection to the test database. Copy this file and rename it
 * to 'bootstrap_pdo.php' in the same directory.
 * The DBUnit tests then require these methods to get a connection to the
 * test db.
 *
 * @author David Meredith
 */

/**
 * Returns the database connection to your test databse.
 * Modify as required to return a connection to your test db.
 * @return PHPUnit\DbUnit\Database\DefaultConnection
 */
function getConnectionToTestDB() {
    $sqliteFile = '/tmp/gocdb.sqlite';
    $pdo = new PDO("sqlite:" . $sqliteFile);
    return new PHPUnit\DbUnit\Database\DefaultConnection($pdo, 'sqlite');
}

?>
