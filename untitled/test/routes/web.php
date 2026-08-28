<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

Route::get('/', function () {
    return view('login');
});


Route::get('/register', function () {
    return view('register');
});


Route::post('/register', function (Request $request) {
    $login = $request->input('login');
    $email = $request->input('email');
    $password = $request->input('password');

    $existingUser = User::where('name', $login)->orWhere('email', $email)->first();
    if ($existingUser) {
        return back()->with('error', 'Пользователь с таким логином или email уже существует');
    }

    $user = User::create([
        'name' => $login,
        'email' => $email,
        'password' => Hash::make($password)
    ]);

    session(['user_id' => $user->id, 'user_login' => $user->name, 'cart' => []]);
    return redirect('/products')->with('success', 'Регистрация успешна! Добро пожаловать, ' . $user->name . '!');
});


Route::post('/login', function (Request $request) {
    $login = $request->input('login');
    $password = $request->input('password');

    $user = User::where('name', $login)->orWhere('email', $login)->first();

    if ($user && Hash::check($password, $user->password)) {
        session(['user_id' => $user->id, 'user_login' => $user->name, 'cart' => []]);
        return redirect('/products')->with('success', 'Добро пожаловать, ' . $user->name . '!');
    }

    return back()->with('error', 'Неверный логин или пароль');
});


Route::get('/logout', function () {
    session()->forget(['user_id', 'user_login', 'cart']);
    return redirect('/');
});


Route::post('/add-to-cart', function (Request $request) {
    $productId = $request->input('product_id');
    $product = Product::find($productId);

    if (!$product) {
        return response()->json(['error' => 'Товар не найден'], 404);
    }


    $cart = session('cart', []);


    if (isset($cart[$productId])) {
        $cart[$productId]['quantity']++;
    } else {

        $cart[$productId] = [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'image' => $product->image,
            'quantity' => 1
        ];
    }


    session(['cart' => $cart]);


    $totalItems = array_sum(array_column($cart, 'quantity'));

    return response()->json([
        'success' => true,
        'total_items' => $totalItems,
        'message' => 'Товар добавлен в корзину'
    ]);
});


Route::post('/remove-from-cart', function (Request $request) {
    $productId = $request->input('product_id');
    $cart = session('cart', []);

    if (isset($cart[$productId])) {
        unset($cart[$productId]);
        session(['cart' => $cart]);
    }

    return redirect('/cart');
});


Route::post('/update-cart', function (Request $request) {
    $productId = $request->input('product_id');
    $quantity = (int)$request->input('quantity');

    $cart = session('cart', []);

    if (isset($cart[$productId])) {
        if ($quantity <= 0) {
            unset($cart[$productId]);
        } else {
            $cart[$productId]['quantity'] = $quantity;
        }
        session(['cart' => $cart]);
    }

    return redirect('/cart');
});


Route::get('/products', function () {
    $products = Product::all();
    $userLogin = session('user_login');
    $cart = session('cart', []);
    $isAdmin = ($userLogin === 'admin');
    $cartCount = array_sum(array_column($cart, 'quantity'));

    return view('shop', [
        'products' => $products,
        'user' => $userLogin,
        'cartCount' => $cartCount,
         'isAdmin' => $isAdmin
    ]);
});


Route::get('/cart', function () {
    $cart = session('cart', []);
    $total = array_sum(array_map(function ($item) {
        return $item['price'] * $item['quantity'];
    }, $cart));

    return view('cart', [
        'cart' => $cart,
        'total' => $total
    ]);
});


Route::post('/clear-cart', function () {
    session(['cart' => []]);
    return redirect('/cart');
});
Route::get('/profile', function () {
    $userId = session('user_id');
    if (!$userId) {
        return redirect('/')->with('error', 'Пожалуйста, войдите в систему');
    }

    $user = User::find($userId);
    if (!$user) {
        session()->forget(['user_id', 'user_login', 'cart']);
        return redirect('/')->with('error', 'Пользователь не найден');
    }

    return view('profile', ['user' => $user]);
});

Route::post('/profile/update', function (Request $request) {
    $userId = session('user_id');
    if (!$userId) {
        return redirect('/')->with('error', 'Пожалуйста, войдите в систему');
    }

    $user = User::find($userId);
    if (!$user) {
        return redirect('/')->with('error', 'Пользователь не найден');
    }

    $name = $request->input('name');
    $email = $request->input('email');

    $existingUser = User::where('email', $email)->where('id', '!=', $userId)->first();
    if ($existingUser) {
        return back()->with('error', 'Этот email уже используется другим пользователем');
    }

    $existingUser = User::where('name', $name)->where('id', '!=', $userId)->first();
    if ($existingUser) {
        return back()->with('error', 'Это имя уже используется другим пользователем');
    }

    $user->name = $name;
    $user->email = $email;
    $user->save();

    session(['user_login' => $name]);

    return back()->with('success', '✅ Профиль обновлен успешно!');
});

Route::post('/profile/password', function (Request $request) {
    $userId = session('user_id');
    if (!$userId) {
        return redirect('/')->with('error', 'Пожалуйста, войдите в систему');
    }

    $user = User::find($userId);
    if (!$user) {
        return redirect('/')->with('error', 'Пользователь не найден');
    }

    $currentPassword = $request->input('current_password');
    $newPassword = $request->input('new_password');
    $newPasswordConfirm = $request->input('new_password_confirm');


    if (!Hash::check($currentPassword, $user->password)) {
        return back()->with('password_error', '❌ Текущий пароль неверен');
    }

    if (strlen($newPassword) < 4) {
        return back()->with('password_error', '❌ Новый пароль должен быть минимум 4 символа');
    }

    if ($newPassword !== $newPasswordConfirm) {
        return back()->with('password_error', '❌ Пароли не совпадают');
    }


    $user->password = Hash::make($newPassword);
    $user->save();

    return back()->with('password_success', '✅ Пароль успешно изменен!');
});

Route::delete('/products/{id}', function ($id) {
    $userLogin = session('user_login');
    if ($userLogin !== 'admin') {
        return response()->json(['error' => 'Доступ запрещен'], 403);
    }

    $product = Product::find($id);
    if (!$product) {
        return response()->json(['error' => 'Товар не найден'], 404);
    }

    $product->delete();

    return response()->json([
        'success' => true,
        'message' => 'Товар удален'
    ]);
});

Route::post('/products/{id}/restore', function ($id) {
    $userLogin = session('user_login');
    if ($userLogin !== 'admin') {
        return response()->json(['error' => 'Доступ запрещен'], 403);
    }

    $product = Product::withTrashed()->find($id);
    if (!$product) {
        return response()->json(['error' => 'Товар не найден'], 404);
    }

    $product->restore();

    return response()->json([
        'success' => true,
        'message' => 'Товар восстановлен'
    ]);
});
Route::get('/products/deleted', function () {
    $userLogin = session('user_login');
    if ($userLogin !== 'admin') {
        return redirect('/products')->with('error', 'Доступ запрещен');
    }

    $deletedProducts = Product::onlyTrashed()->get();
    return view('admin.deleted-products', ['products' => $deletedProducts]);
});
