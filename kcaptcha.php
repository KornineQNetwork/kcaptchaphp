<?php
define('KAPTCHA_VERIFY_URL', 'https://sys.kornineq.de/kaptcha/kaptcha-verify.php');
define('SITEKEY', '');
define('SITE_SECRET', '');

function kaptcha_validate() {
    if(!isset($_POST["_KAPTCHA"])) { return false; }
   
    $postFields = [
        'key' => $_POST["_KAPTCHA_KEY"],
        'site_key' => SITEKEY,
        'site_secret' => SITE_SECRET
    ];
   
    $ch = curl_init(KAPTCHA_VERIFY_URL);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $result = curl_exec($ch);
    curl_close($ch);
    
    $response = json_decode($result, true);
   
    return isset($response['success']) && $response['success'] === true;
}

function check_captcha() {
    if (isset($_POST["_KAPTCHA"]))
        return kaptcha_validate();
    return false;
}
?>
