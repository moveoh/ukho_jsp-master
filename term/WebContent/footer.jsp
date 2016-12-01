<!--
<?php
	if(!defined('__CERTIS_CTF__'))	return;
	if(!$_SESSION['login'])	return;
!-->

<%
	if (__CERTIS_CTF__ == False)
		return;
	if ((String)request.getSession().getAttribute("login") == False)
		return;
