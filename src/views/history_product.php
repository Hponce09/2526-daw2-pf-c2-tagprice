<?php
session_start();
require_once __DIR__ . '/../config/paths.php';
include_once PATH_BASE . 'includes/db_connect.php';

// 1. Seguridad y captura de ID
$id_producto = $_GET['id'] ?? null;
if (!$id_producto) { header('Location: favoritos.php'); exit; }

// 2. Obtener datos del producto
$stmt = $db->prepare("SELECT * FROM product WHERE product_id = ?");
$stmt->execute([$id_producto]);
$producto = $stmt->fetch(PDO::FETCH_ASSOC);

include PATH_BASE .'includes/header.php';
?>

<main class="min-h-screen py-10 px-4 relative bg-surface-dark">
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[500px] bg-brand/5 rounded-full blur-[150px] pointer-events-none"></div>

    <div class="relative max-w-6xl mx-auto">
        
        <a href="favoritos.php" class="inline-flex items-center text-slate-500 hover:text-brand transition-colors mb-8 group text-xs font-black uppercase tracking-widest">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7" />
            </svg>
            Volver al Vault
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-surface-mid/40 backdrop-blur-md border border-surface-border p-6 rounded-3xl">
                    <div class="bg-white rounded-2xl p-4 mb-6 shadow-2xl">
                        <img src="<?= $producto['imagen'] ?>" alt="" class="w-full h-48 object-contain">
                    </div>
                    <h1 class="text-2xl font-display font-bold text-white uppercase tracking-tight leading-tight mb-4">
                        <?= htmlspecialchars($producto['nombre']) ?>
                    </h1>
                    <div class="p-4 bg-brand/10 border border-brand/20 rounded-2xl">
                        <p class="text-[10px] text-brand uppercase font-black tracking-widest mb-1">Precio Actual</p>
                        <p class="text-4xl font-black text-brand tracking-tighter"><?= number_format($producto['precio_actual'], 2) ?>€</p>
                    </div>
                   <a href="<?= $producto['url_compra'] ?>" 
                        target="_blank" 
                        class="w-full mt-6 flex items-center justify-center gap-3 bg-white text-slate-900 font-black uppercase tracking-[0.2em] text-xs py-4 rounded-xl hover:bg-brand hover:text-white transition-all shadow-[0_10px_20px_rgba(255,255,255,0.05)]">
                        Ir a la tienda
                    </a>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-surface-mid/40 backdrop-blur-md border border-surface-border p-8 rounded-3xl h-full">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h2 class="text-xl font-display font-bold text-white uppercase">Análisis de Tendencia</h2>
                            <p class="text-slate-500 text-[10px] font-bold uppercase tracking-[0.3em]">Historial de fluctuación // 24H Sync</p>
                        </div>
                        <div class="flex gap-2">
                            <span class="px-3 py-1 bg-surface-dark border border-surface-border rounded-md text-[9px] font-black text-brand uppercase tracking-tighter">Live Feed</span>
                        </div>
                    </div>

                    <div class="relative h-[350px] w-full">
                        <canvas id="priceChart"></canvas>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('priceChart').getContext('2d');
const productId = <?= $id_producto ?>;

// Atacamos a tu API
fetch(`../api/get_history.php?id=${productId}`)
    .then(res => res.json())
    .then(data => {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'VALOR DE MERCADO (€)',
                    data: data.precios,
                    borderColor: '#2ecc71',
                    borderWidth: 4,
                    pointBackgroundColor: '#2ecc71',
                    pointBorderColor: 'rgba(255,255,255,0.2)',
                    pointRadius: 5,
                    pointHoverRadius: 8,
                    tension: 0.4, // Curva suave tipo trading
                    fill: true,
                    backgroundColor: (context) => {
                        const gradient = context.chart.ctx.createLinearGradient(0, 0, 0, 400);
                        gradient.addColorStop(0, 'rgba(46, 204, 113, 0.2)');
                        gradient.addColorStop(1, 'rgba(46, 204, 113, 0)');
                        return gradient;
                    }
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        grid: { color: 'rgba(255,255,255,0.05)', drawBorder: false },
                        ticks: { color: '#64748b', font: { weight: 'bold' } }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#64748b', font: { weight: 'bold' } }
                    }
                }
            }
        });
    });
</script>