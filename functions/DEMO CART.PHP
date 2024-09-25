<?php

function getCartItem(){
    $cart = isset($_SESSION["cart"]) ? $_SESSION["cart"] : [];

    $item = [];
    if(count($cart) > 0) {
        $ids = [];
        foreach($cart as $key=>$item){
            $ids[] = $key;
        }
    } //die("a");// lenh check bug 
    $ids = implode(",", $ids); // convert array into string
    $sql = "select * from products where id in ($ids)";
    $getItems = select($sql);//var_dump($getItems);die(); // lenh check bug 
    foreach($getItems as $item){ 
        $buy_qty = $cart[$item['id']];
        $items[] = [ 
            "id" => $item['id'],
            "NAME" => $item['NAME'],
            "thumbnail" => $item['thumbnail'],
            "price" => $item['price'],
            "in_stock" => $item['qty'] > $buy_qty, // Checking if enough stock is available
            "buy_qty" => $buy_qty
        ];
       
    }
    return $items;
}
?>