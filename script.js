document.getElementById('registrationForm').addEventListener('submit', function(event) {
    const phone = document.getElementById('phone').value;
    const fullname = document.getElementById('fullname').value;
    const errorMessage = document.getElementById('error-message');
    
    errorMessage.textContent = '';

    // Simple validation: Check if phone number is filled with text
    if (isNaN(phone)) {
        event.preventDefault(); // Prevent form submission
        errorMessage.textContent = 'Invalid phone number. Please enter a valid number.';
        return;
    }

    // Optional: Additional validation can be added here
});