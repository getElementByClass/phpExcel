<?php
/**
 * 登录
 * @authors Your Name (you@example.org)
 * @date    2017-12-04 13:44:04
 * @version $Id$
 */
require_once('../php/class.Request.php');
$response = new Request();
$loginName = isset($_POST['name'])?$_POST['name']:$response->notParameter('name');
$password = isset($_POST['pwd'])?$_POST['pwd']:$response->notParameter('pwd');
$data = array(
	'userAccount' => $loginName,
	'userPassword' => $password,
	'loginIp' => $_SERVER["REMOTE_ADDR"]
	);
$locationUrl = "/api/sct/webLogin";
$res = $response->sendParameter($locationUrl,$data);

if($res['status'] == '200'){
	Session_start();
	$_SESSION["token"] = $res['data']['token'];
	$_SESSION["uid"] = $res['data']['uid'];
	$_SESSION["userName"] = $res['data']['userName'];
	$_SESSION["brandId"] = $res['data']['brandId'];   //品牌ID
	$_SESSION["unitId"] = $res['data']['unitId'];    //单位ID
	$_SESSION["admin"] = $res['data']['_admin'];   //是否为系统管理员
	$_SESSION["brandAdmin"] = $res['data']['_brandAdmin'];   //是否为品牌管理员
	$_SESSION["userHead"] = $res['data']['userHead'];   //用户头像

	//setcookie('token',$res['data']['token']);
	//setcookie('uid',$res['data']['uid'],time()+3600*24,'/');

	echo json_encode(array(
		'status' => $res['status'],
		'message'  => $res['message'],
		'data' => $res['data']
	));
}else if($res['status'] == '400'){
	echo json_encode(array(
		'status' => $res['status'],
		'message'  => $res['message']
	));
}else if($res['status'] == '401'){
	echo json_encode(array(
		'status' => $res['status'],
		'message'  => $res['message']
	));
}else if($res['status'] == '404'){
	echo json_encode(array(
		'status' => $res['status'],
		'message'  => $res['message']
	));
}else if($res['status'] == '500'){
	echo json_encode(array(
		'status' => $res['status'],
		'message'  => $res['message']
	));
};
die();
