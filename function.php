<?php

function request($method, array $data)
{
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL, 'https://payment.alikassa.com/api/' . $method);
    curl_setopt($ch,CURLOPT_POST, true);
    curl_setopt($ch,CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch,CURLOPT_CONNECTTIMEOUT ,3);
    curl_setopt($ch,CURLOPT_TIMEOUT, 20);
    $response = curl_exec($ch);
    
    return json_decode($response, true);
}

function sign(array $dataSet, $key, $algo)
{
    if (isset($dataSet['sign'])) {

        unset($dataSet['sign']);
    }

    ksort($dataSet, SORT_STRING); // Sort elements in array by var names in alphabet queue
    array_push($dataSet, $key); // Adding secret key at the end of the string

    $signString = implode(':', $dataSet); // Concatenation calues using symbol ":"

    $signString = hash($algo, $signString, true);

    return base64_encode($signString); // Return the result
}

function getEncryptedData(array $data)
{
    $cipher = 'aes-256-ctr';

    if (!in_array($cipher, openssl_get_cipher_methods())) {
        throw new \Exception('Wrong cipher!');
    }

    $ivLen = openssl_cipher_iv_length($cipher);
    $iv = openssl_random_pseudo_bytes($ivLen);
    $encryptKey = openssl_random_pseudo_bytes(64);
    $key = json_encode(array(
        'iv' => base64_encode($iv),
        'key' => base64_encode($encryptKey)
    ));

    $publicKey = openssl_get_publickey(file_get_contents(__DIR__ . '/public.clients.pem'));

    if(!$publicKey) {
        throw new Exception('Public key error!');
    }

    if(!openssl_public_encrypt($key, $encrypted, $publicKey)) {
        throw new \Exception('Encryption error!');
    }

    return [
        'info' => openssl_encrypt(json_encode($data), $cipher, $encryptKey, 0, $iv),
        'key' => base64_encode($encrypted)
    ];
}
