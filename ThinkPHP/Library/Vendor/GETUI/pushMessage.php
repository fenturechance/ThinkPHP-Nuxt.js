<?php
//消息推送Demo
header("Content-Type: text/html; charset=utf-8");
require_once(dirname(__FILE__) . '/' . 'IGt.Push.php');

//采用"PHP SDK 快速入门"， "第二步 获取访问凭证 "中获得的应用配置
//define('APPKEY','XjiSjjOdYk6VoMWcOTC2A4');
//define('APPID','rzsa472i2y88oNYA25sbP2');
//define('MASTERSECRET','rbBlfk7hIH6RLBbVrzoka7');

define('APPKEY','VWRU5Q1qxUAyAiHIYfn121');
define('APPID','wQ94CMuW7bASTQKn6yrd62');
define('MASTERSECRET','jbJDQ3jcSa5DmMBis0i7x5');

// define('APPKEY','sOT7yyp40R6IgL53xyBPbA');
// define('APPID','KLPoLsBa7T6ho7kWyCiK16');
// define('MASTERSECRET','LpOzLoLSqh7pRcVaO9NsI4');

define('HOST','http://sdk.open.api.igexin.com/apiex.htm');

//别名推送方式
//define('Alias','请输入您的Alias');

// pushMessageToSingle();

//单推接口案例
//function pushMessageToSingle($msg,$cid){
//    $igt = new IGeTui(HOST,APPKEY,MASTERSECRET);
//
//    //消息模版：
//    // 4.NotyPopLoadTemplate：通知弹框下载功能模板
//    $template = IGtNotyPopLoadTemplateDemo($msg);
//
//
//    //定义"SingleMessage"
//    $message = new IGtSingleMessage();
//
//    $message->set_isOffline(true);//是否离线
//    $message->set_offlineExpireTime(3600*12*1000);//离线时间
//    $message->set_data($template);//设置推送消息类型
//    //$message->set_PushNetWorkType(0);//设置是否根据WIFI推送消息，2为4G/3G/2G，1为wifi推送，0为不限制推送
//    //接收方
//    $target = new IGtTarget();
//    $target->set_appId(APPID);
//    $target->set_clientId($cid);
////    $target->set_alias(Alias);
//
//    try {
//        $rep = $igt->pushMessageToSingle($message, $target);
//        // var_dump($rep);
//        echo ("<br><br>");
//
//    }catch(RequestException $e){
//        $requstId =e.getRequestId();
//        //失败时重发
//        $rep = $igt->pushMessageToSingle($message, $target,$requstId);
//        var_dump($rep);
//        echo ("<br><br>");
//    }
//}
//
//
//
//
//function pushMessageToApp($msg){
//    $igt = new IGeTui(HOST,APPKEY,MASTERSECRET);
//    $template = IGtNotyPopLoadTemplateDemo($msg);
//    //个推信息体
//    //基于应用消息体
//    $message = new IGtAppMessage();
//    $message->set_isOffline(true);
//    $message->set_offlineExpireTime(10 * 60 * 1000);//离线时间单位为毫秒，例，两个小时离线为3600*1000*2
//    $message->set_data($template);
//
//    $appIdList=array(APPID);
//    $phoneTypeList=array('ANDROID');
//    $provinceList=array('浙江');
//    $tagList=array('haha');
//
//    $message->set_appIdList($appIdList);
//    // $message->set_conditions($cdt);
//
//    $rep = $igt->pushMessageToApp($message);
//    // $template = IGtNotificationTemplateDemo($msg);
//    // $message->set_data($notify);
//    // $rep = $igt->pushMessageToApp($message);
//
//
////    print_r($rep);
////    echo ("<br><br>");
//}

function pushMessageToList($msg,$cidList,$sendType){
    putenv("gexin_pushList_needDetails=true");
    $igt = new IGeTui(HOST,APPKEY,MASTERSECRET);
    //消息模版：
    // LinkTemplate:通知打开链接功能模板
    $template = IGtNotyPopLoadTemplate($msg,$sendType);


    //定义"ListMessage"信息体
    $message = new IGtListMessage();
    $message->set_isOffline(true);//是否离线
    $message->set_offlineExpireTime(10 * 60 * 1000);//离线时间
    $message->set_data($template);//设置推送消息类型
    $message->set_PushNetWorkType(0);//设置是否根据WIFI推送消息，1为wifi推送，0为不限制推送
    $contentId = $igt->getContentId($message);

    for($i=0;$i<count($cidList);$i++){
        $targetList[$i] = new IGtTarget();
        $targetList[$i]->set_appId(APPID);
        $targetList[$i]->set_clientId($cidList[$i]);
    }

    $rep = $igt->pushMessageToList($contentId, $targetList);
    return $rep;
    // $notify = IGtNotyPopLoadTemplateDemo($msg);
    // $message->set_data($notify);
    // $contentId = $igt->getContentId($message);
    // $rep = $igt->pushMessageToList($contentId, $targetList);
//    print_r($rep);
//    echo ("<br><br>");
}

//function IGtNotificationTemplateDemo($msg){
//    $template =  new IGtNotificationTemplate();
//    $template->set_appId(APPID);                      //应用appid
//    $template->set_appkey(APPKEY);                    //应用appkey
//    $template->set_transmissionType(1);               //透传消息类型
//    $template->set_transmissionContent('');   //透传内容
//    $template->set_title("test");                     //通知栏标题
//    $template->set_text("test");        //通知栏内容
//    $template->set_logo("logo.png");                  //通知栏logo
//    $template->set_logoURL("http://wwww.igetui.com/logo.png"); //通知栏logo链接
//    $template->set_isRing(true);                      //是否响铃
//    $template->set_isVibrate(true);                   //是否震
//    //
//    //动
//    $template->set_isClearable(true);                 //通知栏是否可清除
//    //$template->set_duration(BEGINTIME,ENDTIME); //设置ANDROID客户端在此时间区间内展示消息
//    return $template;
//}

function IGtNotyPopLoadTemplate($content,$sendType){
    $template =  new IGtTransmissionTemplate();
    $template->set_appId(APPID);//应用appid
    $template->set_appkey(APPKEY);//应用appkey
    $template->set_transmissionType($sendType);//透传消息类型
    $template->set_transmissionContent($content);//透传内容
    //$template->set_duration(BEGINTIME,ENDTIME); //设置ANDROID客户端在此时间区间内展示消息
    //APN简单推送
    $apn = new IGtAPNPayload();
    $alertmsg=new SimpleAlertMsg();
    $alertmsg->alertMsg="abcdefg3";
    $apn->alertMsg=$alertmsg;
    $apn->badge=2;
    $apn->sound="";
    $apn->add_customMsg("payload","payload");
    $apn->contentAvailable=1;
    $apn->category="ACTIONABLE";
    $template->set_apnInfo($apn);

    return $template;
}


?>