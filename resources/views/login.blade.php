<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | YanOo Brand</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: radial-gradient(circle at top right, #f8fafc, #e2e8f0);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-y: auto;
        }
        .login-card { 
            background: rgba(255, 255, 255, 0.98); 
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
        }
        .input-field {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            transition: all 0.2s ease;
        }
        .input-field:focus {
            background: white;
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.05);
        }
        /* Floating Animation for Logo */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        .float-logo { animation: float 3s ease-in-out infinite; }
    </style>
</head>
<body class="p-4 py-10">

    <div class="login-card w-full max-w-[340px] p-8 rounded-[2rem] animate-in fade-in zoom-in duration-500">
        
        <div class="text-center mb-6">
            <div class="float-logo inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-blue-600 text-white mb-4 shadow-lg shadow-blue-500/30">
                <span class="material-symbols-outlined text-2xl">cloud_queue</span>
            </div>
            <h1 class="text-xl font-black text-slate-900 tracking-tighter uppercase italic">Welcome Back</h1>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">YanOo Identity Gateway</p>
        </div>

        <form id="loginForm" class="space-y-4">
            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Email</label>
                <input type="email" id="email" required placeholder="name@yanoo.com" 
                    class="input-field w-full px-4 py-3 rounded-xl outline-none text-sm font-medium text-slate-700">
            </div>

            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Password</label>
                <input type="password" id="password" required placeholder="••••••••" 
                    class="input-field w-full px-4 py-3 rounded-xl outline-none text-sm font-medium text-slate-700">
            </div>

            <div class="pt-2">
                <button type="submit" id="loginBtn" class="w-full bg-slate-900 hover:bg-black text-white font-bold py-3.5 rounded-xl text-[11px] uppercase tracking-widest transition-all flex items-center justify-center gap-2">
                    Login
                    <span class="material-symbols-outlined text-sm">login</span>
                </button>
            </div>
        </form>

        <div class="mt-6 pt-5 border-t border-slate-50 text-center">
            <a href="/register-view" class="text-blue-600 font-bold uppercase text-[10px] tracking-widest hover:underline">
                Create Account
            </a>
        </div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const btn = document.getElementById('loginBtn');
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            
            btn.innerHTML = `<div class="h-3 w-3 border-2 border-white border-t-transparent rounded-full animate-spin"></div>`;
            btn.disabled = true;

            try {
                const res = await fetch('/api/login', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                    body: JSON.stringify({ email, password })
                });
                const data = await res.json();

                if (res.ok) {
                    localStorage.setItem('token', data.token);
                    const userRes = await fetch('/api/user', { headers: { 'Authorization': `Bearer ${data.token}` } });
                    const user = await userRes.json();
                    
                    if (user.role === 'super_admin' || user.role?.name === 'super_admin') {
                        window.location.href = '/super-admin';
                    } else {
                        window.location.href = '/dashboard-view';
                    }
                } else {
                    alert('Denied: ' + (data.message || 'Invalid Login'));
                    btn.innerHTML = `Login <span class="material-symbols-outlined text-sm">login</span>`;
                    btn.disabled = false;
                }
            } catch (err) {
                alert('Server Connection Error');
                btn.disabled = false;
            }
        });
    </script>
</body>
</html>