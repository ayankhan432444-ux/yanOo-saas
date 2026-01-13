<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nimbus - Platform Control</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(255, 255, 255, 0.3); }
        .sidebar-active { background: linear-gradient(to right, #ef4444, #b91c1c); box-shadow: 0 10px 15px -3px rgba(239, 68, 68, 0.3); }
    </style>
</head>
<body class="bg-slate-50 text-slate-900">

    <div class="flex h-screen overflow-hidden">
        
        <aside class="w-72 bg-slate-900 text-white flex flex-col hidden lg:flex">
            <div class="p-8 flex items-center gap-4">
                <div class="bg-red-600 p-2 rounded-xl shadow-lg shadow-red-500/30">
                    <span class="material-symbols-outlined text-white">admin_panel_settings</span>
                </div>
                <span class="text-2xl font-extrabold tracking-tighter uppercase">Nexus Core</span>
            </div>

            <nav class="flex-1 px-6 space-y-2 mt-6">
                <a href="#" class="flex items-center gap-4 px-5 py-4 rounded-2xl sidebar-active text-white transition-all font-bold">
                    <span class="material-symbols-outlined">domain</span> Companies
                </a>
                <a href="#" class="flex items-center gap-4 px-5 py-4 text-slate-400 hover:text-white hover:bg-slate-800 rounded-2xl transition-all font-semibold">
                    <span class="material-symbols-outlined">payments</span> Revenue Flow
                </a>
                <a href="#" class="flex items-center gap-4 px-5 py-4 text-slate-400 hover:text-white hover:bg-slate-800 rounded-2xl transition-all font-semibold">
                    <span class="material-symbols-outlined">history</span> Global Audit
                </a>
            </nav>

            <div class="p-6">
                <button id="logoutBtn" class="flex items-center justify-center gap-3 bg-slate-800/50 text-red-400 hover:bg-red-500/10 w-full py-4 rounded-2xl font-bold border border-slate-800 transition-all">
                    <span class="material-symbols-outlined text-lg">logout</span> Terminate Session
                </button>
            </div>
        </aside>

        <main class="flex-1 flex flex-col overflow-y-auto">
            <header class="glass h-20 flex items-center justify-between px-10 sticky top-0 z-40">
                <h1 class="text-xl font-black text-slate-800 uppercase tracking-tighter italic">Platform Command</h1>
                <div class="flex items-center gap-4">
                    <div class="flex flex-col text-right">
                        <span class="text-xs font-black text-red-600 uppercase tracking-widest">Platform Owner</span>
                        <span class="text-[10px] font-bold text-slate-400">System Integrity: 100%</span>
                    </div>
                    <div class="h-10 w-10 bg-red-50 text-red-600 rounded-xl flex items-center justify-center font-black">SA</div>
                </div>
            </header>

            <div class="p-10 max-w-7xl mx-auto w-full">
                
                <div class="mb-12 flex justify-between items-center">
                    <div>
                        <h2 class="text-4xl font-extrabold text-slate-900 tracking-tight">Onboarding <span class="text-red-600">Control</span></h2>
                        <p class="text-slate-400 mt-2 font-medium">Verify pending company nodes and manage service states.</p>
                    </div>
                    <button onclick="loadCompanies()" class="group px-6 py-3 bg-white text-slate-600 rounded-2xl text-xs font-bold hover:bg-slate-50 transition-all border border-slate-200 flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm group-hover:rotate-180 transition-transform duration-500">refresh</span> Refresh Nexus
                    </button>
                </div>

                <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50/50 border-b border-slate-100">
                                <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Company Node</th>
                                <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Admin Email</th>
                                <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Registry Date</th>
                                <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Protocol Status</th>
                                <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Action Interface</th>
                            </tr>
                        </thead>
                        <tbody id="company-list" class="divide-y divide-slate-50">
                            </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

<script>
    const token = localStorage.getItem('token');
    if (!token) window.location.href = '/login';

    async function loadCompanies() {
        const tbody = document.getElementById('company-list');
        tbody.innerHTML = '<tr><td colspan="5" class="py-20 text-center"><div class="h-10 w-10 border-4 border-slate-100 border-t-red-600 rounded-full animate-spin mx-auto"></div></td></tr>';

        try {
            const res = await fetch('/api/admin/companies', { headers: { 'Authorization': `Bearer ${token}` } });
            const responseData = await res.json();
            const companies = responseData.data || responseData;
            
            tbody.innerHTML = '';
            if (!Array.isArray(companies) || companies.length === 0) {
                tbody.innerHTML = '<tr><td colspan="5" class="px-10 py-20 text-center font-bold text-slate-400 uppercase text-xs">No active nodes in registry</td></tr>';
                return;
            }

            companies.forEach(company => {
                let statusBadge = '';
                if (company.status === 'pending') statusBadge = 'bg-amber-50 text-amber-600 border-amber-100 animate-pulse';
                else if (company.status === 'approved') statusBadge = 'bg-emerald-50 text-emerald-600 border-emerald-100';
                else statusBadge = 'bg-rose-50 text-rose-600 border-rose-100';

                const adminEmail = (company.users && company.users.length > 0) ? company.users[0].email : 'N/A';

                tbody.innerHTML += `
                    <tr class="hover:bg-slate-50/50 transition-all group">
                        <td class="px-10 py-8 font-extrabold text-slate-800 uppercase tracking-tighter text-sm">${company.name}</td>
                        <td class="px-10 py-8 text-xs font-bold text-slate-500">${adminEmail}</td>
                        <td class="px-10 py-8 text-[10px] font-black text-slate-400 uppercase tracking-widest">${new Date(company.created_at).toLocaleDateString()}</td>
                        <td class="px-10 py-8 text-center">
                            <span class="px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest border ${statusBadge}">
                                ${company.status}
                            </span>
                        </td>
                        <td class="px-10 py-8 text-right space-x-2">
                            ${company.status !== 'approved' ? `
                                <button onclick="updateStatus(${company.id}, 'approved')" class="h-10 w-10 bg-emerald-50 text-emerald-600 rounded-xl hover:bg-emerald-600 hover:text-white transition-all shadow-sm">
                                    <span class="material-symbols-outlined text-sm">verified</span>
                                </button>` : ''}
                            ${company.status !== 'rejected' ? `
                                <button onclick="updateStatus(${company.id}, 'rejected')" class="h-10 w-10 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition-all shadow-sm">
                                    <span class="material-symbols-outlined text-sm">block</span>
                                </button>` : ''}
                        </td>
                    </tr>`;
            });
        } catch(e) { console.error(e); }
    }

    async function updateStatus(id, newStatus) {
        if(!confirm(`Verify ${newStatus.toUpperCase()} action?`)) return;
        const res = await fetch(`/api/admin/companies/${id}/status`, {
            method: 'POST',
            headers: { 'Authorization': `Bearer ${token}`, 'Content-Type': 'application/json' },
            body: JSON.stringify({ status: newStatus })
        });
        if(res.ok) loadCompanies();
    }

    loadCompanies();
    document.getElementById('logoutBtn').addEventListener('click', () => {
        localStorage.setItem('token', '');
        window.location.href = '/login';
    });
</script>
</body>
</html>