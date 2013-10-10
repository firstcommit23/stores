<style type="text/css">
      body {
        padding-top: 100px;
        padding-bottom: 40px;
        background: url(images/bg.jpg) no-repeat center center fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
      }

      .form-signin {
        max-width: 400px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }

    </style>
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
        ・メールアドレス<input type="text" name="email" class="input-block-level" placeholder="mail_address">
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
 </body>