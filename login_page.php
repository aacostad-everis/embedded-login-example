<?php
	function myFunction() {
		define("USERNAME", "tgodoyr.damm@everis.com");
		define("PASSWORD", "Tg28122019");
		define("SECURITY_TOKEN", "edQ9hwiWyF4rtuPciKEwnAOoZ");
		
		echo "Before importing";
		
		require_once ('soapclient/SforceEnterpriseClient.php');
		
		echo "Before creating instance";
		
		$mySforceConnection = new SforceEnterpriseClient();
		$mySforceConnection->createConnection("/app/soapclient/enterprise.wsdl.xml");
	
		echo "Before login";
		
		$mySforceConnection->login(USERNAME, PASSWORD.SECURITY_TOKEN);
		
		echo "after login";
		
		echo $mySforceConnection->sessionId;
	}

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	if (isset($_POST['username']) && $_POST['username'] && isset($_POST['password']) && $_POST['password']) {
		
	}
	
	myFunction();
?>

