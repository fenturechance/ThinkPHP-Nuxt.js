<?php

namespace Common\Controller;

use Think\Controller\RestController;
use Think\Auth;

class AuthController extends RestController {
    protected $Uid = null;
    protected $Sid = null;
    protected $Param = null;
    protected function _initialize() {
        $Util = A('Common/Util');
        if(MODULE_NAME == 'Home') {
            header('Content-Type: application/json; charset=UTF-8');
            $Util->get_authorized($this->Uid, $this->Sid);
            $controllerIndex = MODULE_NAME . "/" . CONTROLLER_NAME . "/" . ACTION_NAME . "/" . $this->_method;
            $auth = new Auth();
            if (!$auth->check($controllerIndex, $this->Sid)) {
                http_response_code(400);
                echo json_encode( array( "status" => "403",
                    "message" => "Sorry, you don't have authorization for this action."));
                die;
            }
            $this->Param = $Util->parse_param(I('param.'));
        }else{
            $this->assign('lang', L());
        }
    }

    public function addAuthRuleInfo() {

        $util = A('Common/Util');

        $db = M(C('AUTH_CONFIG.AUTH_RULE'));

        $map = array();
        $map['name'] = MODULE_NAME . "/" . CONTROLLER_NAME . "/" . ACTION_NAME . "/" . $this->_method;
        $map['title'] = "Api - " . ACTION_NAME . "_" . $this->_method;

        $data = $db->where($map)->find();
        if (!$data) {
            $db->add($map);
            $util->response(0);
        }
        $util->response(-4);
    }

}
