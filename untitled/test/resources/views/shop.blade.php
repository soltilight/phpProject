<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MemMarket - Магазин мемов</title>
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
            max-width: 1200px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            background: white;
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .header h1 {
            font-size: 3em;
            color: #ff6b6b;
            text-shadow: 3px 3px 0 #ffd93d;
        }
        .header p {
            color: #555;
            font-size: 1.2em;
            margin-top: 10px;
        }
        .header .top-links {
            margin-top: 15px;
        }
        .header .top-links a,
        .header .top-links span {
            padding: 8px 20px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            margin: 0 5px;
            display: inline-block;
        }
        .btn-login {
            background: #ff6b6b;
            color: white;
        }
        .btn-logout {
            background: #ff6b6b;
            color: white;
        }
        .btn-cart {
            background: #ffd93d;
            color: #333;
        }
        .btn-profile {
            background: #3498db;
            color: white;
        }
        .btn-admin {
            background: #9b59b6;
            color: white;
        }
        .user-greeting {
            color: #2ecc71;
            font-weight: bold;
        }
        .products {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 25px;
        }
        .product {
            background: white;
            border-radius: 20px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: 0.3s;
            border: 3px solid #ffd93d;
            position: relative;
        }
        .product:hover {
            transform: translateY(-10px) rotate(-2deg);
            box-shadow: 0 8px 30px rgba(255, 107, 107, 0.3);
        }
        .product.deleted {
            opacity: 0.5;
            border-color: #95a5a6;
            transform: none;
        }
        .product.deleted:hover {
            transform: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .product img {
            width: 100%;
            height: 200px;
            object-fit: contain;
            border-radius: 15px;
            background: #f8f9fa;
            padding: 10px;
        }
        .product h3 {
            margin: 15px 0 10px;
            color: #333;
            font-size: 1.3em;
        }
        .product .price {
            font-size: 22px;
            font-weight: bold;
            color: #ff6b6b;
            margin-bottom: 15px;
        }
        .product .quantity {
            color: #666;
            font-size: 0.9em;
            margin-bottom: 10px;
        }
        .product .deleted-badge {
            background: #95a5a6;
            color: white;
            padding: 2px 15px;
            border-radius: 20px;
            font-size: 0.8em;
            display: inline-block;
            margin-bottom: 10px;
        }
        .btn-add-cart {
            background: #ff6b6b;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 50px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            width: 100%;
            justify-content: center;
        }
        .btn-add-cart:hover {
            background: #ee5a24;
            transform: scale(1.05);
        }
        .btn-add-cart:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
        }
        .admin-actions {
            display: flex;
            gap: 8px;
            margin-top: 10px;
            flex-wrap: wrap;
            justify-content: center;
        }
        .btn-delete {
            background: #ff6b6b;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            transition: 0.3s;
            flex: 1;
            min-width: 60px;
        }
        .btn-delete:hover {
            background: #ee5a24;
            transform: scale(1.05);
        }
        .btn-delete:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
        }
        .btn-restore {
            background: #2ecc71;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            transition: 0.3s;
            flex: 1;
            min-width: 60px;
        }
        .btn-restore:hover {
            background: #27ae60;
            transform: scale(1.05);
        }
        .cart-icon {
            position: fixed;
            top: 20px;
            right: 20px;
            background: white;
            padding: 15px 20px;
            border-radius: 50px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            font-weight: bold;
            color: #333;
            cursor: pointer;
            transition: 0.3s;
            z-index: 1000;
            text-decoration: none;
        }
        .cart-icon:hover {
            transform: scale(1.1);
        }
        .cart-count {
            background: #ff6b6b;
            color: white;
            border-radius: 50%;
            padding: 2px 8px;
            margin-left: 5px;
        }
        .notification {
            position: fixed;
            top: 80px;
            right: 20px;
            background: #2ecc71;
            color: white;
            padding: 15px 25px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            display: none;
            z-index: 1001;
            font-weight: bold;
        }
        .notification.show {
            display: block;
            animation: slideIn 0.5s ease;
        }
        .notification.error {
            background: #e74c3c;
        }
        @keyframes slideIn {
            from { transform: translateX(100px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
    </style>
</head>
<body>
<a href="/cart" class="cart-icon">
    🛒 Корзина <span class="cart-count">{{ $cartCount ?? 0 }}</span>
</a>

<div class="notification" id="notification">✅ Товар добавлен в корзину!</div>

<div class="container">
    <div class="header">
        <h1>🔥 MemMarket</h1>
        <p>🎉 Самые свежие и сочные мемы для вас!</p>
        <div class="top-links">
            @if(session('user_login'))
                <span class="user-greeting">👋 {{ session('user_login') }}</span>
                <a href="/profile" class="btn-profile">👤 Профиль</a>
                @if($isAdmin ?? false)
                    <a href="/products/deleted" class="btn-admin">🗑 Удаленные</a>
                @endif
                <a href="/logout" class="btn-logout">🚪 Выйти</a>
            @else
                <a href="/" class="btn-login">🔐 Войти</a>
            @endif
            <a href="/cart" class="btn-cart">🛒 Корзина</a>
        </div>
    </div>

    <div class="products">
        @foreach($products as $product)
            <div class="product {{ $product->trashed() ? 'deleted' : '' }}" data-id="{{ $product->id }}">
                <img src="{{ $product->image }}" alt="{{ $product->name }}">

                @if($product->trashed())
                    <div class="deleted-badge">🗑 Удален</div>
                @endif

                <h3>{{ $product->name }}</h3>
                <div class="price">{{ $product->price }} ₽</div>
                <div class="quantity">В наличии: {{ $product->quantity }} шт.</div>

                @if($isAdmin ?? false)
                    <div class="admin-actions">
                        @if($product->trashed())
                            <button class="btn-restore" onclick="restoreProduct({{ $product->id }})">↩ Восстановить</button>
                        @else
                            <button class="btn-delete" onclick="deleteProduct({{ $product->id }})">🗑 Удалить</button>
                        @endif
                    </div>
                @else
                    @if(!$product->trashed())
                        <button class="btn-add-cart" data-id="{{ $product->id }}">
                            🛒 В корзину
                        </button>
                    @else
                        <button class="btn-add-cart" disabled style="background: #ccc; cursor: not-allowed;">
                            ⛔ Товар недоступен
                        </button>
                    @endif
                @endif
            </div>
        @endforeach
    </div>
</div>

<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    const notification = document.getElementById('notification');

    function showNotification(message, isError = false) {
        notification.textContent = message;
        notification.className = 'notification show';
        if (isError) {
            notification.classList.add('error');
        }
        setTimeout(() => {
            notification.classList.remove('show');
        }, 2000);
    }


    const buttons = document.querySelectorAll('.btn-add-cart');
    const cartCountElement = document.querySelector('.cart-count');

    buttons.forEach(btn => {
        btn.addEventListener('click', function() {
            const productId = this.dataset.id;
            const originalText = this.innerHTML;

            this.disabled = true;
            this.innerHTML = '⏳ Добавление...';

            fetch('/add-to-cart', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ product_id: productId })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        cartCountElement.textContent = data.total_items;
                        showNotification('✅ ' + data.message);

                        this.innerHTML = '✅ В корзине';
                        this.style.background = '#2ecc71';
                        setTimeout(() => {
                            this.innerHTML = originalText;
                            this.style.background = '#ff6b6b';
                            this.disabled = false;
                        }, 1500);
                    }
                })
                .catch(error => {
                    console.error('Ошибка:', error);
                    this.innerHTML = '❌ Ошибка';
                    this.disabled = false;
                    setTimeout(() => {
                        this.innerHTML = originalText;
                    }, 2000);
                });
        });
    });

    function deleteProduct(productId) {
        if (!confirm('🗑 Вы уверены, что хотите удалить этот товар?')) {
            return;
        }

        const productElement = document.querySelector(`.product[data-id="${productId}"]`);
        const btn = productElement.querySelector('.btn-delete');

        btn.disabled = true;
        btn.textContent = '⏳ Удаление...';

        fetch(`/products/${productId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json'
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('✅ ' + data.message);
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showNotification('❌ ' + data.error, true);
                    btn.disabled = false;
                    btn.textContent = '🗑 Удалить';
                }
            })
            .catch(error => {
                console.error('Ошибка:', error);
                showNotification('❌ Ошибка при удалении', true);
                btn.disabled = false;
                btn.textContent = '🗑 Удалить';
            });
    }

    function restoreProduct(productId) {
        if (!confirm('↩ Восстановить этот товар?')) {
            return;
        }

        const productElement = document.querySelector(`.product[data-id="${productId}"]`);
        const btn = productElement.querySelector('.btn-restore');

        btn.disabled = true;
        btn.textContent = '⏳ Восстановление...';

        fetch(`/products/${productId}/restore`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json'
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('✅ ' + data.message);
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showNotification('❌ ' + data.error, true);
                    btn.disabled = false;
                    btn.textContent = '↩ Восстановить';
                }
            })
            .catch(error => {
                console.error('Ошибка:', error);
                showNotification('❌ Ошибка при восстановлении', true);
                btn.disabled = false;
                btn.textContent = '↩ Восстановить';
            });
    }
</script>
</body>
</html>
