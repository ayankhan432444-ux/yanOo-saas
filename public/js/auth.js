document.addEventListener('DOMContentLoaded', function () {
    const loginForm = document.getElementById('loginForm');

    // Safety check: exit if we are not on the login page
    if (!loginForm) return;

    loginForm.addEventListener('submit', async function(e) {
        e.preventDefault(); 

        // 1. Get Elements
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const btn = document.getElementById('submitBtn');
        const errorBox = document.getElementById('errorBox');

        // 2. Loading State
        const originalText = btn.innerText;
        btn.innerText = "Authenticating...";
        btn.disabled = true;
        btn.classList.add('opacity-70', 'cursor-not-allowed');
        errorBox.classList.add('hidden'); 

        try {
            // 3. Send Request
            const response = await fetch('/api/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ email, password })
            });

            const data = await response.json();

            if (response.ok) {
                // 1. Save Token to LocalStorage
                localStorage.setItem('token', data.token);
                
                // 2. Save Token to Cookie (Optional, but helps some browsers)
                document.cookie = `token=${data.token}; path=/; max-age=86400; SameSite=Lax`; 

                // 3. Debugging: Log it to console to be sure
                console.log("Token saved:", data.token);

                // 4. Redirect to the Trial Page
                window.location.href = '/trial-status'; 
            }
        } catch (error) {
            console.error('Network Error:', error);
            errorBox.innerText = "Network error. Is the server running?";
            errorBox.classList.remove('hidden');
        } finally {
            // Reset Button
            btn.innerText = originalText;
            btn.disabled = false;
            btn.classList.remove('opacity-70', 'cursor-not-allowed');
        }
    });
});