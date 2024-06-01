<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;

    public function getOrdersByMonth() {
        $curMonth = date('m');
        $curYear = date("Y");
        $countDaysInMonth = cal_days_in_month(CAL_JULIAN, $curMonth, $curYear);

        $week1 = DB::table("orders")->where("created_at", ">=", $curYear."-".$curMonth."-01")->where("created_at", "<", $curYear."-".$curMonth."-07  23:59:59:59")->count();
        $week2 = DB::table("orders")->where("created_at", ">=", $curYear."-".$curMonth."-08")->where("created_at", "<", $curYear."-".$curMonth."-14  23:59:59:59")->count();
        $week3 = DB::table("orders")->where("created_at", ">=", $curYear."-".$curMonth."-15")->where("created_at", "<", $curYear."-".$curMonth."-21  23:59:59:59")->count();
        $week4 = DB::table("orders")->where("created_at", ">=", $curYear."-".$curMonth."-22")->where("created_at", "<", $curYear."-".$curMonth."-28  23:59:59:59")->count();
        $week5 = DB::table("orders")->where("created_at", ">=", $curYear."-".$curMonth."-29")->where("created_at", "<=", $curYear."-".$curMonth."-".$countDaysInMonth ." 23:59:59:59")->count();

        return ["week1" => $week1, "week2" => $week2, "week3" => $week3, "week4" => $week4, "week5" => $week5, "count_days" => $countDaysInMonth];
    }

    public function getOrdersBy6Month() {
        $curMonth = date('m');
        $curYear = date("Y");
        $month = [];

        for ($i = 0; $i <= 5; $i++) {
            if ($curMonth - $i > 0) {
                $month[$i] = ["month" => $curMonth - $i, "year" => intval($curYear)];
            } else {
                $month[$i] = ["month" => 12 + ($curMonth - $i), "year" => $curYear - 1];
            }
        }

        $countOrdersBy6Month = [];
        foreach ($month as $m) {
            $countOrdersBy6Month[$m["month"]] = DB::table("orders")
                ->where("created_at", ">=", $m['year']."-".$m['month']."-01")
                ->where("created_at", "<", (($m['month'] + 1 > 12) ? $m['year'] + 1 : $m['year']) ."-". (($m['month'] + 1 > 12) ? "01" : $m['month'] + 1) ."-01")
                ->count();
        }

        return $countOrdersBy6Month;
    }

    public function getMostPopularProducts($count = 5) {
        $mostPopularProducts = DB::table("order_products")
            ->join("products", "products.id", "=", "order_products.product_id")
            ->select('name', 'product_id', DB::raw('count(*) as count'))
            ->groupBy("product_id")
            ->orderBy("count", "DESC")
            ->take($count)
            ->get();
        if (count($mostPopularProducts) < $count) {
            return Product::all()->take($count);
        }

        return $mostPopularProducts;
    }
}
