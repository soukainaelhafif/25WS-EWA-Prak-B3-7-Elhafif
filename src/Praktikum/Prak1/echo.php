<?php
$title = "Bestellbestätigung";
require_once("head.php");
?>

<main>
  <h2>Bestellbestätigung</h2>

  <?php 
    // Formulardaten abholen
    $name = $_POST['name'] ?? '';
    $pizzas = $_POST['pizza'] ?? [];

    // Falls nur eine Pizza gewählt → in Array umwandeln
    if (!is_array($pizzas)) {
        $pizzas = [$pizzas];
    }
  ?>

  <!-- Bestellung anzeigen -->
  <?php if (!empty($name) && !empty($pizzas)): ?>
      <p>Danke, <?php echo htmlspecialchars($name); ?>!</p>

      <p>Du hast folgende Pizza(s) bestellt:</p>
      <ul>
        <?php foreach ($pizzas as $pizza): ?>
            <li><?php echo htmlspecialchars($pizza); ?></li>
        <?php endforeach; ?>
      </ul>
  <?php endif; ?>

  <!-- Bäcker-Status -->
  <?php if (!empty($_POST['pizza_status'])): ?>
      <p><strong>Pizza-Status vom Bäcker:</strong>
        <?php echo htmlspecialchars($_POST['pizza_status']); ?>
      </p>
  <?php endif; ?>

  <!-- Fahrer-Status -->
  <?php if (!empty($_POST['delivery_status'])): ?>
      <p><strong>Lieferstatus vom Fahrer:</strong>
        <?php echo htmlspecialchars($_POST['delivery_status']); ?>
      </p>
  <?php endif; ?>

  <!-- Wenn gar nichts übermittelt wurde -->
  <?php if (empty($name) && empty($_POST['pizza_status']) && empty($_POST['delivery_status'])): ?>
      <p>Es wurden keine Bestelldaten übermittelt.</p>
  <?php endif; ?>

</main>

<?php require_once("footer.php"); ?>