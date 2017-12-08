<!DOCTYPE html>
<html lang="nl">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title>Mobri | VD | Adres</title>

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
$page = "adres";
$nieuwAdres = new vdAdres();

// als adresID mee gegeven word
if(isset($_GET['adresID'])) {
	$nieuwAdres->adresID = clean_input($_GET['adresID']);
	$nieuwAdres->fillFromDB($conn);
}

// wanneer het formulier verzonden is
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// maak alle input schoon en stop in object
	$nieuwAdres->naam = clean_input($_POST["naam"]);
	$nieuwAdres->leeftijd = clean_input($_POST["leeftijd"]);
	$nieuwAdres->geslacht = clean_input($_POST["geslacht"]);
	$nieuwAdres->straat = clean_input($_POST["straat"]);
	$nieuwAdres->huisnummer = clean_input($_POST["huisnummer"]);
	$nieuwAdres->plaats = clean_input($_POST["plaats"]);
	$nieuwAdres->extra = clean_input($_POST["extra"]);
	$nieuwAdres->adresID = clean_input($_POST["adresID"]);


	// wanneer het gaat om een nieuw adres
	if($nieuwAdres->adresID == ""){
		$nieuwAdres -> addToDB($conn);
		$feedback = "<i class=\"fa fa-check-circle-o\" aria-hidden=\"true\"></i> Het onderstaande adres is aangemaakt.";
	} else {
		// wanneer het gaat om een update
		$nieuwAdres -> updateInDB($conn);
		$feedback = "<i class=\"fa fa-check-circle-o\" aria-hidden=\"true\"></i> Het onderstaande adres is geupdate.";
	}
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

	<div class="row">
		<div class="col-sm-6">
			<h1>Adres</h1>
		</div>
		<div class="col-sm-6">
			<?php if($nieuwAdres->adresID != ""){ ?>
			<a class="btn btn-danger pull-right" href="delete.php?adresID=<?php echo "$nieuwAdres->adresID"; ?> " role="button" onclick="return confirm('Weet je het zeker?')"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>
			<?php } ?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<form method="post" name="adresForm" id="adresForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >
			  <div class="form-group">
			    <label for="naam">Naam</label>
			    <input type="text" name="naam" class="form-control" id="naam" aria-describedby="naam" placeholder="Naam" value="<?php if($nieuwAdres->naam != ""){ echo $nieuwAdres->naam; } ?>">
			  </div>
				<div class="form-group">
			    <label for="leeftijd">Leeftijd</label>
			    <input type="text" name="leeftijd" class="form-control" id="leeftijd" aria-describedby="leeftijd" placeholder="Leeftijd" value="<?php if($nieuwAdres->leeftijd != ""){ echo $nieuwAdres->leeftijd; } ?>">
			  </div>
				<div class="form-group">
			    <label for="geslacht">Geslacht</label>
			    <select class="form-control" name="geslacht" id="geslacht">
						<option value="0" <?php if($nieuwAdres->geslacht == ""){ echo "selected"; } ?>>Onbekend</option>
						<option value="1" <?php if($nieuwAdres->geslacht == "1"){ echo "selected"; } ?>>Man</option>
			      <option value="2" <?php if($nieuwAdres->geslacht == "2"){ echo "selected"; } ?>>Vrouw</option>
			    </select>
			  </div>
				<div class="form-group">
			    <label for="straat">Straat</label>
			    <input type="text" name="straat" class="form-control" id="straat" aria-describedby="straat" placeholder="Straat" value="<?php if($nieuwAdres->straat != ""){ echo $nieuwAdres->straat; } ?>">
			  </div>
				<div class="form-group">
			    <label for="huisnummer">Huisnummer</label>
			    <input type="text" name="huisnummer" class="form-control" id="huisnummer" aria-describedby="huisnummer" placeholder="huisnummer" value="<?php if($nieuwAdres->huisnummer != ""){ echo $nieuwAdres->huisnummer; } ?>">
			  </div>
				<div class="form-group">
			    <label for="plaats">Plaats</label>
					<select class="form-control" name="plaats" id="plaats">
						<option value="" <?php if($nieuwAdres->plaats == ""){ echo "selected"; } ?>>Kies een plaats</option>
						<option value="Meppel" <?php if($nieuwAdres->plaats == "Meppel"){ echo "selected"; } ?>>Meppel</option>
						<option value="Steenwijk" <?php if($nieuwAdres->plaats == "Steenwijk"){ echo "selected"; } ?>>Steenwijk</option>
						<option value="Staphorst" <?php if($nieuwAdres->plaats == "Staphorst"){ echo "selected"; } ?>>Staphorst</option>
						<option value="IJhorst" <?php if($nieuwAdres->plaats == "IJhorst"){ echo "selected"; } ?>>IJhorst</option>
						<option value="Koekange" <?php if($nieuwAdres->plaats == "Koekange"){ echo "selected"; } ?>>Koekange</option>
						<option value="Nijeveen" <?php if($nieuwAdres->plaats == "Nijeveen"){ echo "selected"; } ?>>Nijeveen</option>
						<option value="Giethoorn" <?php if($nieuwAdres->plaats == "Giethoorn"){ echo "selected"; } ?>>Giethoorn</option>
						<option value="Wanneperveen" <?php if($nieuwAdres->plaats == "Wanneperveen"){ echo "selected"; } ?>>Wanneperveen</option>
						<option value="Ruinerwold" <?php if($nieuwAdres->plaats == "Ruinerwold"){ echo "selected"; } ?>>Ruinerwold</option>
						<option value="Giethoorn" <?php if($nieuwAdres->plaats == "Giethoorn"){ echo "selected"; } ?>>Giethoorn</option>
						<option value="De Wijk" <?php if($nieuwAdres->plaats == "De Wijk"){ echo "selected"; } ?>>De Wijk</option>
						<option value="Zwartsluis" <?php if($nieuwAdres->plaats == "Zwartsluis"){ echo "selected"; } ?>>Zwartsluis</option>
				 </select>
			  </div>
				<div class="form-group">
					<label for="extra">Extra</label>
			    <textarea name="extra" class="form-control" id="extra" rows="3" placeholder="Extra informatie"><?php if($nieuwAdres->extra != ""){ echo $nieuwAdres->extra; } ?></textarea>
			  </div>
				<div class="form-group">
					<input type="hidden" name="adresID" value="<?php if($nieuwAdres->adresID != ""){ echo $nieuwAdres->adresID; } ?>" />
			  	<button type="submit" class="btn col-xs-12 btn-primary"><?php if($nieuwAdres->adresID != ""){ echo "Updaten"; }else{ echo "Aanmaken"; } ?></button>
				</div>
			</form>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<h1>Nabezoeken voor dit adres</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<?php
				// maak het object aan voor de lijst
				$nieuwNabezoek = new vdNabezoek();
				$nieuwNabezoek->showRowAll($conn, "datum", "", $nieuwAdres->adresID);
			?>
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
