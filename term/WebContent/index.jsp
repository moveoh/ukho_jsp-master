<!--
<?php
	error_reporting(E_ALL^E_NOTICE);
	session_start();
	define('__CERTIS_CTF__', true);	//모든 페이지는 index.php를 통하도록

	require_once('var.php');

	if($_SERVER['REQUEST_METHOD']=='POST'){
		if(in_array($_POST['target'], $_MODULE))
			include($_POST['target'].'.php');
		return;
	}
?>
!-->

<%!
	Bool __CERTIS_CTF__= true;
	session.setAttribute("login", True);
%>

<jsp:include page="var.jsp"></jsp:include>
<%
	if(HttpServletRequest.getMethod() == "POST"){
		for (int i=0 ; _METHOD.length ; i++){
			String tmp = request.getParameter("target");
			if(tmp != null){
				if(_METHOD[i].equals(tmp)){
%>
					<jsp:include page=<%=tmp+".jsp"%>></jsp:include>
<%
				}
			}
		}
		return;
	}
}
%>

<!DOCTYPE html>
<html>
<head>
	<title>CERT-IS CTF</title>
	<link rel="stylesheet" type="text/css" href="css/css.css">
	<link rel="stylesheet" type="text/css" href="css/metro.min.css">
	<link rel="stylesheet" type="text/css" href="css/metro-icons.min.css">
	
	<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="js/jquery.transit.min.js"></script>
	<script type="text/javascript" src="js/metro.min.js"></script>
	<script type="text/javascript" src="js/md5.js"></script>
	<script type="text/javascript" src="js/script.min.js"></script>
</head>
<body>
	<jsp:include page="login.jsp"></jsp:include>
	<header>
		<jsp:include page="header.jsp"></jsp:include>
	</header>
	<main class="padding20">
		<jsp:include page="prob.jsp"></jsp:include>
	</main>
	<footer>
		<jsp:include page="footer.jsp"></jsp:include>
	</footer>
</body>
</html>