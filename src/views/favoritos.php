<?php
session_start();
require_once __DIR__ . '/../config/paths.php';
include_once PATH_BASE . 'includes/db_connect.php';

if(!isset($_SESSION['autenticated']) || $_SESSION['autenticated'] !== true){
    header('Location:' . URL_BASE . 'views/login.php');
    exit;
}

include PATH_BASE .'includes/header.php';

$usu_id = $_SESSION['id_user'];

$sql = "SELECT p.product_id, p.nombre, p.imagen, p.precio_actual, f.fecha_agregado 
        FROM product p
        INNER JOIN favorites f ON p.product_id = f.product_id
        WHERE f.usu_id = :usu_id
        ORDER BY f.fecha_agregado DESC";

$stmt = $db->prepare($sql);
$stmt->bindValue(':usu_id', $usu_id, PDO::PARAM_INT);
$stmt->execute();

$mis_favoritos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="min-h-screen py-12 px-4 relative">
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-[400px] bg-brand/5 rounded-full blur-[120px] pointer-events-none"></div>

    <div class="relative max-w-5xl mx-auto">
        <header class="mb-12 border-b border-surface-border pb-8">
            <div class="flex items-center gap-4 mb-2">
                
                <h1 class="text-4xl md:text-5xl font-display font-bold text-white uppercase tracking-tight">
                    Mi <span class="text-brand">Vault</span> <span class="font-light text-slate-300">Personal</span>
                </h1>
            </div>
            <p class="text-slate-500 font-body uppercase tracking-[0.4em] text-[9px] font-black opacity-70">
                Sistemas de Monitoreo de Activos // Nivel 01
            </p>
        </header>

        <?php if (!$mis_favoritos): ?>
            <div class="bg-surface-mid/30 border border-surface-border p-20 rounded-3xl text-center backdrop-blur-sm">
                <p class="text-slate-500 uppercase tracking-widest font-bold text-xs mb-6">La terminal está vacía</p>
                <a href="index.php" class="text-brand border border-brand/30 px-6 py-2 rounded-full hover:bg-brand/10 transition-all uppercase text-[11px] font-black tracking-widest">Iniciar Rastreo</a>
            </div>
        <?php else: ?>
            <div class="grid gap-4">
                <?php foreach ($mis_favoritos as $prod): ?>
                    <div class="group relative flex items-center bg-surface-mid/40 backdrop-blur-md border border-surface-border p-4 rounded-2xl hover:border-brand/30 transition-all duration-500 overflow-hidden">
                        
                        <div class="absolute inset-0 bg-gradient-to-r from-brand/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>

                        <div class="relative w-24 h-24 bg-white rounded-xl overflow-hidden flex-shrink-0 p-2 border border-surface-border shadow-2xl">
                            <img src="<?= $prod['imagen'] ?>" alt="Producto" class="w-full h-full object-contain">
                        </div>

                        <div class="ml-8 flex-grow">
                            <h3 class="text-white font-display font-bold text-lg uppercase tracking-tight leading-tight max-w-md group-hover:text-brand transition-colors">
                                <?= htmlspecialchars($prod['nombre']) ?>
                            </h3>
                            <div class="flex items-center gap-6 mt-3">
                                <div>
                                    <p class="text-[9px] text-slate-500 uppercase font-black tracking-widest mb-1">Valor Actual</p>
                                    <p class="text-2xl font-black text-brand tracking-tighter">
                                        <?= number_format($prod['precio_actual'], 2) ?>€
                                    </p>
                                </div>
                                <div class="h-8 w-[1px] bg-surface-border"></div>
                                <div>
                                    <p class="text-[9px] text-slate-500 uppercase font-black tracking-widest mb-1">Rastreado desde</p>
                                    <p class="text-xs text-slate-300 font-bold"><?= date('d.m.Y', strtotime($prod['fecha_agregado'])) ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="relative z-10 ml-4">
                            <a href="history_product.php?id=<?= $prod['product_id'] ?>" 
                               class="flex flex-col items-center justify-center w-32 h-20 bg-surface-dark border border-surface-border rounded-xl hover:bg-brand hover:border-brand transition-all group/btn shadow-inner">
                                <span class="text-[10px] font-black uppercase tracking-tighter text-slate-400 group-hover/btn:text-surface mb-1">Ver Análisis</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-brand group-hover/btn:text-surface group-hover/btn:translate-y-1 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</main>