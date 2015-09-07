<?php

require 'vendor/autoload.php';
use sandeepshetty\shopify_api;

$db = new Mysqli("localhost", "root", "root", "shopify");

if ($db->connect_errno) {
    die('Connect Error: ' . $db->connect_errno);
}
$shop = $db->query("SELECT * FROM tbl_usersettings WHERE id = 1");
$shop_data = $shop->fetch_object();

$app = $db->query("SELECT * FROM tbl_appsettings WHERE id = 1");
$app_settings = $app->fetch_object();
$shopify = shopify_api\client(
  $shop_data->store_name, $shop_data->access_token, $app_settings->api_key, $app_settings->shared_secret
);
//$arguments = array(
//  'limit' => '10', //default: 50
//  'page' => '1', //default: 1
//  'status' => 'open',
//
//);
//$orders = $shopify('GET', '/admin/orders.json', $arguments);
//when cart is created
$arguments = array(
  'topic' => 'cart/creation',
  'address' => 'http://somewhere.com/update_inventory.php'
);

$webhooks = $shopify('POST', '/admin/webhooks.json', $arguments);

//$products = $shopify('GET', '/admin/products.json', $arguments);
//echo "<pre>";
//print_r($orders);
//echo "</pre>";

?>