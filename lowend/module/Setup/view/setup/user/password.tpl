
<br>
<br>
{if isset($success)}
<h4>変更しました。</h4><br>
<input type="button" value="戻る" onClick="location.href='/user'">
{else}
<h4>パスワード変更</h4>
{if isset($msg)}<font color="red">{$msg}</font>{/if}
<br>
<form name="password" id="passwordForm" method="post" action="/user/password">
今のパスワード：<input type="password" name="cur_pw">
<br>
新しいパスワード：<input type="password" name="edit_pw">
<br>
<input type="button" value="キャンセル" onClick="location.href='/user'">
<input type="submit" value="変更する" id="passwordBtn">
<br>
</form>
{/if}
<br>
<br>
<br>
{literal}
<script>

 $("#passwordBtn").click(function(){

    $("#passwordForm").validate({
    rules: {
    	remote: {type: "post", url:"/user/passwordValid"},
    	cur_pw: { required: true,  maxlength:16 },
    	edit_pw: { required: true, maxlength:16 },
    },

    messages: {
    	cur_pw: {
    	  	remote: "パスワードが一致ssしません。",
    		required : "入力してください",
    		maxlength: "16文字以内で入力してください"
    	},
    	edit_pw: {

    		required : "入力してください",
    		maxlength: "16文字以内で入力してください"
    	},
    }

    });


});


</script>
{/literal}