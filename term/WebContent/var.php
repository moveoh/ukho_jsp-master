<!--
<?php
if(!defined('__CERTIS_CTF__'))	return;

/**
 * include 내용을 반환
 * @param  [string] $filename [읽을 php 파일 이름]
 * @return [string|bool]           [php 내용, 파일이 없으면 false]
 */
function get_include_contents($filename) {
    if (is_file($filename)) {
        ob_start();
        include($filename);
        $contents = ob_get_contents();
        ob_end_clean();
        return $contents;
    }
    return false;
}
//여기 있는 페이지만 접근 가능
$_MODULE=['login', 'header', 'prob', 'footer', 'session', 'rank', 'notice', 'contact'];
!-->

<%
	if (__CERTIS_CTF__ == false)
		return;



// $_CATEGORY_ORDER=[
// 	'forensic'	=>	1,
// 	'system'	=>	2,
// 	'reversing'	=>	3,
// 	'web'		=>	4,
// 	'crypto'	=>	5,
// 	'misc'		=>	6
// ];