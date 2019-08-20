<?php

namespace Common\Controller;

use Think\Controller;
use Think\Model;

//require_once 'big5ToGbArr.php';
//$GLOBALS['s2t_table'] = array_flip($GLOBALS['t2s_table']);

class translate extends Controller {

    public $location;

    //private $db;
    public function translate($location) {
        $this->location = $location;
    }

    function big5ToGbArr() {
        $db = M('words_list');
        $data = array();
        $dataArr = $db->field('fanti big5,jianti Gb')->select();
        foreach ($dataArr as $key => $value) {
            $k = $value['big5'];
            $v = $value['Gb'];
            $data[$k] = $v;
        }
        return $data;
    }

    function utf8_GbTobig5($word) {
        $table = $this->big5ToGbArr();
        $table = array_flip($table);
        return strtr($word, $table);
    }

    function utf8_big5ToGb($word) {
        $table = $this->big5ToGbArr();
        return strtr($word, $table);
    }

}

?>
