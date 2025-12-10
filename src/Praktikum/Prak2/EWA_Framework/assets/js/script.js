/* ===================== WARENKORB ===================== */

const cart = [];

// Preis formatiert (z.B. 8.57 -> 8,57€)
function formatPrice(price) {
    return price.toFixed(2).replace('.', ',') + '€';
}

// Warenkorb neu anzeigen
function renderCart() {
    const text  = document.getElementById('cart_text');
    const total = document.getElementById('cart_total');
    const json  = document.getElementById('cart_json');

    if (!text || !total || !json) return;

    let sum = 0;

    const lines = cart.map(item => {
        const line = item.price * item.amount;
        sum += line;
        return `+ ${item.amount}x ${item.name} - ${formatPrice(line)}`;
    });

    text.value  = lines.join("\n");
    total.value = formatPrice(sum);

    // WICHTIG: jetzt mit id, name, price, amount
    json.value = JSON.stringify(cart);
}

// Pizza hinzufügen
function addSelectedPizzaToCart() {
    const selected      = document.querySelector('input[name="pizza_id"]:checked');
    const amountSelect  = document.getElementById('amount');

    if (!selected) return;

    const card = selected.closest('.pizza-card');
    if (!card) return;

    const id     = parseInt(selected.value, 10);      // <-- article_id aus dem Radio
    const name   = card.dataset.name;
    const price  = parseFloat(card.dataset.price);
    const amount = parseInt(amountSelect.value) || 1;

    cart.push({ id, name, price, amount });
    renderCart();
}

// letzte Bestellung entfernen
function removeLast() {
    cart.pop();
    renderCart();
}

// alles entfernen
function clearCart() {
    cart.length = 0;
    renderCart();
}

// Events aktivieren
window.addEventListener('DOMContentLoaded', () => {

    // Klick auf Pizza
    document.querySelectorAll('.pizza-card').forEach(card => {
        card.addEventListener('click', () => addSelectedPizzaToCart());
    });

    // Buttons
    const btnR = document.getElementById('btnRemove');
    const btnC = document.getElementById('btnClear');

    if (btnR) btnR.addEventListener('click', removeLast);
    if (btnC) btnC.addEventListener('click', clearCart);

    renderCart();
});
