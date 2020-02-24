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
	<?php
		function myFunction() {
			define("USERNAME", "tgodoyr.damm@everis.com");
			define("PASSWORD", "Tg28122019");
			define("SECURITY_TOKEN", "edQ9hwiWyF4rtuPciKEwnAOoZ");

			require_once ('soapclient/SforceEnterpriseClient.php');
			echo $_POST["username"];
		}
		myFunction();
	?>

<button onclick="myFunction()">Get login info</button>
Welcome2 <?php echo $_POST["username"]; ?><br>
</body>    
</html>
