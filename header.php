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

if($http_req_headers["X-Site-Id"] == 'ec2012') { // we are being called via the ec2012 microsite
  $_GLOBALS['lsecities']['microsite_id'] = 'ec2012';
  get_header('ec2012');
} elseif($http_req_headers["X-Site-Id"] == 'cc') { // we are being called via the Cities and the crisis microsite
  $_GLOBALS['lsecities']['microsite_id'] = 'cc';
  get_header('default');
} else {
  get_header('default');
}
?>
