<?php
error_reporting(E_ALL);
header("Content-Type: text/plain");

$email = $_GET['email'];
$domain = $_GET['domain'];
$auth = $_GET['auth'];
$user = $_GET['user'];
$key = $_GET['key'];

if($auth=='asfkljasf78945u43khjsvncx78sdyiqw') {
    $client = new SoapClient('http://' . $domain .'/api/v2_soap/?wsdl');
    $session = $client->login($user, $key);
    $params = array('email'=>$email);
    try {
        $customerFilter = array(
            'filter' => array(array('key' => 'email', 'value' => $email))
        );
        $customer = array_pop($client->customerCustomerList($session, $customerFilter));
        $ordersFilter = array(
            'filter' => array(
                array('key' => 'customer_id', 'value' => $customer->customer_id),
            ),
            'complex_filter' => array(
                array('key' => 'status', 'value' => array('key' => 'eq', 'value' => 'canceled')),
            )
        );
        $individualRevenue = 0;
        $orders = $client->salesOrderList($session, $ordersFilter);
        foreach($orders as $order) {
            $order = $client->salesOrderInfo($session,$order->increment_id);
            $individualRevenue += $order->grand_total;
            foreach($order->items as $item) {
                $lastItem = $item->name.' ('.$item->sku.')';
            }
        }
        $customer_groups = $client->customerGroupList($session);
        foreach($customer_groups as $group) {
            if($group->customer_group_id == $customer->group_id) {
                $customer_group = $group->customer_group_code;
            }
        }

        $store = $client->storeInfo($session,$customer->store_id)->name;
    } catch(Exception $e) {
        echo $e->getMessage();
    }

    if(isset($customer) && is_object($customer)) {
        $json['profile']['Firstname'] = $customer->firstname;
        $json['profile']['Lastname'] = $customer->lastname;
        if($store) $json['profile']['Website'] = $store;
        if($customer_group) $json['profile']['Customer Group'] = $customer_group;
        if($individualRevenue) $json['profile']['Individual turnover'] = '&euro; '.number_format($individualRevenue,2,'.',',');
        if($lastItem) $json['profile']['Last purchased item'] = $lastItem;

        $json['actions'][0]['title'] = 'View user in shop backend';
        $json['actions'][0]['url'] = 'http://' . $domain;
        $json['actions'][0]['ajax'] = false;

        $json['actions'][1]['title'] = 'Log in as user in shop frontend';
        $json['actions'][1]['url'] = 'http://' . $domain;
        $json['actions'][1]['ajax'] = false;

        echo json_encode($json);
    }
}
