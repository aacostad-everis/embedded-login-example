<!DOCTYPE html>
<html lang="en">
<head>
    <!--<meta name="salesforce-community" content="https://<?php echo getenv('SALESFORCE_COMMUNITY_URL');?>">
	<meta name="salesforce-mode" content="<?php echo getenv('SALESFORCE_MODE');?>-callback">
	<meta name="salesforce-save-access-token" content="true">
	<meta name="salesforce-allowed-domains" content="<?php echo getenv('SALESFORCE_HEROKUAPP_URL');?>">
	<script src="https://<?php echo getenv('SALESFORCE_COMMUNITY_URL');?>/servlet/servlet.loginwidgetcontroller?type=javascript_widget" async defer></script>-->

</head> 
<body>
<button onclick="myFunction()">Get login info</button>

<p id="demo"></p>
	
	<script>
		function myFunction() {
			var x = "Welcome: ";  
			document.getElementById("demo").innerHTML = x;
			define("USERNAME", "user@example.com");
			define("PASSWORD", "password");
			define("SECURITY_TOKEN", "sdfhkjwrhgfwrgergp");

			require_once ('soapclient/SforceEnterpriseClient.php');

			$mySforceConnection = new SforceEnterpriseClient();
			$mySforceConnection->createConnection("enterprise.wsdl.xml");
			$mySforceConnection->login(USERNAME, PASSWORD.SECURITY_TOKEN);
			Welcome1 <?php echo $_POST["username"]; ?><br>
		}
	</script>

Welcome2 <?php echo $_POST["username"]; ?><br>
</body>    
</html>
