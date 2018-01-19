<?php
/**
 * 
 * @authors Your Name (you@example.org)
 * @date    2017-12-04 11:29:49
 * @version $Id$
 */

require_once "config.php";
class Request
{   

	/**
	 * 传值是否正确
	 * @param string $parameter POST传值
	 * @return 返回请求接口返回的数据
	 */
    public  function notParameter($parameter){
    	echo 'undefied '.$parameter;
    }
	
	/**
	 * 发起http请求
	 * @param string $url 请求接口的url
	 * @param string $data 请求时传递的数据
	 * @return 返回请求接口返回的数
	 */
    public function sendParameter($url, $data){
		$completeUrl = config::interfaceUrl.$url;
		$response = $this->httpRequest($completeUrl, $data);
		return json_decode($response,true);
	}	

	/**
	 * 构造获取http请求
	 * @param string $url 请求接口的url
	 * @return 返回请求接口返回的数据
	 */
	protected function httpRequest($url, $data){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);	
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch,CURLOPT_TIMEOUT,10);
		$response = curl_exec($ch);
		curl_close($ch);
		return $response;
	}

	// protected function send_post($url, $post_data) {
	//   $postdata = http_build_query($post_data);
	//   $options = array(
	//     'http' => array(
	//       'method' => 'POST',
	//       'header' => 'Content-type:application/x-www-form-urlencoded',
	//       'content' => $postdata,
	//       'timeout' => 15 * 60 // 超时时间（单位:s）
	//     )
	//   );
	//   $context = stream_context_create($options);
	//   $result = file_get_contents($url, false, $context);
	//   return $result;
	// }


}
 