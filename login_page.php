<?php
	function myFunction(string $userEmail = NULL, string $password = NULL) {
		// Validate function parameters
		if (is_null($userEmail) || is_null($password) || strlen($userEmail) == 0 || strlen($password) == 0){
			return NULL;
		}
		// Get connection credentials for integration user
		$IntegrationUsername = getenv('SALESFORCE_INTEGRATION_USERNAME');
		$IntegrationPassword = getenv('SALESFORCE_INTEGRATION_PASSWORD');
		// Connect to Salesforce instance using PHP Toolkit
		require_once ('soapclient/SforceEnterpriseClient.php');
		$mySforceConnection = new SforceEnterpriseClient();
		$mySforceConnection->createConnection("/app/soapclient/enterprise.wsdl.xml");
		$mySforceConnection->login($IntegrationUsername, $IntegrationPassword);
		// Query Salesforce to get Username from email
		$query = "SELECT username FROM USER where email = '{$userEmail}' AND isActive = true";
		$queryResult = $mySforceConnection->query($query);
		// Close connection for integrated user
		$mySforceConnection->logout();
		// Get username from result
		if ($queryResult->records == NULL || count($queryResult->records) != 1) {
			return NULL;
		}
		$user = $queryResult->records[0];
		$username = $user->Username;
		// Get Oauth token for actual username & password
		$finalConnection = new SforceEnterpriseClient();
		
		$Options = array('location'=> getenv('SALESFORCE_COMMUNITY_URL') . '/Soap/c/48.0/');
		
		$finalConnection->createConnection("/app/soapclient/enterprise.wsdl.xml", $Options);
		$finalConnection->login($username, $password);
		
		
	}

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	if (isset($_POST['username']) && $_POST['username'] && isset($_POST['password']) && $_POST['password']) {
		myFunction($_POST['username'], $_POST['password']);
	}
	else {
		echo "ERROR Message";
	}
	
	myFunction('aacostad.everis@gmail.com', 'P4ssw0rd_3v3r1s');
?>

