<?php
	
	class loginResult {
		public bool $loggedIn;
		public $resultData;
		
		function __construct(bool $logged, $result) {
			$this->loggedIn = $logged;
			$this->resultData = $result;
		}
	}

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
		$loginResult = new loginResult(false, "User not logged in.");
		try {
			// Validate function parameters
			if (is_null($userEmail) || is_null($password) || strlen($userEmail) == 0 || strlen($password) == 0){
				$loginResult->resultData = "Invalid parameters passed.";
				return json_encode($loginResult);
			}
			$username = getUsernameForEmail($userEmail);
			if ($username == NULL) {
				$loginResult->resultData = "Could not find user.";
				return json_encode($loginResult);
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
			$calloutResult = $finalConnection->login($username, $password);
			
			$loginResult->loggedIn = true;
			$loginResult->resultData = $calloutResult;
			
			return json_encode($loginResult);
		}
		catch (Exception $e) {
			$loginResult->resultData = $e->getMessage();
			return json_encode($loginResult);
		}
	}

	if (isset($_POST['username']) && $_POST['username'] && isset($_POST['password']) && $_POST['password']) {
		echo loginUser($_POST['username'], $_POST['password']);
	}
	else {
		echo json_encode(new loginResult(false, "Incorrect parameters provided."));
	}
?>

