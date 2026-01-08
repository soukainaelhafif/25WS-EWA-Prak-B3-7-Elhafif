<?php
// Bestellseite
$title = 'Pizza-Service – Bestellung';
require __DIR__ . '/partials/head.php';
?>

<section class="page-card page-card--orderpage">

    <!-- ================= SPEISEKARTE ================= -->
    <h2 class="page-title">Speisekarte</h2>

    <form action="index.php" method="post" class="order-form">

        <div class="menu-row">
            <?php if (isset($data) && is_array($data)): ?>
                <?php foreach ($data as $article): ?>
                    <?php
                    $id      = (int)($article['article_id'] ?? 0);
                    $name    = (string)($article['name'] ?? '');
                    $price   = (float)($article['price'] ?? 0);
                    $picture = (string)($article['picture'] ?? 'pizza.png');

                    $imgSrc  = 'EWA_Framework/assets/images/' . $picture;
                    ?>
                    <label class="pizza-card card"
                           data-name="<?= htmlspecialchars($name) ?>"
                           data-price="<?= htmlspecialchars($price) ?>">
                        <img class="pizza-card__img"
                             src="<?= htmlspecialchars($imgSrc) ?>"
                             alt="<?= htmlspecialchars($name) ?>">

                        <div class="pizza-card__name">
                            <?= htmlspecialchars($name) ?>
                        </div>
                        <div class="pizza-card__price">
                            <?= htmlspecialchars(number_format($price, 2, ',', '.')) ?> €
                        </div>

                        <input type="radio"
                               name="pizza_id"
                               value="<?= $id ?>"
                               <?= $id === 1 ? 'checked' : '' ?>
                               required>
                    </label>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- ================= WARENKORB ================= -->
        <h2 class="page-title page-title--cart">Warenkorb</h2>

        <div class="cart-box">

            <div class="cart-left">
                <label for="address" class="cart__label">Adresse eingeben</label>
                <input type="text" id="address" name="address" class="cart__address" required>

                <textarea id="cart_text"
                          class="cart__items"
                          readonly></textarea>

                <div class="cart__total-row">
                    <span>Gesamtpreis:</span>
                    <input type="text"
                           id="cart_total"
                           class="cart__total"
                           name="cart_total"
                           value="0,00€"
                           readonly>
                </div>
            </div>

            <div class="cart-right">
                <label for="amount" class="cart__label">Anzahl</label>
                <select id="amount" name="amount" class="cart__select">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                </select>

                <button type="button" id="btnRemove" class="cart-btn cart-btn--remove">
                    🗑 Auswahl löschen
                </button>

                <button type="button" id="btnClear" class="cart-btn cart-btn--clear">
                    🗑 Alles löschen
                </button>

                <button type="submit" name="submit_order" id="btnOrder" class="cart-btn cart-btn--order">
                    ➜ Bestellen
                </button>
            </div>

        </div>

        <!-- JSON mit allen Pizzen im Warenkorb (optional für den Controller) -->
        <input type="hidden" name="cart_json" id="cart_json">
    </form>
</section>

<?php require __DIR__ . '/partials/footer.php'; ?>
