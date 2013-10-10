{literal}
<script>
	function withdrawal(){

		var answer = confirm('この処理は取り消せません。本当に退会しますか?');

		if(answer){
			document.userForm.submit();


		}else{

		}

	}

</script>

{/literal}



<div align="center">
<h3>登録情報</h3>
<form id="userForm" name="userForm" method="post" action="/user/withdrawal">
	<input type="hidden" name="email" value="{$email}">
<table width="700" cellspacing="20">
<tr>
	<td><b>メールアドレス </b></td>
	<td>{$email}<input type="button" onClick="location.href='/user/email'" class="btn btn-primary" name="store_name_btn" value="変更"></td>
</tr>
<tr>
	<td><b>パスワード</b></td>
	<td><input type="button" class="btn btn-primary" onClick="location.href='/user/password'" name="store_name_btn" value="変更" ></td>
</tr>
<tr>
	<td><b>お知らせメール </b></td>
	<td><input type="button" name="store_dest" id="mailmag_flag_btn" onClick="changeMailmag();" {if $mailmag_flag =='N'}class="btn btn-primary"{else}class="btn btn-inverse"{/if} value="{if $mailmag_flag=='Y'}解除する{else}受け取る{/if}" class="btn btn-primary"></td>
</tr>
<tr>
	<td><b>入金先口座登 </b></td>
	<td><input type="button" class="btn btn-primary" name="store_public" value="登録" onClick="location.href='/user/bank'" ></td>
</tr>

<tr>
	<td><b> 退会</b></td>
	<td><input type="button" onClick="withdrawal()" name="store_ketsai" value="退会する" class="btn btn-primary"></td>
</tr>

</table>
</form>
</div>


<br>

{literal}
<script>

function changeMailmag(){

	$.ajax({
		url:'/user/changeMailmag',
		dataType: 'json',
		data : $("#userForm").serialize(),
		type: "POST",

	}).done(function(data) {
		if(data.mailmag_flag =='Y'){
			$("#mailmag_flag_btn").removeClass('btn btn-primary');
			$("#mailmag_flag_btn").addClass('btn btn-inverse');
			$("#mailmag_flag_btn").attr('value', '解除する');
		}else{
			$("#mailmag_flag_btn").removeClass('btn btn-inverse');
			$("#mailmag_flag_btn").addClass('btn btn-primary');
			$("#mailmag_flag_btn").attr('value', '受け取る');
		}

	});
}

</script>

{/literal}