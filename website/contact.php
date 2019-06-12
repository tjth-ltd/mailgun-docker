
<?php
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    http_response_code(404);
    include('404.php'); // provide your own 404 error page
    die(); /* remove this if you want to execute the rest of
              the code inside the file before redirecting. */
}

if (empty($_POST) || !isset($_POST)) {
    ajaxResponse('error', 'Post cannot be empty.');
} else {
    $postData = $_POST;
    $dataString = implode($postData, ",");
    $mailgun = sendMailgun($postData);
}
function ajaxResponse($status, $message, $data = NULL, $mg = NULL) {
    $response = array(
        'status' => $status,
        'message' => $message,
        'data' => $data,
        'mailgun' => $mg
    );
    $output = json_encode($response);
    exit($output);
}
function sendMailgun($data) {
    $api_key = 'key-**';
    $api_domain = 'mg.yourdomain.com';
    $send_to = 'recpient@yourdomain.com';
    $name = $data['Website'];
    $email = $data['email'];
    $content = $data['message'];
    $messageBody = "Contact: $name ($email)\n\nMessage: $content";
    $config = array();
    $config['api_key'] = $api_key;
    $config['api_url'] = 'https://api.mailgun.net/v2/' . $api_domain . '/messages';
    $message = array();
    $message['from'] = "sender@yourdomain.com";
    $message['to'] = $send_to;
    $message['h:Reply-To'] = "sender@yourdomain.com";
    $message['subject'] = 'Website form Submission';
    $message['text'] = $messageBody;
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $config['api_url']);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_USERPWD, "api:{$config['api_key']}");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $message);
    $result = curl_exec($curl);
    curl_close($curl);
    return $result;
}
?>