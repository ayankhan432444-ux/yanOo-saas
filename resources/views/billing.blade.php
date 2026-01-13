<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing Center - YanOo Brand</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; overflow: hidden; }
        .glass { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(255, 255, 255, 0.3); }
        .sidebar-active { background: linear-gradient(to right, #2563eb, #4f46e5); box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.3); color: white !important; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .plan-card:hover { transform: translateY(-10px); }
    </style>
</head>
<body class="bg-slate-50 text-slate-900">

    <div id="app" class="flex h-screen overflow-hidden">
        
        <aside class="w-72 bg-slate-900 text-white flex flex-col h-full flex-shrink-0 border-r border-slate-800">
            <div class="p-8 flex items-center gap-4 flex-shrink-0">
                <div class="bg-blue-600 p-2 rounded-xl shadow-lg shadow-blue-500/30">
                    <span class="material-symbols-outlined text-white">cloud_queue</span>
                </div>
                <span class="text-2xl font-extrabold tracking-tighter uppercase">YanOo Brand</span>
            </div>

            <nav class="flex-1 px-6 space-y-2 mt-4 overflow-y-auto no-scrollbar pb-10">
                <a href="/dashboard-view" class="flex items-center gap-4 px-5 py-4 text-slate-400 hover:text-white hover:bg-slate-800 rounded-2xl transition-all">
                    <span class="material-symbols-outlined">grid_view</span>
                    <span class="font-semibold">Dashboard</span>
                </a>
                <a href="/files-view" class="flex items-center gap-4 px-5 py-4 text-slate-400 hover:text-white hover:bg-slate-800 rounded-2xl transition-all">
                    <span class="material-symbols-outlined">folder_open</span>
                    <span class="font-semibold">My Files</span>
                </a>
                <a href="/support-view" class="flex items-center gap-4 px-5 py-4 text-slate-400 hover:text-white hover:bg-slate-800 rounded-2xl transition-all">
                    <span class="material-symbols-outlined">chat_bubble</span>
                    <span class="font-semibold">Support</span>
                </a>
                <a href="/audit-view" class="flex items-center gap-4 px-5 py-4 text-slate-400 hover:text-white hover:bg-slate-800 rounded-2xl transition-all">
                    <span class="material-symbols-outlined">history</span>
                    <span class="font-semibold">Audit Logs</span>
                </a>
                
                <div id="admin-sidebar" class="hidden pt-6 space-y-2 border-t border-slate-800 mt-6">
                    <p class="px-5 text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Management</p>
                    <a href="/team-view" class="flex items-center gap-4 px-5 py-4 text-slate-400 hover:text-white hover:bg-slate-800 rounded-2xl transition-all">
                        <span class="material-symbols-outlined">group</span>
                        <span class="font-semibold">Team Hub</span>
                    </a>
                    <a href="/billing-view" class="flex items-center gap-4 px-5 py-4 rounded-2xl sidebar-active transition-all">
                        <span class="material-symbols-outlined">payments</span>
                        <span class="font-bold">Billing</span>
                    </a>
                </div>
            </nav>

            <div class="p-6 border-t border-slate-800 flex-shrink-0 bg-slate-900">
                <button id="logoutBtn" class="flex items-center justify-center gap-3 bg-slate-800/50 text-red-400 hover:bg-red-500/10 w-full py-4 rounded-2xl font-bold transition-all border border-slate-800">
                    <span class="material-symbols-outlined text-lg">logout</span> Sign Out
                </button>
            </div>
        </aside>

        <main class="flex-1 flex flex-col h-full overflow-hidden">
            <header class="glass h-20 flex items-center justify-between px-10 flex-shrink-0 z-40 bg-white/80 border-b border-slate-100">
                <h1 class="text-xl font-black text-slate-800 uppercase tracking-tighter">Billing Center</h1>
                <div id="current-plan-display" class="px-5 py-2 bg-blue-50 text-blue-600 rounded-xl text-[10px] font-black uppercase tracking-widest border border-blue-100 shadow-sm">
                    Status: Initializing...
                </div>
            </header>

            <div class="flex-1 overflow-y-auto p-10 bg-white">
                <div class="max-w-7xl mx-auto w-full">
                    <div class="mb-12 text-center">
                        <h2 class="text-5xl font-extrabold text-slate-900 tracking-tight">Scale Your <span class="text-blue-600">Infrastructure</span></h2>
                        <p class="text-slate-400 mt-4 text-lg font-medium">Select a computational plan that fits your YanOo Brand node.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                        <div class="plan-card bg-white p-10 rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 transition-all duration-300">
                            <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Entry Node</h3>
                            <div class="text-4xl font-black text-slate-900">$10<span class="text-sm font-bold text-slate-400 uppercase ml-1">/mo</span></div>
                            <ul class="mt-8 space-y-4">
                                <li class="flex items-center gap-3 text-sm font-bold text-slate-600"><span class="material-symbols-outlined text-green-500 text-lg">check_circle</span> 10 Files Quota</li>
                                <li class="flex items-center gap-3 text-sm font-bold text-slate-600"><span class="material-symbols-outlined text-green-500 text-lg">check_circle</span> 1 Authorized User</li>
                            </ul>
                            <button onclick="openCheckout('price_basic_monthly', 'Basic')" class="mt-10 w-full py-5 bg-slate-50 text-slate-900 font-black rounded-2xl text-[10px] uppercase tracking-widest hover:bg-slate-100 transition-all border border-slate-100">Initialize Basic</button>
                        </div>

                        <div class="plan-card bg-slate-900 p-10 rounded-[2.5rem] shadow-2xl shadow-blue-500/20 border-t-4 border-blue-600 transition-all duration-300 relative">
                            <div class="absolute top-6 right-10 px-3 py-1 bg-blue-600 text-white text-[8px] font-black rounded-full uppercase tracking-widest">Recommended</div>
                            <h3 class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-4">Performance Node</h3>
                            <div class="text-4xl font-black text-white">$30<span class="text-sm font-bold text-slate-500 uppercase ml-1">/mo</span></div>
                            <ul class="mt-8 space-y-4">
                                <li class="flex items-center gap-3 text-sm font-bold text-slate-300"><span class="material-symbols-outlined text-blue-500 text-lg">verified</span> 100 Files Quota</li>
                                <li class="flex items-center gap-3 text-sm font-bold text-slate-300"><span class="material-symbols-outlined text-blue-500 text-lg">verified</span> 5 Authorized Users</li>
                            </ul>
                            <button onclick="openCheckout('price_1SojqcJM5TFsmE4QHsYY7PQg', 'Pro')" class="mt-10 w-full py-5 bg-blue-600 text-white font-black rounded-2xl text-[10px] uppercase tracking-widest hover:bg-blue-700 shadow-xl shadow-blue-500/40 transition-all">Upgrade to Pro</button>
                        </div>

                        <div class="plan-card bg-white p-10 rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 transition-all duration-300">
                            <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Enterprise Node</h3>
                            <div class="text-4xl font-black text-slate-900">$300<span class="text-sm font-bold text-slate-400 uppercase ml-1">/yr</span></div>
                            <ul class="mt-8 space-y-4">
                                <li class="flex items-center gap-3 text-sm font-bold text-slate-600"><span class="material-symbols-outlined text-blue-600 text-lg">star</span> 1000 Files Quota</li>
                                <li class="flex items-center gap-3 text-sm font-bold text-slate-600"><span class="material-symbols-outlined text-blue-600 text-lg">star</span> Unlimited Nodes</li>
                            </ul>
                            <button onclick="openCheckout('price_enterprise_yearly', 'Enterprise')" class="mt-10 w-full py-5 bg-slate-50 text-slate-900 font-black rounded-2xl text-[10px] uppercase tracking-widest hover:bg-slate-100 transition-all border border-slate-100">Secure Enterprise</button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="checkout-modal" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
                <div class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-md p-10 border border-white">
                    <div class="flex justify-between items-center mb-10">
                        <h3 class="text-xl font-black text-slate-900 tracking-tighter uppercase" id="modal-title">Initialize Payment</h3>
                        <button onclick="closeCheckout()" class="text-slate-400 hover:text-slate-600"><span class="material-symbols-outlined">close</span></button>
                    </div>
                    <div class="mb-8">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Encrypted Card Entry</label>
                        <div id="card-element" class="p-5 bg-slate-50 rounded-2xl border border-slate-100"></div>
                        <div id="card-errors" class="text-red-500 text-[10px] mt-4 font-black uppercase tracking-widest" role="alert"></div>
                    </div>
                    <button id="pay-btn" class="w-full py-5 bg-slate-900 text-white font-black rounded-2xl text-xs uppercase tracking-[0.2em] shadow-2xl shadow-slate-900/30 transition-all flex justify-center items-center gap-3">
                        <span class="material-symbols-outlined text-sm">lock</span> Transmit Payment
                    </button>
                </div>
            </div>
        </main>
    </div>

    <script>
        const token = localStorage.getItem('token');
        if (!token) window.location.href = '/login';

        const stripe = Stripe('pk_test_51S59deJM5TFsmE4QAP4sOBOdoFTzhOxbFxCqmVPSuE4hMzLm9R4rE7eWBn3HqT3v8mhP4jn24UJZFax3PryPz57e008pQQRzK9'); 
        const elements = stripe.elements();
        const card = elements.create('card', {
            style: { base: { fontSize: '14px', color: '#1e293b', fontFamily: '"Plus Jakarta Sans", sans-serif', '::placeholder': { color: '#94a3b8' } } }
        });
        card.mount('#card-element');

        let selectedPlanId = null;

        function openCheckout(planId, planName) {
            selectedPlanId = planId;
            document.getElementById('modal-title').innerText = `Subscribe: ${planName}`;
            document.getElementById('checkout-modal').classList.remove('hidden');
        }

        function closeCheckout() {
            document.getElementById('checkout-modal').classList.add('hidden');
            document.getElementById('card-errors').textContent = "";
        }

        const payBtn = document.getElementById('pay-btn');
        payBtn.addEventListener('click', async () => {
            payBtn.innerText = "TRANSMITTING...";
            payBtn.disabled = true;
            const { paymentMethod, error } = await stripe.createPaymentMethod({ type: 'card', card: card });
            if (error) {
                document.getElementById('card-errors').textContent = error.message;
                payBtn.innerText = "TRANSMIT PAYMENT";
                payBtn.disabled = false;
            } else {
                subscribeToPlan(paymentMethod.id);
            }
        });

        async function subscribeToPlan(paymentMethodId) {
            try {
                const res = await fetch('/api/subscribe', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Authorization': `Bearer ${token}` },
                    body: JSON.stringify({ plan_id: selectedPlanId, payment_method: paymentMethodId })
                });
                const data = await res.json();
                if (res.ok) { alert("Node Uplink Successful!"); window.location.href = '/dashboard-view'; }
                else { alert("Uplink Failed: " + data.message); payBtn.innerText = "TRANSMIT PAYMENT"; payBtn.disabled = false; }
            } catch (err) { alert("Network Failure"); payBtn.disabled = false; }
        }

        async function init() {
            try {
                const res = await fetch('/api/user', { headers: { 'Authorization': `Bearer ${token}` } });
                const user = await res.json();
                const isPro = (user.company?.status === 'active' || user.company?.status === 'approved');
                document.getElementById('current-plan-display').innerText = isPro ? "Status: Pro Node Active" : "Status: Trial Mode"; 
                if (user.role?.name === 'company_admin' || user.role === 'company_admin' || user.role === 'super_admin') {
                    document.getElementById('admin-sidebar').classList.remove('hidden');
                }
            } catch(e) {}
        }
        init();

        document.getElementById('logoutBtn').addEventListener('click', () => {
            localStorage.removeItem('token');
            window.location.href = '/login';
        });
    </script>
</body>
</html>