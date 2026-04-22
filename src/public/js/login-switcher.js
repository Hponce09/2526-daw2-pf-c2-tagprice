
    const loginDiv = document.getElementById('container-login');
    const registreDiv = document.getElementById('container-registre');
    
    const btnToRegistre = document.getElementById('btn-show-registre');
    const btnToLogin = document.getElementById('btn-show-login');

    // Al hacer clic en "Regístrate aquí"
    btnToRegistre.addEventListener('click', (e) => {
        e.preventDefault(); // Evita que la página recargue
        loginDiv.style.display = 'none';
        registreDiv.style.display = 'block';
    });

    // Al hacer clic en "Inicia sesión"
    btnToLogin.addEventListener('click', (e) => {
        e.preventDefault();
        registreDiv.style.display = 'none';
        loginDiv.style.display = 'block';
    });
