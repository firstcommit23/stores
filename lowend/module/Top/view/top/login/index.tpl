     <div class="container">
      <form name="login" action="/login" class="form-signin" method="post">
      	<input type="hidden" name="code" value="check">
        <h2 class="form-signin-heading">Eストアーショップ</h2>
             {if $err_msg}<br><font color="red">※{$err_msg}</font><br>{/if}
        <input type="email" {if $email} value="{$email}" {/if} class="input-block-level" required placeholder="emailを入力してください" name="user_email">
        <input type="password" max="16" class="input-block-level" name="user_passwd" placeholder="passwordを入力してください">
        <label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
        </label>
        <button class="btn btn-large btn-primary" type="submit">Sign in</button>
        <br>
     <a href="/forgot_password">パスワードを忘れた方はコチラ</a>
      </form>
    </div>

