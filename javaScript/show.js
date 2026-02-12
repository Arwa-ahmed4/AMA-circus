let selectedShow = null;

document.addEventListener('DOMContentLoaded', function() {
    const isFreshLoad = sessionStorage.getItem('pageFreshLoad') === null;
    
    if (isFreshLoad) {
        localStorage.removeItem('selectedShow');
        sessionStorage.setItem('pageFreshLoad', 'true');
    }
    
    loadSelectedShow();
    updateDisplay();
    
    // Add event listeners to all cards
    document.querySelectorAll('.card-label').forEach(card => {
        const button = card.querySelector('.buy-ticket-button');
        
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            selectShow(card);
        });
        
        // Also allow clicking the card itself
        card.addEventListener('click', function(e) {
            if (!e.target.closest('.buy-ticket-button')) {
                selectShow(card);
            }
        });
    });
    
    // Date filter 
    const dateInput = document.getElementById('date');
    if (dateInput) {
        dateInput.addEventListener('change', filterShowsByDate);
    }
    
    // Confirm Selection button
    const confirmBtn = document.getElementById('confirmSelectionBtn');
    if (confirmBtn) {
        confirmBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            if (!selectedShow) {
                alert('⚠️ Please select a show first!');
                return;
            }
            
            // Save to localStorage
            localStorage.setItem('selectedShow', JSON.stringify(selectedShow));
            
            // Redirect to seats booking page
            window.location.href = `seats-booking.html?show=${encodeURIComponent(selectedShow.name)}
            &date=${encodeURIComponent(selectedShow.date)}&time=${encodeURIComponent(selectedShow.time)}&price=${selectedShow.price}`;
        });
    }
});

// Select a single show
function selectShow(card) {
    const showData = {
        name: card.dataset.show,
        date: card.dataset.date,
        time: card.dataset.time,
        price: parseInt(card.dataset.price)
    };
    
    // If clicking the same show again, deselect it
    if (selectedShow && 
        selectedShow.name === showData.name && 
        selectedShow.date === showData.date && 
        selectedShow.time === showData.time) {
        deselectAllShows();
        selectedShow = null;
        localStorage.removeItem('selectedShow');
    } else {
        // Deselect all first, then select the new one
        deselectAllShows();
        selectedShow = showData;
        card.classList.add('selected');
        card.querySelector('.buy-ticket-button').innerHTML = '<strong>Selected ✓</strong>';
        localStorage.setItem('selectedShow', JSON.stringify(selectedShow));
    }
    
    updateDisplay();
}

// Deselect all shows
function deselectAllShows() {
    document.querySelectorAll('.card-label').forEach(card => {
        card.classList.remove('selected');
        card.querySelector('.buy-ticket-button').innerHTML = '<strong>Buy Ticket</strong>';
    });
}

// Load selected show from localStorage
function loadSelectedShow() {
    const saved = localStorage.getItem('selectedShow');
    if (saved) {
        selectedShow = JSON.parse(saved);
        
        document.querySelectorAll('.card-label').forEach(card => {
            const showData = {
                name: card.dataset.show,
                date: card.dataset.date,
                time: card.dataset.time
            };
            
            if (selectedShow && 
                selectedShow.name === showData.name && 
                selectedShow.date === showData.date && 
                selectedShow.time === showData.time) {
                card.classList.add('selected');
                card.querySelector('.buy-ticket-button').innerHTML = '<strong>Selected ✓</strong>';
            }
        });
    }
}

function updateDisplay() {
    const confirmBtn = document.getElementById('confirmSelectionBtn');
    
    if (confirmBtn) {
        if (selectedShow) {
            confirmBtn.style.display = 'inline-block';
        } else {
            confirmBtn.style.display = 'none';
        }
    }
}

// Filter shows by date
function filterShowsByDate() {
    const selectedDate = document.getElementById('date').value;
    const cards = document.querySelectorAll('.card-label');
    
    if (!selectedDate) {
        // Show all cards if no date selected
        cards.forEach(card => {
            card.style.display = 'block';
        });
        return;
    }
    
    // Convert selected date to match the format in data attributes
    const selectedDateObj = new Date(selectedDate);
    const monthNames = ['January', 'February', 'March', 'April', 'May', 'June',
                       'July', 'August', 'September', 'October', 'November', 'December'];
    
    const selectedMonth = monthNames[selectedDateObj.getMonth()];
    const selectedDay = selectedDateObj.getDate();
    
    cards.forEach(card => {
        const cardDate = card.dataset.date;
        // Check if card date matches selected date
        if (cardDate.includes(selectedMonth) && cardDate.includes(selectedDay)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}

window.addEventListener('beforeunload', function() {
    sessionStorage.removeItem('pageFreshLoad');
});
