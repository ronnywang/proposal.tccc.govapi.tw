<?php

if (strpos($_SERVER['REQUEST_URI'], '/test/html_e_print.php?id=') !== 0) {
    echo 'only support http://proposal.tccc.gov.tw/test/html_e_print.php?id=[id]';
    exit;
}

preg_match('#^/test/html_e_print.php\?id=([0-9]*)#', $_SERVER['REQUEST_URI'], $matches);

$curl = curl_init();
curl_setopt($curl, CURLOPT_COOKIEFILE, '/tmp/tccc-gov-tw-cookie');
curl_setopt($curl, CURLOPT_COOKIEJAR, '/tmp/tccc-gov-tw-cookie');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_URL, 'http://proposal.tccc.gov.tw/test/html_e_print.php?id=' . intval($matches[1]));
$content = curl_exec($curl);
if ($content == '404!') {
    error_log('login');
    curl_setopt($curl, CURLOPT_COOKIEFILE, '/tmp/tccc-gov-tw-cookie');
    curl_setopt($curl, CURLOPT_URL, 'http://proposal.tccc.gov.tw/test/index.php?act=login');
    curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36');
    curl_setopt($curl, CURLOPT_POSTFIELDS, 'account=guest001&pw=guest0101');
    $content = curl_exec($curl);

    curl_setopt($curl, CURLOPT_COOKIEFILE, '/tmp/tccc-gov-tw-cookie');
    curl_setopt($curl, CURLOPT_URL, 'http://proposal.tccc.gov.tw/test/html_e_print.php?id=' . intval($matches[1]));
    $content = curl_exec($curl);
}
curl_close($curl);

echo $content;
