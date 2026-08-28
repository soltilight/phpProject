
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Личный кабинет - MemMarket</title>
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
        }
        .container {
    max-width: 600px;
            margin: 0 auto;
        }
        .header {
    text-align: center;
            margin-bottom: 30px;
            background: white;
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }
        .header h1 {
    font-size: 2.5em;
            color: #ff6b6b;
            text-shadow: 3px 3px 0 #ffd93d;
        }
        .header a {
    padding: 10px 20px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            margin: 5px;
            display: inline-block;
        }
        .btn-shop {
    background: #ff6b6b;
    color: white;
}
.btn-shop:hover {
    background: #ee5a24;
}
.profile-box {
    background: white;
    border-radius: 20px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border: 3px solid #ffd93d;
        }
        .profile-box .avatar {
    text-align: center;
            font-size: 4em;
            margin-bottom: 20px;
        }
        .form-group {
    margin-bottom: 20px;
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
        .form-group input:disabled {
    background: #f5f5f5;
    cursor: not-allowed;
}
.btn-save {
    width: 100%;
    background: #2ecc71;
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
        .btn-save:hover {
    background: #27ae60;
    transform: scale(1.02);
}
.btn-save:disabled {
    background: #ccc;
    cursor: not-allowed;
    transform: none;
}
.btn-change-password {
    width: 100%;
    background: #ffd93d;
    color: #333;
    border: none;
    padding: 14px;
            border-radius: 50px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
        }
        .btn-change-password:hover {
    background: #f7c948;
    transform: scale(1.02);
}
.section-title {
    font-size: 1.2em;
            font-weight: bold;
            color: #333;
            margin: 30px 0 15px 0;
            padding-bottom: 10px;
            border-bottom: 2px solid #ffd93d;
        }
        .error-msg {
    background: #ffe6e6;
    color: #ff6b6b;
    padding: 10px;
            border-radius: 10px;
            margin-bottom: 15px;
            display: none;
        }
        .error-msg.show {
    display: block;
}
.success-msg {
    background: #e6ffe6;
    color: #2ecc71;
    padding: 10px;
            border-radius: 10px;
            margin-bottom: 15px;
            display: none;
        }
        .success-msg.show {
    display: block;
}
.password-section {
    display: none;
    margin-top: 20px;
            padding-top: 20px;
            border-top: 2px dashed #ddd;
        }
        .password-section.show {
    display: block;
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
</style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>👤 Личный кабинет</h1>
            <a href="/products" class="btn-shop">← В магазин</a>
        </div>

        <div class="profile-box">
            <div class="avatar">👤</div>

@if(session('error'))
    <div class="error-msg show">{{ session('error') }}</div>
@endif
@if(session('success'))
    <div class="success-msg show">{{ session('success') }}</div>
@endif

<!-- Основные данные -->
<form method="POST" action="/profile/update">
    @csrf
    <div class="form-group">
        <label for="name">👤 Имя пользователя</label>
        <input type="text" id="name" name="name" value="{{ $user->name }}" required>
    </div>

    <div class="form-group">
        <label for="email">📧 Email</label>
        <input type="email" id="email" name="email" value="{{ $user->email }}" required>
    </div>

    <button type="submit" class="btn-save">💾 Сохранить изменения</button>
</form>

<!-- Кнопка смены пароля -->
<button class="btn-change-password" onclick="togglePasswordForm()">🔑 Сменить пароль</button>

<!-- Форма смены пароля -->
<div class="password-section" id="passwordSection">
    <div class="section-title">🔑 Смена пароля</div>
    <form method="POST" action="/profile/password">
        @csrf
        <div class="form-group">
            <label for="current_password">🔒 Текущий пароль</label>
            <input type="password" id="current_password" name="current_password" placeholder="Введите текущий пароль" required>
        </div>

        <div class="form-group">
            <label for="new_password">🔑 Новый пароль</label>
            <input type="password" id="new_password" name="new_password" placeholder="Введите новый пароль" required>
        </div>

        <div class="form-group">
            <label for="new_password_confirm">🔑 Подтвердите новый пароль</label>
            <input type="password" id="new_password_confirm" name="new_password_confirm" placeholder="Повторите новый пароль" required>
        </div>

        <button type="submit" class="btn-save">🔄 Сменить пароль</button>
    </form>
</div>

<a href="/products" class="back-link">← Вернуться в магазин</a>
</div>
</div>

<script>
    function togglePasswordForm() {
        const section = document.getElementById('passwordSection');
        section.classList.toggle('show');
    }


    @if(session('password_error'))
    document.getElementById('passwordSection').classList.add('show');
    @endif
    @if(session('password_success'))
    document.getElementById('passwordSection').classList.add('show');
    @endif
</script>
</body>
</html>
