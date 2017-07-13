<?php
//echo base64_encode('4db426e60d95317b2683b7b88743cda5:923e5a52f1eff4eccea5feeb45251ff3');
//exit;

$img = $_POST['img'];

$data = [
    "product" => [
        "title" => "Customer map " . date('c'),
        "body_html" => "",
        "product_type" => "Customer map",
        "images" => [
            [
              "src" => $img
            ]
        ]
    ]
];

$json = json_encode($data);

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://satellitelens.myshopify.com/admin/products.json",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $json,
    CURLOPT_HTTPHEADER => array(
        "authorization: Basic NGRiNDI2ZTYwZDk1MzE3YjI2ODNiN2I4ODc0M2NkYTU6OTIzZTVhNTJmMWVmZjRlY2NlYTVmZWViNDUyNTFmZjM=",
        "cache-control: no-cache",
        "content-type: application/json"
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    $result = ['result' => 0, 'msg' => $err];
} else {
    $product = json_decode($response);
    $result = ['result' => 1, 'product' => $product->product];
}

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
//echo $_GET['callback'] . "(" . json_encode($result) . ")";  // JSONP
echo json_encode($result);  // JSON