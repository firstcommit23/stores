{if isset($state)}
変更できました。
{else}
{if isset($err_msg)}

{$err_msg}

{else}


<br>
<br>

<h4>ログインメールアドレス変更</h4>
<form id="emailForm" name="emailForm" action="/user/sendMail" method="post">
<br>
変更するメールアドレス：<input type="text" name="edit_email" id="edit_email" name="user_email" >
<br>
<input type="button" value="キャンセル" onClick="location.href='/user'">
<input type="submit" value="登録する">
</form>
<br>

<br>

{literal}
<script>
  $(document).ready(function(){
    $("#emailForm").validate({

    rules: {
    	edit_email: { required: true, email: true, maxlength:100 },

    },

    messages: {

    	edit_email: {
    		required : "入力してください",
    		email: "メール形式",
    		maxlength: "100文字以内で入力してください"
    	},
    }



    });
  });

</script>

{/literal}

<br>
<br>
<br>
{/if}
{/if}