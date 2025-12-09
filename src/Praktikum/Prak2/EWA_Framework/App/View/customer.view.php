<?php
$title = $title ?? 'Bestellstatus';
require __DIR__ . '/partials/head.php';
?>

<section class="page-card">
    <h2>Status meiner Bestellungen</h2>

    <?php
    // Daten nach Bestell-ID absteigend sortieren (neueste oben)
    if (!empty($data) && is_array($data)) {
        usort($data, function($a, $b) {
            return (int)($b['ordering_id'] ?? 0) <=> (int)($a['ordering_id'] ?? 0);
        });
    }
    ?>

    <table>
        <thead>
            <tr>
                <th>Best.-ID</th>
                <th>Pizzen</th>
                <th class="col-right">Anzahl</th>
                <th class="col-right">Gesamtpreis</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (empty($data)) {
                echo '<tr><td colspan="5">Keine Bestellungen vorhanden.</td></tr>';
            } else {
                foreach ($data as $order) {

                    $min = (int)($order['min_status'] ?? 0);
                    $max = (int)($order['max_status'] ?? 0);

                    $statusKey = ($min === $max) ? $min : 'mixed';

                    $statusText = match ($statusKey) {
                        1 => 'Bestellt',
                        2 => 'Im Ofen',
                        3 => 'Fertig/Wartet auf Fahrer',
                        4 => 'Unterwegs',
                        5 => 'Ausgeliefert',
                        'mixed' => 'In Bearbeitung (gemischt)',
                        default => 'Unbekannt'
                    };

                    echo '<tr>';
                    echo '<td>' . htmlspecialchars((string)($order['ordering_id'] ?? '')) . '</td>';
                    echo '<td>' . htmlspecialchars((string)($order['pizzas'] ?? '')) . '</td>';
                    echo '<td class="col-right">' . htmlspecialchars((string)($order['amount'] ?? '0')) . '</td>';
                    echo '<td class="col-right">' . htmlspecialchars(number_format((float)($order['total_price'] ?? 0), 2, ',', '.')) . ' €</td>';
                    echo '<td>' . htmlspecialchars($statusText) . '</td>';
                    echo '</tr>';
                }
            }
            ?>
        </tbody>
    </table>
</section>

<?php require __DIR__ . '/partials/footer.php'; ?>
