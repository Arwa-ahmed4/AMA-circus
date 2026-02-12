//  صفحة الدفع وإدخال اسماء الزوار

document.addEventListener("DOMContentLoaded", () => {
  let bookingData = JSON.parse(sessionStorage.getItem("currentBooking"));
  if (!bookingData) {
    window.location.href = "show bage.html";
    return;
  }

  const seatsContainer = document.getElementById("seatsNamesContainer");
  const confirmBtn = document.getElementById("confirmPay");

  //  عند الضغط على زر الدفع
  confirmBtn.addEventListener("click", (e) => {
    e.preventDefault();

    // إذا لم يتم الدفع سابقًا يتحقق من بيانات البطاقة أولًا
    if (!bookingData.paymentDone) {
      const card = document.getElementById("card").value.trim();
      const name = document.getElementById("name").value.trim();
      const cvv = document.getElementById("cvv").value.trim();
      const expiration = document.getElementById("expiration").value.trim();

      if (!card || !name || !cvv || !expiration) {
        alert("⚠️ Please complete payment details first!");
        return;
      }

      bookingData.paymentDone = true;
      sessionStorage.setItem("currentBooking", JSON.stringify(bookingData));

      
      generateSeatInputs();
      confirmBtn.textContent = "Confirm Ticket Names ✅";
    } else {
      saveSeatNamesAndGo();
    }
  });

 
  function generateSeatInputs() {
    seatsContainer.innerHTML = "<h3>🎟️ Ticket Holders</h3>";

    bookingData.seatNames = [];

    const seats = bookingData.selectedSeats || bookingData.seats || [];
    seats.forEach((seat, index) => {
      const div = document.createElement("div");
      div.innerHTML = `
        <label>Seat ${seat.label || seat} - Name</label>
        <input type="text" id="seatName_${index}" placeholder="Enter name" required>
      `;
      seatsContainer.appendChild(div);
    });
  }

  //  حفظ الأسماء والانتقال لصفحة التذاكر
  function saveSeatNamesAndGo() {
    const seats = bookingData.selectedSeats || bookingData.seats || [];
    bookingData.ticketHolders = [];

    let valid = true;

    seats.forEach((seat, index) => {
      const input = document.getElementById(`seatName_${index}`);
      if (!input || !input.value.trim()) valid = false;

      bookingData.ticketHolders.push({
        seat: seat.label || seat,
        name: input ? input.value.trim() : "Guest",
      });
    });

    if (!valid) {
      alert("⚠️ Please enter all ticket names!");
      return;
    }

    sessionStorage.setItem("currentBooking", JSON.stringify(bookingData));
    window.location.href = "project_ticket.html";
  }
});
