<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Mobri | VD | Home</title>

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

$page = "home";
require_once('includes/header.php');
?>

<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h1>Adressen overzicht</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <form name="adresFilterForm" id="adresFilterForm">
                <div class="form-group">
                    <select class="form-control" name="plaats" id="plaats">
                        <option value="">Kies een plaats</option>
                        <option value="Meppel">Meppel</option>
                        <option value="Steenwijk">Steenwijk</option>
                        <option value="Staphorst">Staphorst</option>
                        <option value="IJhorst">IJhorst</option>
                        <option value="Koekange">Koekange</option>
                        <option value="Nijeveen">Nijeveen</option>
                        <option value="Giethoorn">Giethoorn</option>
                        <option value="Wanneperveen">Wanneperveen</option>
                        <option value="Ruinerwold">Ruinerwold</option>
                        <option value="Giethoorn">Giethoorn</option>
                        <option value="De Wijk">De Wijk</option>
                        <option value="Zwartsluis">Zwartsluis</option>
                    </select>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
			<?php
			// maak het object aan voor de lijst
			$nieuwAdres = new vdAdres();
			$nieuwAdres->showRowAll($conn, "plaats");
			?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <h1>Nabezoeken overzicht</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
			<?php
			// maak het object aan voor de lijst
			$nieuwNabezoek = new vdNabezoek();
			$nieuwNabezoek->showRowAll($conn, "datum", "", "");
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
