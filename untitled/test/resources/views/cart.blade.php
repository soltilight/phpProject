<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Корзина - MemMarket</title>
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
            max-width: 800px;
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
        .cart-items {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border: 3px solid #ffd93d;
        }
        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 2px dashed #f0f0f0;
            flex-wrap: wrap;
        }
        .cart-item:last-child {
            border-bottom: none;
        }
        .cart-item-info {
            display: flex;
            align-items: center;
            gap: 20px;
            flex: 1;
        }
        .cart-item img {
            width: 60px;
            height: 60px;
            object-fit: contain;
            background: #f8f9fa;
            border-radius: 10px;
            padding: 5px;
        }
        .cart-item-name {
            font-size: 1.2em;
            font-weight: bold;
            color: #333;
        }
        .cart-item-price {
            color: #ff6b6b;
            font-weight: bold;
            font-size: 1.1em;
        }
        .cart-item-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .cart-item-quantity {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .cart-item-quantity button {
            background: #ffd93d;
            border: none;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }
        .cart-item-quantity button:hover {
            transform: scale(1.1);
        }
        .cart-item-quantity span {
            font-size: 1.2em;
            font-weight: bold;
            min-width: 30px;
            text-align: center;
        }
        .btn-remove {
            background: #ff6b6b;
            color: white;
            border: none;
            padding: 5px 12px;
            border-radius: 20px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
        }
        .btn-remove:hover {
            background: #ee5a24;
            transform: scale(1.05);
        }
        .cart-total {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 3px solid #ffd93d;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 1.5em;
            font-weight: bold;
            flex-wrap: wrap;
        }
        .cart-total span {
            color: #ff6b6b;
        }
        .cart-actions {
            display: flex;
            gap: 15px;
            margin-top: 20px;
            flex-wrap: wrap;
            justify-content: center;
        }
        .btn-pay {
            background: #2ecc71;
            color: white;
            border: none;
            padding: 15px 40px;
            border-radius: 50px;
            font-size: 1.2em;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }
        .btn-pay:hover {
            background: #27ae60;
            transform: scale(1.05);
        }
        .btn-clear {
            background: #ff6b6b;
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 50px;
            font-size: 1em;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }
        .btn-clear:hover {
            background: #ee5a24;
            transform: scale(1.05);
        }
        .empty-cart {
            text-align: center;
            padding: 50px 20px;
            color: #999;
        }
        .empty-cart h2 {
            font-size: 2em;
            margin-bottom: 10px;
        }
        .empty-cart a {
            display: inline-block;
            margin-top: 20px;
            background: #ff6b6b;
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
        }
        .empty-cart a:hover {
            background: #ee5a24;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>🛒 Корзина</h1>
        <div>
            <a href="/products" class="btn-shop">← В магазин</a>
        </div>
    </div>

    <div class="cart-items">
        @if(count($cart) > 0)
            @foreach($cart as $id => $item)
                <div class="cart-item" data-id="{{ $id }}">
                    <div class="cart-item-info">
                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}">
                        <div>
                            <div class="cart-item-name">{{ $item['name'] }}</div>
                            <div class="cart-item-price">{{ $item['price'] }} ₽</div>
                        </div>
                    </div>
                    <div class="cart-item-actions">
                        <div class="cart-item-quantity">
                            <button onclick="updateQuantity({{ $id }}, -1)">−</button>
                            <span>{{ $item['quantity'] }}</span>
                            <button onclick="updateQuantity({{ $id }}, 1)">+</button>
                        </div>
                        <button class="btn-remove" onclick="removeItem({{ $id }})">✕</button>
                    </div>
                </div>
            @endforeach

            <div class="cart-total">
                <div>Итого:</div>
                <div><span>{{ $total ?? 0 }}</span> ₽</div>
            </div>

            <div class="cart-actions">
                <button class="btn-pay" onclick="pay()">💳 Оплатить</button>
                <form method="POST" action="/clear-cart" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn-clear">🗑 Очистить</button>
                </form>
            </div>
        @else
            <div class="empty-cart">
                <h2>😅 Корзина пуста</h2>
                <p>Добавьте товары из магазина!</p>
                <a href="/products">В магазин →</a>
            </div>
        @endif
    </div>
</div>

<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    function updateQuantity(productId, delta) {
        const item = document.querySelector(`.cart-item[data-id="${productId}"]`);
        const quantitySpan = item.querySelector('.cart-item-quantity span');
        let current = parseInt(quantitySpan.textContent);
        const newQuantity = current + delta;

        if (newQuantity < 1) {
            removeItem(productId);
            return;
        }

        // Отправляем запрос на обновление
        fetch('/update-cart', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: newQuantity
            })
        })
            .then(response => response.json())
            .then(() => {
                quantitySpan.textContent = newQuantity;
                updateTotal();
            });
    }

    function removeItem(productId) {
        if (!confirm('Удалить товар из корзины?')) return;

        fetch('/remove-from-cart', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ product_id: productId })
        })
            .then(response => response.json())
            .then(() => {
                location.reload();
            });
    }

    function updateTotal() {
        const items = document.querySelectorAll('.cart-item');
        let total = 0;

        items.forEach(item => {
            const priceText = item.querySelector('.cart-item-price').textContent;
            const price = parseInt(priceText.replace(' ₽', ''));
            const quantity = parseInt(item.querySelector('.cart-item-quantity span').textContent);
            total += price * quantity;
        });

        document.querySelector('.cart-total span').textContent = total;
    }

    function pay() {
        if (confirm('💳 Подтвердите оплату заказа?')) {
            alert('✅ Спасибо за покупку! Ваш заказ оформлен.');
            // Очищаем корзину
            fetch('/clear-cart', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            })
                .then(() => {
                    location.reload();
                });
        }
    }
</script>
</body>
</html>
