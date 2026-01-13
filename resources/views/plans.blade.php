<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription Plans - Nimbus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://js.stripe.com/v3/"></script> <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-50 text-gray-900">

    <nav class="bg-white border-b border-gray-200 px-8 py-4 flex justify-between items-center">
        <div class="font-bold text-xl text-blue-600">Nimbus</div>
        <a href="/dashboard-view" class="text-sm font-medium text-gray-500 hover:text-gray-900">Back to Dashboard</a>
    </nav>

    <div class="max-w-7xl mx-auto px-4 py-16">
        
        <div class="text-center mb-16">
            <h1 class="text-4xl font-bold mb-4">Upgrade your Workspace</h1>
            <p class="text-gray-500 text-lg">Choose the plan that fits your team's needs.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
            
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8 hover:shadow-lg transition">
                <h3 class="text-xl font-bold mb-2">Basic Plan</h3>
                <div class="text-4xl font-bold mb-6">$10 <span class="text-base font-normal text-gray-500">/mo</span></div>
                <ul class="space-y-4 mb-8 text-gray-600">
                    <li class="flex items-center gap-2">✓ 1 User</li>
                    <li class="flex items-center gap-2">✓ 5GB Storage</li>
                    <li class="flex items-center gap-2">✓ Basic Support</li>
                </ul>
                <button onclick="openCheckout('price_basic_monthly', 'Basic Plan')" class="w-full py-3 px-4 bg-blue-50 text-blue-600 font-bold rounded-xl hover:bg-blue-100 transition">
                    Choose Basic
                </button>
            </div>

            <div class="bg-white rounded-2xl shadow-lg border-2 border-blue-600 p-8 relative transform scale-105">
                <span class="absolute top-0 right-0 bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-bl-xl rounded-tr-lg">POPULAR</span>
                <h3 class="text-xl font-bold mb-2">Pro Plan</h3>
                <div class="text-4xl font-bold mb-6">$30 <span class="text-base font-normal text-gray-500">/mo</span></div>
                <ul class="space-y-4 mb-8 text-gray-600">
                    <li class="flex items-center gap-2">✓ 5 Users</li>
                    <li class="flex items-center gap-2">✓ 50GB Storage</li>
                    <li class="flex items-center gap-2">✓ Priority Support</li>
                </ul>
                <button onclick="openCheckout('price_pro_monthly', 'Pro Plan')" class="w-full py-3 px-4 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition shadow-md shadow-blue-200">
                    Choose Pro
                </button>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8 hover:shadow-lg transition">
                <h3 class="text-xl font-bold mb-2">Enterprise</h3>
                <div class="text-4xl font-bold mb-6">$100 <span class="text-base font-normal text-gray-500">/mo</span></div>
                <ul class="space-y-4 mb-8 text-gray-600">
                    <li class="flex items-center gap-2">✓ Unlimited Users</li>
                    <li class="flex items-center gap-2">✓ Unlimited Storage</li>
                    <li class="flex items-center gap-2">✓ 24/7 Support</li>
                </ul>
                <button onclick="openCheckout('price_enterprise_monthly', 'Enterprise')" class="w-full py-3 px-4 bg-blue-50 text-blue-600 font-bold rounded-xl hover:bg-blue-100 transition">
                    Choose Enterprise
                </button>
            </div>
        </div>

    </div>

    <div id="checkout-modal" class="fixed inset-0 bg-black/50 hidden flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4 shadow-2xl">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold" id="modal-title">Confirm Subscription</h3>
                <button onclick="closeCheckout()" class="text-gray-400 hover:text-gray-600">✕</button>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Card Details</label>
                <div id="card-element" class="p-4 border border-gray-300 rounded-lg"></div>
                <div id="card-errors" class="text-red-500 text-sm mt-2" role="alert"></div>
            </div>

            <button id="pay-btn" class="w-full py-3 px-4 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition flex justify-center items-center gap-2">
                Pay Securely
            </button>
        </div>
    </div>

    <script>
        // 🛑 IMPORTANT: Replace with your ACTUAL Stripe Public Key from .env
        // It starts with 'pk_test_...'
        const stripe = Stripe('pk_test_51S59deJM5TFsmE4QAP4sOBOdoFTzhOxbFxCqmVPSuE4hMzLm9R4rE7eWBn3HqT3v8mhP4jn24UJZFax3PryPz57e008pQQRzK9'); 
        const elements = stripe.elements();
        const card = elements.create('card');
        card.mount('#card-element');

        let selectedPlanId = null;

        function openCheckout(planId, planName) {
            selectedPlanId = planId;
            document.getElementById('modal-title').innerText = `Subscribe to ${planName}`;
            document.getElementById('checkout-modal').classList.remove('hidden');
        }

        function closeCheckout() {
            document.getElementById('checkout-modal').classList.add('hidden');
        }

        // Handle Payment Submission
        const payBtn = document.getElementById('pay-btn');
        payBtn.addEventListener('click', async () => {
            payBtn.innerText = "Processing...";
            payBtn.disabled = true;

            // 1. Create Payment Method via Stripe
            const { paymentMethod, error } = await stripe.createPaymentMethod({
                type: 'card',
                card: card,
            });

            if (error) {
                document.getElementById('card-errors').textContent = error.message;
                payBtn.innerText = "Pay Securely";
                payBtn.disabled = false;
            } else {
                // 2. Send to Backend
                subscribeToPlan(paymentMethod.id);
            }
        });

        async function subscribeToPlan(paymentMethodId) {
            const token = localStorage.getItem('token');
            try {
                const res = await fetch('/api/subscribe', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${token}`
                    },
                    body: JSON.stringify({
                        plan_id: selectedPlanId,
                        payment_method: paymentMethodId
                    })
                });

                const data = await res.json();

                if (res.ok) {
                    alert("Subscription Successful! Welcome aboard.");
                    window.location.href = '/dashboard-view';
                } else {
                    alert("Payment Failed: " + data.message);
                    payBtn.innerText = "Pay Securely";
                    payBtn.disabled = false;
                }
            } catch (err) {
                console.error(err);
                alert("Network Error");
                payBtn.innerText = "Pay Securely";
                payBtn.disabled = false;
            }
        }
    </script>
</body>
</html>