<?php
return array(
    'ERROR_MESSAGE' => 'something happened, please try later',
    'ERROR_PAGE' => '',
    'SHOW_ERROR_MSG' => false,
    'SHOW_PAGE_TRACE' => false,
    'TRACE_MAX_RECORD' => 100,
    // database
    'DB_TYPE' => 'mysql',
    'DB_HOST' => (CONF_DB_HOST) ? CONF_DB_HOST : '10.116.57.136',
    'DB_NAME' => (CONF_DB_NAME) ? CONF_DB_NAME : 'wechat_medical',
    'DB_USER' => (CONF_DB_USER) ? CONF_DB_USER : 'root',
    'DB_PWD' => (CONF_DB_PWD) ? CONF_DB_PWD : '',
    'DB_PORT' => 3306,
    'DB_PREFIX' => '',
    'DB_PARAMS' => array(PDO::ATTR_CASE => PDO::CASE_NATURAL),
    'DB_PREFIX' => '',
    'TMPL_L_DELIM' => '<!--{', //定義模板引擎普通標籤的開始標記
    'TMPL_R_DELIM' => '}-->', //定義模板引擎普通標籤的結束標記
    'AUTH_CONFIG' => array(
        'AUTH_ON' => true,
        'AUTH_TYPE' => 1,
        'AUTH_GROUP' => 'role',
        'AUTH_GROUP_ACCESS' => 'user',
        'AUTH_RULE' => 'rule',
    ),
    'URL_ROUTER_ON' => true,
    'URL_ROUTE_RULES' => array(
        ''            => 'Home/Index/index',
    ),
    'AUTH_CONFIG' => array(
        'AUTH_ON' => true, //認證開關
        'AUTH_TYPE' => 1, // 認證方式，1为时时认证；2为登录认证。
        'AUTH_GROUP' => 'auth_group', //用户组数据表名
        'AUTH_GROUP_ACCESS' => 'auth_group_access', //用户组明细表
        'AUTH_RULE' => 'auth_rule', //权限规则表
    ),
    'LOAD_EXT_CONFIG' => array(
        'HTTP_STATCODE' => 'http_status_code',
        'RESP_STATCODE' => 'response_status_code',
    ),
    'LANG_SWITCH_ON' => true, //开启多语言支持开关
    'DEFAULT_LANG' => 'zh-cn', // 默认语言
    'LANG_LIST' => 'zh-cn,en-us', // 允许切换的语言列表 用逗号分隔
    'VAR_LANGUAGE' => 'l', // 默认语言切换变量
    'SECURITY_CONFIG' => array(
        'NAME' => 'admin',
        'PASS' => 'admin'
    ),
    'APP_NAME' => '【消防猿】', //分頁顯示配置参数
    'VAR_PAGE' => 'P', //分頁顯示配置参数
    'VAR_LIMIT' => 'LIMIT',
    // 'CURLOPT_PROXY' => 'http://10.116.27.249:31173', //http://10.116.57.136:31188
    //'CURLOPT_PROXYUSERPWD' => 'hayley:hayley1210', //tom:Foxconn!2007
    'SESSION_EXPIRE' => 3600 * 12, //SESSION过期时间:12hr
);