<?php

	function getUsernameForEmail(string $userEmail = NULL) {
		// Validate function parameters
		if (is_null($userEmail) || strlen($userEmail) == 0){
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
		$query = "SELECT username FROM USER where email = '{$userEmail}' AND isActive = true AND IsPortalEnabled = true";
		$queryResult = $mySforceConnection->query($query);
		// Close connection for integrated user
		$mySforceConnection->logout();
		// Get username from result
		if ($queryResult->records == NULL || count($queryResult->records) != 1) {
			return NULL;
		}
		$user = $queryResult->records[0];
		return $user->Username;
	}

	function loginUser(string $userEmail = NULL, string $password = NULL) {
		try {
			// Validate function parameters
			if (is_null($userEmail) || is_null($password) || strlen($userEmail) == 0 || strlen($password) == 0){
				return "{ \"ERROR\": \"Invalid parameters passed!\" }";
			}
			$username = getUsernameForEmail($userEmail);
			if ($username == NULL) {
				return "{ \"ERROR\": \"Could not find user!\" }";
			}
			// Get Oauth token for actual username & password
			$finalConnection = new SforceEnterpriseClient();
			$Options = array(
				'location'=> getenv('SALESFORCE_COMMUNITY_URL') . '/Soap/c/48.0/'
			);
			$finalConnection->createConnection("/app/soapclient/enterprise.wsdl.xml", $Options);
			$OrgId='00D5J000000nKmp';
			$SiteId=''; //'0DB5J0000004CLY';
			$finalConnection->setLoginScopeHeader(new LoginScopeHeader($OrgId, $SiteId));		
			$loginResult = $finalConnection->login($username, $password);
			return json_encode($loginResult);
		}
		catch (Exception $e) {
			return "{ \"ERROR\": \"{$e->getMessage()}\" }";
		}
	}

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	if (isset($_POST['username']) && $_POST['username'] && isset($_POST['password']) && $_POST['password']) {
		echo loginUser($_POST['username'], $_POST['password']);
	}
	else {
		echo "{ \"ERROR\": \"Invalid parameters passed!\" }";
	}
	
	echo loginUser('aacostad.everis@gmail.com', 'P4ssw0rd_3v3r1s');
?>

