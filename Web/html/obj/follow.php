<?php
include('header.php');
$query_wallet_id = "SELECT `wallet_id` FROM `wallet` WHERE `user_id` = '$_POST[user_id]'";
$temp = mysqli_query($con, $query_wallet_id);
$data = mysqli_fetch_array($temp);

$query_stock_id = "SELECT `stock_id` FROM `stock` WHERE `symbol` = '$_POST[name]'";
$temp = mysqli_query($con, $query_stock_id);
$data2 = mysqli_fetch_array($temp);
$query_add = "INSERT INTO `wallet_stock`(`wallet_id`, `stock_id`) VALUES ( '$data[wallet_id]', '$data2[stock_id]') 
                WHERE NOT EXISTS ( SELECT * FROM  `wallet_stock` WHERE `wallet_id` = '$data[wallet_id]' AND `stock_id` = '$data2[stock_id]' ) ";
mysqli_query($con, $query_add);

function updatefile($filepath)
{

    $con = mysqli_connect('localhost', 'romeofrancesco', '');
    $con_db = (mysqli_select_db($con, 'my_romeofrancesco'));
    $data_file = fopen($filepath, "w") or die('Errore =(');
    $query = 'SELECT distinct symbol FROM wallet_stock, stock WHERE wallet_stock.stock_id = stock.stock_id';
    $temp = mysqli_query($con, $query);
    $data = mysqli_fetch_all($temp, MYSQLI_ASSOC);
    foreach ($data as $array) {
        fwrite($data_file, $array['symbol']  . "\n");
    }
    fclose($data_file);
}

updatefile('../../../Data/stockname.txt');
