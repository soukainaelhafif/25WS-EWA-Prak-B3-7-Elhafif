<?php
$title = $title ?? 'Fahreransicht';
require __DIR__ . '/partials/head.php';
?>

<section class="page-card">
    <h2>Fahrer-Ansicht: Auslieferung</h2>

    <?php
    if (empty($data)) {
        echo '<p>Derzeit keine Bestellungen zur Auslieferung bereit.</p>';
    } else {
        foreach ($data as $order) {
            $orderingId = (int)($order['ordering_id'] ?? 0);

            $formId = 'driver-form-' . $orderingId;
            echo '<form id="' . $formId . '" action="driver.php" method="post" style="margin-bottom:18px;">';

            echo '<fieldset>';
            echo '<legend>Auslieferung #' . htmlspecialchars((string)$orderingId, ENT_QUOTES, 'UTF-8') .
            ' - Adresse: ' . htmlspecialchars((string)($order['address'] ?? ''), ENT_QUOTES, 'UTF-8') . '</legend>';

            echo '<p>Enthält: ' . htmlspecialchars((string)($order['articles'] ?? ''), ENT_QUOTES, 'UTF-8') . '</p>';

            $total = (float)($order['total_price'] ?? 0);
            echo '<p>Gesamtpreis: ' . htmlspecialchars(number_format($total, 2, ',', '.'), ENT_QUOTES, 'UTF-8') . ' €</p>';


            echo '<label><input type="radio" name="status_' . $orderingId . '" value="4"' .
                ' onclick="document.forms[\'' . $formId . '\'].submit();"> Unterwegs</label> ';
            echo '<label><input type="radio" name="status_' . $orderingId . '" value="5"' .
                ' onclick="document.forms[\'' . $formId . '\'].submit();"> Ausgeliefert (Zum Löschen)</label>';

            // echo '<br><br><button type="submit">Status aktualisieren</button>';
            echo '</fieldset>';
            echo '</form>';
        }
    }
    ?>
</section>

<?php require __DIR__ . '/partials/footer.php'; ?>
