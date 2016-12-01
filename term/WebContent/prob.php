<?php
/**
 * 문제 보기, 풀기
 */
if(!defined('__CERTIS_CTF__'))	return;
if(!$_SESSION['login'])	return false;
include('db.php');

if($_POST['ajax']){
	switch ($_POST['oper']) {
		case 'show_prob':	//문제 보기
			$stmt=$pdo->prepare('SELECT * FROM problem_table WHERE idx=:idx');
			$stmt->bindParam(':idx', $_POST['idx']);
			$stmt->execute();
			$prob=$stmt->fetch(PDO::FETCH_ASSOC);
			if($prob){
				$solved=$pdo->query("SELECT u.id 
					FROM ctf_user u, solve s, problem_table p 
					WHERE u.idx=s.uidx AND p.idx=s.pidx AND p.idx=$prob[idx]
					order by s.date desc")
					->fetchAll(PDO::FETCH_COLUMN, 0);
				echo json_encode(['category'=>$prob['category'],
									'name'=>$prob['name'],
									'introduce'=>nl2br(htmlspecialchars($prob['introduce'])),
									'path'=>nl2br(htmlspecialchars($prob['path'])),
									'auth'=>$prob['auth'],
									'solved_person'=>$solved,
									'solved_count'=>count($solved)]);
			}
			break;
		case 'flag':	//플래그 인증
			$stmt=$pdo->prepare('SELECT flag, score FROM problem_table WHERE idx=:idx');
			$stmt->bindParam(':idx', $_POST['idx']);
			$stmt->execute();
			$prob=$stmt->fetch(PDO::FETCH_ASSOC);
			
			if($prob){
				if($_POST['flag']==md5($_SESSION['id'].$prob['flag'])){
					//solve 테이블에 삽입
					$stmt=$pdo->prepare('INSERT INTO solve (uidx, pidx) VALUES (:uidx, :pidx)');
					$stmt->bindParam(':uidx', $_SESSION['idx']);
					$stmt->bindParam(':pidx', $_POST['idx']);
					if($stmt->execute()){
						//총 점수 증가, 최종 인증 시간 업데이트
						$stmt=$pdo->prepare('UPDATE ctf_user SET score=score+:score, 
							auth_time=current_timestamp() WHERE idx=:idx');
						$stmt->bindParam(':score', $prob['score']);
						$stmt->bindParam(':idx', $_SESSION['idx']);
						if($stmt->execute())
							$_SESSION['score']+=$prob['score'];
					}
					echo json_encode(['suc'=>true, 'score'=>$_SESSION['score']]);
				}else
					echo json_encode(['suc'=>false]);
			}
			break;
	}
	return;
}
//푼 문제는 pidx에 값이 들어감
$prob=$pdo->query("SELECT p.idx, p.category, p.name, p.score, s.pidx FROM problem_table p 
	LEFT JOIN (SELECT pidx FROM solve WHERE uidx=$_SESSION[idx]) s ON p.idx=s.pidx
	ORDER BY category, score")->fetchAll(PDO::FETCH_ASSOC);
?>
<div id="prob_detail" class="dialog padding20" data-role="dialog"
	data-overlay="true" data-overlay-click-close="true"
	data-windows-style="true" data-close-button="true"
	data-overlay-color="#aaa">
	<div class="container">
		<h1 class="name"></h1>
		<div class="auth"></div>
		<p class="introduce"></p>
		<p class="path"></p>
		<div class="right">
			Sovled: <select class="solved_person"></select> -
			<span class="solved_count"></span> 명
		</div>
		<form id="flag_form">
			<input type="hidden" name="id" value="<?=$_SESSION['id']?>">
			<input type="hidden" name="idx" value="">
			<div class="input-control modern text iconic" data-role="input">
				<input type="text" name="flag">
				<span class="label">Flag</span>
		    	<span class="placeholder">Flag</span>
		    	<span class="icon mif-key"></span>
			</div>
			<button class="button" onclick="return submitFlag();">인증</button>
		</form>
	</div>
</div>
<div>
<?$cate='';
for($i=0; $i<count($prob); $i++):
	if($cate!=$prob[$i]['category']):
		$cate=$prob[$i]['category'];?>
<div style="clear: both;"></div></div>
<div class="prob_container" data-category="<?=$cate?>">
	<h1 class="capital"><?=$cate?></h1>
	<?endif;
	$class=$prob[$i]['pidx']?' solved':'';?>
	<div class="tile tile-small-y prob<?=$class?>" data-role="tile" 
		data-idx="<?=$prob[$i]['idx']?>" onclick="showProb(getAttribute('data-idx'))">
		<div class="tile-label"><?=$prob[$i]['name']?></div>
		<div class="score"><?=$prob[$i]['score']?></div>
		<div class="solve_mark">Solved</div>
	</div>
<?endfor;?>
<div style="clear: both;"></div></div>