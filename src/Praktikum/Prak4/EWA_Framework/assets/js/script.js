console.log("Script geladen!");

// 1 - Warenkorb (Array)
const cart = [];

// 2 - Funktion: Warenkorb im HTML anzeigen
function renderCart() {
    const cartList = document.getElementById("cart_list");
    const cartTotal = document.getElementById("cart_total");
    const cartJson = document.getElementById("cart_json");

    if (!cartList || !cartTotal) return;

    cartList.innerHTML = ""; // Liste leeren
    let total = 0;          // gesamtpreis startet bei 0

    cart.forEach(function(item, index) {
         const li = document.createElement("li");
        li.className = "cart-item";
        
        // Text erstellen
        const span = document.createElement("span");
        span.textContent = "1x " + item.name + " - " + item.price.toFixed(2) + "€";
        
        // Löschen-Button für DIESES Item
        const deleteBtn = document.createElement("button");
        deleteBtn.textContent = "X";
        deleteBtn.className = "cart-item__delete";
        deleteBtn.addEventListener("click", function() {
            removeItem(index);
        });
        
        // Zusammenbauen
        li.appendChild(span);
        li.appendChild(deleteBtn);
        cartList.appendChild(li);
        
        total += item.price;
    });

        cartTotal.value = total.toFixed(2).replace(".", ",") + "€";

    // JSON speichern für Controller
    if (cartJson) {
        cartJson.value = JSON.stringify(cart);
    }
    
    // Button aktualisieren
    updateOrderButton();
}

// 3 - Letzte Pizza entfernen
function removeItem(index) {
    cart.splice(index, 1);
    renderCart();
}

// Letzte Pizza entfernen
function removeLast() {
    if (cart.length > 0) {
        cart.pop();
        renderCart();
    }
}

// 4 - Alle Pizzen entfernen
function clearCart() {
    cart.length = 0;
    renderCart();
}

// 5 - Bestellknopf aktivieren/deaktivieren
function updateOrderButton() {
    const btnOrder = document.getElementById("btnOrder");
    const addressInput = document.getElementById("address");
    
    if (!btnOrder || !addressInput) return;
    
    const isEmpty = cart.length === 0;
    const noAddress = addressInput.value.trim() === "";
    
    btnOrder.disabled = (isEmpty || noAddress);
}

// 6 - Warten bis Seite geladen ist
document.addEventListener("DOMContentLoaded", () => {
    console.log("Seite ist bereit!");

    // 7 - Alle Pizza Karten finden
    const pizzaCards = document.querySelectorAll(".pizza-card");

    // 8 - Für jede Pizza-Karte: Klick Event hinzufügen
    pizzaCards.forEach(function(card) {
        card.addEventListener("click", function(event) {
            event.preventDefault();
            
            const name = card.dataset.name;
            const price = parseFloat(card.dataset.price);
            
            // Anzahl holen
            const amountSelect = document.getElementById("amount");
            const amount = amountSelect ? parseInt(amountSelect.value) : 1;
            
            // Pizzen hinzufügen
            for (let i = 0; i < amount; i++) {
                cart.push({
                    name: name,
                    price: price
                });
            }

            renderCart();
        });
    });

    // 9 - Löschen-Buttons
    const btnRemove = document.getElementById("btnRemove");
    const btnClear = document.getElementById("btnClear");

    if (btnRemove) {
        btnRemove.addEventListener("click", removeLast);
    }

    if (btnClear) {
        btnClear.addEventListener("click", clearCart);
    }

    // 10 - Adresse-Eingabe überwachen
    const addressInput = document.getElementById("address");
    if (addressInput) {
        addressInput.addEventListener("input", updateOrderButton);
    }

    // 11 - Button am Anfang prüfen
    updateOrderButton();
});