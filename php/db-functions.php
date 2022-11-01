<?php
  function connect_db($dbname) {
    try {
      return new PDO("mysql:host=localhost;dbname=$dbname", "root", "",
        array(PDO::ATTR_PERSISTENT => true));
    } catch (PDOException $e) {
      print "Error!: {$e->getMessage()}<br>";
      die();
    }
  }

  function fetch_sizes($dbh) {
    $sth = $dbh->query("SELECT DISTINCT Koko FROM renkaat ORDER BY Koko");
    return $sth->fetchAll(PDO::FETCH_COLUMN);
  }

  function fetch_tires($dbh)
  {
    $sql = "SELECT Merkki, Malli, Tyyppi, Koko, Hinta, Saldo FROM renkaat";
    
    $selected_sizes = $_GET["size"] ?? NULL;
    if ($selected_sizes) {
      $sql .= " where Koko = ?";
      for($i = 1, $count = count($selected_sizes); $i < $count; ++$i) {
        $sql .= " OR Koko = ?";
      }
    }

    $sql .= " ORDER BY " . ($_GET["order"] ?? "Merkki") .
      ", Malli, Koko, Tyyppi, Saldo DESC";
    
    $sth = $dbh->prepare($sql);
    $sth->execute($selected_sizes);

    return $sth->fetchAll(PDO::FETCH_ASSOC);
  }