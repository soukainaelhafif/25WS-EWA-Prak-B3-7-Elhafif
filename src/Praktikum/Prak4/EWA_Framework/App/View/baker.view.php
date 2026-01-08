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
            $formId = 'baker-form-' . $ordering_id;
            echo '<form id="' . $formId . '" action="baker.php" method="post" style="margin-bottom:18px;">';
            
            echo '<fieldset>';
            echo '<legend>Bestellung #' . htmlspecialchars((string)$ordering_id, ENT_QUOTES, 'UTF-8') .
                ' – Adresse: ' . htmlspecialchars((string)$pizzas[0]['address'], ENT_QUOTES, 'UTF-8') . '</legend>';


            foreach ($pizzas as $pizza) {
                $pizzaId = (int)$pizza['ordered_article_id'];
                $currentStatus = (int)$pizza['status'];

                echo '<p><strong>Pizza: ' . htmlspecialchars((string)$pizza['pizza_name'], ENT_QUOTES, 'UTF-8') .
                    '</strong> (Status: ' . htmlspecialchars((string)($statusText[$currentStatus] ?? 'Unbekannt'), ENT_QUOTES, 'UTF-8') . ')</p>';


                if ($currentStatus < 4) {
                    echo '<label><input type="radio" name="status_' . $pizzaId . '" value="2" ' .
                    ($currentStatus == 2 ? 'checked' : '') . 
                    ' onclick="document.forms[\'' . $formId . '\'].submit();"> Im Ofen</label> ';

                    echo '<label><input type="radio" name="status_' . $pizzaId . '" value="3" ' .
                    ($currentStatus == 3 ? 'checked' : '') . 
                    ' onclick="document.forms[\'' . $formId . '\'].submit();"> Fertig/Warte auf Fahrer</label>';

                    echo '<br><br>';
                } else {
                    echo '<p><em>Bereits beim Fahrer – keine Änderung durch den Bäcker möglich.</em></p>';
                }
            }

            // echo '<button type="submit">Status aktualisieren</button>';
            echo '</fieldset>';
            echo '</form>';
        }
    }
    ?>
</section>

<?php require __DIR__ . '/partials/footer.php'; ?>
