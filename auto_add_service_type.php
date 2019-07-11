<?php
  require_once __DIR__.'/lib/Gocdb_Services/Factory.php';//aquirs the bit for making a service type
  function ServiceCreator($newValues){
  $user = null;
  $serviceType = \Factory::getServiceTypeService()->addServiceType($newValues, $user);/*tells the code making the service type
                                                                                        what to input as the values for the new
										 	service type*/
echo($newValues);
}
?>
