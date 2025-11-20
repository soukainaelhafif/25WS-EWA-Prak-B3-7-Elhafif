<?php
$title = "Fahrer";
require_once("head.php");
?>
<main>
  <h2>Fahrer-Übersicht</h2>
  <p>Hier sieht der Fahrer, welche Bestellungen ausgeliefert werden müssen.</p>
  <form action="echo.php" method="post">
    <input type="submit" value="Lieferung starten">
  </form>
</main>
<?php require_once("footer.php"); ?>