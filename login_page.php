<?php
	function myFunction(string $userEmail = NULL, string $password = NULL) {
		// Validate function parameters
		if (is_null($userEmail) || is_null($password) || strlen($userEmail) == 0 || strlen($password) == 0){
			return NULL;
		}
		// Get connection credentials for integration user
		define("USERNAME", "tgodoyr.damm@everis.com");
		define("PASSWORD", "Tg28122019");
		define("SECURITY_TOKEN", "edQ9hwiWyF4rtuPciKEwnAOoZ");
		// Connect to Salesforce instance using PHP Toolkit
		require_once ('soapclient/SforceEnterpriseClient.php');
		$mySforceConnection = new SforceEnterpriseClient();
		$mySforceConnection->createConnection("/app/soapclient/enterprise.wsdl.xml");
		$mySforceConnection->login(USERNAME, PASSWORD.SECURITY_TOKEN);
		// Query Salesforce to get Username from email
		$query = "SELECT username FROM USER where email = '{$userEmail}' AND isActive = true";
		echo "query: {$query}";
		$queryResult = $mySforceConnection->query($query);
		
		if ($queryResult->records == NULL || count($queryResult->records) != 1) {
			return NULL;
		}
		
		$username = $queryResult->records[0]->fields->username;
		
		echo "Username: {$username} for email: {$userEmail}";
		// Get Oauth token for actual username & password
		
		
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
	
	myFunction('tania.godoy.rodriguez@everis.com', 'p4ssw0rd');
?>

