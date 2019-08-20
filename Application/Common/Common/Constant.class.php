<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Constant
 *
 * @author Hayley
 */

namespace Common\Common;

class Constant {

    //字典
    const APP_NAME = ''; //时间格式
    const POST_METHOD = 'POST'; //时间格式
    const GET_METHOD = 'GET'; //时间格式
    const TIME_FORMAT = 'Y/m/d H:i:s'; //时间格式
    const TIME_FORMAT1 = 'Y-m-d H:i:s'; //时间格式
    const TIME_FORMAT2 = 'YmdHis'; //时间格式
    const DATE_FORMAT = "Y/m/d";
    const DATE_FORMAT1 = "Y-m-d";
    const MONTH_FORMAT = "Y/m";
    const MONTH_FORMAT1 = "Y-m";
    const MONTH_FORMAT2 = "Y-m-1 00:00:00";
    const YEAR_FORMAT1 = "Y";
    const SESSION_NAME = 'medical_user';
    const ROOT_AUTHNAME = 'root';
    const ADMIN_AUTHNAME = 'admin';
    const USER_AUTHNAME = 'user';
    const OTHER_AUTHNAME = 'other';
    const IDENTITYID_REGEX = '/(^\d{17}([0-9]|X)$)/';
    const TELEPHONE_REGEX = '/^1(3|4|5|7|8)\d{9}$/';
    const EMAIL_REGEX = '/^[a-z0-9_-]+(\.[-_a-z0-9]+)*@[a-z0-9]+(\.[-a-z0-9]+)*$/i';
    const FOLLOW_NAME = 'follow';
    const MEMBER_NAME = 'member';

}

?>