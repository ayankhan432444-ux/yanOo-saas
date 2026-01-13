<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support Hub - YanOo Brand</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; overflow: hidden; }
        .glass { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(255, 255, 255, 0.3); }
        .sidebar-active { background: linear-gradient(to right, #2563eb, #4f46e5); box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.3); color: white !important; }
        #chat-container::-webkit-scrollbar { width: 4px; }
        #chat-container::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
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
                <a href="/support-view" class="flex items-center gap-4 px-5 py-4 rounded-2xl sidebar-active transition-all">
                    <span class="material-symbols-outlined">chat_bubble</span>
                    <span class="font-bold">Support</span>
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

        <main class="flex-1 flex flex-col h-full overflow-hidden bg-white">
            <header class="glass h-20 flex items-center justify-between px-10 flex-shrink-0 z-40 bg-white/80 border-b border-slate-100">
                <div class="flex items-center gap-4">
                    <div class="h-10 w-10 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined">support_agent</span>
                    </div>
                    <div>
                        <h1 class="text-lg font-black text-slate-800 tracking-tighter uppercase">YanOo Support Hub</h1>
                        <p class="text-[10px] font-bold text-green-500 uppercase tracking-widest">● Secure Node Active</p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-sm font-black text-slate-900" id="user-name">...</div>
                    <div class="text-[10px] font-bold text-blue-600 uppercase tracking-tighter" id="user-role">...</div>
                </div>
            </header>

            <div class="flex-1 p-8 overflow-y-auto bg-slate-50/50 space-y-6" id="chat-container">
                <div class="flex flex-col items-center justify-center h-full text-slate-300" id="empty-state">
                    <div class="p-6 bg-white rounded-full shadow-xl shadow-slate-200 mb-6">
                        <span class="material-symbols-outlined text-5xl">forum</span>
                    </div>
                    <p class="font-black uppercase text-[10px] tracking-widest">No Active Conversations</p>
                </div>
            </div>

            <div class="p-8 bg-white border-t border-slate-100 flex-shrink-0">
                <form id="chatForm" class="max-w-5xl mx-auto relative group">
                    <input type="text" id="messageInput" required placeholder="Describe your issue..." 
                        class="w-full pl-6 pr-32 py-5 bg-slate-50 border border-slate-200 rounded-[2rem] focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-medium text-slate-700">
                    <button type="submit" class="absolute right-2 top-2 bottom-2 bg-blue-600 hover:bg-blue-700 text-white px-8 rounded-[1.8rem] font-black text-xs uppercase tracking-widest transition-all flex items-center gap-2 shadow-lg shadow-blue-500/30">
                        <span class="material-symbols-outlined text-sm">send</span> Send
                    </button>
                </form>
            </div>
        </main>
    </div>

<script>
    const token = localStorage.getItem('token');
    if (!token) window.location.href = '/login';

    const container = document.getElementById('chat-container');
    const emptyState = document.getElementById('empty-state');
    let currentUserId = null;

    async function init() {
        try {
            const userRes = await fetch('/api/user', { headers: { 'Authorization': `Bearer ${token}` } });
            const user = await userRes.json();
            currentUserId = user.id;

            let roleName = user.role?.name || user.role || "normal_user";
            document.getElementById('user-name').innerText = user.name;
            document.getElementById('user-role').innerText = roleName.replace('_', ' ').toUpperCase();

            // SECURITY: Role-based element removal
            if (roleName === 'company_admin' || roleName === 'super_admin') {
                document.getElementById('admin-sidebar').classList.remove('hidden');
            } else {
                // Remove restricted links for Normal/Support users
                const auditLink = document.getElementById('audit-link');
                if (auditLink) auditLink.remove();
                
                const adminSection = document.getElementById('admin-sidebar');
                if (adminSection) adminSection.remove();
            }

            loadMessages();
            setInterval(loadMessages, 10000);
        } catch(e) { window.location.href = '/login'; }
    }
    init();

    async function loadMessages() {
        try {
            const res = await fetch('/api/messages', { headers: { 'Authorization': `Bearer ${token}` } });
            const messages = await res.json();
            
            if (messages.length > 0) {
                emptyState.classList.add('hidden');
                container.innerHTML = ''; 
                
                messages.forEach(msg => {
                    const isMe = (msg.user_id === currentUserId); 
                    const align = isMe ? 'justify-end' : 'justify-start';
                    const bubbleStyle = isMe 
                        ? 'bg-blue-600 text-white rounded-[2rem] rounded-tr-none shadow-xl shadow-blue-500/20' 
                        : 'bg-white border border-slate-100 text-slate-700 rounded-[2rem] rounded-tl-none shadow-sm';
                    const senderName = isMe ? 'You' : 'YanOo Support';

                    container.innerHTML += `<div class="flex ${align}"><div class="max-w-xl"><div class="px-8 py-5 ${bubbleStyle}"><p class="text-sm font-medium leading-relaxed">${msg.message || msg.content}</p></div><p class="text-[9px] font-black text-slate-400 mt-2 px-2 uppercase tracking-widest ${isMe ? 'text-right' : 'text-left'}">${senderName} • Sent</p></div></div>`;
                });
                container.scrollTop = container.scrollHeight;
            }
        } catch(e) {}
    }

    document.getElementById('chatForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const input = document.getElementById('messageInput');
        const message = input.value;
        emptyState.classList.add('hidden');
        input.value = '';

        try {
            const res = await fetch('/api/messages', {
                method: 'POST',
                headers: { 'Authorization': `Bearer ${token}`, 'Content-Type': 'application/json' },
                body: JSON.stringify({ message: message }) 
            });
            if(res.ok) loadMessages(); 
        } catch(e) {}
    });

    document.getElementById('logoutBtn').addEventListener('click', () => {
        localStorage.removeItem('token');
        window.location.href = '/login';
    });
</script>
</body>
</html>