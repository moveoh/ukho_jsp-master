<!--
<?php
	/**
	 * 공지사항
	 */
	if(!defined('__CERTIS_CTF__'))	return;
	if(!$_SESSION['login'])	return false;
?>
!-->

<%
	if (__CERTIS_CTF__ == False)
		return;
	if ((String)request.getSession().getAttribute("login") == False)
		return;
%>

<h4>서버에 공격하는 행위 금지.</h4>
<h4>FLAG 및 풀이 공유 금지</h4>
<h4>No breakthrough point</h4>