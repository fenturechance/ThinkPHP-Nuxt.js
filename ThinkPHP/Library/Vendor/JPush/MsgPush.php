<?php

require_once("JPush/JPush.php");
class MsgPush{
    
   //appkey
    static public function app_key(){
 
        $app_key = "e0a7452205161a1b8a15d829";//极光官网分配的
        return $app_key;
    }

    //master_secret,用于服务器端API调用时与Appkey 配合使用达到鉴权的目的
    static public function master_secret(){
 
        $master_secret = "ef63e3e79cb3bf55797b9ef6";//极光官网分配的
        return $master_secret;
    }

    //将json格式转换成数组格式
    function json_array($result){
        $result_json = json_encode($result);
        return json_decode($result_json,true);
    }
        
    //获取alias和tags
    public function getDevices($registrationID){
 
        $app_key = $this->app_key();
        $master_secret = $this->master_secret();
 
        $JPush = new JPush($app_key, $master_secret);
 
        $result = $JPush->device()->getDevices($registrationID);
        
        return $result;
 
    }

    //添加tags
    public function addTags($registrationID,$tags){
 
        $app_key = $this->app_key();
        $master_secret = $this->master_secret();
 
        $JPush = new JPush($app_key, $master_secret);
 
        $result = $JPush->device()->addTags($registrationID,$tags);
        
        return $result;
 
    }
 
    //移除tags
    public function removeTags($registrationID,$tags){
 
        $app_key = $this->app_key();
        $master_secret = $this->master_secret();
 
        $JPush = new JPush($app_key, $master_secret);
 
        $result = $JPush->device()->removeTags($registrationID,$tags);
        
        return $result;
 
    }

    //标签推送
    public function pushTag($tag,$content){
 
        $app_key = $this->app_key();
        $master_secret = $this->master_secret();
 
        $JPush = new JPush($app_key, $master_secret);
 
        $tags = implode(",",$tag);
 
        $JPush->push()
                ->setPlatform(array('ios', 'android'))
                ->addTag($tags)                          //标签
                ->setNotificationAlert($content)           //内容
                ->send();
                
        return json_array($result);
 
    }

    //标签推送
    public function pushRegistrationId($registrationId,$content){
 
                echo "string";
        $app_key = $this->app_key();
        $master_secret = $this->master_secret();
 
        $JPush = new JPush($app_key, $master_secret);
 
        $tags = implode(",",$tag);
 
        $result=$JPush->push()
                ->setPlatform(array('ios', 'android'))
                ->addRegistrationId($registrationId)                          //标签
                ->setMessage("msg content", 'msg title', 'type')
                // ->setNotificationAlert($content)           //内容
                ->send();
        return $this->json_array($result);
 
    }
 
    //别名推送
    public function pushAlias($userids,$content){
 
        $app_key = $this->app_key();
        $master_secret = $this->master_secret();
 
        $JPush = new JPush($app_key, $master_secret);
        $alias = implode(",",$userids);
 
        $result = $JPush->push()
                ->setPlatform(array('ios', 'android'))
                ->addAlias($alias)                      //别名
                ->setNotificationAlert($content)        //内容
                ->send();
                
         return json_array($result);
 
    }
    
    //向所有设备推送消息（用于开发阶段的测试）
    function sendNotifyAll($message){
        $message = $message;
        $app_key = $this->app_key();
        $master_secret = $this->master_secret();
        $JPush = new JPush($app_key, $master_secret);
        $result = $JPush->push()
                ->setPlatform('all')
                ->addAllAudience()                      //别名
                ->setNotificationAlert($message)        //内容
                ->send();
        return json_array($result);
    }
}