<?php

function getNumberValues(Number $number_entity) {
    $values = array();
    $values['number'] = $number_entity->getNumber();
    $values['parity'] = $number_entity->getParity();
    return $values;
    
}
    
//function setNumberValues(array $newValues, Number $number_entity) {
//    $number_entity->setNumber($newValues['number']);
//    $number_entity->setParity($newValues['parity']);
//    return;
//    }
    
function isEven($number) {
    if($number % 2 == 0){ 
        return true;  
    } 
    else{ 
        return false; 
    } 
    }
