<?php
$title = "Bestellung";
require_once("head.php");
?>
<main>
  <h2>Bestellung</h2>
  <form action="echo.php" method="post">
    <label for="name">Name:</label><br>
    <input type="text" id="name" name="name" required><br><br>

    <label for="pizza">Pizza:</label><br>
    <select id="pizza" name="pizza">
      <option>Margherita</option>
      <option>Salami</option>
      <option>Funghi</option>
    </select><br><br>

    <input type="submit" value="Bestellen">
  </form>
</main>
<?php require_once("footer.php"); ?>