  document.addEventListener("DOMContentLoaded", () => {
  const bookingData = JSON.parse(sessionStorage.getItem("currentBooking"));
  const container = document.getElementById("ticketsContainer");

  if (!bookingData || !bookingData.ticketHolders) {
    window.location.href = "show bage.html";
    return;
  }

  const show = bookingData.show;
  const date = bookingData.date;
  const time = bookingData.time;
  const price = bookingData.price;

  //  إنشاء تذكرة مستقلة لكل زائر
  bookingData.ticketHolders.forEach((holder) => {
    const ticket = document.createElement("div");
    ticket.className = "ticket";
    ticket.innerHTML = `
      <div class="ticket-border">
        <h2>🎪 AMA CIRCUS TICKET 🎟️</h2>
        <table>
          <tr><th>👤 Visitor</th><td>${holder.name}</td></tr>
          <tr><th>💺 Seat</th><td>${holder.seat}</td></tr>
          <tr><th>🎭 Show</th><td>${show}</td></tr>
          <tr><th>📅 Date</th><td>${date}</td></tr>
          <tr><th>⏰ Time</th><td>${time}</td></tr>
          <tr><th>💰 Price</th><td>${price} Riyal</td></tr>
        </table>
      </div>
    `;
    container.appendChild(ticket);
  });
});
