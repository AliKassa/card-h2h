### H2H интеграция


```
$data['Order']['merchantUuid'] = 'bb0000ee-c029-402b-a0d6-b04cb7810f25';
$data['Order']['orderId'] = time();
$data['Order']['amount'] = 100;
$data['Order']['payWayVia'] = 'Card';
$data['Order']['currency'] = 'UAH';
$data['Order']['userAgent'] = 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:84.0) Gecko/20100101 Firefox/84.0'; // HTTP_USER_AGENT
$data['Order']['ip'] = '17.190.80.10'; // client ip
$data['Order']['customerEmail'] = 'client@mail.ru'; // client email
$data['Order']['sign'] = sign($data['Order'], 'secret key', 'md5');

$data['Card']['pan'] = '5108700706300000'; // number card
$data['Card']['date'] = '05/21'; // month/year
$data['Card']['cvv'] = '102'; // cvv
$data['Card']['holder'] = 'Universal'; //  first_name last_name

// Not required
$data['CardHolder']['first_name'] = 'Universal';
$data['CardHolder']['last_name'] = 'Universal';
$data['CardHolder']['phone'] = '79370100401'; // 380ХХХХХХХХХ
$data['CardHolder']['email'] = 'client@mail.ru';
$data['CardHolder']['post_code'] = '420000';
$data['CardHolder']['country'] = '643'; // https://www.artlebedev.ru/country-list/ ISO
$data['CardHolder']['state'] = 'Moscow';
$data['CardHolder']['city'] = 'Moscow';
$data['CardHolder']['address_line_1'] = 'Moscow address';
$data['CardHolder']['address_line_2'] = 'Moscow address';
$data['CardHolder']['address_line_3'] = 'Moscow address';

$request = request('charge', getEncryptedData($data));

var_dump($request);

```

### Response

```
{
  "success": true,
  "id": "146612",
  "hash": "d61094030f016b07f1000414b4be4aa0",
  "url": "https://payment.alikassa.com/payment/charge",
  "params": {
    "hash": "d61094030f016b07f1000414b4be4aa0",
    "info": "kXO5WHzHGceE...",
    "key": "ADtXrNGn6opxWQetviZyW..."
  }
}

```

### Form submit

```
<form method="post" action="http://payment.alikassa.com/payment/charge">
<input type="hidden" name="hash" value="d61094030f016b07f1000414b4be4aa0" />
<input type="hidden" name="info" value="kXO5WHzHGceE..." />
<input type="hidden" name="key" value="ADtXrNGn6opxWQetviZyW..." />
<input type="submit" />
</form>
```



