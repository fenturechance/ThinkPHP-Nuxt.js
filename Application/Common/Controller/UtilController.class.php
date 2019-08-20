<?php

namespace Common\Controller;

use Common\Controller\translate;

class UtilController {

    function toCurl($url, $method, $content, $httpHeader, $type = 'function', $cookie = '') {
        $ch = curl_init($url); //请求的URL地址
        //curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        if ($method != "GET") {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $httpHeader);
//        } else {
//            curl_setopt($ch, CURLOPT_HEADER, false);
//        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($cookie != '') {
            $cookie_jar = dirname(__FILE__) . "\\" . $cookie;
        }
        if ($type == "login") {
            curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_jar);
        }
        if ($type != 'login' && $cookie != '') {
            curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_jar); //读取
        }
        //curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/x-www-form-urlencoded;charset=utf-8', 'Content-Length:' . strlen($post_content)));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        //curl_setopt($ch, CURLOPT_PROXY, C('CURLOPT_PROXY'));
        //curl_setopt($ch, CURLOPT_PROXYUSERPWD, C('CURLOPT_PROXYUSERPWD'));
        $recv = curl_exec($ch);
        $httpInfo = curl_getinfo($ch); //curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpInfo['http_code'] == 200) {
            return $recv;
        } else {
            return json_encode($httpInfo);
        }
    }
    /**
     +---------------------------------------------------------- 
     When you need to accept these as valid, non-empty values:
     *  - 0 (0 as an integer)
     *  - 0.0 (0 as a float)
     *  - "0" (0 as a string)
     +---------------------------------------------------------- 
     * @param mixed $var
     +---------------------------------------------------------- 
     * @return boolean 
     +---------------------------------------------------------- 
     **/
    public function is_empty_param($value) {
        return empty($value) && !is_numeric($value);
    }

     /**
     +---------------------------------------------------------- 
     To transform parameter from HTTP Body to php object
     +---------------------------------------------------------- 
     * @param object $param
     +---------------------------------------------------------- 
     * @return object 
     +---------------------------------------------------------- 
     **/
    public function parse_param($param) {
        $contentType = $_SERVER["CONTENT_TYPE"];
        if(strpos($contentType, "application/json") !== false) {
            $put = json_decode(file_get_contents("php://input"), true);
            if(strtolower($_SERVER['REQUEST_METHOD']) == 'put') $param = array();
            foreach ($put as $key => $value) {
                $param[$key] = $value;   
            }
        }
        return $param;
    }

    public function check_login(){
        if(session('fire_user')){
            return true;
        }else{
            http_response_code(403);
            echo json_encode( array( 'parameter' => 'Unauthorized',
                                     "message" => "Please login to this system"));
            die;
        }
    }

    public function check_method(){
        if(IS_POST){
            return;
        }else{
            http_response_code(500);
            echo json_encode( array( 'parameter' => 'Unauthorized',
                                     "message" => "Unauthorized access"));
            die;
        }
    }
  
    public function decode_token(){
        if($this->check_login()){
            $token = base64_decode(session('fire_user')['token']);
            $explodeToken = explode(";", $token);
            $accountID = $explodeToken[0];
            $acoountEmail = $explodeToken[1];
            $lastLoginTime = $explodeToken[2];
            return $accountID;
        }
    }

    public function userJoin() {
        $join1 = 'organization o on u.organization_id = o.id';
        $join2 = 'organization_company oc on o.id = oc.org_id';
        $join3 = 'company c on c.id = oc.company_id';
        return M()->table('users u')->join($join1)->join($join2)->join($join3);
    }

    public function organizationJoin() {
        $join1 = 'organization_company oc on o.id = oc.org_id';
        $join2 = 'company c on c.id = oc.company_id';
        return M()->table('organization o')->join($join1)->join($join2);
    }
}

?>
