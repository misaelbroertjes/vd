<?php

// input schoonmaken
function clean_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

// een adres van een nabezoek
class vdAdres{
  // ieder adres heeft een uniek ID
  public $adresID = "";
  // persoonsinformatie
  // voor en achternaam
  public $naam = "";
  // (geschatte) leeftijd in jaren
  public $leeftijd = "";
  // geslacht (m of v)
  public $geslacht = "";
  // adres
  // straatnaam
  public $straat = "";
  // huisnummer en toevoegging
  public $huisnummer = "";
  // woonplaats
  public $plaats = "";
  // overig
  // extra informatie
  public $extra = "";


  function __construct($adresID = "", $naam = "", $leeftijd = "", $geslacht = "", $straat = "", $huisnummer = "", $plaats = "", $extra = ""){
    $this->adresID = $adresID;
    $this->naam = $naam;
    $this->leeftijd = $leeftijd;
    $this->geslacht = $geslacht;
    $this->straat = $straat;
    $this->huisnummer = $huisnummer;
    $this->plaats = $plaats;
    $this->extra = $extra;
  }

  public function fillFromDB($conn){
    $sql = "SELECT * FROM vdAdres WHERE adresID='$this->adresID'";
  	$result = $conn->query($sql);

  	if ($result->num_rows > 0) {
  	     // loop door de resultaten heen
  	    while($row = $result->fetch_assoc()) {
  				$this->naam = $row['naam'];
  				$this->leeftijd = $row['leeftijd'];
  				$this->geslacht = $row['geslacht'];
  				$this->straat = $row['straat'];
  				$this->huisnummer = $row['huisnummer'];
  				$this->plaats = $row['plaats'];
  				$this->extra = $row['extra'];
  	    }
  	} else {
  	    echo "0 results";
  	}
  }

  public function geslachtVoluit(){
    if($this->geslacht == 0){
      return "Onbekend";
    } else if($this->geslacht == 1){
      return "Man";
    } else {
      return "Vrouw";
    }
  }

  public function showAdres(){
    echo '<pre>';
    print_r($this);
    echo '</pre>';
  }

  public function showRow(){
    echo "<tr>
            <td>$this->naam</td>
            <td>$this->leeftijd</td>";
            echo "<td>" . $this->geslachtVoluit() . "</td>";
            echo "<td>$this->straat</td>
            <td>$this->huisnummer</td>
            <td>$this->plaats</td>
            <td>$this->extra</td>
            <td><a class=\"btn btn-primary btn-sm\" href=\"nabezoek.php?adresID=$this->adresID\" role=\"button\"><i class=\"fa fa-plus-circle\" aria-hidden=\"true\"></i> Nabezoek</a> <a class=\"btn btn-primary btn-sm\" href=\"adres.php?adresID=$this->adresID\" role=\"button\"><i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i> Info</a></td>
          </tr>";
  }

  public function showRowAll($conn, $orderBy = "", $desc = ""){
    // maak th aan
    echo '<table class="table table-striped table-hover">
       <thead class="thead-dark">
        <tr>
          <th scope="col">Naam</th>
          <th scope="col">Leeftijd</th>
          <th scope="col">Geslacht</th>
          <th scope="col">Straat</th>
          <th scope="col">Nummer</th>
          <th scope="col">Plaats</th>
          <th scope="col">Extra informatie</th>
          <th><a class="btn btn-success " href="adres.php" role="button"><i class="fa fa-plus-circle" aria-hidden="true"></i> Nieuw</a></th>
        </tr>
      </thead>
      <tbody>';

      // haal alle adressen op voor een overzicht
      if($orderBy != ""){
        $sql = "SELECT * FROM vdAdres ORDER BY $orderBy $desc";
      } else{
        $sql = "SELECT * FROM vdAdres $desc";
      }
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
          // loop door de resultaten heen
          while($row = $result->fetch_assoc()) {
            // voor elk resultaat stoppen we de waarde in het object
            $this->adresID = $row['adresID'];
            $this->naam = $row['naam'];
            $this->leeftijd = $row['leeftijd'];
            $this->geslacht = $row['geslacht'];
            $this->straat = $row['straat'];
            $this->huisnummer = $row['huisnummer'];
            $this->plaats = $row['plaats'];
            $this->extra = $row['extra'];

            // Maak een tabel van de gegevens
            $this->showRow();
          }
      } else {
          echo "0 results";
      }

