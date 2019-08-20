<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Common\Controller;

use Common\Controller\translate;

/**
 * Description of HayleyCommonController
 *
 * @author Hayley
 */
class Hayley {

    public $location;

    //private $db;
//    public function Hayley($location) {
//        $this->location = $location;
//    }
    public function __construct() {
        
    }

    /*
     * 建立CURL访问；
      +----------------------------------------------------------
     * @Author: Hayley
      +----------------------------------------------------------
     * @access public
      +----------------------------------------------------------
     * @param string $url（访问的URL）
      +----------------------------------------------------------
     * @param string $method（请求方式）
      +----------------------------------------------------------
     * @param ... $content（请求参数，依实际情况定类型）
      +----------------------------------------------------------
     * @param array $httpHeader（请求头）
      +----------------------------------------------------------
     * @param string $type（请求功能：function，login）
      +----------------------------------------------------------
     * @param string $cookie（cookie 文件名）
      +----------------------------------------------------------
     * @return jsonstring（返回json字串）
      +----------------------------------------------------------
     */

    function toCurl($url, $method, $content, $httpHeader, $type = 'function', $cookie = '') {
        $ch = curl_init($url); //请求的URL地址
        //curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        if ($method != "GET" && !empty($method)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
        }
        if (!empty($httpHeader)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $httpHeader);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($cookie != '') {
            $cookie_jar = dirname(__FILE__) . "\\" . $cookie; //cookie 文件名
        }
        if ($type == "login") {
            curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_jar); //存储cookie 目录
        }
        if ($type != 'login' && $cookie != '') {
            curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_jar); //读取cookie 目录
        }
        //curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/x-www-form-urlencoded;charset=utf-8', 'Content-Length:' . strlen($post_content)));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        //curl_setopt($ch, CURLOPT_PROXY, C('CURLOPT_PROXY'));
        //curl_setopt($ch, CURLOPT_PROXYUSERPWD, C('CURLOPT_PROXYUSERPWD'));
        $recv = curl_exec($ch);
        $httpInfo = curl_getinfo($ch); //curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpInfo['http_code'] == 200) {
            if (empty(json_decode($recv))) {
                return json_encode($recv);
            } else {
                return $recv;
            }
        } else {
            return json_encode($httpInfo);
        }
    }

    /*
     * 建立从开始时间到截止时间的时间数组；
      +----------------------------------------------------------
     * @Author: Hayley
      +----------------------------------------------------------
     * @access public
      +----------------------------------------------------------
     * @param array $time_arr（时间数组）
      +----------------------------------------------------------
     * @param array $startTime（开始时间）
      +----------------------------------------------------------
     * @param array $endTime（截止时间）
      +----------------------------------------------------------
     * @param string $type（统计单位：hour，day，week，month，year）
      +----------------------------------------------------------
     * @return array（返回时间数组）
      +----------------------------------------------------------
     */

    function timeArrayProcess($startTime, $endTime, $type = null) {
        $format = "Y-m-d H:i:s";
        if ($startTime > $endTime) {
            $temp = $startTime;
            $startTime = $endTime;
            $endTime = $temp;
        }
        $timeLength = date_diff(date_create($startTime), date_create($endTime));
        //echo $diff->format("%a days");
        $s_stamp = strtotime($startTime);
        $e_stamp = strtotime($endTime);
        $time_arr = array();
        if (empty($type)) {
            if ($timeLength->days <= 1) {
                $type = "hour";
            } elseif (($timeLength->days > 1) and ( $timeLength->days <= 31)) {
                $type = "day";
            } elseif (($timeLength->days > 31) and ( $timeLength->days <= 92)) {
                $type = "week";
            } elseif (($timeLength->days > 92) and ( $timeLength->days <= 730)) {
                $type = "month";
            } else {
                $type = "year";
            }
        }
        switch ($type) {
            case hour:
                $start = date('Y-m-d H:00:00', strtotime($startTime));
                $end = date('Y-m-d H:00:00', strtotime($endTime));
                $ns_stamp = strtotime($start);
                $ne_stamp = strtotime($end);
                if ($ns_stamp == $s_stamp) {
                    $i = 0;
                    $ns_stamp = $s_stamp;
                } else {
                    $i = 1;
                    $time_arr[0][x] = date('Y-m-d H', $s_stamp) . "时";
                    $time_arr[0][start] = date($format, $s_stamp);
                    $ns_stamp+=3599;
                    $time_arr[0][end] = date($format, $ns_stamp);
                    $ns_stamp+=1;
                }
                while ($ns_stamp < $ne_stamp) {
                    $time_arr[$i][x] = date('Y-m-d H', $ns_stamp) . "时";
                    $time_arr[$i][start] = date($format, $ns_stamp);
                    $ns_stamp+=3599;
                    //if ($ns_stamp < $ne_stamp) {
                    $time_arr[$i][end] = date($format, $ns_stamp);
                    $ns_stamp+=1;
                    $i++;
                    //} else {
                    //break;
                    // }
                }
                //$e_stamp-=1;
                if ($ne_stamp < $e_stamp) {
                    $time_arr[$i][x] = date('Y-m-d H', $ne_stamp) . "时";
                    $time_arr[$i][start] = date($format, $ne_stamp);
                    $time_arr[$i][end] = date($format, $e_stamp);
                }
                break;
            case day:
                $start = date('Y-m-d', strtotime($startTime));
                $end = date('Y-m-d', strtotime($endTime));
                $ns_stamp = strtotime($start);
                $ne_stamp = strtotime($end);
                if ($ns_stamp == $s_stamp) {
                    $i = 0;
                } else {
                    $i = 1;
                    $time_arr[0][x] = date('Y-m-d', $s_stamp);
                    $time_arr[0][start] = date($format, $s_stamp);
                    $ns_stamp+=86399;
                    $time_arr[0][end] = date($format, $ns_stamp);
                    $ns_stamp+=1;
                }//$ne_stamp = $e_stamp;
                while ($ns_stamp < $ne_stamp) {
                    $time_arr[$i][x] = date('Y-m-d', $ns_stamp);
                    $time_arr[$i][start] = date($format, $ns_stamp);
                    $ns_stamp+=86399;
                    if ($ns_stamp < $ne_stamp) {
                        $time_arr[$i][end] = date($format, $ns_stamp);
                        $ns_stamp+=1;
                        $i++;
                    }
                }
                //$e_stamp=1;
                //if ($ne_stamp < $e_stamp) {
                $time_arr[$i][x] = date('Y-m-d', $ns_stamp);
                $time_arr[$i][start] = date($format, $ns_stamp);
                $time_arr[$i][end] = date($format, $e_stamp);
                //}
                break;
            case week:
                $start = date('Y-m-d', strtotime($startTime));
                $end = date('Y-m-d', strtotime($endTime));
                $ns_stamp = strtotime($start);
                $ne_stamp = strtotime($end);
                if ($ns_stamp == $s_stamp) {
                    $i = 0;
                } else {
                    $i = 1;
                    $time_arr[0][x] = date('Y-m-d', $s_stamp);
                    $time_arr[0][start] = date($format, $s_stamp);
                    $w = date('N', strtotime($time_arr[0][start]));
                    $ns_stamp+=(8 - $w ) * 86400 - 1;
                    $time_arr[0][end] = date($format, $ns_stamp);
                    $arr = array(date('Y-m-d', strtotime($time_arr[0][start])), date('Y-m-d', strtotime($time_arr[0][end])));
                    $time_arr[0][x] = implode("~", $arr);
                    $ns_stamp+=1;
                }
                //$ne_stamp = $e_stamp;
                while ($ns_stamp < $ne_stamp) {
                    $time_arr[$i][x] = date('Y-m-d', $ns_stamp);
                    $time_arr[$i][start] = date($format, $ns_stamp);
                    $ns_stamp+=604799; //(7 * 86400 - 1)
                    if ($ns_stamp < $ne_stamp) {
                        $time_arr[$i][end] = date($format, $ns_stamp);
                        $arr = array(date('Y-m-d', strtotime($time_arr[$i][start])), date('Y-m-d', strtotime($time_arr[$i][end])));
                        $time_arr[$i][x] = implode("~", $arr);
                        $ns_stamp+=1;
                        $i++;
                    } /* else {
                      break;
                      } */
                }
                //$e_stamp-=1;
                //if ($ne_stamp < $e_stamp) {
                $time_arr[$i][start] = date($format, $ns_stamp);
                $time_arr[$i][end] = date($format, $e_stamp);
                $arr = array(date('Y-m-d', strtotime($time_arr[$i][start])), date('Y-m-d', strtotime($time_arr[$i][end])));
                $time_arr[$i][x] = implode("~", $arr);
                //}
                break;
            case month:
                $start = date('Y-m', strtotime($startTime));
                $end = date('Y-m', strtotime($endTime));
                $ns_stamp = strtotime($start);
                $ne_stamp = strtotime($end);
                if ($ns_stamp == $s_stamp) {
                    $i = 0;
                    $ns_stamp = $s_stamp;
                } else {
                    $i = 1;
                    $time_arr[0][x] = date('Y-m', $s_stamp);
                    $time_arr[0][start] = date($format, $s_stamp);
                    $num = date("t", $s_stamp);
                    $ns_stamp+=$num * 86400 - 1;
                    $time_arr[0][end] = date($format, $ns_stamp);
                    $ns_stamp+=1;
                }
                while ($ns_stamp < $ne_stamp) {//这里累加每个月的的总秒数 计算公式：上一月1号的时间戳秒数减去当前月的时间戳秒数
                    $time_arr[$i][x] = date('Y-m', $ns_stamp);
                    $time_arr[$i][start] = date($format, strtotime($time_arr[$i][x]));
                    $num = date("t", $ns_stamp);
                    $ns_stamp+=$num * 86400 - 1;
                    $time_arr[$i][end] = date($format, $ns_stamp);
                    $ns_stamp+=1;
                    $i++;
                }
                //$e_stamp-=1;
                //if ($ne_stamp < $e_stamp) {
                $time_arr[$i][x] = date('Y-m', $ne_stamp);
                $time_arr[$i][start] = date($format, strtotime($time_arr[$i][x]));
                $time_arr[$i][end] = date($format, $e_stamp);
                //}
                break;
            case year:
                $start = date('Y-01-01 00:00:00', strtotime($startTime));
                $end = date('Y-01-01 00:00:00', strtotime($endTime));
                $ns_stamp = strtotime($start);
                $ne_stamp = strtotime($end);
                if ($ns_stamp == $s_stamp) {
                    $i = 0;
                } else {
                    $i = 1;
                    $time_arr[0][x] = date('Y', $s_stamp);
                    $time_arr[0][start] = date($format, $s_stamp);
                    $s_stamp = strtotime(date("Y-12-31 23:59:59", $s_stamp));
                    $time_arr[0][end] = date($format, $s_stamp);
                    $nu = 0;
                    for ($j = 01; $j <= 12; $j++) {
                        $stamp = strtotime(date("Y-$j", $s_stamp));
                        $nu += date("t", $stamp);
                    }
                    $ns_stamp+=$nu * 86400;
                }//$ne_stamp = $e_stamp;
                while ($ns_stamp < $ne_stamp) {
                    $time_arr[$i][x] = date('Y', $ns_stamp);
                    $time_arr[$i][start] = date($format, $ns_stamp);
                    $n = 0;
                    for ($j = 01; $j <= 12; $j++) {
                        $stamp = strtotime(date("Y-$j", $ns_stamp));
                        $n += date("t", $stamp);
                    }
                    $ns_stamp+=$n * 86400 - 1;
                    $time_arr[$i][end] = date($format, $ns_stamp);
                    $ns_stamp+=1;
                    $i++;
                }
                //$e_stamp-=1;
                //if ($ne_stamp < $e_stamp) {
                $time_arr[$i][x] = date('Y', $ne_stamp);
                $time_arr[$i][start] = date($format, $ne_stamp);
                $time_arr[$i][end] = date($format, $e_stamp);
                //}
                break;
            default:
                break;
        }
        //var_dump($time_arr);
        return $time_arr;
    }

    /*
     * 进行汉字简繁体双向转换；
      +----------------------------------------------------------
     * @Author: Hayley
      +----------------------------------------------------------
     * @access public
      +----------------------------------------------------------
     * @return array $array（目的数组）
      +----------------------------------------------------------
     * @param array $array（被转数组）
      +----------------------------------------------------------
     * @param string $type（转成字体类型：big5，Gb）
      +----------------------------------------------------------
     * @return array $array（返回被转数组）
      +----------------------------------------------------------
     */

    function big5ToGb($array, $type) {
        if (empty($array)) {
            return $array;
        } else {
            if (is_array($array)) {
                foreach ($array as $key => $value) {
                    $array[$key] = $this->arraybig5ToGb($value, $type);
//                if (is_array($value)) {
//                    $array[$key] = arraybig5ToGb($value, $type);
//                } else {
//                    $array[$key] = stringbig5ToGb($value, $type);
//                }
                }
            } else {
                $translate = new translate;
                switch ($type) {
                    case "big5":
                        $array = $translate->utf8_GbTobig5($array);
                        break;
                    case "gb":
                        $array = $translate->utf8_big5ToGb($array);
                        break;
                    default:
                        break;
                }
            }
            return $array;
        }
    }

    /*
     * log文件存储；
      +----------------------------------------------------------
     * @Author: Hayley
      +----------------------------------------------------------
     * @access public
      +----------------------------------------------------------
     * @param string $string（记录内容）
      +----------------------------------------------------------
     * @param string $dest（log名称）
      +----------------------------------------------------------
     * @param string $path（存储路径）
      +----------------------------------------------------------
     * @return string (返回记录结果）
      +----------------------------------------------------------
     */

    function myLog($string, $dest, $path = '') {
        if ($path == '') {
            $path = "./Public/log/"; //服務器地址,本地也可以使用
        }
        if (!is_dir($path)) {
            mkdir($path);
        }
        $fp = fopen($path . $dest, 'a');
        fwrite($fp, $string . "\r\n");
        fclose($fp);
        if (fwrite) {
            return $path . $dest;
        } else {
            return false;
        }
    }

    /*
     * 二维数组单一字段排序；
      +----------------------------------------------------------
     * @Author: Hayley
      +----------------------------------------------------------
     * @access public
      +----------------------------------------------------------
     * @param string $string（记录内容）
      +----------------------------------------------------------
     * @param string $dest（log名称）
      +----------------------------------------------------------
     * @param string $path（存储路径）
      +----------------------------------------------------------
     * @return array $array (返回排序数组）
      +----------------------------------------------------------
     */

    function arrayScort($array, $field, $sort) {
        $flag = array(); //排序的根据
        foreach ($array as $v) {
            $flag[] = $v[$field];
        }
        switch ($sort) {
            case SORT_ASC:
            case "asc":
            case "ASC":
                array_multisort($flag, SORT_ASC, $array); //根据排序的根据数组升序排序
                break;
            case SORT_DESC:
            case "DESC":
            case "desc":
                array_multisort($flag, SORT_DESC, $array); //根据排序的根据数组降序排序
                break;
            default:
                break;
        }
        //array_splice($array, 10); //只取数组里的10个元素
        return $array;
    }

    /*
     * 二维维数组多字段排序；
      +----------------------------------------------------------
     * @Author: Hayley
      +----------------------------------------------------------
     * @access public
      +----------------------------------------------------------
     * @param array $array（）
      +----------------------------------------------------------
     * @param string $dest（log名称）
      +----------------------------------------------------------
     * @param string $path（存储路径）
      +----------------------------------------------------------
     * @return array $array (返回排序数组）
      +----------------------------------------------------------
     * @example arrayScortByManyField($eventList['data'], 'NAME', SORT_DESC, 'TIME', SORT_DESC);
      +----------------------------------------------------------
     */

    function arrayScortByManyField() {
        $args = func_get_args();
        if (empty($args)) {
            return null;
        }
        $arr = array_shift($args);
        if (!is_array($arr)) {
            return array();
        }
        foreach ($args as $key => $field) {
            if (is_string($field)) {
                $temp = array();
                foreach ($arr as $index => $val) {
                    $temp[$index] = $val[$field];
                }
                $args[$key] = $temp;
            }
        }
        $args[] = &$arr; //引用值
        call_user_func_array('array_multisort', $args);
        return array_pop($args);
    }

    //防止中文转码，遍历数据结果，每项单独urlencode，
    function arrayUrlencode($array) {
        if (empty($array)) {
            return $array;
        } else {
            foreach ($array as $key => $value) {//对每个数组元素进行urlencode
                if (is_array($value)) {
                    $array[$key] = $this->arrayUrlencode($value);
                } else {
                    $array[$key] = urlencode($value);
                }
            }
        }
        return $array;
    }

    //    再整体urldecode
    function arrayJsonencode($array) {
        $url_arr = $this->arrayUrlencode($array);
        $json_arr = json_encode($url_arr); //json 输出
        return urldecode($json_arr); //整体urldecode
    }

    /**
     * 导出数据为excel表格
     * @param $title    Excel主题，字符串
     * *@param $labels   excel的第一行标题,一个数组, //如果为空则没有标题
     * @param $data   一个二维数组,结构如同从数据库查出来的数组
     * @param $filename 下载的文件名
     * @examlpe
      $stu = M ('User');
      $arr = $stu -> select();
      exportToExcel('User Info',array('id','账户','密码','昵称'),$arr,'文件名!');
     */
    function exportToExcel($title, $labels, $data, $filename) {
        vendor("PHPExcel.PHPExcel");
        $objExcel = new \PHPExcel();
        $objWriter = new \PHPExcel_Writer_Excel5($objExcel);
        //设置文档基本属性
        $objProps = $objExcel->getProperties();
        $objProps->setCreator("System");
        $objProps->setLastModifiedBy("System");
        $objProps->setTitle($title);
        $objProps->setSubject($title);
        $objProps->setDescription($title);
        //$objProps->setKeywords("Car List Sheet");
        //$objProps->setCategory("Car");

        $objExcel->setActiveSheetIndex(0);
        $objActSheet = $objExcel->getActiveSheet();

        $objActSheet->setTitle($title);


        //设置名称
        $idx = ord('A');
        foreach ($labels as $label) {
            //echo $data["deviceid"]."| ".$data["vehicleid"]."<br/>";

            $objActSheet->setCellValue(chr($idx) . '1', $label);
            $idx +=1;
        }

        $rowidx = 2;
        //设置数据
        foreach ($data as $rows) {
            //echo $data["deviceid"]."| ".$data["vehicleid"]."<br/>";
            $colidx = ord('A');
            foreach ($rows as $col) {
                $objActSheet->setCellValueExplicit(chr($colidx) . $rowidx, $col);
                //$objActSheet->setCellValue(chr($colidx).$rowidx, $col);
                $colidx +=1;
            }

            $rowidx +=1;
        }

        // 输出
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename=' . $filename);
        header('Cache-Control: max-age=0');

        $objWriter->save('php://output');
    }

    /**
     * 判断一个值是否存在于二位数组中
     * @param $v    被判断的值
     * *@param $array   被判断的二维数组
     * @return mixed 返回被判断值所在的数组的在二维数组里的键名或布尔类型
     */
    function twoDimenArrayValueJudge($v, $array) {
        foreach ($array as $key => $value) {
            $t = array_search($v, $value);
            if (!(array_search($v, $value) === false)) {
                $flag = $key; //array_search($v, $value);
                break;
            } else {
                $flag = false;
            }
        }
        return $flag;
    }

    /*
      +----------------------------------------------------------
     * 计算给定两个耗时时间和（例：1天2小时3分4秒）
      +----------------------------------------------------------
     * @access public
      +----------------------------------------------------------
     * @return $consumetimeSum 时间和（例：1天2小时3分4秒）
      +----------------------------------------------------------
     * @param string $consumetime1   时间差1(例：1天2小时3分4秒)
     * @param string $consumetime2   时间差2(例：2小时3分4秒)
     * @param string $secondFlag   秒标志(返回结果：N:不计算秒，其它：计算秒)
     */

    function consumetimeFormSum($consumetime1, $consumetime2, $secondFlag = null) {
        if (empty($consumetime1) && empty($consumetime2)) {
            if ($secondFlag == "N") {
                $consumetimeSum = "0分";
            } else {
                $consumetimeSum = "0秒";
            }
        } else {
            if (empty($consumetime1)) {
                $consumetime = $consumetime2;
            } elseif (empty($consumetime2)) {
                $consumetime = $consumetime1;
            } else {
                if (strpos($consumetime1, '小时') === false) {
                    $consumetime1 = str_ireplace("时", "小时", $consumetime1);
                }
                if (strpos($consumetime2, '小时') === false) {
                    $consumetime2 = str_ireplace("时", "小时", $consumetime2);
                }
                $secondSum1 = consumetimeStrtotime($consumetime1);
                $secondSum2 = consumetimeStrtotime($consumetime2);
                $secondSum = $secondSum1 + $secondSum2;
                $consumetime = timediff("", "", $secondSum);
            }
            $consumetimeSum = timeDiffFormProcess("", "", $consumetime, $secondFlag);
        }
        return $consumetimeSum;
    }

    /*
      +----------------------------------------------------------
     * 计算给定耗时时间秒数和
      +----------------------------------------------------------
     * @access public
      +----------------------------------------------------------
     * @return $secondSum 时间秒数和（例：7384）
      +----------------------------------------------------------
     * @param string $consumetime   时间差(例：0天2小时3分4秒，2小时3分4秒)
     */

    function consumetimeStrtotime($consumetime) {
        if (empty($consumetime)) {
            $secondSum = 0;
        } else {
            if (strpos($consumetime, '小时') === false) {
                $consumetime = str_ireplace("时", "小时", $consumetime);
            }
            $dateArr = explode("天", $consumetime);
            if (sizeof($dateArr) != 2) {
                $date = 0;
                $dateDiff = $dateArr[0];
            } else {
                $date = $dateArr[0];
                $dateDiff = $dateArr[1];
            }
            if (empty($dateDiff)) {
                $hour = 0;
                $minute = 0;
                $second = 0;
            } else {
                $hourArr = explode("小时", $dateDiff);
                if (sizeof($hourArr) != 2) {
                    $hour = 0;
                    $hourDiff = $hourArr[0];
                } else {
                    $hour = $hourArr[0];
                    $hourDiff = $hourArr[1];
                }
                if (empty($hourDiff)) {
                    $minute = 0;
                    $second = 0;
                } else {
                    $minuteArr = explode("分", $hourDiff);
                    if (sizeof($minuteArr) != 2) {
                        $minute = 0;
                        $minuteDiff = $minuteArr[0];
                    } else {
                        $minute = $minuteArr[0];
                        $minuteDiff = $minuteArr[1];
                    }
                    if (empty($minuteDiff)) {
                        $second = 0;
                    } else {
                        $secondArr = explode("秒", $minuteDiff);
                        $second = $secondArr[0];
                    }
                }
            }
            $secondSum = $date * 86400 + $hour * 3600 + $minute * 60 + $second;
        }
        return $secondSum;
    }

    function postMail($sender, $recipient, $subject, $body, $attachment = '', $Cc = '', $Bcc = '', $Reply = '') {
        require_once('class.phpmailer.php');
        include('class.smtp.php');
        $mail = new PHPMailer;
        $mail->SMTPDebug = 0;
        //  0 = close SMTP debug;1 = errors and messages; 2 = messages only;3= Enable verbose debug output
        $mail->CharSet = "UTF-8"; //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
        $mail->isSMTP();                                      // Set mailer to use SMTP serve
        $mail->Host = C('MAIL_SMTP'); //'snchnsh.efoxconn.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = false;                               // Enable SMTP authentication
        //$mail->Username = 'user@example.com';                 // SMTP username
        //$mail->Password = 'secret';                           // SMTP password
        $mail->SMTPSecure = C('MAIL_SMTP_SECURE'); //'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = C('MAIL_SMTP_PORT'); //587;                                    // TCP port to connect to
        $mail->Helo = C('MAIL_SMTP_HELO'); // 'ismetoad';
        //$mail->setFrom('zacker.z.mei@mail.foxconn.com', 'Mailer');
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $sendArray = explode(':', $sender);
        $mail->setFrom($sendArray[0], $sendArray[1]);
        foreach ($recipient as $value) {
            $recipientArray = explode(':', $value);
            $mail->addAddress($recipientArray[0], $recipientArray[1]);
        }
        //$mail->addAddress('zacker.z.mei@mail.foxconn.com', 'User');     // Add a recipient
        if (!empty($Reply)) {
            $ReplyArray = explode(':', $Reply);
            $mail->addReplyTo($ReplyArray[0], $ReplyArray[1]);
        }
        //$mail->addReplyTo('info@example.com', 'Information');
        //$mail->addCC('cc@example.com');
        if (!empty($Cc)) {
            foreach ($Cc as $value) {
                $CcArray = explode(':', $value);
                $mail->addCC($CcArray[0], $CcArray[1]);
            }
        }
        //$mail->addBCC('bcc@example.com');
        if (!empty($Bcc)) {
            foreach ($Bcc as $value) {
                $BccArray = explode(':', $value);
                $mail->addCC($BccArray[0], $BccArray[1]);
            }
        }
        //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        if (!empty($attachment)) {
            if (is_array($attachment)) { // 添加附件
                foreach ($attachment as $file) {
                    if (is_array($file)) {
                        is_file($file['path']) && $mail->AddAttachment($file['path'], $file['name']);
                    } else {
                        is_file($file) && $mail->AddAttachment($file);
                    }
                }
            } else {
                is_file($attachment) && $mail->AddAttachment($attachment);
            }
        }
        //$mail->isHTML(true);                                  // Set email format to HTML
        //$mail->Subject = 'Here is the subject';
        $mail->Subject = $subject;
        //$mail->Body = 'This is the HTML message body <b>in bold!</b>';
        $mail->Body = $body;
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        if (!$mail->send()) {
            $result['result'] = "fail";
            $result['error'] = $mail->ErrorInfo;
        } else {
            $result['result'] = "pass";
        }
        return $result;
    }

    function tryCatchTest() {
        try {
            if (file_exists('test_try_catch.php')) {
                require ('test_try_catch.php');
            } else {
                throw new Exception('file is not exists');
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /*
     * 生成随机数；
      +----------------------------------------------------------
     * @Author: Hayley
      +----------------------------------------------------------
     * @access public
      +----------------------------------------------------------
     * @param int $param（随机数位数）
      +----------------------------------------------------------
     * @param string $param（随机数种类(int代表整型,string代表字符型(默认))）
      +----------------------------------------------------------
     * @return string $key (随机数）
      +----------------------------------------------------------
     * @example getRandom(32);
      +----------------------------------------------------------
     */

    function getRandom($param, $type = 'string') {
        switch ($type) {
            case 'int':
                $str = "0123456789";
                break;
            default:
                $str = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
                break;
        }
        $key = "";
        for ($i = 0; $i < $param; $i++) {
            $key .= $str{mt_rand(0, 32)};    //生成php随机数
        }
        return $key;
    }

    /**
     * 编号的格式处理
      +----------------------------------------------------------
     * @author hayley
      +----------------------------------------------------------
     * @access public
      +----------------------------------------------------------
     * @param string str 被处理编号
      +----------------------------------------------------------
     * @param string num 被处理编号
      +----------------------------------------------------------
     * @param string type 要处理的方式（Delete0:清前面的0，Add0:不足num位前补0）
      +----------------------------------------------------------
     * @param string letterType 字母转换处理
      +----------------------------------------------------------
     * @return string $data 转换后的值
     */
    function add0Format($str, $num, $type = 'Add0', $letterType = '') {
        switch ($letterType) {
            case 'Big':
                $str = strtoupper($str);
                break;
            case 'Small':
                $str = strtolower($str);
                break;
            default:
                break;
        }
        switch ($type) {
            case 'Delete0':
                $data = trim(preg_replace('/^0*/', '', $str));
                break;
            case 'Add0':
                if (strlen($str) !== $num) {
                    $data = sprintf("%0" . $num . "s", $str);
                } else {
                    $data = $str;
                }
                break;
            default:
                $data = $str;
                break;
        }
        return $data;
    }

    /**
     * xml字串的格式处理
      +----------------------------------------------------------
     * @author hayley
      +----------------------------------------------------------
     * @access public
      +----------------------------------------------------------
     * @param string $xmlString 被处理xml字串
      +----------------------------------------------------------
     * @return array data 处理后的得到数组
     */
    function xmlStringProcess($xmlString) {
        $xmlResult = simplexml_load_string($xmlString); //转换为simplexml对象
//        foreach ($xmlResult->children() as $childItem) {    //遍历所有节点数据
//            echo $childItem->getName() . "->" . $childItem . "<br />"; //输出xml节点名称和值   
//            //其他操作省略
//        }
        $jsonStr = json_encode($xmlResult);
        $jsonArray = json_decode($jsonStr, true);
        return $jsonArray;
    }

    /**
     * @Purpose:男女字符串处理
      +----------------------------------------------------------
     * @Author: Hayley
      +----------------------------------------------------------
     * @access public
      +----------------------------------------------------------
     * @param string param 字符串
      +----------------------------------------------------------
     * @return string param  处理后的字符串
      +----------------------------------------------------------
     */
    function sexStringProcess($param) {
        if (preg_match('/男/', $param)) {
            $param = 'male';
        } elseif (preg_match('/女/', $param)) {
            $param = 'female';
        } elseif (preg_match('/male/', $param)) {
            $param = '男';
        } elseif (preg_match('/female/', $param)) {
            $param = '女';
        }
        return $param;
    }

    /**
     * @Purpose:数据按时间格式分组处理
      +----------------------------------------------------------
     * @Author: Hayley
      +----------------------------------------------------------
     * @access public
      +----------------------------------------------------------
     * @param array data 比分组数组
      +----------------------------------------------------------
     * @return string key  分组数据键名
      +----------------------------------------------------------
     * @return string format  分组单位格式，默认为：Y-m-d
      +----------------------------------------------------------
     */
    function groupByTimes($data, $key, $format = 'Y-m-d') {
        if (empty($data) || empty($key)) {
            return null;
        }
        $result = array();
        foreach ($data as $v) {
            $date = date($format, strtotime($v[$key]));
            if ($result[$date]) {
                array_push($result[$date], $v);
            } else {
                $result[$date] = array($v);
            }
        }
        return $result;
    }

}
