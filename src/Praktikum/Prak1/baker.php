<?php
$title = "Bäcker";
require_once("head.php");
?>
<main>
  <h2>Bäcker-Übersicht</h2>
  <p>Hier sieht der Bäcker, welche Pizzen er backen muss.</p>
  <form action="echo.php" method="post">
    <input type="submit" value="Daten abrufen">
  </form>
</main>
<?php require_once("footer.php"); ?>