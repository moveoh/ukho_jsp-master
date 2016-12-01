<?php
	/**
	 * 순위 보기
	 */
	if(!defined('__CERTIS_CTF__'))	return;
	if(!$_SESSION['login'])	return false;
	include('db.php');

	$rank=$pdo->query('SELECT * FROM score ORDER BY score DESC, auth_time ASC LIMIT 20')->fetchAll(PDO::FETCH_ASSOC);
?>

<table class="table striped hovered">
	<thead class="capital">
		<tr>
			<td>rank</td>
			<td>id</td>
			<td>score</td>
			<td>last auth time</td>
		</tr>
	</thead>
	<tbody>
	<?for($i=0; $i<count($rank); $i++):?>
		<tr>
			<td><?=$i+1?></td>
			<td><?=$rank[$i]['id']?></td>
			<td><?=$rank[$i]['score']?></td>
			<td><?=$rank[$i]['auth_time']?></td>
		</tr>
	<?endfor;?>
	</tbody>
</table>
