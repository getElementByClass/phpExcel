<?php
/**
 * 
 * @authors Your Name (you@example.org)
 * @date    2017-12-05 13:50:27
 * @version $Id$
 */

session_start();
$token = isset($_SESSION["token"]) ? $_SESSION["token"] : header("Location:../login.html");
$uid = isset($_SESSION["uid"]) ? $_SESSION["uid"] : header("Location:../login.html");
$userName = isset($_SESSION["userName"]) ? $_SESSION["userName"] : header("Location:../login.html");
$brandId = isset($_SESSION["brandId"]) ? $_SESSION["brandId"] : header("Location:../login.html");
$unitId = isset($_SESSION["unitId"]) ? $_SESSION["unitId"] : header("Location:../login.html");
$admin = isset($_SESSION["admin"]) ? $_SESSION["admin"] : header("Location:../login.html");
$brandAdmin = isset($_SESSION["brandAdmin"]) ? $_SESSION["brandAdmin"] : header("Location:../login.html");