      // sluit table af
      echo "</tbody></table>";
  }

  public function addToDB($conn){
    $sql = "INSERT INTO vdAdres (adresID, naam, leeftijd, geslacht, straat, huisnummer, plaats, extra)
    VALUES ('', '$this->naam', '$this->leeftijd', '$this->geslacht', '$this->straat', '$this->huisnummer', '$this->plaats', '$this->extra')";

    if ($conn->query($sql) === TRUE) {
        //echo "Nieuw adres aangemaakt";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }

  public function updateInDB($conn){
    $sql = "UPDATE vdAdres SET naam='$this->naam', leeftijd='$this->leeftijd', geslacht='$this->geslacht', straat='$this->straat', huisnummer='$this->huisnummer', plaats='$this->plaats', extra='$this->extra' WHERE adresID='$this->adresID'";

    if (mysqli_query($conn, $sql)) {
      //echo "Adres geupdate.";
    } else {
      echo "Error updating record: " . mysqli_error($conn);
    }
  }

  public function removeFromDB($conn){
    // verwijder een vdAdres en bijbehorende nabezoeken
    $sql = "DELETE vdAdres, vdNabezoek FROM vdAdres LEFT JOIN vdNabezoek ON vdAdres.adresID = vdNabezoek.adresID WHERE vdAdres.adresID='$this->adresID'";

    if ($conn->query($sql) === TRUE) {
        //echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
  }
}

// nabezoek voor elk nabezoek gebracht
class vdNabezoek{
  // ieder nabezoek heeft een uniek ID
  public $nabezoekID = "";
  // ieder nabezoek heeft adresID om te zien bij wie hij hoort
  public $adresID = "";
  // datum van het nabezoek zoals 29-12-1986
  public $datum = "";
  // op een half uur specifiek
  public $tijd = "";
  // wat hebben we verspreid
  public $publicatie = "";
  // gemaakte afspraak of plan voor volgende keer
  public $volgendeKeer = "";
  // Was de huisbewoner thuis of niet?
  public $thuis = "";
  // extra informatie zoals gewerkt met iemand of andere info
  public $extra = "";


  function __construct($nabezoekID = "", $adresID = "", $datum = "", $tijd = "", $publicatie = "", $volgendeKeer = "", $thuis = "", $extra = ""){
    $this->nabezoekID = $nabezoekID;
    $this->adresID = $adresID;
    $this->datum = $datum;
    $this->tijd = $tijd;
    $this->publicatie = $publicatie;
    $this->volgendeKeer = $volgendeKeer;
    $this->thuis = $thuis;
    $this->extra = $extra;
  }

  public function fillFromDB($conn){
    $sql = "SELECT * FROM vdNabezoek WHERE nabezoekID='$this->nabezoekID'";
  	$result = $conn->query($sql);

  	if ($result->num_rows > 0) {
  	    // loop door de resultaten heen
  	    while($row = $result->fetch_assoc()) {
  				$this->adresID = $row['adresID'];
  				$this->datum = $row['datum'];
  				$this->tijd = $row['tijd'];
  				$this->publicatie = $row['publicatie'];
  				$this->volgendeKeer = $row['volgendeKeer'];
          $this->thuis = $row['thuis'];
          $this->extra = $row['extra'];
  	    }
  	} else {
  	    echo "0 results";
  	}
  }

  public function thuisVoluit(){
    if($this->thuis == 0){
      return "Thuis";
    } else if($this->thuis == 1){
      return "Niet thuis";
    } else {
      return "In de bus";
    }
  }

  public function showNabezoek(){
    echo '<pre>';
    print_r($this);
    echo '</pre>';
  }

  public function showRow(){
    echo "<tr>
            <td>$this->datum</td>
            <td>$this->tijd</td>
            <td>$this->publicatie</td>
            <td>$this->volgendeKeer</td>";
    echo "<td>" . $this->thuisVoluit() . "</td>";
    echo "<td>$this->extra</td>
            <td><a class=\"btn btn-primary btn-sm\" href=\"nabezoek.php?nabezoekID=$this->nabezoekID\" role=\"button\"><i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i> Info</a></td>
          </tr>";
  }

  public function showRowAll($conn, $orderBy = "", $desc = ""){
    // maak th aan
    echo '<table class="table table-striped table-hover">
       <thead class="thead-dark">
        <tr>
          <th scope="col">Datum</th>
          <th scope="col">Tijd</th>
          <th scope="col">Publicatie</th>
          <th scope="col">Volgende keer</th>
          <th scope="col">Thuis</th>
          <th scope="col">Extra informatie</th>
          <th></th>
        </tr>
      </thead>
      <tbody>';

      // haal alle adressen op voor een overzicht
      if($orderBy != ""){
        $sql = "SELECT * FROM vdNabezoek ORDER BY $orderBy $desc";
      } else{
        $sql = "SELECT * FROM vdNabezoek $desc";
      }

      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
          // loop door de resultaten heen
          while($row = $result->fetch_assoc()) {
            // voor elk resultaat stoppen we de waarde in het object
            $this->adresID = $row['adresID'];
            $this->nabezoekID = $row['nabezoekID'];
            $this->datum = $row['datum'];
            $this->tijd = $row['tijd'];
            $this->publicatie = $row['publicatie'];
            $this->volgendeKeer = $row['volgendeKeer'];
            $this->thuis = $row['thuis'];
            $this->extra = $row['extra'];

            // Maak een tabel van de gegevens
            $this->showRow();
          }
      } else {
          echo "0 results";
      }

      // sluit table af
      echo "</tbody></table>";
  }

  public function addToDB($conn){
    $sql = "INSERT INTO vdNabezoek (nabezoekID, adresID, datum, tijd, publicatie, volgendeKeer, thuis, extra)
    VALUES ('', '$this->adresID', '$this->datum', '$this->tijd', '$this->publicatie', '$this->volgendeKeer', '$this->thuis', '$this->extra')";

    if ($conn->query($sql) === TRUE) {
        //echo "Nieuw adres aangemaakt";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }

  public function updateInDB($conn){
    $sql = "UPDATE vdNabezoek SET datum='$this->datum', tijd='$this->tijd', publicatie='$this->publicatie', volgendeKeer='$this->volgendeKeer', thuis='$this->thuis', extra='$this->extra' WHERE nabezoekID='$this->nabezoekID'";

    if (mysqli_query($conn, $sql)) {
      //echo "Adres geupdate.";
    } else {
      echo "Error updating record: " . mysqli_error($conn);
    }
  }

  public function removeFromDB($conn){
    // sql to delete a record
    $sql = "DELETE FROM vdNabezoek WHERE nabezoekID='$this->nabezoekID'";

    if ($conn->query($sql) === TRUE) {
        //echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
  }


}

?>
