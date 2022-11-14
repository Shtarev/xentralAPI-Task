<?php
/** initialization *********************************/
$user = 'HIER IST LOGIN';                          // 
$pass = 'HIER IST PASSWORT';                       // 
$xentralApi = 'HIER SOLL EIN xentralApi URL SEIN'; // 
/***************************************************/
$result;
$anfrage = '/v1/adressen';
$params = '/51'; // ein testUser

if(isset($_GET['suche'])) {
    
    switch ($_GET['suche'])
    {
        case 'user_rechnungen':
        $anfrage = '/v1/belege/rechnungen';
        $params = '?kundennummer=' . trim($_GET['param']);
        $result = sucheArtisan($anfrage, $params, $user, $pass, $xentralApi);
        break;
        
        case 'search':
        $arr['artikel'] = '';
        $arr['auftraege'] = '';

        if($get_auftraege = trim($_GET['auftraege'])) {
            $anfrage = '/v1/artikel';
            $params = '?name_de=' . $get_auftraege;
            $arr['auftraege'] = json_decode(sucheArtisan($anfrage, $params, $user, $pass, $xentralApi), true);
        }

        if($get_artikel = trim($_GET['artikel'])) {
            $anfrage = '/v1/belege/auftraege';
            $params = '?kundennummer=' . $get_artikel;
            $arr['artikel'] = json_decode(sucheArtisan($anfrage, $params, $user, $pass, $xentralApi), true);
        }
        
        $result = json_encode($arr);
        break;
        
        default:
        $result = sucheArtisan($anfrage, $params, $user, $pass, $xentralApi);
        break;
    }

}
else {
    $result = sucheArtisan($anfrage, $params, $user, $pass, $xentralApi);
}

echo $result;
exit;

function sucheArtisan($anfrage, $params, $user, $pass, $xentralApi) {
    $resource = $anfrage . $params;

    if (!function_exists('curl_version')) {
        throw new Exception('curl-Extension fehlt');
    }
    
    $api = array(
        'url' => $xentralApi,
        'resource' => $resource,
        'username' => $user,
        'password' => $pass,
    );
    
    $options = array(
        CURLOPT_URL => $api['url'] . $api['resource'],
        CURLOPT_HEADER => false,
        CURLOPT_HTTPHEADER => array('Accept: application/json'),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTPAUTH => CURLAUTH_DIGEST,
        CURLOPT_USERPWD => $api['username'] . ':' . $api['password'],
    );
    
    $ch = curl_init();
    curl_setopt_array($ch, $options);
    $response = curl_exec($ch);
    
    if (curl_errno($ch)) {
        throw new Exception(curl_error($ch));
    }
    if ($ch != null) {
        curl_close($ch);
    }
    return $response;
}
