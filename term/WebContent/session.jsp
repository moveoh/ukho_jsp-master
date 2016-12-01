<!--
<?php
	/**
	 * 세션 관련, 로그아웃
	 */
	if(!defined('__CERTIS_CTF__'))	return;
	if(!$_SESSION['login'])	return false;

	switch($_POST['oper']){
		case 'logout':
			session_destroy();
			break;
	}
!-->

<%
	if (__CERTIS_CTF__ == False)
		return;
	if ((String)request.getSession().getAttribute("login") == False)
		return false;

	if request.getParameter("oper") == "logout"
		session.removeAttribute("login");



