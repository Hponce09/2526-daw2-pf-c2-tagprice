<?php
session_start();
include_once __DIR__ . '/../config/paths.php';
include_once PATH_BASE . 'includes/db_connect.php';

if(!isset($_SESSION['autenticated']) || $_SESSION['autenticated'] !== true){
    header('Location:' . URL_BASE . 'views/login.php');
    exit;
}

include PATH_BASE .'includes/header.php';

$id = $_REQUEST['id_user'] ?? null; 
$usuario = null;

if ($id) {
    $stmt = $db->prepare("SELECT * FROM users WHERE usu_id = ?");
    $stmt->execute([$id]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<main class="relative min-h-[calc(100vh-96px)] flex items-center justify-center px-4 overflow-hidden">
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[400px] bg-brand/5 rounded-full blur-[120px] pointer-events-none"></div>

    <div class="relative w-full max-w-lg">
        
        <a href="<?= URL_BASE ?>views/panelAdmin.php" class="inline-flex items-center gap-2 text-slate-500 hover:text-brand transition-colors mb-8 group">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span class="text-[10px] font-bold uppercase tracking-[0.2em]">Volver al Panel</span>
        </a>

        <div class="relative overflow-hidden rounded-2xl bg-surface-mid/40 backdrop-blur-md border border-surface-border p-8 md:p-10">
            
            <div class="mb-10 text-center">
                <div class="inline-flex items-center gap-3 px-3 py-1 rounded-full bg-brand/5 border border-brand/10 mb-4">
                    <span class="text-[9px] font-black uppercase tracking-[0.3em] text-brand/80">
                        <?= $id ? 'Modificación de Credenciales' : 'Registro de Nuevo Agente' ?>
                    </span>
                </div>
                <h2 class="text-3xl font-display font-bold text-white uppercase tracking-tight">
                    <?= $id ? 'Editar <span class="text-brand">Perfil</span>' : 'Alta de <span class="text-brand">Usuario</span>' ?>
                </h2>
            </div>

            <form action="<?=URL_BASE?>actions/user_update.proc.php" method="POST" class="space-y-6">
                <input type="hidden" name="id" value="<?= $id ?>">

                <div class="space-y-2">
                    <label class="text-[10px] font-bold uppercase tracking-widest text-slate-500 ml-1">Nombre Completo</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-600 group-focus-within:text-brand transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <input type="text" name="nombre" 
                               value="<?= htmlspecialchars($usuario['usu_name'] ?? '') ?>" 
                               class="w-full bg-white/[0.03] border border-white/10 rounded-xl py-3.5 pl-12 pr-4 text-white placeholder:text-slate-700 focus:outline-none focus:border-brand/50 focus:ring-1 focus:ring-brand/20 transition-all font-body"
                               placeholder="Ej. John Doe" required>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-bold uppercase tracking-widest text-slate-500 ml-1">Dirección de Enlace (Email)</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-600 group-focus-within:text-brand transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <input type="email" name="email" 
                               value="<?= htmlspecialchars($usuario['usu_mail'] ?? '') ?>" 
                               class="w-full bg-white/[0.03] border border-white/10 rounded-xl py-3.5 pl-12 pr-4 text-white placeholder:text-slate-700 focus:outline-none focus:border-brand/50 focus:ring-1 focus:ring-brand/20 transition-all font-body"
                               placeholder="agente@dominio.com" required>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" 
                            class="w-full flex items-center justify-center gap-3 bg-brand hover:bg-brand-light text-surface font-black uppercase tracking-[0.2em] py-4 rounded-xl transition-all duration-300 hover:shadow-[0_0_25px_rgba(52,211,113,0.3)] active:scale-[0.98] group text-sm">
                        <span><?= $id ? 'Ejecutar Actualización' : 'Confirmar Registro' ?></span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </button>
                </div>
            </form>
            
            <?php if(!$id): ?>
                <p class="mt-6 text-center text-[10px] text-slate-500 uppercase tracking-widest leading-relaxed">
                    Al crear un nuevo usuario, el sistema generará una <br> 
                    <span class="text-slate-400">contraseña temporal automática</span>.
                </p>
            <?php endif; ?>

        </div>
        
        <div class="mt-8 flex justify-center items-center gap-6 opacity-30">
            <div class="h-[1px] w-12 bg-gradient-to-r from-transparent to-slate-500"></div>
            <span class="text-[9px] text-slate-400 uppercase tracking-[0.4em] font-bold">Secure Core Access</span>
            <div class="h-[1px] w-12 bg-gradient-to-l from-transparent to-slate-500"></div>
        </div>
    </div>
</main>