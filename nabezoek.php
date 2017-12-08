<!DOCTYPE html>
<html lang="nl">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title>Mobri | VD | Nabezoek</title>

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
$page = "nabezoek";
$nieuwNabezoek = new vdNabezoek();

// als nabezoekID mee gegeven word
if(isset($_GET['nabezoekID'])) {
	$nieuwNabezoek->nabezoekID = clean_input($_GET['nabezoekID']);
	$nieuwNabezoek->fillFromDB($conn);
} else if(isset($_GET['adresID'])) {
	$nieuwNabezoek->adresID = clean_input($_GET['adresID']);
} else {
	$feedback = "<i class=\"fa fa-exclamation-circle\" aria-hidden=\"true\"></i> Voor dit nabezoek is geen adres geselecteerd.";
	$feedbackType = 0;
}

// wanneer het formulier verzonden is
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// maak alle input schoon
	$nieuwNabezoek->nabezoekID = clean_input($_POST["nabezoekID"]);
	$nieuwNabezoek->adresID = clean_input($_POST["adresID"]);
	$nieuwNabezoek->datum = clean_input($_POST["datum"]);
	$nieuwNabezoek->tijd = clean_input($_POST["tijd"]);
	$nieuwNabezoek->publicatie = clean_input($_POST["publicatie"]);
	$nieuwNabezoek->volgendeKeer = clean_input($_POST["volgendeKeer"]);
	$nieuwNabezoek->thuis = clean_input($_POST["thuis"]);
	$nieuwNabezoek->extra = clean_input($_POST["extra"]);

	// wanneer het gaat om een nieuw adres
	if($nieuwNabezoek->nabezoekID == ""){
		$nieuwNabezoek -> addToDB($conn);
		//$nieuwNabezoek -> showNabezoek();
		$feedback = "<i class=\"fa fa-check-circle-o\" aria-hidden=\"true\"></i> Het onderstaande nabezoek is aangemaakt.";
		$feedbackType = 1;
	} else {
		// wanneer het gaat om een update
		$nieuwNabezoek -> updateInDB($conn);
		//$nieuwNabezoek -> showNabezoek();
		$feedback = "<i class=\"fa fa-check-circle-o\" aria-hidden=\"true\"></i> Het onderstaande nabezoek is geupdate.";
		$feedbackType = 1;
	}
}

require_once('includes/header.php');
?>

<div class="container">
	<!-- voegt de feedback toe wanneer van toepassing -->
	<?php if($feedback != ""){ ?>
	<div class="row">
		<div id="feedback" class="alert <?php if($feedbackType == "1"){ echo 'alert-success'; } else { echo 'alert-danger';} ?> col-sm-12 text-center" role="alert">
  		<?php echo $feedback; ?>
		</div>
	</div>
	<?php } ?>

	<div class="row">
		<div class="col-sm-6">
			<h1>Nabezoek</h1>
		</div>
		<div class="col-sm-6">
			<?php if($nieuwNabezoek->nabezoekID != ""){ ?>
			<a class="btn btn-danger pull-right" href="delete.php?nabezoekID=<?php echo "$nieuwNabezoek->nabezoekID"; ?> " role="button" onclick="return confirm('Weet je het zeker?')"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>
			<?php } ?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<form method="post" name="nabezoekForm" id="nabezoekForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >
			  <div class="form-group">
			    <label for="datum">Datum</label>
			    <input type="date" name="datum" class="form-control" id="datum" aria-describedby="datum" value="<?php if($nieuwNabezoek->datum != ""){ echo $nieuwNabezoek->datum; } ?>">
			  </div>
				<div class="form-group">
			    <label for="tijd">Tijd</label>
			    <input type="time" name="tijd" class="form-control" id="tijd" aria-describedby="tijd" placeholder="Tijd" value="<?php if($nieuwNabezoek->tijd != ""){ echo $nieuwNabezoek->tijd; } ?>">
			  </div>
				<div class="form-group">
			    <label for="publicatie">Publicatie</label>
			    <input type="text" name="publicatie" class="form-control" id="publicatie" aria-describedby="publicatie" placeholder="Publicatie" value="<?php if($nieuwNabezoek->publicatie != ""){ echo $nieuwNabezoek->publicatie; } ?>">
			  </div>
				<div class="form-group">
			    <label for="volgendeKeer">Volgende keer</label>
			    <textarea name="volgendeKeer" class="form-control" id="volgendeKeer" rows="3" placeholder="Volgende keer"><?php if($nieuwNabezoek->volgendeKeer != ""){ echo $nieuwNabezoek->volgendeKeer; } ?></textarea>
			  </div>
				<div class="form-group">
			    <label for="thuis">Thuis</label>
			    <select class="form-control" name="thuis" id="thuis">
						<option value="0" <?php if($nieuwNabezoek->thuis == ""){ echo "selected"; } ?>>Thuis</option>
						<option value="1" <?php if($nieuwNabezoek->thuis == "1"){ echo "selected"; } ?>>Niet thuis</option>
			      <option value="2" <?php if($nieuwNabezoek->thuis == "2"){ echo "selected"; } ?>>In de bus</option>
			    </select>
			  </div>
				<div class="form-group">
					<label for="extra">Extra</label>
			    <textarea name="extra" class="form-control" id="extra" rows="3" placeholder="Extra informatie"><?php if($nieuwNabezoek->extra != ""){ echo $nieuwNabezoek->extra; } ?></textarea>
			  </div>
				<div class="form-group">
					<input type="hidden" name="adresID" value="<?php if($nieuwNabezoek->adresID != ""){ echo $nieuwNabezoek->adresID; } ?>" />
					<input type="hidden" name="nabezoekID" value="<?php if($nieuwNabezoek->nabezoekID != ""){ echo $nieuwNabezoek->nabezoekID; } ?>" />
			  	<button type="submit" class="btn col-xs-12 btn-primary"><?php if($nieuwNabezoek->nabezoekID != ""){ echo "Updaten"; }else{ echo "Aanmaken"; } ?></button>
				</div>
			</form>
		</div>
	</div>
</div>

<?php
mysqli_close($conn);
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
</html>
