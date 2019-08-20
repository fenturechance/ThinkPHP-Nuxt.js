<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Error
 *
 * @author Hayley
 */

namespace Common\Common;

class Error {

    //错误码对应的错误类型,详情;
    const S_CODE = 1;
    const S_MES = '成功';
    //
    const E_CODE = 0;
    const E0_MES = '登录错误';
    const E00001_CODE = 00001;
    const E00001_REA = '未登录错误';
    const E00002_CODE = 00002;
    const E00002_REA = '登录密码错误';
    const E00003_CODE = 00003;
    const E00003_REA = '无相关用户信息';
    //
    const E1_MES = '输入错误';
    const E10001_CODE = 10001;
    const E10001_REA = '必输字段，不能缺省';
    const E10002_CODE = 10002;
    const E10002_REA = '字段过长，操作失败';
    const E10003_CODE = 10003;
    const E10003_REA = '验证码错误，请重新输入';
    const E10004_CODE = 10004;
    const E10004_REA = '旧密码错误，请重新输入';
    const E10005_CODE = 10005;
    const E10005_REA = '身份证格式错误，请重新输入';
    const E10006_CODE = 10006;
    const E10006_REA = '电话号码格式错误，请重新输入';
    //E2... :内部错误    
    const E20_MES = '数据库错误';
    const E20001_CODE = 20001;
    const E20001_REA = '数据库表更新失败';
    //
    const E21_MES = '系统运行错误';
    const E21001_CODE = 21001;
    const E21001_REA = '系统运行内部错误';
    //
    const E22_MES = '业务操作错误';
    const E22001_CODE = 22001;
    const E22001_REA = '设备非系统内部设备';
    const E22002_CODE = 22002;
    const E22002_REA = '设备已添加过';
    const E22003_CODE = 22003;
    const E22003_REA = '用户信息已添加过';
    const E22004_CODE = 22004;
    const E22004_REA = '无相关信息';
    const E22005_CODE = 22005;
    const E22005_REA = '数据种类已添加过';
    const E22006_CODE = 22006;
    const E22006_REA = '设备种类已添加过';
    const E22007_CODE = 22007;
    const E22007_REA = '公司信息已添加过';
    const E22008_CODE = 22008;
    const E22008_REA = '设备种类非系统内部种类';
    const E22009_CODE = 22009;
    const E22009_REA = '设备类型已添加过';
    const E22010_CODE = 22010;
    const E22010_REA = '设备类型非系统内部类型';
    const E22011_CODE = 22011;
    const E22011_REA = '请确认关注双方用户信息';
    const E22012_CODE = 22012;
    const E22012_REA = '确认关注方为非个人用户信息';
    const E22013_CODE = 22013;
    const E22013_REA = '用户信息已关注过';
    const E22014_CODE = 22014;
    const E22014_REA = '用户信息未关注过';
    const E22015_CODE = 22015;
    const E22015_REA = '没有权限，请联系管理员';
    const E22016_CODE = 22016;
    const E22016_REA = '没有权限，请检查您是否建立此账户';
    const E22017_CODE = 22017;
    const E22017_REA = '关注超上限';
    //E3... :第三方系统错误
    const E3_MES = '第三方系统交互错误';
    const E30001_CODE = 30001;
    const E30001_REA = '第三方系统API调用失败';

}
