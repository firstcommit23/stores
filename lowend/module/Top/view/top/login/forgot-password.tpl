
     <div class="container">

      <form name="forgot_password" action="{$action}" class="form-signin"  method="post">
        <h2 class="form-signin-heading">{$title}</h2>
        {if $err_msg_id}<br><font color="red">※{$err_msg_id}</font><br>{/if}

       {if isset($edit_pass)}
        	<input type="password" class="input-block-level" required placeholder="パスワードを入力してください" name="edit_password">
        	<input type="hidden" value="{$email}" name="user_email">
        	<input type="hidden" value="{$token}" name="token">
        	{else}
		   <input type="email" class="input-block-level" {if $email} value="{$email}" {/if} required placeholder="emailを入力してください" name="user_email">

		{/if}
        <button class="btn btn-large btn-primary" type="submit">{$submit_btn}</button>
        <br>

      </form>

    </div> <!-- /container -->