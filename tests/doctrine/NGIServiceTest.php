<?php

require_once dirname(__FILE__) . '/TestUtil.php';

use Doctrine\ORM\EntityManager;

require_once dirname(__FILE__) . '/bootstrap.php';
require_once dirname(__FILE__) . '/../../lib/Gocdb_Services/NGI.php';

/**
 * Test the NGI service, in particular the cascade delete behaviour when
 * deleting an ngi (i.e. cascading to Service, EndpointLocation, Downtime, Roles etc).
 *
 * @author David Meredith
 */
class NGIServiceTest extends PHPUnit\DbUnit\TestCase
{
    private $em;

  /**
   * Overridden.
   */
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        echo "\n\n-------------------------------------------------\n";
        echo "Executing NGIServiceTest. . .\n";
    }

  /**
   * Overridden. Returns the test database connection.
   * @return PHPUnit\DbUnit\Database\DefaultConnection
   */
    protected function getConnection()
    {
        require_once dirname(__FILE__) . '/bootstrap_pdo.php';
        return getConnectionToTestDB();
    }

  /**
   * Overridden. Returns the test dataset.
   * Defines how the initial state of the database should look before each test is executed.
   * @return PHPUnit\DbUnit\DataSet\IDataSet
   */
    protected function getDataSet()
    {
        return $this->createFlatXMLDataSet(dirname(__FILE__) . '/truncateDataTables.xml');
      // Use below to return an empty data set if we don't want to truncate and seed
      //return new PHPUnit\DbUnit\DataSet\DefaultDataSet();
    }

  /**
   * Overridden.
   */
    protected function getSetUpOperation()
    {
      // CLEAN_INSERT is default
      //return PHPUnit\DbUnit\Operation\Factory::CLEAN_INSERT();
      //return PHPUnit\DbUnit\Operation\Factory::UPDATE();
      //return PHPUnit\DbUnit\Operation\Factory::NONE();
      //
      // Issue a DELETE from <table> which is more portable than a
      // TRUNCATE table <table> (some DBs require high privileges for truncate statements
      // and also do not allow truncates across tables with FK contstraints e.g. Oracle)
        return PHPUnit\DbUnit\Operation\Factory::DELETE_ALL();
    }

  /**
   * Overridden.
   */
    protected function getTearDownOperation()
    {
      // NONE is default
        return PHPUnit\DbUnit\Operation\Factory::NONE();
    }

  /**
   * Sets up the fixture, e.g create a new entityManager for each test run
   * This method is called before each test method is executed.
   */
    protected function setUp(): void
    {
        parent::setUp();
        $this->em = $this->createEntityManager();
    }
  /**
   * Run after each test function to prevent pile-up of database connections.
   */
    protected function tearDown(): void
    {
        parent::tearDown();
        if (!is_null($this->em)) {
            $this->em->getConnection()->close();
        }
    }
  /**
   * @todo Still need to setup connection to different databases.
   * @return EntityManager
   */
    private function createEntityManager()
    {
        require dirname(__FILE__) . '/bootstrap_doctrine.php';
        return $entityManager;
    }

  /**
   * Called after setUp() and before each test. Used for common assertions
   * across all tests.
   */
    protected function assertPreConditions(): void
    {
        $con = $this->getConnection();
        $fixture = dirname(__FILE__) . '/truncateDataTables.xml';
        $tables = simplexml_load_file($fixture);

        foreach ($tables as $tableName) {
            $sql = "SELECT * FROM " . $tableName->getName();
            $result = $con->createQueryTable('results_table', $sql);
            if ($result->getRowCount() != 0) {
                throw new RuntimeException("Invalid fixture. Table has rows: " . $tableName->getName());
            }
        }
    }

  /**
   * Test the NGI service deleteNGI() method which recursively deletes child
   * sites and services, roles etc.
   */
    public function testNgiService_deleteNgi()
    {
        print __METHOD__ . "\n";
        include __DIR__ . '/resources/sampleFixtureData1.php';

      // create an admin user (required to call the NGI service)
        $adminUser = TestUtil::createSampleUser('some', 'admin');
        $identifier = TestUtil::createSampleUserIdentifier('X.509', '/some/admin');
        $adminUser->addUserIdentifierDoJoin($identifier);
        $this->em->persist($identifier);
        $adminUser->setAdmin(true);
        $this->em->persist($adminUser);

      // Now delete the ngi using the NGI service.
        $ngiService = new org\gocdb\services\NGI();
        $ngiService->setEntityManager($this->em);
        $ngiService->deleteNgi($ngi, $adminUser, false);


      // since we deleted the NGI, we expect an empty DB !
        $result = $testConn->createQueryTable('results_table', "SELECT * FROM Roles");
        $this->assertTrue($result->getRowCount() == 0);

        $result = $testConn->createQueryTable('results_table', "SELECT * FROM NGIs");
        $this->assertTrue($result->getRowCount() == 0);

        $result = $testConn->createQueryTable('results_table', "SELECT * FROM Sites");
        $this->assertTrue($result->getRowCount() == 0);

        $result = $testConn->createQueryTable('results_table', "SELECT * FROM Services");
        $this->assertTrue($result->getRowCount() == 0);

        $result = $testConn->createQueryTable('results_table', "SELECT * FROM Downtimes");
        $this->assertTrue($result->getRowCount() == 0);

        $result = $testConn->createQueryTable('results_table', "SELECT * FROM EndpointLocations");
        $this->assertTrue($result->getRowCount() == 0);

        $result = $testConn->createQueryTable('results_table', "SELECT * FROM CertificationStatusLogs");
        $this->assertTrue($result->getRowCount() == 0);
    }
}
