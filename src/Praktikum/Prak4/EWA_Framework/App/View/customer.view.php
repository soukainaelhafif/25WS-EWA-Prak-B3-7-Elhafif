<?php
$title = 'Status meiner Bestellungen';
require __DIR__ . '/partials/head.php';
?>

<!-- JavaScript NUR für diese Seite -->
<script src="EWA_Framework/assets/js/customer.js" defer></script>

<section class="page-card">
    <h2 class="page-title">Status meiner Bestellungen</h2>

    <!-- Dieser Container wird von JavaScript gefüllt -->
    <div id="order-status">
        <p>Lade Bestelldaten...</p>
    </div>
</section>

<?php require __DIR__ . '/partials/footer.php'; ?>