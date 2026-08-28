
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Удаленные товары - MemMarket</title>
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
    max-width: 1000px;
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
            border: 3px solid #95a5a6;
            opacity: 0.7;
            transition: 0.3s;
        }
        .product:hover {
    opacity: 1;
    transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
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
            color: #666;
            font-size: 1.3em;
        }
        .product .price {
    font-size: 22px;
            font-weight: bold;
            color: #95a5a6;
            margin-bottom: 15px;
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
        .product .deleted-at {
    color: #999;
    font-size: 0.8em;
            margin-bottom: 10px;
        }
        .btn-restore {
    background: #2ecc71;
    color: white;
    border: none;
    padding: 10px 20px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            transition: 0.3s;
            width: 100%;
        }
        .btn-restore:hover {
    background: #27ae60;
    transform: scale(1.05);
}
.btn-restore:disabled {
    background: #ccc;
    cursor: not-allowed;
    transform: none;
}
.empty {
    text-align: center;
            padding: 50px;
            background: white;
            border-radius: 20px;
            border: 3px solid #ffd93d;
            color: #999;
        }
        .empty h2 {
    font-size: 2em;
            margin-bottom: 10px;
        }
        .empty a {
    display: inline-block;
    margin-top: 20px;
            background: #ff6b6b;
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
        }
        .empty a:hover {
    background: #ee5a24;
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
    <!-- Уведомление -->
    <div class="notification" id="notification">✅ Успешно!</div>

    <div class="container">
        <div class="header">
            <h1>🗑 Удаленные товары</h1>
            <div>
                <a href="/products" class="btn-shop">← В магазин</a>
            </div>
        </div>

@if(count($products) > 0)
    <div class="products">
        @foreach($products as $product)
            <div class="product" data-id="{{ $product->id }}">
                <img src="{{ $product->image }}" alt="{{ $product->name }}">
                <span class="deleted-badge">🗑 Удален</span>
                <h3>{{ $product->name }}</h3>
                <div class="price">{{ $product->price }} ₽</div>
                <div class="deleted-at">
                    Удален: {{ $product->deleted_at ? $product->deleted_at->format('d.m.Y H:i') : 'Дата неизвестна' }}
                </div>
                <button class="btn-restore" onclick="restoreProduct({{ $product->id }})">
                    ↩ Восстановить
                </button>
            </div>
        @endforeach
    </div>
@else
    <div class="empty">
        <h2>📭 Корзина удаленных пуста</h2>
        <p>Нет удаленных товаров</p>
        <a href="/products">В магазин →</a>
    </div>
    @endif
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

        // ============================
        // ВОССТАНОВЛЕНИЕ ТОВАРА
        // ============================
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
                        // Удаляем карточку товара или перезагружаем страницу
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
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
