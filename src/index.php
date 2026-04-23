<?php
require_once __DIR__ . '/config/paths.php';
if (session_status() === PHP_SESSION_NONE) { session_start(); }

include PATH_BASE .'includes/header.php';

// Capturamos el error si existe
$errorUrl = $_SESSION['errorUrl'] ?? null;
if ($errorUrl) { 
    unset($_SESSION['errorUrl']); 
}
?>

<main class="relative min-h-[calc(100vh-96px)] flex flex-col items-center justify-center px-4 overflow-hidden">
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[500px] bg-brand/5 rounded-full blur-[140px] pointer-events-none"></div>

    <div class="relative w-full max-w-4xl mx-auto text-center">

        <?php if ($errorUrl): ?>
            <div class="inline-flex items-center gap-3 px-5 py-3 rounded-2xl bg-red-500/10 border border-red-500/20 mb-8 animate-in fade-in slide-in-from-top-4 duration-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span class="text-sm font-bold text-red-200 uppercase tracking-wide">
                    <?= htmlspecialchars($errorUrl) ?>
                </span>
            </div>
        <?php else: ?>
            <div class="inline-flex items-center gap-3 px-4 py-1.5 rounded-full bg-brand/5 border border-brand/10 mb-10">
                <span class="flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-2 w-2 rounded-full bg-brand opacity-40"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-brand"></span>
                </span>
                <span class="text-[11px] font-bold uppercase tracking-[0.3em] text-brand/80">Protocolo de Rastreo Activo</span>
            </div>
        <?php endif; ?>

        <h1 class="font-display text-6xl md:text-8xl font-bold text-white uppercase tracking-tight mb-6 leading-[0.9]">
            Rastrea el <span class="text-brand font-black">Precio</span>
        </h1>
        
        <p class="text-slate-400 text-xl mb-14 max-w-2xl mx-auto font-body leading-relaxed">
            Monitoreo inteligente de métricas deportivas. <br>
            <span class="text-slate-500 text-base">Analiza tendencias de valor en tiempo real con precisión milimétrica.</span>
        </p>

        <form action="<?=URL_BASE?>actions/procesar_url.proc.php" method="POST" class="relative max-w-3xl mx-auto">
            <div class="relative flex items-center p-2.5 rounded-2xl bg-surface-mid/50 backdrop-blur-sm border border-surface-border focus-within:border-brand/40 focus-within:ring-1 focus-within:ring-brand/20 transition-all duration-500">
                
                <div class="pl-5 pr-3 text-brand/50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>

                <input type="text" 
                       name="url" 
                       placeholder="Pega aquí el enlace del producto..." 
                       class="w-full bg-transparent border-none focus:ring-0 text-white placeholder:text-slate-600 py-4 px-2 text-lg font-body"
                       required>

                <button type="submit" 
                        class="flex items-center gap-3 bg-brand hover:bg-brand-light text-surface font-bold uppercase tracking-[0.1em] px-10 py-4 rounded-xl transition-all duration-300 hover:shadow-[0_0_20px_rgba(52,211,113,0.3)] active:scale-95 group">
                    <span>Analizar</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </button>
            </div>
            
            <div class="mt-6 flex justify-center items-center gap-8 opacity-40">
                <span class="text-[9px] text-slate-400 uppercase tracking-[0.3em] font-bold">Redes de datos optimizadas</span>
                <span class="w-1 h-1 bg-slate-600 rounded-full"></span>
                <span class="text-[9px] text-slate-400 uppercase tracking-[0.3em] font-bold">Análisis 24/7</span>
            </div>
        </form>
    </div>
</main>