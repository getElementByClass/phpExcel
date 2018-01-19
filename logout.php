<?php
/**
 * 安全退出
 * @authors Your Name (you@example.org)
 * @date    2017-12-04 18:44:04
 * @version $Id$
 */
require_once('../php/class.Request.php');
$response = new Request();
$token = isset($_POST['token'])?$_POST['token']:$response->notParameter('token');
$uid = isset($_POST['uid'])?$_POST['uid']:$response->notParameter('uid');
$data = array(
	'token' => $token,
	'uid' => $uid
	);
$locationUrl = "/api/sct/webLogout";
$res = $response->sendParameter($locationUrl,$data);

if($res['status'] == '200'){
	session_start();
	unset($_SESSION);
	session_destroy(); 
	echo json_encode(array(
		'status' => $res['status'],
		'message'  => $res['message']
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
