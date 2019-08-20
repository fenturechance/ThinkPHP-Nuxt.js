<?php

function params(){
    $put = json_decode(file_get_contents("php://input"), true);
    return $put;
}


function curl($url, $method = 'get', $post_fields = '', $json_body = '', $headers = null, $timeout = 10) {
    $valid_method = ['get', 'post', 'put', 'delete'];
    if ($method && !in_array($method, $valid_method)) {
        exit('Unable to handle method ' . $method);
    }
    $ch = curl_init();
    /* 设置返回结果为流 */
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    /* 设置超时时间 */
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    /* 设置通信方式 */
    'post' == $method && curl_setopt($ch, CURLOPT_POST, true);
    'post' == $method && $post_fields && curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_fields));
    'post' == $method && $json_body && curl_setopt($ch, CURLOPT_POSTFIELDS, $json_body);
    'put' == $method && curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    'put' == $method && $post_fields && curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_fields));
    'delete' == $method && curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');

    $headers && curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_URL, $url);

    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

function resSuccess($tip = '', $data = '') {
    http_response_code(200);
    $info = array(
        'message' => $tip
    );
    if($data!='')
        $info['data']=$data;
    exit(json_encode($info, JSON_UNESCAPED_UNICODE));
}

function resError($error_code, $error_reason) {
    $info= array("error"=>$error_reason);
    switch ($error_code){
        case 400;
            http_response_code(400);
            break;
        case 401;
            http_response_code(401);
            break;
        case 403;
            http_response_code(403);
            break;
        case 404;
            http_response_code(404);
            break;
        case 409;
            http_response_code(409);
            break;
        case 500;
            http_response_code(500);
            break;
        case 503;
            http_response_code(503);
            break;

    }
//    $info = array(
//        1300 => array(
//            'error_code' => 1300,
//            'error_message' => '登录错误',
//            'error_reason' => $error_reason
//        ),
//        1301 => array(
//            'error_code' => 1301,
//            'error_message' => '登录超时',
//            'error_reason' => $error_reason
//        ),
//        1302 => array(
//            'error_code' => 1302,
//            'error_message' => '没有权限',
//            'error_reason' => $error_reason
//        ),
//        1401 => array(
//            'error_code' => 1401,
//            'error_message' => '参数错误',
//            'error_reason' => $error_reason
//        ),
//        1406 => array(
//            'error_code' => 1406,
//            'error_message' => '其它错误',
//            'error_reason' => $error_reason
//        ),
//        1500 => array(
//            'error_code' => 1500,
//            'error_message' => '未知错误',
//            'error_reason' => ''
//        ),
//        1501 => array(
//            'error_code' => 1501,
//            'error_message' => '数据库错误',
//            'error_reason' => $error_reason
//        ),
//        1600 => array(
//            'error_code' => 1600,
//            'error_message' => '推送失败',
//            'error_reason' => $error_reason
//        )
//    );
    exit(json_encode($info, JSON_UNESCAPED_UNICODE));
}

function zero($string,$length){
    return str_pad($string,$length,"0",STR_PAD_LEFT);
}
