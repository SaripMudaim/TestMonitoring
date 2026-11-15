<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Website Builder</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #0d1b2a; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-box { background: white; padding: 40px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.2); width: 350px; }
        h2 { text-align: center; color: #1b263b; margin-bottom: 30px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; color: #415a77; font-weight: bold; }
        
        /* Style untuk input dan pembungkus ikon mata */
        .input-wrapper { position: relative; }
        input[type="text"], input[type="password"] { 
            width: 100%; 
            padding: 10px; 
            padding-right: 40px; /* Beri ruang agar teks tidak tertutup ikon */
            border: 1px solid #ccc; 
            border-radius: 5px; 
            box-sizing: border-box; 
        }
        
        /* Style untuk ikon mata */
        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #888;
            user-select: none; /* Agar teks tidak terblok saat diklik */
            font-size: 18px;
        }
        .toggle-password:hover { color: #1b263b; }
        
        button { width: 100%; padding: 12px; background-color: #1b263b; color: white; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; transition: 0.3s; }
        button:hover { background-color: #415a77; }
        .error { color: #e63946; background: #ffe3e3; padding: 10px; border-radius: 5px; margin-bottom: 20px; text-align: center; font-size: 14px; }
    </style>
</head>
<body>

    <div class="login-box">
        <h2>Admin Login</h2>
        
        <?php if(isset($_SESSION['flash_error'])): ?>
            <div class="error">
                <?= $_SESSION['flash_error']; ?>
            </div>
            <?php unset($_SESSION['flash_error']); ?>
        <?php endif; ?>

        <form action="<?= BASEURL; ?>/auth/prosesLogin" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" required autocomplete="off">
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <input type="password" name="password" id="password" required>
                    <span class="toggle-password" id="togglePassword" title="Perlihatkan/Sembunyikan Password">👁️</span>
                </div>
            </div>
            
            <button type="submit">Masuk ke Dashboard</button>
        </form>
    </div>

    <!-- Script untuk Toggle Password -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');

            togglePassword.addEventListener('click', function() {
                // Cek tipe input saat ini
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                // Ubah ikon (opsional: ganti emoji mata terbuka/tertutup)
                this.textContent = type === 'password' ? '👁️' : '🙈';
            });
        });
    </script>

</body>
</html>