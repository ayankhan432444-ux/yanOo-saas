<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Files - YanOo Brand</title>
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

                <a href="/files-view" class="flex items-center gap-4 px-5 py-4 rounded-2xl sidebar-active transition-all">
                    <span class="material-symbols-outlined">folder_open</span>
                    <span class="font-bold">My Files</span>
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
            <header class="glass h-20 flex items-center justify-between px-10 flex-shrink-0 z-40 bg-white/80 border-b border-slate-100">
                <h1 class="text-xl font-black text-slate-800 uppercase tracking-tighter">File Repository</h1>
                <button id="uploadBtn" onclick="document.getElementById('uploadInput').click()" class="hidden flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-2xl font-black text-xs uppercase tracking-widest transition-all shadow-lg shadow-blue-500/30">
                    <span class="material-symbols-outlined text-sm">cloud_upload</span> Upload Node Asset
                </button>
                <input type="file" id="uploadInput" class="hidden" onchange="handleUpload(this)">
            </header>

            <div class="flex-1 overflow-y-auto p-10 bg-white">
                <div class="max-w-7xl mx-auto w-full">
                    <div class="mb-10">
                        <h2 class="text-4xl font-extrabold text-slate-900 tracking-tight">Cloud <span class="text-blue-600">Assets</span></h2>
                        <p class="text-slate-400 mt-2 font-medium">Manage and synchronize company encrypted files.</p>
                    </div>

                    <div id="files-grid" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8 mb-10">
                        </div>
                </div>
            </div>
        </main>
    </div>

    <script>
    const token = localStorage.getItem('token');
    let userRole = 'normal_user';

    if (!token) window.location.href = '/login';

    async function checkRoleAndInit() {
        try {
            const res = await fetch('/api/user', { headers: { 'Authorization': `Bearer ${token}` } });
            const user = await res.json();
            userRole = user.role?.name || user.role || 'normal_user';

            // Sidebar Visibility Logic
            const isAdmin = (userRole === 'company_admin' || userRole === 'super_admin');
            const isSupport = (userRole === 'support_user');

            if (isAdmin) {
                document.getElementById('admin-sidebar').classList.remove('hidden');
            } else {
                document.getElementById('audit-link').remove(); // Hide Audit for Support/Normal
            }

            // Upload Button Logic (Hides for Normal User)
            if (isAdmin || isSupport) {
                document.getElementById('uploadBtn').classList.remove('hidden');
            }

            loadFiles();
        } catch (e) { window.location.href = '/login'; }
    }

    async function loadFiles() {
        try {
            const res = await fetch('/api/files', { 
                headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' } 
            });
            const json = await res.json();
            const container = document.getElementById('files-grid');
            container.innerHTML = '';
            const files = json.data || json; 

            if (!files || files.length === 0) {
                container.innerHTML = `<div class="col-span-full text-center py-20 bg-slate-50 rounded-[2.5rem] border-2 border-dashed border-slate-200"><span class="material-symbols-outlined text-slate-300 text-6xl mb-4">folder_open</span><p class="text-slate-400 font-black uppercase text-xs tracking-widest">No assets found</p></div>`;
                return;
            }

            const canDelete = (userRole === 'company_admin' || userRole === 'support_user' || userRole === 'super_admin');

            files.forEach(file => {
                container.innerHTML += `
                    <div class="bg-white p-6 rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 group relative">
                        <div class="h-40 bg-slate-50 rounded-3xl flex items-center justify-center mb-6">
                            <span class="material-symbols-outlined text-blue-600 text-6xl">description</span>
                        </div>
                        <h3 class="font-black text-slate-800 truncate uppercase tracking-tighter text-sm">${file.filename}</h3>
                        <p class="text-[10px] font-black text-slate-400 mt-1 uppercase tracking-widest">Secure Asset</p>
                        
                        ${canDelete ? `
                        <button onclick="deleteFile(${file.id})" class="absolute top-4 right-4 h-10 w-10 bg-white text-red-500 rounded-xl shadow-sm flex items-center justify-center opacity-0 group-hover:opacity-100 hover:bg-red-50 border border-slate-100">
                            <span class="material-symbols-outlined text-sm">delete</span>
                        </button>` : ''}
                    </div>`;
            });
        } catch (e) {}
    }

    async function handleUpload(input) {
        const file = input.files[0];
        if (!file) return;
        const formData = new FormData();
        formData.append('file', file);
        const btn = document.getElementById('uploadBtn');
        btn.disabled = true;

        try {
            const res = await fetch('/api/files/upload', {
                method: 'POST',
                headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' },
                body: formData
            });
            if (res.ok) { loadFiles(); }
            else { const r = await res.json(); alert(r.message || "Quota limit"); }
        } catch (e) {}
        finally { btn.disabled = false; input.value = ''; }
    }

    async function deleteFile(id) {
        if (!confirm("Terminate asset?")) return;
        try {
            await fetch('/api/files/' + id, { method: 'DELETE', headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' } });
            loadFiles();
        } catch (e) {}
    }

    checkRoleAndInit();
    document.getElementById('logoutBtn').addEventListener('click', () => {
        localStorage.removeItem('token');
        window.location.href = '/login';
    });
    </script>
</body>
</html>