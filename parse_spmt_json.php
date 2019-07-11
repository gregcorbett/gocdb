<?php

$i = 0;
$services_info =  file_get_contents('https://host-172-16-112-83.nubes.stfc.ac.uk/portal/fake-spmt/api/v2/service-types/');
//gets the information about the different service types
echo "Running normally: ";//test to see if the program is running normally as it will come up in the command line
sleep(2);
$services_info = json_decode($services_info, true);//converts the array into a json array
$numberOfServices =  count($services_info);

echo "The Service Types and names are: ";
require_once'/usr/share/GOCDB5/auto_add_service_type.php';//links to the other script in order to create a new service type
sleep(3);
while ($i < $numberOfServices){//loops through the diferent values printing them as it goes
	echo $services_info[$i]["service_name"];//prints of the service names only
	echo "//";
	sleep(0.5);
	echo $services_info[$i]["service_type"];//prints of the service type only
	sleep(0.5);
	echo "//next service:  ";
	sleep(0.5);
	$newValues = array("Name" => $services_info [$i]["service_name"],//defining the name and dwescription of the new service type
                     "Description" => $services_info [$i]["service_type"]);
	try{ServiceCreator($newValues);
	}catch(Exception $e) {
		echo 'already entered service type: ', $services_info[$i]["service_type"], "\n";
	}
	$i++;

      


}
?>
