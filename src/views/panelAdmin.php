<?php
require_once __DIR__ . '/../config/paths.php';

session_start();
if(!isset($_SESSION['autenticated']) || $_SESSION['autenticated'] !== true){
    header('Location:' . URL_BASE . 'views/login.php');
    exit;
}

$mensaje = $_SESSION['mensaje_confirmacion'] ?? null;
if($mensaje) unset($_SESSION['mensaje_confirmacion']);

include PATH_BASE .'includes/header.php';
include_once PATH_BASE . 'includes/db_connect.php'; 

$sql = $db->prepare("SELECT usu_id, usu_mail, usu_name, usu_rol FROM users");
?>

<main class="relative min-h-[calc(100vh-96px)] py-12 px-4 overflow-hidden">
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[500px] bg-brand/5 rounded-full blur-[140px] pointer-events-none"></div>

    <div class="relative w-full max-w-5xl mx-auto">
        
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6">
            <div class="text-left">
                <div class="inline-flex items-center gap-3 px-4 py-1.5 rounded-full bg-brand/5 border border-brand/10 mb-4">
                    <span class="flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-2 w-2 rounded-full bg-brand opacity-40"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-brand"></span>
                    </span>
                    <span class="text-[11px] font-bold uppercase tracking-[0.3em] text-brand/80">Gestión de Accesos</span>
                </div>
                <h1 class="font-display text-5xl font-bold text-white uppercase tracking-tight leading-none">
                    Panel de <span class="text-brand">Usuarios</span>
                </h1>
            </div>

            <a href="<?=URL_BASE?>views/user_uptade.php" 
               class="flex items-center gap-3 bg-brand hover:bg-brand-light text-surface font-bold uppercase tracking-wider px-6 py-3 rounded-xl transition-all duration-300 hover:shadow-[0_0_20px_rgba(52,211,113,0.3)] active:scale-95 group text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                <span>Nuevo Agente</span>
            </a>
        </div>

        <?php if($mensaje): ?>
            <div class="flex items-center gap-3 px-5 py-3 rounded-2xl bg-brand/10 border border-brand/20 mb-8 animate-in fade-in slide-in-from-top-4 duration-500">
                <span class="text-sm font-bold text-brand-light uppercase tracking-wide">
                    [SISTEMA]: <?= htmlspecialchars($mensaje) ?>
                </span>
            </div>
        <?php endif; ?>

        <div class="relative overflow-hidden rounded-2xl bg-surface-mid/40 backdrop-blur-md border border-surface-border">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-surface-border bg-white/[0.02]">
                            <th class="px-6 py-5 text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">ID</th>
                            <th class="px-6 py-5 text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Agente</th>
                            <th class="px-6 py-5 text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Email</th>
                            <th class="px-6 py-5 text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Rango</th>
                            <th class="px-6 py-5 text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-surface-border/50">
                        <?php if($sql->execute()): ?>
                            <?php while($file = $sql->fetch(PDO::FETCH_ASSOC)): 
                                $esAdmin = ($file['usu_rol'] === 'admin');
                            ?>
                                <tr class="hover:bg-white/[0.02] transition-colors group">
                                    <td class="px-6 py-5 font-mono text-sm text-slate-500">#<?= $file['usu_id'] ?></td>
                                    <td class="px-6 py-5">
                                        <span class="text-white font-bold tracking-tight"><?= $file['usu_name'] ?></span>
                                    </td>
                                    <td class="px-6 py-5 text-slate-400 text-sm font-body"><?= $file['usu_mail'] ?></td>
                                    <td class="px-6 py-5">
                                        <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest <?= $esAdmin ? 'bg-brand/10 text-brand border border-brand/20' : 'bg-slate-800 text-slate-400 border border-slate-700' ?>">
                                            <?= $file['usu_rol'] ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex justify-end gap-3">
                                            <?php if (!$esAdmin): ?>
                                                <form action="<?= URL_BASE ?>views/user_uptade.php" method="post">
                                                    <input type="hidden" name="id_user" value="<?= $file['usu_id'] ?>">
                                                    <button type="submit" class="p-2 text-slate-500 hover:text-brand transition-colors">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                        </svg>
                                                    </button>
                                                </form>
                                                
                                                <form action="<?= URL_BASE ?>actions/user_delete.proc.php" method="post" onsubmit="return confirm('¿Confirmar baja del sistema?')">
                                                    <input type="hidden" name="id_user" value="<?= $file['usu_id'] ?>">
                                                    <button type="submit" class="p-2 text-slate-500 hover:text-red-500 transition-colors">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            <?php else: ?>
                                                <div class="px-3 py-1 text-[9px] font-bold text-slate-600 uppercase tracking-tighter border border-slate-800 rounded">Inmutable</div>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-8 flex justify-center items-center gap-8 opacity-40">
            <span class="text-[9px] text-slate-400 uppercase tracking-[0.3em] font-bold">Base de datos encriptada</span>
            <span class="w-1 h-1 bg-slate-600 rounded-full"></span>
            <span class="text-[9px] text-slate-400 uppercase tracking-[0.3em] font-bold">Protocolo V.2.6</span>
        </div>
    </div>
</main>