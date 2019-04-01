<?php
//toy_writer.php <number>

require __DIR__."/bootstrap.php";
require __DIR__."/toy_writer_utils.php";

$target_id = 1;
$new_number= $argv[1];

# Have doctrine manage fetch of object and setting of new value
$returned_entity = $entityManager->find("Number", $target_id);

# Start a transaction
$entityManager->getConnection()->beginTransaction();
try {
    $returned_entity->setNumber($new_number);

    if (isEven($new_number)) {
        $returned_entity->setParity('even'); 
    }
    else {
        $returned_entity->setParity('odd');
    }

    # End Transaction
    $entityManager->merge($returned_entity);
    $entityManager->flush();
    $entityManager->getConnection()->commit();
} catch (Exception $e) {
    $em->getConnection()->rollback();
    $em->close();
    throw $e;
}

// Now check the database is consistent. We dont care if it has the data
// we have just wrote, so long as the database is in a conistent state.
// Create connection
$direct_conn = new mysqli($db_host, $db_user, $db_password, $db_name);

$sql = 'SELECT * FROM numbers where id='.$target_id;

$direct_result = $direct_conn->query($sql);

$returned_row = $direct_result->fetch_assoc();

// Do a check that the result is conistant.
if (isEven($returned_row['number'])) {
    if ($returned_row['parity'] != 'even') {
        fopen('./stop', 'w');
    }
} else {
    if ($returned_row['parity'] != 'odd') {
        fopen('./stop', 'w');
    }
}

mysqli_close($direct_conn);
