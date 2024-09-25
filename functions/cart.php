<?php
require_once("db.php");

function getCartItems(){
    $cart = isset($_SESSION["cart"]) ? $_SESSION["cart"] : []; // Nếu có giỏ hàng thì lấy, không thì để mảng trống
    $items = [];
    if(count($cart) > 0){
        $ids = [];
        foreach($cart as $key => $item){
            $ids[] = $key;
        }
        $ids = implode(",", $ids); // Chuyển mảng ID thành chuỗi để sử dụng trong câu SQL
        $sql = "SELECT * FROM products WHERE id IN ($ids)";
        $result = select($sql);
        foreach($result as $item){
            $items[] = [
                "id" => $item["id"],
                "NAME" => $item["NAME"],
                "thumbnail" => $item["thumbnail"],
                "price" => $item["price"],
                "in_stock" => $item["qty"] > $cart[$item["id"]] ? true : false,
                "buy_qty" => $cart[$item["id"]]
            ];
        }
    }
    return $items;
}

// Hàm tăng số lượng sản phẩm trong giỏ hàng
function increaseCartItemQty($product_id) {
    if (isset($_SESSION["cart"][$product_id])) {
        $_SESSION["cart"][$product_id] += 1; // Tăng số lượng lên 1
    }
}

// Hàm giảm số lượng sản phẩm trong giỏ hàng
function decreaseCartItemQty($product_id) {
    if (isset($_SESSION["cart"][$product_id])) {
        if ($_SESSION["cart"][$product_id] > 1) {
            $_SESSION["cart"][$product_id] -= 1; // Giảm số lượng nếu lớn hơn 1
        } else {
            unset($_SESSION["cart"][$product_id]); // Xóa sản phẩm khỏi giỏ hàng nếu số lượng là 1
        }
    }
}
?>
