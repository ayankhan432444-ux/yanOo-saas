<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trial Status - Nimbus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
</head>
<body class="bg-gray-50 h-screen flex items-center justify-center">

    <div id="loading" class="text-center">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto mb-4"></div>
        <p class="text-gray-500">Checking subscription status...</p>
    </div>

    <div id="status-card" class="hidden bg-white p-8 rounded-2xl shadow-xl max-w-md w-full text-center transition-all transform scale-100">
        
        <div id="icon-bg" class="mx-auto flex items-center justify-center h-20 w-20 rounded-full mb-6 bg-green-100">
            <span id="status-icon" class="material-symbols-outlined text-4xl text-green-600">verified</span>
        </div>

        <h1 id="status-title" class="text-2xl font-bold text-gray-900 mb-2">Trial Active</h1>
        <p id="status-desc" class="text-gray-500 mb-8">You have <span class="font-bold text-gray-800" id="days-left">7</span> days remaining in your free trial.</p>

        <div class="space-y-3">
            <button id="primary-btn" class="w-full py-3 px-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow transition-colors">
                Go to Dashboard
            </button>
            <button id="secondary-btn" class="hidden w-full py-3 px-4 bg-white border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition-colors">
                View Plans
            </button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            const token = localStorage.getItem('token');
            if (!token) window.location.href = '/login';

            try {
                // 1. Get User Data
                const response = await fetch('/api/user', {
                    headers: { 'Authorization': `Bearer ${token}` }
                });
                
                if (!response.ok) throw new Error('Auth failed');
                
                const user = await response.json();
                
                // 2. Calculate Trial Days Left
                // Assuming 'created_at' is the start of the trial
                const startDate = new Date(user.created_at);
                const today = new Date();
                const diffTime = Math.abs(today - startDate);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
                const daysRemaining = 7 - diffDays;

                // 3. Update UI based on Status
                const card = document.getElementById('status-card');
                const loading = document.getElementById('loading');
                const iconBg = document.getElementById('icon-bg');
                const icon = document.getElementById('status-icon');
                const title = document.getElementById('status-title');
                const desc = document.getElementById('status-desc');
                const btn = document.getElementById('primary-btn');
                const btn2 = document.getElementById('secondary-btn');

                loading.classList.add('hidden');
                card.classList.remove('hidden');

                if (daysRemaining > 0) {
                    // --- CASE A: TRIAL ACTIVE ---
                    document.getElementById('days-left').innerText = daysRemaining;
                    
                    // Button Action: Go to Dashboard
                    btn.innerText = "Continue to Dashboard";
                    btn.onclick = () => window.location.href = '/dashboard-view';
                } else {
                    // --- CASE B: TRIAL EXPIRED ---
                    iconBg.className = "mx-auto flex items-center justify-center h-20 w-20 rounded-full mb-6 bg-red-100";
                    icon.className = "material-symbols-outlined text-4xl text-red-600";
                    icon.innerText = "warning";
                    
                    title.innerText = "Trial Expired";
                    desc.innerHTML = "Your 7-day trial has ended. Please upgrade your plan to continue using Nimbus.";
                    
                    // Button Action: Go to Billing
                    btn.innerText = "Upgrade Plan";
                    btn.className = "w-full py-3 px-4 bg-red-600 hover:bg-red-700 text-white font-bold rounded-lg shadow transition-colors";
                    btn.onclick = () => window.location.href = '/billing-view'; // We will build this later
                    
                    // Secondary Button: Logout
                    btn2.classList.remove('hidden');
                    btn2.innerText = "Logout";
                    btn2.onclick = () => {
                        localStorage.removeItem('token');
                        window.location.href = '/login';
                    };
                }

            } catch (error) {
                console.error(error);
                window.location.href = '/login';
            }
        });
    </script>
</body>
</html>