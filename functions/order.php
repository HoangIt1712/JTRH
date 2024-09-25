<?php 
require_once("db.php");
const PENDING = 0;
const CONFIRM = 1;
const SHIPPING = 2;
const SHIPPED = 3;
const COMPLETE = 4;
const CANCEL = 5;

function order_list(){
    $sql = "select * from orders order by id desc";
    return select($sql);
}
function status_label($status){
    switch($status){
        case PENDING: return "<span class='text-warning'>Pending</span>";
        case CONFIRM: return "<span class='text-primary'>Confirmed</span>";
        case SHIPPING: return "<span class='text-secondary'>Shipping</span>";
        case SHIPPED: return "<span class='text-info'>Shipped</span>";
        case COMPLETE: return "<span class='text-success'>Completed</span>";
        case CANCEL: return "<span class='text-danger'>Cancel</span>";
    }
}

function order_detail($id){
    $sql = "select * from orders where id = $id";
    $order = findById($sql);
    $sql_item = "select products.name,
                        products.thumbnail, 
                        order_items.buy_qty,
                        order_items.price
                  from order_items inner join products 
                  on order_items.product_id = products.id
                  where order_items.order_id = $id";
    $items = select($sql_item);
    return [
        "order"=>$order,
        "items"=>$items
    ];              
}
function update_status($order_id ,  $new_status){
    if($new_status > PENDING && $new_status <= CANCEL){
        $status = $new_status -1 ;
        $sql = "update orders set status = $new_status where id = $order_id and status=$status";
    update($sql);
    }
    if($new_status == CANCEL){
        $pending=PENDING;
        $confirm = CONFIRM;
        $sql = "update orders set status = $new_status where id = $order_id and status in($pending,$confirm)" ;
        upadte($sql);
        $sql_item = "select * from order_items where order_id = $order_id";
        $items = select($sql_items);
        foreach($items as $item){
            $buy_qty = $item['buy_qty'];
            $product_id = $item['product_id'];
            $sql_p = "update products set qty = qty +$buy_qty where id=$product_id";
            update($sql_p);
        }
    }

}