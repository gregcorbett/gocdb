<?php
// create_first_row.php
require_once "bootstrap.php";


$number = new Number();
$number->setNumber(0);
$number->setParity('even');

$entityManager->persist($number);
$entityManager->flush();

echo "Created Number with ID " . $number->getId() . "\n";


