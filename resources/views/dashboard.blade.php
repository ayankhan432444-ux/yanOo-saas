<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YanOo Brand Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; overflow: hidden; }
        .glass { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); }
        .sidebar-active { background: linear-gradient(to right, #2563eb, #4f46e5); box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.4); color: white !important; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900">

    <div id="loading-screen" class="fixed inset-0 bg-white z-[100] flex items-center justify-center transition-opacity duration-500">
        <div class="relative">
            <div class="h-20 w-20 border-4 border-slate-100 border-t-blue-600 rounded-full animate-spin"></div>
            <div class="absolute inset-0 flex items-center justify-center font-bold text-blue-600 text-[10px] uppercase">YanOo</div>
        </div>
    </div>

    <div id="app" class="hidden flex h-screen overflow-hidden">
        
        <aside class="w-72 bg-slate-900 text-white flex flex-col h-full flex-shrink-0 border-r border-slate-800">
            <div class="p-8 flex items-center gap-4 flex-shrink-0">
                <div class="bg-blue-600 p-2 rounded-xl shadow-lg shadow-blue-500/30">
                    <span class="material-symbols-outlined text-white">cloud_queue</span>
                </div>
                <span class="text-2xl font-extrabold tracking-tighter uppercase">YanOo Brand</span>
            </div>

            <nav class="flex-1 px-6 space-y-2 mt-4 overflow-y-auto no-scrollbar pb-10">
                <a href="/dashboard-view" class="flex items-center gap-4 px-5 py-4 rounded-2xl sidebar-active transition-all">
                    <span class="material-symbols-outlined">grid_view</span>
                    <span class="font-bold">Dashboard</span>
                </a>
                <a href="/files-view" class="flex items-center gap-4 px-5 py-4 text-slate-400 hover:text-white hover:bg-slate-800 rounded-2xl transition-all">
                    <span class="material-symbols-outlined">folder_open</span>
                    <span class="font-semibold">My Files</span>
                </a>
                <a href="/support-view" class="flex items-center gap-4 px-5 py-4 text-slate-400 hover:text-white hover:bg-slate-800 rounded-2xl transition-all">
                    <span class="material-symbols-outlined">chat_bubble</span>
                    <span class="font-semibold">Support</span>
                </a>
                
                <a href="/audit-view" id="audit-link" class="flex items-center gap-4 px-5 py-4 text-slate-400 hover:text-white hover:bg-slate-800 rounded-2xl transition-all">
                    <span class="material-symbols-outlined">history</span>
                    <span class="font-semibold">Audit Logs</span>
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
            <header class="glass h-20 flex items-center justify-between px-10 flex-shrink-0 z-40 border-b border-slate-100 bg-white/80">
                <div class="flex items-center gap-2">
                    <div id="status-dot" class="h-2 w-2 rounded-full bg-green-500 animate-pulse"></div>
                    <h1 class="text-sm font-bold text-slate-500 uppercase tracking-widest">YanOo System Healthy</h1>
                </div>
                <div class="flex items-center gap-6">
                    <div class="text-right">
                        <div class="text-sm font-extrabold text-slate-900" id="user-name">...</div>
                        <div class="text-[10px] font-bold text-blue-600 uppercase tracking-tighter" id="user-role">...</div>
                    </div>
                    <div class="h-12 w-12 bg-gradient-to-tr from-blue-600 to-indigo-600 rounded-2xl flex items-center justify-center text-white font-black" id="user-initials">?</div>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto p-10 bg-white">
                <div class="max-w-7xl mx-auto w-full">
                    <div class="mb-12">
                        <h2 class="text-5xl font-extrabold text-slate-900 tracking-tight">System <span class="text-blue-600">Overview</span></h2>
                        <p class="text-slate-500 mt-4 text-lg font-medium">Monitoring company assets for YanOo Brand node.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                        <div class="bg-white p-8 rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100">
                            <div class="flex justify-between items-start mb-8">
                                <div class="p-4 bg-purple-50 rounded-2xl"><span class="material-symbols-outlined text-purple-600 text-3xl">verified</span></div>
                                <span id="plan-status-badge" class="px-4 py-1.5 bg-green-50 text-green-600 text-[10px] font-black rounded-full uppercase border border-green-100">Active</span>
                            </div>
                            <h3 class="text-slate-400 text-xs font-black uppercase tracking-widest">Status Plan</h3>
                            <p class="text-3xl font-black text-slate-900 mt-2" id="plan-name">...</p>
                        </div>

                        <div class="bg-white p-8 rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100">
                            <div class="flex justify-between items-start mb-8">
                                <div class="p-4 bg-blue-50 rounded-2xl"><span class="material-symbols-outlined text-blue-600 text-3xl">cloud_done</span></div>
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest" id="storage-limit">...</span>
                            </div>
                            <h3 class="text-slate-400 text-xs font-black uppercase tracking-widest">Storage</h3>
                            <div class="flex items-baseline gap-2 mt-2">
                                <span class="text-4xl font-black text-slate-900" id="files-count">0</span>
                                <span class="text-slate-400 font-bold">Files</span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-3 mt-6 overflow-hidden">
                                <div id="storage-bar" class="bg-gradient-to-r from-blue-600 to-indigo-600 h-full rounded-full transition-all duration-1000"></div>
                            </div>
                        </div>

                        <div class="bg-white p-8 rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100">
                            <div class="flex justify-between items-start mb-8">
                                <div class="p-4 bg-orange-50 rounded-2xl"><span class="material-symbols-outlined text-orange-600 text-3xl">group_add</span></div>
                            </div>
                            <h3 class="text-slate-400 text-xs font-black uppercase tracking-widest">Node Velocity</h3>
                            <p class="text-3xl font-black text-slate-900 mt-2">Active</p>
                            <button id="invite-btn" onclick="window.location.href='/team-view'" class="hidden mt-4 text-blue-600 text-sm font-black uppercase tracking-widest hover:text-blue-800 flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">add_circle</span> Invite member
                            </button>
                        </div>
                    </div>

                    <div class="bg-white p-10 rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 mb-10">
                        <div class="flex justify-between items-center mb-10">
                            <h3 class="text-2xl font-black text-slate-900 tracking-tight">Recent File Assets</h3>
                            <button onclick="window.location.href='/files-view'" class="px-6 py-2 bg-slate-50 text-slate-600 rounded-full text-xs font-bold hover:bg-slate-100 transition-all border border-slate-100">View All</button>
                        </div>
                        <div id="files-list" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="text-center py-16 bg-slate-50/50 rounded-[2rem] border-2 border-dashed border-slate-200 flex flex-col items-center">
                                <span class="material-symbols-outlined text-slate-300 text-5xl mb-4">folder_off</span>
                                <p class="text-slate-400 font-bold uppercase text-[10px] tracking-widest">Repository Empty</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', async () => {
        const token = localStorage.getItem('token');
        if (!token) window.location.href = '/login';

        try {
            const userRes = await fetch('/api/user', { headers: { 'Authorization': `Bearer ${token}` } });
            const user = await userRes.json();
            const role = user.role?.name || user.role || "normal_user";

            // ROLE-BASED UI RESTRICTIONS
            const isAdmin = (role === 'company_admin' || role === 'super_admin');

            if (isAdmin) {
                document.getElementById('admin-sidebar').classList.remove('hidden');
                document.getElementById('invite-btn').classList.remove('hidden');
            } else {
                // Remove Audit link permanently for Normal/Support
                const auditLink = document.getElementById('audit-link');
                if (auditLink) auditLink.remove();
                
                // Ensure management section is never visible
                const adminSection = document.getElementById('admin-sidebar');
                if (adminSection) adminSection.remove();
            }

            // Populate User Data
            document.getElementById('user-name').innerText = user.name;
            document.getElementById('user-initials').innerText = user.name.charAt(0).toUpperCase();
            document.getElementById('user-role').innerText = role.replace('_', ' ').toUpperCase();

            // Populate Files/Stats
            const fileRes = await fetch('/api/files', { headers: { 'Authorization': `Bearer ${token}` } });
            const filesArray = await fileRes.json();
            const fileCount = filesArray.length;
            const company = user.company || {};
            const isPro = (company.status === 'active' || company.status === 'approved');
            const limit = isPro ? 100 : 2;

            document.getElementById('plan-name').innerText = isPro ? 'Professional Pro' : 'Explorer Trial';
            document.getElementById('files-count').innerText = fileCount;
            document.getElementById('storage-limit').innerText = `QUOTA: ${limit} FILES`;
            
            const percentage = Math.min((fileCount / limit) * 100, 100);
            document.getElementById('storage-bar').style.width = `${percentage}%`;

            // Recent Files List
            if (fileCount > 0) {
                const list = document.getElementById('files-list');
                list.innerHTML = ''; 
                filesArray.slice(0, 4).forEach(file => {
                    list.innerHTML += `<div class="flex items-center justify-between p-6 bg-slate-50 border border-slate-100 rounded-3xl"><div class="flex items-center gap-5"><div class="h-12 w-12 bg-white rounded-2xl flex items-center justify-center shadow-sm"><span class="material-symbols-outlined text-blue-600 text-xl">description</span></div><p class="text-sm font-extrabold text-slate-800 truncate w-32 uppercase tracking-tighter">${file.filename}</p></div></div>`;
                });
            }

            document.getElementById('loading-screen').classList.add('opacity-0');
            setTimeout(() => {
                document.getElementById('loading-screen').classList.add('hidden');
                document.getElementById('app').classList.remove('hidden');
            }, 500);

        } catch (error) { window.location.href = '/login'; }
    });

    document.getElementById('logoutBtn').addEventListener('click', () => {
        localStorage.removeItem('token');
        window.location.href = '/login';
    });
</script>
</body>
</html>