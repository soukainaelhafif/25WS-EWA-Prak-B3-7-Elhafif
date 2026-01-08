<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$title = 'Übersicht – Pizza Service';
require __DIR__ . '/EWA_Framework/App/View/partials/head.php';
?>

<section class="page-card">
    <h2>Übersicht</h2>
    <p>Willkommen beim Pizza-Service. Über die Navigation oben kannst du:</p>
    <ul>
        <li><strong>Bestellen</strong> – Neue Pizza-Bestellung aufgeben</li>
        <li><strong>Kunde</strong> – Status deiner letzten Bestellung ansehen</li>
        <li><strong>Bäcker</strong> – Bestellungen im Ofen / fertig markieren</li>
        <li><strong>Fahrer</strong> – Bestellungen ausliefern</li>
    </ul>
</section>

<?php require __DIR__ . '/EWA_Framework/App/View/partials/footer.php'; ?>
