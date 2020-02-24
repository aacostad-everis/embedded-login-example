<!DOCTYPE html>
<html lang="en">
<head>
    <!--<meta name="salesforce-community" content="https://<?php echo getenv('SALESFORCE_COMMUNITY_URL');?>">
	<meta name="salesforce-mode" content="<?php echo getenv('SALESFORCE_MODE');?>-callback">
	<meta name="salesforce-save-access-token" content="true">
	<meta name="salesforce-allowed-domains" content="<?php echo getenv('SALESFORCE_HEROKUAPP_URL');?>">
	<script src="https://<?php echo getenv('SALESFORCE_COMMUNITY_URL');?>/servlet/servlet.loginwidgetcontroller?type=javascript_widget" async defer></script>-->
	<button onclick="myFunction()">Get login info</button>
	
	<p id="demo"></p>
	
	<script>
		function myFunction() {
			var x = "Welcome: " + <?php echo $_POST["username"]; ?> + location.hash;  
 		 	document.getElementById("demo").innerHTML = x;
		}
	</script>
</head> 
<body></body>    
</html>
