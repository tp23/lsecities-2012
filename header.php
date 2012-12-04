<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package LSECities2012
 */
?><?php
$http_req_headers = getallheaders();
var_trace($http_req_headers["X-Site-Id"], 'X-Site-Id');

if($_GET["siteid"] == 'ec2012') {
  get_header('ec2012');
} else {
  get_header('default');
}
?>
