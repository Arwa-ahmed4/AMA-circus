// Seats Booking System for AMA Circus

let selectedSeats = [];
let currentShow = {
    name: '',
    date: '',
    time: '',
    price: 0
};

document.addEventListener('DOMContentLoaded', function() {
    loadShowInfo();
    generateSeats();
    updateSummary();
});

// Load show information 
function loadShowInfo() {
    const urlParams = new URLSearchParams(window.location.search);
    
    currentShow.name = urlParams.get('show') || 'Information of show';
    currentShow.date = urlParams.get('date') || '-';
    currentShow.time = urlParams.get('time') || '-';
    currentShow.price = parseInt(urlParams.get('price')) || 0;

    // Update display
    const showNameEl = document.getElementById('showName');
    const showDateEl = document.getElementById('showDate');
    const showTimeEl = document.getElementById('showTime');
    const showPriceEl = document.getElementById('showPrice');
    const pricePerSeatEl = document.getElementById('pricePerSeat');
    
    if (showNameEl) showNameEl.textContent = currentShow.name;
    if (showDateEl) showDateEl.textContent = currentShow.date;
    if (showTimeEl) showTimeEl.textContent = currentShow.time;
    if (showPriceEl) showPriceEl.textContent = currentShow.price;
    if (pricePerSeatEl) pricePerSeatEl.textContent = currentShow.price + ' Riyal';
}

// Generate seats grid - ALL SEATS AVAILABLE
function generateSeats() {
    const seatsGrid = document.getElementById('seatsGrid');
    if (!seatsGrid) return;
    
    const totalSeats = 80; // 8 rows x 10 columns
    seatsGrid.innerHTML = '';

    for (let i = 1; i <= totalSeats; i++) {
        createSeat(i, seatsGrid);
    }
}

// Create individual seat element
function createSeat(seatIndex, container) {
    const seat = document.createElement('div');
    seat.className = 'seat';
    seat.dataset.seatNumber = seatIndex;
    
    const row = String.fromCharCode(65 + Math.floor((seatIndex - 1) / 10)); 
    const seatNum = ((seatIndex - 1) % 10) + 1;
    const seatLabel = row + seatNum;
    
    seat.textContent = seatLabel;
    seat.classList.add('available');
    seat.dataset.seatLabel = seatLabel;
    
    seat.addEventListener('click', handleSeatClick);
    container.appendChild(seat);
}

// Handle seat click event
function handleSeatClick(event) {
    const seatElement = event.currentTarget;
    const seatNumber = seatElement.dataset.seatNumber;
    const seatLabel = seatElement.dataset.seatLabel;
    toggleSeat(seatNumber, seatLabel);
}

// Toggle seat selection
function toggleSeat(seatNumber, seatLabel) {
    const seat = document.querySelector('[data-seat-number="' + seatNumber + '"]');
    if (!seat) return;
    
    const seatIndex = findSeatIndex(seatNumber);

    if (seatIndex > -1) {
        // Deselect seat
        selectedSeats.splice(seatIndex, 1);
        seat.classList.remove('selected');
        seat.classList.add('available');
    } else {
        // Select seat
        selectedSeats.push({
            number: seatNumber,
            label: seatLabel
        });
        seat.classList.remove('available');
        seat.classList.add('selected');
    }

    updateSummary();
}

// Find seat index in selectedSeats array
function findSeatIndex(seatNumber) {
    for (let i = 0; i < selectedSeats.length; i++) {
        if (selectedSeats[i].number === seatNumber) {
            return i;
        }
    }
    return -1;
}

// Remove seat from selection
function removeSeat(seatNumber) {
    const seatIndex = findSeatIndex(seatNumber);
    
    if (seatIndex > -1) {
        selectedSeats.splice(seatIndex, 1);
        
        const seat = document.querySelector('[data-seat-number="' + seatNumber + '"]');
        if (seat) {
            seat.classList.remove('selected');
            seat.classList.add('available');
        }
        
        updateSummary();
    }
}

// Update booking summary
function updateSummary() {
    const seatCount = selectedSeats.length;
    const total = seatCount * currentShow.price;

    const seatCountEl = document.getElementById('seatCount');
    const totalAmountEl = document.getElementById('totalAmount');
    
    if (seatCountEl) seatCountEl.textContent = seatCount;
    if (totalAmountEl) totalAmountEl.textContent = total + ' Riyal';

    // Update selected seats list
    updateSelectedSeatsList(seatCount);
    
    // Enable/disable confirm button
    const confirmBtn = document.getElementById('confirmBtn');
    if (confirmBtn) {
        confirmBtn.disabled = seatCount === 0;
    }
}

// Update selected seats list display
function updateSelectedSeatsList(seatCount) {
    const selectedSeatsList = document.getElementById('selectedSeatsList');
    if (!selectedSeatsList) return;
    
    if (seatCount === 0) {
        selectedSeatsList.innerHTML = '<span style="color: #999;">No seats selected</span>';
    } else {
        let html = '';
        for (let i = 0; i < selectedSeats.length; i++) {
            const seat = selectedSeats[i];
            html += '<span class="seat-tag">' +
                seat.label +
                '<span class="remove" onclick="removeSeat(' + seat.number + ')">×</span>' +
                '</span>';
        }
        selectedSeatsList.innerHTML = html;
    }
}


function confirmBooking() {

    const bookingData = {
        show: currentShow.name,
        date: currentShow.date,
        time: currentShow.time,
        price: currentShow.price,
        seats: selectedSeats,
        totalSeats: selectedSeats.length,
        totalAmount: selectedSeats.length * currentShow.price
    };

    try {
        sessionStorage.setItem('currentBooking', JSON.stringify(bookingData));
    } catch (e) {
        console.error('Storage error:', e);
    }

    // Redirect to pay page
    window.location.href = 'project_pay.html';
}

// Attach confirm button event
const confirmBtn = document.getElementById('confirmBtn');
if (confirmBtn) {
    confirmBtn.addEventListener('click', confirmBooking);
}
