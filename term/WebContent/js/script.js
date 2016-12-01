//script.min.js 내용
$.ajaxSetup({
	url:'.',
	method:'POST',
	dataType:'json'
});
/**
 * 로그인
 * @return {bool} [false]
 */
function login(){
	var form=$('#login_form');
	form.find('input').attr('readonly', '');
	var pw=form.find('input[name=pw]');
	
	pw.val(calcMD5(pw.val()));
	
	$.ajax({
		data:form.serialize(),
		success:function(ret){
			if(ret.suc){
				$('#login').transition({'opacity':'0', 'top':'0px'}, 
					function(){$(this).hide()});
				$('header').hide().html(ret.header).show();
				$('main').hide().html(ret.main).show();
				$('footer').hide().html(ret.footer).show();
			}else
				alert(ret.msg);
		}
	});
	
	pw.val('');
	form.find('input').removeAttr('readonly');
	return false;
}
/**
 * 회원가입
 */
function signup(){
	var form=$('#login_form'),
		id=form.find('input[name=id]').val(),
		pw=form.find('input[name=pw]').val();
	
	if(id.length<5 || pw.length<5){
		form.submit();
		return;
	}
	var pw2=prompt('비밀번호를 다시 입력해 주세요.');
	if(!pw2)
		return;
	if(pw!=pw2)
		alert('비밀번호가 맞지 않습니다.');
	else
		$.ajax({
			data:{'target':'login', 'oper':'signup', 'ajax':true, 
			'id':id, 'pw':calcMD5(pw)},
			success:function(ret){
				if(ret.suc)
					alert('가입이 완료되었습니다.');
				else
					alert('가입에 실패했습니다.');
			}
		});
}
		
/**
 * 로그아웃
 */
function logout(){
	$.ajax({
		data:{'target':'session', 'oper':'logout'},
		success:function(){location.reload();},
		dataType:'text'
	});
}
/**
 * 문제 보기
 * @param  {int} idx [문제의 idx]
 */
function showProb(idx){
	$.ajax({
		data:{'target':'prob', 'oper':'show_prob', 'ajax':true, 'idx':idx},
		success:function(ret){
			$('#prob_detail')
			.find('.button').removeClass('success danger').text('인증').end()
			.find('input[name=idx]').val(idx).end()
			.find('.name').text(ret.name+' ')
				.append($('<small/>').addClass('capital').text(ret.category)).end()
			.find('.introduce').html(ret.introduce).end()
			.find('.path').html(ret.path).end()
			.find('.auth').text(ret.auth).end()
			.find('.solved_person').html('<option>'
				+ret.solved_person.join('</option><option>')
				+'</option>').end()
			.find('.solved_count').text(ret.solved_count).end()
			.find('input[name=flag]').val('').end()
			.show()
			.data('dialog').open();
		}
	});
}
/**
 * 플래그 인증
 * @return {bool} [false]
 */
function submitFlag(){
	var form=$('#flag_form'),
		button=form.find('button'),
		id=form.find('input[name=id]').val(),
		flag=form.find('input[name=flag]').val()
		idx=form.find('input[name=idx]').val();
	
	flag=calcMD5(id+flag);
	$.ajax({
		data:{'target':'prob', 'oper':'flag', 'ajax':true, 'idx':idx ,'flag':flag},
		success:function(ret){
			if(ret.suc){
				$('#score').text(ret.score);
				$('.prob[data-idx='+idx+']').addClass('solved');
				button.addClass('success').text('인증 성공');
			}else{
				button.addClass('danger').text('인증 실패');
			}
		}
	})
	return false;
}
/**
 * 메뉴 이동
 * @param  {string} menu [볼 메뉴 페이지 이름]
 */
function moveMenu(menu){
	$.ajax({
		data:{'target':menu},
		success:function(html){
			$('main').transition({opacity:0, x:200}, 
				function(){this.css({x:-200});this[0].innerHTML=html})
			.transition({opacity:1, x:0}, 
				function(){this.removeAttr('style')});
		}, dataType:'text'
	});
}