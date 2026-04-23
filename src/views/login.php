<?php
include_once __DIR__ . '/../config/paths.php';
if (session_status() === PHP_SESSION_NONE) { session_start(); }

// Captura de errores específica
$errorRegistre = $_SESSION['errUserRegistre'] ?? null;
$errorLogin = $_SESSION['msgError'] ?? null;

// Limpiamos solo los errores para no desloguear al usuario
if($errorRegistre) unset($_SESSION['errUserRegistre']);
if($errorLogin) unset($_SESSION['msgError']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso al Sistema | TAGPRICE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;700;900&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: '#34d399',
                        surface: '#050a07',
                        'surface-mid': '#0d1a12',
                        'surface-border': '#1a2e23',
                    },
                    fontFamily: {
                        display: ['Barlow Condensed', 'sans-serif'],
                        body: ['DM Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-surface text-slate-300 font-body min-h-screen flex items-center justify-center p-4 overflow-hidden">
    
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden -z-10">
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-brand/5 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-brand/5 rounded-full blur-[120px]"></div>
    </div>

    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <a href="<?=URL_BASE?>index.php" class="inline-block group transition-transform duration-300 active:scale-95">
                <h1 class="font-display text-5xl font-black text-white uppercase tracking-tighter italic leading-none group-hover:text-brand transition-colors">
                    TAG<span class="text-brand group-hover:text-white transition-colors">PRICE</span><span class="text-[12px] align-top text-brand/50 ml-1 italic font-bold">v1.0</span>
                </h1>
                <div class="flex items-center justify-center gap-2 mt-3 overflow-hidden">
                    <span class="h-[1px] w-0 bg-brand group-hover:w-6 transition-all duration-500"></span>
                    <p class="text-[9px] font-bold uppercase tracking-[0.4em] text-slate-500 italic group-hover:text-slate-300 transition-colors">
                        Regresar al Panel Principal
                    </p>
                    <span class="h-[1px] w-0 bg-brand group-hover:w-6 transition-all duration-500"></span>
                </div>
            </a>
        </div>

        <div id="container-login" class="bg-surface-mid border border-surface-border p-8 rounded-3xl shadow-2xl shadow-black/50 backdrop-blur-sm">
            <div class="flex items-center justify-between mb-6">
                <h2 class="font-display text-2xl font-bold text-white uppercase tracking-tight">Iniciar Sesión</h2>
                <span class="text-[10px] font-bold text-brand/40 bg-brand/5 px-2 py-1 rounded border border-brand/10">AUTH_MODE</span>
            </div>
            
            <?php if($errorLogin): ?>
                <div class="bg-red-500/10 border border-red-500/20 text-red-400 text-[11px] font-bold uppercase tracking-wider p-3 rounded-xl mb-6 flex items-center gap-2">
                    <span class="w-1.5 h-1.5 bg-red-500 rounded-full animate-pulse"></span>
                    <?= htmlspecialchars($errorLogin) ?>
                </div>
            <?php endif; ?>

            <form action="<?=URL_BASE?>actions/login.proc.php" method="POST" class="space-y-5">
                <div>
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 ml-1">Terminal ID</label>
                    <input type="email" name="usu_mail" placeholder="usuario@dominio.com" required
                           class="w-full bg-surface border border-surface-border rounded-xl px-4 py-3 mt-1 text-white placeholder:text-slate-700 focus:outline-none focus:border-brand/50 focus:ring-1 focus:ring-brand/20 transition-all">
                </div>
                
                <div>
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 ml-1">Access Key</label>
                    <input type="password" name="usu_password" placeholder="••••••••" required
                           class="w-full bg-surface border border-surface-border rounded-xl px-4 py-3 mt-1 text-white placeholder:text-slate-700 focus:outline-none focus:border-brand/50 focus:ring-1 focus:ring-brand/20 transition-all">
                </div>
                
                <button type="submit" 
                        class="w-full bg-brand hover:bg-brand-light text-surface font-display font-bold uppercase tracking-widest py-4 rounded-xl transition-all active:scale-95 shadow-lg shadow-brand/10 mt-2">
                    Establecer Conexión
                </button>
            </form>
            <p class="text-center mt-8 text-sm text-slate-500 font-medium">
                ¿No tienes cuenta? 
                <a href="#" id="btn-show-registre" class="text-brand font-bold hover:text-brand-light transition-colors ml-1 underline underline-offset-4 decoration-brand/20">Regístrate aquí</a>
            </p>
        </div>

        <div id="container-registre" style="display: none;" class="bg-surface-mid border border-surface-border p-8 rounded-3xl shadow-2xl shadow-black/50 backdrop-blur-sm">
            <div class="flex items-center justify-between mb-6">
                <h2 class="font-display text-2xl font-bold text-white uppercase tracking-tight">Nuevo Registro</h2>
                <span class="text-[10px] font-bold text-brand/40 bg-brand/5 px-2 py-1 rounded border border-brand/10">NEW_ACCOUNT</span>
            </div>
            
            <?php if($errorRegistre): ?>
                <div class="bg-red-500/10 border border-red-500/20 text-red-400 text-[11px] font-bold uppercase tracking-wider p-3 rounded-xl mb-6 flex items-center gap-2">
                    <span class="w-1.5 h-1.5 bg-red-500 rounded-full animate-pulse"></span>
                    <?= htmlspecialchars($errorRegistre) ?>
                </div>
            <?php endif; ?>

            <form action="<?=URL_BASE?>actions/registre.proc.php" method="POST" class="space-y-4">
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 ml-1">User Identity</label>
                        <input type="text" name="name" placeholder="Nombre completo" required 
                               class="w-full bg-surface border border-surface-border rounded-xl px-4 py-3 mt-1 text-white placeholder:text-slate-700 focus:outline-none focus:border-brand/50 transition-all">
                    </div>
                    <div>
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 ml-1">Email Connection</label>
                        <input type="email" name="email" placeholder="email@ejemplo.com" required 
                               class="w-full bg-surface border border-surface-border rounded-xl px-4 py-3 mt-1 text-white placeholder:text-slate-700 focus:outline-none focus:border-brand/50 transition-all">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 ml-1">Secret Key</label>
                        <input type="password" name="password" placeholder="••••" required 
                               class="w-full bg-surface border border-surface-border rounded-xl px-4 py-3 mt-1 text-white placeholder:text-slate-700 focus:outline-none focus:border-brand/50 transition-all">
                    </div>
                    <div>
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 ml-1">Confirm</label>
                        <input type="password" name="password_confirm" placeholder="••••" required 
                               class="w-full bg-surface border border-surface-border rounded-xl px-4 py-3 mt-1 text-white placeholder:text-slate-700 focus:outline-none focus:border-brand/50 transition-all">
                    </div>
                </div>

                <button type="submit" 
                        class="w-full bg-transparent border border-brand/40 text-brand hover:bg-brand hover:text-surface font-display font-bold uppercase tracking-widest py-4 rounded-xl transition-all active:scale-95 mt-4 shadow-lg shadow-brand/5">
                    Crear Identidad
                </button>
            </form>
            <p class="text-center mt-8 text-sm text-slate-500 font-medium">
                ¿Ya tienes cuenta? 
                <a href="#" id="btn-show-login" class="text-brand font-bold hover:text-brand-light transition-colors ml-1 underline underline-offset-4 decoration-brand/20">Inicia sesión</a>
            </p>
        </div>
    </div>

    <script src="<?=URL_BASE?>public/js/login-switcher.js"></script>
    <script>
        // Lógica de autorevelación si hay errores en el proceso de registro
        <?php if($errorRegistre): ?>
            document.getElementById('container-login').style.display = 'none';
            document.getElementById('container-registre').style.display = 'block';
        <?php endif; ?>
    </script>
</body>
</html>