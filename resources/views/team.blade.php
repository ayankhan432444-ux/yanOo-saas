<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Hub - YanOo Brand</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; overflow: hidden; }
        .glass { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(255, 255, 255, 0.3); }
        .sidebar-active { background: linear-gradient(to right, #2563eb, #4f46e5); box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.3); color: white !important; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
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
                    <a href="/team-view" class="flex items-center gap-4 px-5 py-4 rounded-2xl sidebar-active transition-all">
                        <span class="material-symbols-outlined">group</span>
                        <span class="font-bold">Team Hub</span>
                    </a>
                    <a href="/billing-view" class="flex items-center gap-4 px-5 py-4 text-slate-400 hover:text-white hover:bg-slate-800 rounded-2xl transition-all">
                        <span class="material-symbols-outlined">payments</span>
                        <span class="font-semibold">Billing</span>
                    </a>
                </div>
            </nav>

            <div class="p-6 border-t border-slate-800 flex-shrink-0 bg-slate-900">
                <button id="logoutBtn" class="flex items-center justify-center gap-3 bg-slate-800/50 text-red-400 hover:bg-red-500/10 w-full py-4 rounded-2xl font-bold transition-all border border-slate-800">
                    <span class="material-symbols-outlined text-lg">logout</span> Sign Out
                </button>
            </div>
        </aside>

        <main class="flex-1 flex flex-col h-full overflow-hidden bg-white">
            <header class="glass h-20 flex items-center justify-between px-10 flex-shrink-0 z-40 bg-white/80 border-b border-slate-100">
                <h1 class="text-xl font-black text-slate-800 uppercase tracking-tighter">Team Management</h1>
                <button onclick="document.getElementById('inviteModal').classList.remove('hidden')" class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-2xl font-black text-xs uppercase tracking-widest transition-all shadow-lg shadow-blue-500/30">
                    <span class="material-symbols-outlined text-sm">person_add</span> Invite Member
                </button>
            </header>

            <div class="flex-1 overflow-y-auto p-10 bg-white">
                <div class="max-w-7xl mx-auto w-full">
                    <div class="mb-10">
                        <h2 class="text-4xl font-extrabold text-slate-900 tracking-tight">Your <span class="text-blue-600">Workforce</span></h2>
                        <p class="text-slate-400 mt-2 font-medium">Manage permissions and access for your company nodes.</p>
                    </div>

                    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="bg-slate-50/50 border-b border-slate-100">
                                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Team Member</th>
                                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Authority Node</th>
                                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Node Status</th>
                                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Operations</th>
                                </tr>
                            </thead>
                            <tbody id="team-list" class="divide-y divide-slate-50"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <div id="inviteModal" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-md p-10 border border-white">
            <div class="flex justify-between items-center mb-8">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center"><span class="material-symbols-outlined">mail</span></div>
                    <h3 class="text-xl font-black text-slate-900 tracking-tighter uppercase">Invite Node</h3>
                </div>
                <button onclick="document.getElementById('inviteModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600"><span class="material-symbols-outlined">close</span></button>
            </div>
            <form id="inviteForm" class="space-y-6">
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Member Email</label>
                    <input type="email" id="inviteEmail" required placeholder="name@company.com" class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl outline-none font-medium">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">System Role</label>
                    <select id="inviteRole" class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-bold text-slate-700">
                        <option value="normal_user">Normal User</option>
                        <option value="support_user">Support Agent</option>
                        <option value="company_admin">Company Admin</option>
                    </select>
                </div>
                <button type="submit" class="w-full bg-slate-900 hover:bg-black text-white font-black py-5 rounded-2xl text-xs uppercase tracking-[0.2em] transition-all">Transmit Invitation</button>
            </form>
        </div>
    </div>

    <script>
        const token = localStorage.getItem('token');
        if (!token) window.location.href = '/login';

        async function loadTeam() {
            try {
                const res = await fetch('/api/team', { headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' } });
                const users = await res.json();
                const tbody = document.getElementById('team-list');
                tbody.innerHTML = '';
                if (!users || users.length === 0) {
                    tbody.innerHTML = `<tr><td colspan="4" class="px-10 py-20 text-center font-bold text-slate-400 uppercase text-xs tracking-widest">No nodes found</td></tr>`;
                    return;
                }
                users.forEach(user => {
                    let roleName = (user.role?.name || user.role || "User").replace('_', ' ').toUpperCase();
                    tbody.innerHTML += `<tr class="hover:bg-slate-50/50 transition-all group"><td class="px-10 py-6"><div class="flex items-center gap-4"><div class="h-12 w-12 rounded-2xl bg-gradient-to-tr from-slate-100 to-slate-200 text-slate-600 flex items-center justify-center font-black text-sm">${user.name.charAt(0).toUpperCase()}</div><div><div class="font-black text-slate-800 uppercase tracking-tighter text-sm">${user.name}</div><div class="text-[10px] font-bold text-slate-400 lowercase">${user.email}</div></div></div></td><td class="px-10 py-6"><span class="px-4 py-1.5 bg-white border border-slate-100 text-slate-500 rounded-full text-[10px] font-black tracking-widest">${roleName}</span></td><td class="px-10 py-6"><div class="flex items-center gap-2"><div class="h-1.5 w-1.5 rounded-full bg-green-500 shadow-[0_0_8px_rgba(34,197,94,0.6)]"></div><span class="text-[10px] font-black text-green-600 uppercase tracking-widest">Encrypted</span></div></td><td class="px-10 py-6 text-right"><button onclick="deleteMember(${user.id})" class="h-10 w-10 flex items-center justify-center bg-slate-50 text-slate-400 rounded-xl hover:bg-red-50 hover:text-red-500 transition-all border border-slate-100"><span class="material-symbols-outlined text-sm">delete</span></button></td></tr>`;
                });
            } catch (error) {}
        }

        async function checkRole() {
            try {
                const res = await fetch('/api/user', { headers: { 'Authorization': `Bearer ${token}` } });
                const user = await res.json();
                if (user.role?.name === 'company_admin' || user.role === 'company_admin' || user.role === 'super_admin' || user.role?.name === 'super_admin') {
                    document.getElementById('admin-sidebar').classList.remove('hidden');
                }
            } catch (e) {}
        }

        document.getElementById('inviteForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const btn = e.target.querySelector('button');
            btn.innerText = "TRANSMITTING...";
            btn.disabled = true;
            try {
                const res = await fetch('/api/team/invite', {
                    method: 'POST',
                    headers: { 'Authorization': `Bearer ${token}`, 'Content-Type': 'application/json', 'Accept': 'application/json' },
                    body: JSON.stringify({ email: document.getElementById('inviteEmail').value, role: document.getElementById('inviteRole').value })
                });
                const data = await res.json();
                if (res.ok) { alert('Invitation Transmitted Successfully!'); document.getElementById('inviteModal').classList.add('hidden'); e.target.reset(); loadTeam(); }
                else { alert('Transmission Failed: ' + (data.message || 'System error')); }
            } catch (err) { alert('Connection breach.'); }
            finally { btn.innerText = "TRANSMIT INVITATION"; btn.disabled = false; }
        });

        async function deleteMember(id) {
            if (!confirm("Terminate node access?")) return;
            try {
                const res = await fetch(`/api/team/${id}`, { method: 'DELETE', headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' } });
                if (res.ok) loadTeam();
            } catch (e) {}
        }

        loadTeam();
        checkRole();
        document.getElementById('logoutBtn').addEventListener('click', () => { localStorage.removeItem('token'); window.location.href = '/login'; });
    </script>
</body>
</html>