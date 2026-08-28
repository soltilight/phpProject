<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход - MemMarket</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Comic Sans MS', cursive, sans-serif;
        }
        body {
            background: linear-gradient(135deg, #ffe6f0, #fff3cd);
            padding: 20px;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            max-width: 400px;
            width: 100%;
            margin: 0 auto;
        }
        .login-box {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            border: 3px solid #ffd93d;
            text-align: center;
        }
        .login-box h1 {
            font-size: 2.5em;
            color: #ff6b6b;
            text-shadow: 3px 3px 0 #ffd93d;
            margin-bottom: 10px;
        }
        .login-box .subtitle {
            color: #666;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }
        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #ddd;
            border-radius: 10px;
            font-size: 16px;
            transition: 0.3s;
            box-sizing: border-box;
        }
        .form-group input:focus {
            outline: none;
            border-color: #ff6b6b;
            box-shadow: 0 0 10px rgba(255, 107, 107, 0.2);
        }
        .btn-login {
            width: 100%;
            background: #ff6b6b;
            color: white;
            border: none;
            padding: 14px;
            border-radius: 50px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
        }
        .btn-login:hover {
            background: #ee5a24;
            transform: scale(1.02);
        }
        .register-link {
            margin-top: 20px;
            color: #666;
        }
        .register-link a {
            color: #ff6b6b;
            text-decoration: none;
            font-weight: bold;
        }
        .register-link a:hover {
            text-decoration: underline;
        }
        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: #999;
            text-decoration: none;
            transition: 0.3s;
        }
        .back-link:hover {
            color: #ff6b6b;
        }
        .error-msg {
            background: #ffe6e6;
            color: #ff6b6b;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: none;
        }
        .error-msg.show {
            display: block;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="login-box">
        <h1>🔐 MemMarket</h1>
        <p class="subtitle">Войдите в свой аккаунт</p>

        @if(session('error'))
            <div class="error-msg show">{{ session('error') }}</div>
        @endif

        <form method="POST" action="/login">
            @csrf
            <div class="form-group">
                <label for="login">👤 Логин или Email</label>
                <input type="text" id="login" name="login" placeholder="Введите логин или email" required>
            </div>

            <div class="form-group">
                <label for="password">🔑 Пароль</label>
                <input type="password" id="password" name="password" placeholder="Введите пароль" required>
            </div>

            <button type="submit" class="btn-login">🚪 Войти</button>
        </form>

        <div class="register-link">
            Нет аккаунта? <a href="/register">Зарегистрироваться</a>
        </div>

        <a href="/products" class="back-link">← В магазин</a>
    </div>
</div>
</body>
</html>
