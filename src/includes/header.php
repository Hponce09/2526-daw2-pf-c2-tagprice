<?php
// --- 1. LÓGICA DE CONTROL ---
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Iniciales para el avatar
$initials = '';
if (isset($_SESSION['name_user'])) {
    $parts = explode(' ', trim($_SESSION['name_user']));
    foreach (array_slice($parts, 0, 2) as $p) {
        $initials .= strtoupper(mb_substr($p, 0, 1));
    }
}

// Enlace de inicio según rol
$homeLink = URL_BASE . "index.php";
if (isset($_SESSION['rol_usu'])) {
    $homeLink = ($_SESSION['rol_usu'] === 'admin')
        ? URL_BASE . "views/panelAdmin.php"
        : URL_BASE . "index.php";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TagPrice | Sport Price Tracker</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@700;900&family=DM+Sans:opsz,wght@9..40,400;9..40,500&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="<?= URL_BASE ?>public/css/style.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        display: ['"Barlow Condensed"', 'sans-serif'],
                        body:    ['"DM Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: { DEFAULT: '#34d371', light: '#4ade80', dark: '#22a855' },
                        surface: { DEFAULT: '#0a0f0d', mid: '#0d1a12', border: '#1e2e24' },
                    },
                    backgroundImage: { 
                        'grid-lines': "repeating-linear-gradient(90deg, transparent, transparent 59px, rgba(52,211,113,0.04) 59px, rgba(52,211,113,0.04) 60px)" 
                    },
                },
            },
        }
    </script>
</head>
<body class="bg-surface font-body">

    <header class="bg-surface relative overflow-hidden border-b border-surface-border">
        <div class="absolute inset-0 bg-grid-lines pointer-events-none" aria-hidden="true"></div>

        <div class="relative max-w-[1600px] mx-auto px-8 flex items-center justify-between h-24">

            <a href="<?= $homeLink ?>" class="flex items-center gap-4 group no-underline focus:outline-none">
                <div class="relative w-11 h-11 flex-shrink-0">
                    <svg viewBox="0 0 36 36" fill="none" class="w-11 h-11 transition-transform group-hover:scale-105" aria-hidden="true">
                        <rect width="36" height="36" rx="8" fill="#0d2016"/>
                        <polyline points="5,26 12,15 19,20 30,7" stroke="#34d371" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="30" cy="7" r="3.2" fill="#4ade80"/>
                        <polyline points="24,7 30,7 30,13" stroke="#4ade80" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="flex flex-col leading-none">
                    <span class="font-display font-black text-[2.2rem] tracking-tighter uppercase text-white leading-none">
                        Tag<span class="text-brand">Price</span>
                    </span>
                    <span class="font-display font-bold text-[0.7rem] tracking-[0.3em] uppercase text-brand opacity-60 mt-1">
                        Sport Price Tracker
                    </span>
                </div>
            </a>

            <div class="flex items-center">
                <?php if (isset($_SESSION['autenticated']) && $_SESSION['autenticated'] === true): ?>
                    
                    <nav class="hidden md:flex items-center gap-8 mr-4">
                        <a href="<?= URL_BASE ?>views/favoritos.php" 
                            class="flex items-center gap-3 px-3 py-2 rounded-lg text-[#8ca897] hover:text-white hover:bg-brand/10 text-[14px] font-bold uppercase tracking-widest transition-all no-underline group">
                            <svg class="w-5 h-5 opacity-70 group-hover:opacity-100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                            </svg>
                            Favoritos
                        </a>
                        <a href="<?= URL_BASE ?>views/historial.php" 
                            class="flex items-center gap-3 px-3 py-2 rounded-lg text-[#8ca897] hover:text-white hover:bg-brand/10 text-[14px] font-bold uppercase tracking-widest transition-all no-underline group">
                            <svg class="w-5 h-5 opacity-70 group-hover:opacity-100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path>
                                <path d="M3 3v5h5"></path>
                                <path d="M12 7v5l4 2"></path>
                            </svg>
                            Historial
                        </a>
                    </nav>

                    <div class="hidden md:block w-px h-10 bg-surface-border mx-8 opacity-50"></div>

                    <div class="flex items-center gap-8">
                        <div class="w-12 h-12 rounded-xl bg-brand/10 border border-brand/20 flex items-center justify-center shadow-lg shadow-brand/5">
                            <span class="font-body font-bold text-lg text-brand uppercase tracking-[0.1em] ml-[0.1em]">
                                <?= htmlspecialchars($initials) ?>
                            </span>
                        </div>

                        <a href="<?= URL_BASE ?>actions/logout.php" 
                            class="group flex items-center gap-3 px-6 py-3.5 rounded-xl bg-rose-500/5 border border-rose-500/10 hover:bg-rose-500/10 hover:border-rose-500/30 transition-all no-underline active:scale-95">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-rose-500 group-hover:-translate-x-1 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" /><polyline points="16 17 21 12 16 7" /><line x1="21" y1="12" x2="9" y2="12" />
                            </svg>
                            <span class="text-[12px] font-black uppercase tracking-[0.2em] text-rose-500/90 group-hover:text-rose-500">
                                Cerrar sesión
                            </span>
                        </a>
                    </div>

                <?php else: ?>
                    <a href="<?= URL_BASE ?>views/login.php" 
                        class="group flex items-center gap-4 pl-6 pr-2 py-2 rounded-full bg-brand/5 border border-brand/20 hover:bg-brand/10 hover:border-brand/40 transition-all no-underline">
                        <span class="text-[12px] font-black uppercase tracking-[0.2em] text-brand/80 group-hover:text-brand">Acceso Sistema</span>
                        <div class="w-10 h-10 rounded-full bg-brand flex items-center justify-center shadow-lg shadow-brand/20 group-hover:scale-110 transition-transform">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-surface" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                            </svg>
                        </div>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </header>
