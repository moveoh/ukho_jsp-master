<!--
<?php
	/**
	 * HTML header 내용
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

<div class="app-bar" data-role="appbar">
	<a class="app-bar-element">CERT-IS WARGAME</a>
	<span class="app-bar-divider"></span>
	<ul class="app-bar-menu capital">
		<li onclick="moveMenu('prob')"><a>Challenge</a></li>
		<li onclick="moveMenu('rank')"><a>Rank</a></li>
		<li onclick="moveMenu('notice')"><a>Notice</a></li>
		<li onclick="moveMenu('contact')"><a>Contact us</a></li>
		<li onclick="prompt('Copy it', this.innerText);"><a class="lowercase">nc kimtae.xyz 28888</a></li>
	</ul>
	<ul class="app-bar-menu place-right">
		<li><a id="id"><?=$_SESSION['id']?></a></li>
		<li><a id="score"><?=$_SESSION['score']?></a></li>
		<span class="app-bar-divider"></span>
		<li><a onclick="logout()">Logout</a></li>
	</ul>
</div>