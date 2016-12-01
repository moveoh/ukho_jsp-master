<!--
<?php
	/**
	 * Contact Us 내용
	 */
	if(!defined('__CERTIS_CTF__'))	return;
?>
!-->

<%
	if (__CERTIS_CTF__ == false)
		return;
	if ((String)request.getSession().getAttribute("login") == False)
		return;
%>

<h1>Email</h1>
<p>kimtae92@gmail.com</p>
<p>ticktock@outlook.kr</p>