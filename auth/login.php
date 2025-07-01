<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - d'edge coffee</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        .container { max-width: 400px; margin: 60px auto; background: #fff; padding: 32px 24px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        h1 { text-align: center; margin-bottom: 8px; }
        .subtitle { text-align: center; color: #888; margin-bottom: 24px; }
        label { display: block; margin-bottom: 6px; font-weight: bold; }
        input[type="email"], input[type="password"] { width: 100%; padding: 10px; margin-bottom: 16px; border: 1px solid #ccc; border-radius: 4px; }
        .remember { display: flex; align-items: center; margin-bottom: 16px; }
        .remember input { margin-right: 8px; }
        button { width: 100%; padding: 10px; background: #6b4f2c; color: #fff; border: none; border-radius: 4px; font-size: 16px; cursor: pointer; }
        button:hover { background: #543d1d; }
        .signup-link { text-align: center; margin-top: 16px; }
        .signup-link a { color: #6b4f2c; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <h1>d'edge coffee</h1>
        <div class="subtitle">Sign in or sign up for an account</div>
        <form action="login_process.php" method="POST">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <div class="remember">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember" style="font-weight:normal;">Remember me</label>
            </div>

            <button type="submit">Sign In</button>
        </form>
        <div class="signup-link">
            Belum punya akun? <a href="register.php">Sign Up</a>
        </div>
    </div>
</body>
</html> 