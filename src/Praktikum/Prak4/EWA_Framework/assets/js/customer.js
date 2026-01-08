console.log("Customer.js geladen!");

// 1 - Daten vom Server holen
async function requestData() {
    try {
        const response = await fetch("status-api.php");

        if (!response.ok) {
            throw new Error("Fehler: " + response.status);
        }

        const data = await response.json();
        process(data);
    } catch (error) {
        console.error("Übertragung fehlgeschlagen:", error);
    }
}

// 2 - Daten verarbeiten und anzeigen
function process(data) {
    console.log("Daten erhalten:", data);
    
    const container = document.getElementById("order-status");
    if (!container) return;
    
    if (!data || data.length === 0) {
        container.innerHTML = "<p>Sie haben noch keine Bestellung in dieser Session aufgegeben.</p>";
        return;
    }
    
    const statusText = {
        1: "Bestellt",
        2: "Im Ofen",
        3: "Fertig",
        4: "Unterwegs",
        5: "Ausgeliefert"
    };
    
    let html = "<table><thead><tr>";
    html += "<th>Best-ID</th>";
    html += "<th>Pizzen</th>";
    html += "<th>Anzahl</th>";
    html += "<th>Gesamtpreis</th>";
    html += "<th>Status</th>";
    html += "</tr></thead><tbody>";
    
    data.forEach(function(order) {
        let status;
        if (order.min_status === order.max_status) {
            status = statusText[order.min_status] || "Unbekannt";
        } else {
            status = "Gemischt";
        }
        
        const price = parseFloat(order.total_price).toFixed(2).replace(".", ",") + " €";
        
        html += "<tr>";
        html += "<td>" + order.ordering_id + "</td>";
        html += "<td>" + order.pizzas + "</td>";
        html += "<td>" + order.amount + "</td>";
        html += "<td>" + price + "</td>";
        html += "<td>" + status + "</td>";
        html += "</tr>";
    });
    
    html += "</tbody></table>";
    container.innerHTML = html;
}

// 3 - Polling starten
document.addEventListener("DOMContentLoaded", function() {
    console.log("Starte Polling...");
    requestData();
    setInterval(requestData, 2000);
});