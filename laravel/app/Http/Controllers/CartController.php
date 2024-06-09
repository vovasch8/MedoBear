<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Promocode;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CartController extends Controller
{
    public function showCart()
    {
//        session()->forget("promocode");
        $categories = Category::all();
        $productsQuantity = $products = [];
        $totalPrice = 0;

        if (session()->has("products")) {
            $productsQuantity = session("products");
            $products = Product::all()->whereIn('id', array_keys($productsQuantity));
            $totalPrice = self::getTotalPrice();
        }

        return view('cart', ['categories' => $categories, 'products' => $products, 'productQuantity' => $productsQuantity, 'totalPrice' => $totalPrice]);
    }

    public function addProduct(Request $request) {

        $id = intval($request->id_product);
        $count_value = strval($request->count_value);
        $productsInCart = array();

        // Якщо в корзині вже є товари вони зберігаються в сесії
        if (session()->has('products')) {
            // То заповним наш массив товарами
            $productsInCart = session('products');
        }

        $product = Product::find($id);
        // Перевіряємо чи такий товар вже є в корзині
        if (array_key_exists($id, $productsInCart)) {
            // Якщо такий товар є в корзині і був доданий то його кількість збільшуємо на 1
            $productsInCart[$id]['count_products'] ++;
            if (isset($productsInCart[$id]['sizes'][$count_value])) {
                $productsInCart[$id]['sizes'][$count_value] ++;
            } else {
                $productsInCart[$id]['sizes'][$count_value] = 1;
            }
        } else {
            // Якщо його немає, додавємо новий товар в кількості 1
            $productsInCart[$id]['count_products'] = 1;
            $productsInCart[$id]['sizes'][$count_value] = 1;
        }

        // Записуємо масив з товарами в сесію
        session(['products' => $productsInCart]);

        // Повертаємо кількість товарів в корзині
        return self::countItems();
    }

    public function deleteProduct(Request $request) {
        $id = intval($request->id_product);
        $count_value = strval($request->count_value);

        if (session()->has('products')) {
            // То заповним наш массив товарами
            $products = session("products");
            $products[$id]['count_products'] = $products[$id]['count_products'] - $products[$id]['sizes'][$count_value];
            unset($products[$id]['sizes'][$count_value]);
            session(['products' => $products]);
        }

        return json_encode(["count" => self::countItems(), "totalPrice" => self::getTotalPrice()]);
    }

    public function addPromocode(Request $request) {
        $promocode = strval($request->promocode);
        $promocodeModel = new Promocode();

        $promocode = $promocodeModel->all()->where("promocode", $promocode)->first();
        $totalPrice = self::getTotalPrice();

        if ($promocode && strtotime($promocode->active_to) > time() && !session()->has("promocode") && !isset($_COOKIE['promocodeName'])) {
            $totalPrice = round($totalPrice - ($promocode->discount * $totalPrice / 100));
            session(["promocode" => ["name" => $promocode->promocode, "discount" => $promocode->discount]]);
            setcookie("promocodeName", $promocode->promocode, time() + round(abs(time() - strtotime($promocode->active_to))));
        } elseif (!$promocode) {
            return ["error" => "**Промокод невірний!**"];
        } elseif (strtotime($promocode->active_to) <= time()) {
            return ["error" => "**Час дії промокоду закінчився!**"];
        } elseif (session()->has("promocode") || isset($_COOKIE['promocodeName'])) {
            return ["error" => "**Ви вже використали цей промокод!**"];
        }

        return $totalPrice;
    }

    public static function countItems()
    {
        // Перевірка чи є товари в корзині
        if (session()->has('products')) {
            // Якщо масив з товарами є підраховуємо їх кількість
            $count = 0;
            foreach (session('products') as $id => $quantity) {
                $count = $count + $quantity['count_products'];
            }
            return $count;
        } else {
            // Якщо товарів немає вертаємо 0
            return 0;
        }
    }

    public static function getTotalPrice() {
        $productsQuantity = $products = [];
        $totalPrice = 0;

        if (session()->has("products")) {
            $productsQuantity = session("products");

            foreach ($productsQuantity as $idProduct => $productKind) {
                foreach ($productKind['sizes'] as $size => $countProduct) {
                    $totalPrice += $countProduct * self::getPriceOfProductSize(Product::find($idProduct), $size);
                }
            }
        }

        if (session()->has("promocode")) {
            $promocode = session('promocode');
            $totalPrice = round($totalPrice - ($promocode['discount'] * $totalPrice / 100));
        }

        return $totalPrice;
    }

    public static function getPriceOfProductSize($product, $size) {
        if ($size === $product->count) {
            return $product->price;
        } elseif ($size === $product->count2) {
            return $product->price2;
        } elseif ($size === $product->count3) {
            return $product->price3;
        } elseif ($size === $product->count4) {
            return $product->price4;
        } else {
            return 0;
        }
    }

    public static function getProducts() {
        $products = [];
        if (session()->has("products")) {
            $products = session("products");
        }

        return $products;
    }

    public static function getPromocode() {
        $promocode = [];
        if (session()->has("promocode")) {
            $promocode = session('promocode');
        }

        return $promocode;
    }
}
