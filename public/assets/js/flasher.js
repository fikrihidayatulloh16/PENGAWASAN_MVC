
    // Auto-close the alert after 2 seconds (2000 milliseconds)
    setTimeout(function() {
        let flashMessage = document.getElementById('flashMessage');
        if (flashMessage) {
            // Using Bootstrap's alert('close') method to close it
            flashMessage.classList.remove('show');
            flashMessage.classList.add('fade');
            setTimeout(() => flashMessage.remove(), 250); // Remove from DOM after fade out
        }
    }, 2000);
