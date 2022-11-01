<?php
  require "php/db-functions.php";
  $db_connection = connect_db("jp");
?>
<!DOCTYPE html>
<html lang="fi-FI">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Mustat Renkaat - Rengaskauppa</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Racing+Sans+One&family=Roboto&display=swap" rel="stylesheet"> 
    <link href="styles/style.css" rel="stylesheet" type="text/css">
    <script src="scripts/index.js" defer></script>
  </head>
  <body>
    <header>
      <a href=""><img src="images/logo_light.svg" alt="Mustat Renkaat"></a>
      <nav>
        <ul>
          <li><a href="">Rengashaku</a></li>
          <li><a href="help.html">Ohjeita</a></li>
          <li><a href="about.html">Tietoja</a></li>
        </ul>
      </nav>
    </header>
    <aside class="ad-left">
      <a href="">
        <img src="images/2cv.jpeg" alt="Värikäs auto sateenkaaren päässä pellolla metsän laidassa">
      </a>
    </aside>
    <aside class="ad-right">
      <a href="">
        <img src="images/Alpine.jpeg" alt="Sininen auto syksyisessä ruskan värisessä metsässä päällystetyllä tiellä">
      </a>
    </aside>
    <main id="search">
      <form method="get" id="filter-form">
        <fieldset>
          <legend>Valitse renkaan koko</legend>
          <ul>
            <?php
              $sizes = fetch_sizes($db_connection);
              foreach ($sizes as $size) {
                echo "<li><label><input type=\"checkbox\" name=\"size[]\" value=\"$size\"";
                if (isset($_GET["size"]) && in_array($size, $_GET["size"])) {
                  echo " checked=\"checked\"";
                }
                echo ">$size</label></li>";
              }
            ?>

          </ul>
        </fieldset>
        <noscript>
          <button>Hae renkaita</button>
        </noscript>
      </form>
      <header>
        <?php
          $tires = fetch_tires($db_connection);
          echo "<p>Renkaat (" . count($tires) . " kpl)</p>";
        ?>

        <select name="order" form="filter-form">
          <?php
            $order_options = [
              [
                "content" => "Rengasmerkki (A-Ö)",
                "attributes" => ["value" => "Merkki ASC", "selected" => False]
              ],
              [
                "content" => "Rengasmerkki (Ö-A)",
                "attributes" => ["value" => "Merkki DESC", "selected" => False]
              ],
              [
                "content" => "Hinta (Pienin-Suurin)",
                "attributes" => ["value" => "Hinta ASC", "selected" => False]
              ],
              [
                "content" => "Hinta (Suurin-Pienin)",
                "attributes" => ["value" => "Hinta DESC", "selected" => False]
              ],
            ];
            $selected = 0;
            if (isset($_GET["order"])) {
              $selected = array_search($_GET["order"], 
                array_column(array_column($order_options, "attributes"), "value"));
            }
            $order_options[$selected]["attributes"]["selected"] = True;
            foreach ($order_options as $option) {
              $content = $option["content"];
              $value = $option["attributes"]["value"];
              $selected = $option["attributes"]["selected"];
              echo "<option value=\"$value\"";
              if ($selected) {
                echo " selected=\"selected\"";
              }
              echo ">$content</option>";
            }
          ?>

        </select>
      </header>
      <ul>
        <?php
          foreach ($tires as $tire) {
            echo "<li><a href=\"\"><article>".
              "<h2>$tire[Merkki] $tire[Malli]</h2>".
              "<p>$tire[Tyyppi], $tire[Koko]</p>".
              "<p>$tire[Hinta] €</p>".
              "<p>Saatavuus: $tire[Saldo] kpl</p>".
              "</article></a></li>";
          }
        ?>
        
      </ul>
    </main>
    <footer>
      <address>
        Mustapään Auto Oy<br>
        Mustat Renkaat<br>
        Kosteenkatu 1, 86300 Oulainen<br>
        Puh. <a href="tel:+358407128158">040-7128158</a><br>
        email. <a href="mailto:myyntimies@mustatrenkaat.net">myyntimies@mustatrenkaat.net</a>
      </address>
    </footer>
  </body>
</html>