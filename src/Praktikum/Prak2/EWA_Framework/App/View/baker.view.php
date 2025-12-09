<?php
$title = $title ?? 'Bäckeransicht';
require __DIR__ . '/partials/head.php';
?>

<section class="page-card">
    <h2>Bäcker-Ansicht: Bestellungen bearbeiten</h2>

    <?php
    if (empty($data)) {
        echo '<p>Derzeit keine offenen Pizzen zum Bearbeiten.</p>';
    } else {
        $statusText = [
            1 => 'Bestellt',
            2 => 'Im Ofen',
            3 => 'Fertig/Wartet auf Fahrer',
            4 => 'Unterwegs',
            5 => 'Ausgeliefert'
        ];

        $groupedOrders = [];
        foreach ($data as $pizza) {
            $groupedOrders[$pizza['ordering_id']][] = $pizza;
        }

        foreach ($groupedOrders as $ordering_id => $pizzas) {
            echo '<form action="baker.php" method="post" style="margin-bottom:18px;">';
            echo '<fieldset>';
            echo '<legend>Bestellung #' . htmlspecialchars($ordering_id) .
                ' – Adresse: ' . htmlspecialchars($pizzas[0]['address']) . '</legend>';

            foreach ($pizzas as $pizza) {
                $pizzaId = (int)$pizza['ordered_article_id'];
                $currentStatus = (int)$pizza['status'];

                echo '<p><strong>Pizza: ' . htmlspecialchars($pizza['pizza_name']) .
                    '</strong> (Status: ' . htmlspecialchars($statusText[$currentStatus] ?? 'Unbekannt') . ')</p>';

                if ($currentStatus < 4) {
                    echo '<label><input type="radio" name="status_' . $pizzaId . '" value="2" ' .
                        ($currentStatus == 2 ? 'checked' : '') . ' required> Im Ofen</label> ';

                    echo '<label><input type="radio" name="status_' . $pizzaId . '" value="3" ' .
                        ($currentStatus == 3 ? 'checked' : '') . ' required> Fertig/Warte auf Fahrer</label>';

                    echo '<br><br>';
                } else {
                    echo '<p><em>Bereits beim Fahrer – keine Änderung durch den Bäcker möglich.</em></p>';
                }
            }

            echo '<button type="submit">Status aktualisieren</button>';
            echo '</fieldset>';
            echo '</form>';
        }
    }
    ?>
</section>

<?php require __DIR__ . '/partials/footer.php'; ?>
