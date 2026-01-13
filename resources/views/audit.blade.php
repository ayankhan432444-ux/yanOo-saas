<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audit Trail - YanOo Brand</title>
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

                <a href="/audit-view" id="audit-link" class="flex items-center gap-4 px-5 py-4 rounded-2xl sidebar-active transition-all">
                    <span class="material-symbols-outlined">history</span>
                    <span class="font-bold">Audit Logs</span>
                </a>
                
                <div id="admin-sidebar" class="hidden pt-6 space-y-2 border-t border-slate-800 mt-6">
                    <p class="px-5 text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Management</p>
                    <a href="/team-view" class="flex items-center gap-4 px-5 py-4 text-slate-400 hover:text-white hover:bg-slate-800 rounded-2xl transition-all">
                        <span class="material-symbols-outlined">group</span>
                        <span class="font-semibold">Team Hub</span>
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

        <main class="flex-1 flex flex-col h-full overflow-hidden">
            <header class="glass h-20 flex items-center justify-between px-10 flex-shrink-0 z-40 bg-white/80">
                <h1 class="text-xl font-black text-slate-800 uppercase tracking-tighter">System Integrity Logs</h1>
                <div class="flex items-center gap-2">
                    <span class="h-2 w-2 rounded-full bg-blue-500 animate-ping"></span>
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Real-time Tracking Active</span>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto p-10 bg-white">
                <div class="max-w-7xl mx-auto w-full">
                    <div class="mb-10">
                        <h2 class="text-4xl font-extrabold text-slate-900 tracking-tight">Activity <span class="text-blue-600">Timeline</span></h2>
                        <p class="text-slate-400 mt-2 font-medium italic">Immutable record of administrative operations for YanOo Brand.</p>
                    </div>

                    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="bg-slate-50/50 border-b border-slate-100">
                                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Operation Event</th>
                                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Executor</th>
                                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Description</th>
                                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Timestamp</th>
                                </tr>
                            </thead>
                            <tbody id="logs-list" class="divide-y divide-slate-50"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

<script>
    const token = localStorage.getItem('token');
    if (!token) window.location.href = '/login';

    async function init() {
        try {
            const userRes = await fetch('/api/user', { headers: { 'Authorization': `Bearer ${token}` } });
            const user = await userRes.json();
            const role = user.role?.name || user.role || "normal_user";

            // 1. Strict Security: Normal aur Support ko Dashboard phenk do
            if (role !== 'company_admin' && role !== 'super_admin') {
                window.location.href = '/dashboard-view';
                return;
            }

            // 2. Admin Sidebar Section toggle
            document.getElementById('admin-sidebar').classList.remove('hidden');
            loadLogs();
        } catch(e) { window.location.href = '/login'; }
    }

    async function loadLogs() {
        try {
            const res = await fetch('/api/audit-logs', { 
                headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' } 
            });
            const logs = await res.json();
            const container = document.getElementById('logs-list');
            container.innerHTML = '';

            if (!logs || logs.length === 0) {
                container.innerHTML = '<tr><td colspan="4" class="px-10 py-20 text-center font-bold text-slate-400 uppercase text-xs tracking-widest">No system events recorded</td></tr>';
                return;
            }

            logs.forEach(log => {
                const event = log.event || 'SYSTEM_ACTION';
                let badgeColor = 'bg-slate-100 text-slate-600';
                if(event.includes('upload')) badgeColor = 'bg-green-50 text-green-600 border-green-100';
                if(event.includes('delete')) badgeColor = 'bg-red-50 text-red-600 border-red-100';

                container.innerHTML += `
                    <tr class="hover:bg-slate-50/50 transition-all group">
                        <td class="px-10 py-6"><span class="px-4 py-1.5 ${badgeColor} rounded-full text-[9px] font-black tracking-widest border uppercase">${event.replace('_', ' ')}</span></td>
                        <td class="px-10 py-6"><div class="flex items-center gap-3"><div class="h-8 w-8 rounded-lg bg-slate-100 flex items-center justify-center text-[10px] font-black text-slate-500 uppercase">${(log.user_name || 'S').charAt(0)}</div><span class="text-sm font-bold text-slate-700">${log.user_name || 'System'}</span></div></td>
                        <td class="px-10 py-6"><p class="text-xs font-medium text-slate-500 leading-relaxed">${log.description || 'Standard operation'}</p></td>
                        <td class="px-10 py-6"><div class="text-[10px] font-black text-slate-400 uppercase tracking-tighter">${new Date(log.created_at).toLocaleDateString()}<br><span class="text-blue-500">${new Date(log.created_at).toLocaleTimeString()}</span></div></td>
                    </tr>`;
            });
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