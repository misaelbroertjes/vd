<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Mobri | VD | Delete</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">

    <!-- Optional Bootstrap theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- None bootstrap -->
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Montserrat|Open+Sans" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script src="js/scripts.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<?php
require_once('includes/dbconnect.php');
require_once('includes/classes.php');
$feedback = "";
$page = "delete";

// als adresID mee gegeven word
if(isset($_GET['adresID'])) {
	$adresID = clean_input($_GET['adresID']);
	
	// maak het object aan met de ontvangen gegevens
	$nieuwAdres = new vdAdres($adresID);
	$nieuwAdres -> removeFromDB($conn);
	$feedback = "<i class=\"fa fa-check-circle-o\" aria-hidden=\"true\"></i> Het adres is verwijderd.";
}

// als nabezoekID mee gegeven word
if(isset($_GET['nabezoekID'])) {
	$nabezoekID = clean_input($_GET['nabezoekID']);
	
	// maak het object aan met de ontvangen gegevens
	$nieuwNabezoek = new vdNabezoek($nabezoekID);
	$nieuwNabezoek -> removeFromDB($conn);
	$feedback = "<i class=\"fa fa-check-circle-o\" aria-hidden=\"true\"></i> Het nabezoek is verwijderd.";
}

require_once('includes/header.php');
?>

<div class="container">
    <!-- voegt de feedback toe wanneer van toepassing -->
	<?php if($feedback != ""){ ?>
    <div class="row">
        <div id="feedback" class="alert alert-success col-sm-12 text-center" role="alert">
            <?php echo $feedback; ?>
        </div>
    </div>
	<?php } ?>
</div>
<?php
mysqli_close($conn);
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
</html>