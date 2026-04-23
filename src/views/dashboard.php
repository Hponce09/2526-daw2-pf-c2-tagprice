<?php

require_once __DIR__ . '/../config/paths.php';

session_start();
if(!isset($_SESSION['producto'])){
    header('Location:' . URL_BASE . 'index.php');
    exit;
}

include PATH_BASE .'includes/header.php';

if(isset($_SESSION['producto'])){
    ?>
<main class="py-12 px-6 min-h-[calc(100vh-96px)] flex items-center justify-center">

    <div class="max-w-5xl w-full bg-surface-mid border border-surface-border rounded-3xl overflow-hidden shadow-2xl shadow-brand/5 group transition-all duration-500 hover:border-brand/20 flex flex-col md:flex-row">
        
        <div class="relative w-full md:w-[40%] bg-white/5 border-b md:border-b-0 md:border-r border-surface-border flex items-center justify-center p-8 overflow-hidden">
            <img src="<?php echo $_SESSION['producto']['imagen']; ?>" 
                 class="w-full h-auto max-h-[400px] object-contain transition-transform duration-700 group-hover:scale-105" 
                 alt="Producto">
            
            <div class="absolute top-6 left-6">
                <span class="bg-surface/80 backdrop-blur-md text-brand border border-brand/20 text-[10px] font-bold px-3 py-1.5 rounded-lg uppercase tracking-widest">
                    Live Feed
                </span>
            </div>
        </div>

        <div class="w-full md:w-[60%] p-10 flex flex-col justify-center">
            
            <div class="text-[11px] font-bold text-slate-500 uppercase tracking-[0.3em] mb-3">
                Product Analysis Result
            </div>

            <h2 class="font-display text-3xl md:text-4xl font-bold text-white uppercase tracking-tight mb-8 leading-tight">
                <?php echo htmlspecialchars($_SESSION['producto']['nombre']); ?>
            </h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-10">
                
                <div class="bg-surface border border-surface-border p-6 rounded-2xl">
                    <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500 block mb-2">Current Value</span>
                    <p class="text-5xl font-display font-bold text-brand tracking-tight leading-none">
                        <?php echo $_SESSION['producto']['precioRebajado']; ?><span class="text-xl ml-1">€</span>
                    </p>
                </div>

                <div class="bg-surface/50 border border-surface-border p-6 rounded-2xl flex flex-col justify-center">
                    <?php if ((float)$_SESSION['producto']['precio'] > (float)$_SESSION['producto']['precioRebajado']): ?>
                        <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500 block mb-1">MSRP (Original)</span>
                        <p class="text-xl text-slate-500 line-through font-medium mb-2"><?php echo $_SESSION['producto']['precio']; ?> €</p>
                        <span class="inline-flex text-[9px] font-bold uppercase tracking-[0.2em] text-brand bg-brand/10 border border-brand/20 px-2 py-1 rounded-md w-fit">
                            Under Market
                        </span>
                    <?php else: ?>
                        <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500 block mb-1">Price Status</span>
                        <p class="text-lg text-white font-bold uppercase tracking-wide">Stable Market</p>
                    <?php endif; ?>
                </div>
            </div>

            <form action="<?= URL_BASE ?>actions/favoritos.proc.php" method="POST">
                <input type="hidden" name="nombre" value="<?php echo htmlspecialchars($_SESSION['producto']['nombre']); ?>">
                <input type="hidden" name="precio" value="<?php echo $_SESSION['producto']['precioRebajado']; ?>">
                <input type="hidden" name="imagen" value="<?php echo $_SESSION['producto']['imagen']; ?>">
                <input type="hidden" name="url" value="<?php echo $_SESSION['producto']['url']; ?>">

                <button type="submit" 
                        class="w-full group/btn relative flex items-center justify-center gap-4 bg-brand text-surface hover:bg-brand-light px-8 py-5 rounded-2xl font-display font-bold uppercase tracking-[0.2em] transition-all duration-300 active:scale-[0.98] overflow-hidden shadow-xl shadow-brand/10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 transition-transform group-hover/btn:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                    </svg>
                    <span class="text-base">Añadir al Vault Personal</span>
                </button>
            </form>
        </div>
    </div>
</main>

    <?php
}

?>