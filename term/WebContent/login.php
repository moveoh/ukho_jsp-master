<?php
/**
 * 로그인, 회원가입
 */
if(!defined('__CERTIS_CTF__'))	return;
if($_SESSION['login']) return false;

if($_POST['ajax']){
	include('db.php');
	switch ($_POST['oper']) {
		case 'signup':	//회원가입
			$stmt=$pdo->prepare('INSERT INTO ctf_user values (null, :id, :pw, 0, null)');
			if(preg_match('/^[a-zA-Z0-9]{5,}$/', $_POST['id']))	//영문자, 숫자만으로 5자리 이상인지 체크
				$stmt->bindParam(':id', $_POST['id']);
			if(preg_match('/^[a-zA-Z0-9]{32}$/', $_POST['pw']))	//md5 해쉬 형식인지 체크
				$stmt->bindParam(':pw', $_POST['pw']);
			if($stmt->execute())
				echo json_encode(['suc'=>true]);
			else
				echo json_encode(['suc'=>false]);
			break;
		case 'signin':	//로그인
			$stmt=$pdo->prepare("SELECT u.idx, u.id, u.pw, s.score 
				FROM ctf_user u left join score s on u.idx=s.idx 
				WHERE u.id=:id AND u.pw=:pw");
			$stmt->bindParam(':id', $_POST['id']);
			$stmt->bindParam(':pw', $_POST['pw']);
			$stmt->execute();
			$user=$stmt->fetch(PDO::FETCH_ASSOC);
			if($user){
				$_SESSION['login']=true;
				$_SESSION['idx']=$user['idx'];
				$_SESSION['id']=$user['id'];
				$_SESSION['score']=(int)$user['score'];
				$_POST['ajax']=false;
				echo json_encode(['suc'=>true, 
					'header'=>get_include_contents('header.php'),
					'main'=>get_include_contents('prob.php'),
					'footer'=>get_include_contents('footer.php')]);
			}else{
				echo json_encode(['suc'=>false, 'msg'=>'아이디 또는 비밀번호가 틀립니다.']);
			}
			break;
		default:
			break;
	}
	return;
}
?>
<div id="login" class="padding20 block-shadow">
	<h1>Login</h1>
	<form id="login_form"
	    data-role="validator"
	    data-hint-easing="easeOutBounce">
	    <input type="hidden" name="target" value="login">
	    <input type="hidden" name="oper" value="signin">
	    <input type="hidden" name="ajax" value="true">
	    <div class="input-control modern text iconic" data-role="input">
	    	<input type="text" name="id" 
	    	data-validate-func="minlength" data-validate-arg="5" data-validate-hint="5자리 이상" data-validate-hint-position="right">
	    	<span class="label">ID</span>
	    	<span class="placeholder">ID</span>
	    	<span class="informer">5자리 이상</span>
	    	<span class="icon mif-user"></span>
	    </div>
	    <div class="input-control modern password iconic" data-role="input">
	    	<input type="password" name="pw" 
	    	data-validate-func="minlength" data-validate-arg="5" data-validate-hint="5자리 이상" data-validate-hint-position="right">
	    	<span class="label">PW</span>
	    	<span class="placeholder">PW</span>
	    	<span class="informer">5자리 이상</span>
	    	<span class="icon mif-lock"></span>
    		<button class="button helper-button reveal"><span class="mif-looks"></span></button>
	    </div>
	    <input type="submit" id="signin_button" value="로그인" onclick="return login()">
	    <button type="button" id="signup_button" class="button" onclick="signup()">회원가입</button>
	</form>
</div>