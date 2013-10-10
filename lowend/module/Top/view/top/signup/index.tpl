<div class="container">
      <form  name="add" action="/signup" method="POST" class="form-signin">
        <input type="hidden" name="flag" value="check" >
        <input type="hidden" name="id" >
        <h2 class="form-signin-heading">Store登録</h2>
        ・URL<input type="text" name="domain" class="input-block-level" placeholder="URL">
        {if isset($urlErr)}<font color="red">{foreach from=$urlErr item=e}
        <br>{$e}
        {/foreach} </font>{/if}
        <br>
        ・メールアドレス<input type="email" name="email" class="input-block-level" placeholder="mail_address">
        {if isset($mailErr)}<font color="red">{foreach from=$mailErr item=e}
        <br>{$e}
        {/foreach} </font>{/if}
        <br>
        ・パスワード<input type="password" name="password" class="input-block-level" placeholder="Password">
        {if isset($passwordErr)}<font color="red">{foreach from=$passwordErr item=e}
        <br>{$e}
        {/foreach} </font>{/if}
        <label class="checkbox">
          <input type="checkbox" value="remember-me"> <a href="#">利用規約</a>に同意する
        </label>
        <button class="btn btn-primary" type="submit">スタート</button>
      </form>
    </div>