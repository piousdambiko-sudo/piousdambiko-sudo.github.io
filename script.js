// Toggle product details (Show More/Less functionality)
function toggleDetails(productId) {
    const detailsElement = document.getElementById(productId);
    
    if (detailsElement.style.display === "none") {
        detailsElement.style.display = "block";
    } else {
        detailsElement.style.display = "none";
    }
}

// Form validation function
function validateForm() {
    // Clear previous error messages
    clearErrors();
    
    let isValid = true;
    
    // Get form fields
    const name = document.getElementById('name').value.trim();
    const email = document.getElementById('email').value.trim();
    const subject = document.getElementById('subject').value.trim();
    const message = document.getElementById('message').value.trim();
    
    // Validate name
    if (name === '') {
        showError('name', 'Please enter your full name');
        isValid = false;
    } else if (name.length < 3) {
        showError('name', 'Name must be at least 3 characters long');
        isValid = false;
    }
    
    // Validate email
    if (email === '') {
        showError('email', 'Please enter your email address');
        isValid = false;
    } else if (!isValidEmail(email)) {
        showError('email', 'Please enter a valid email address');
        isValid = false;
    }
    
    // Validate subject
    if (subject === '') {
        showError('subject', 'Please enter a subject');
        isValid = false;
    } else if (subject.length < 5) {
        showError('subject', 'Subject must be at least 5 characters long');
        isValid = false;
    }
    
    // Validate message
    if (message === '') {
        showError('message', 'Please enter your message');
        isValid = false;
    } else if (message.length < 10) {
        showError('message', 'Message must be at least 10 characters long');
        isValid = false;
    }
    
    return isValid;
}

// Function to check if email is valid
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Function to show error message
function showError(fieldId, errorMessage) {
    const errorElement = document.getElementById(fieldId + '-error');
    const inputElement = document.getElementById(fieldId);
    
    if (errorElement) {
        errorElement.textContent = errorMessage;
        inputElement.classList.add('error');
    }
}

// Function to clear all error messages
function clearErrors() {
    const errorElements = document.querySelectorAll('.error-message');
    errorElements.forEach(function(element) {
        element.textContent = '';
    });
    
    const inputElements = document.querySelectorAll('input, textarea');
    inputElements.forEach(function(element) {
        element.classList.remove('error');
    });
}

// Real-time validation - remove error when user starts typing
document.addEventListener('DOMContentLoaded', function() {
    const formInputs = document.querySelectorAll('#contactForm input, #contactForm textarea');
    
    formInputs.forEach(function(input) {
        input.addEventListener('input', function() {
            const errorElement = document.getElementById(input.id + '-error');
            if (errorElement && errorElement.textContent !== '') {
                errorElement.textContent = '';
                input.classList.remove('error');
            }
        });
    });
});

// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});
