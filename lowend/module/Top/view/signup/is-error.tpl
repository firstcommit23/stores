<body background="/home/jeong/work/zf2-tutorial/public/images/star.jpg">
<link href="../assets/css/bootstrap.css" rel="stylesheet">
<style type="text/css">
      body {
        padding-top: 80px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }

      .form-signin {
        max-width: 300px;
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

      <form  name="add" action="/isError" method="POST" class="form-signin">
        <input type="hidden" name="id" >
        <h2 class="form-signin-heading">Store登録</h2>
        ・URL<input type="text" name="domain" class="input-block-level" placeholder="URL">
        <br>
         {if $urlErr != NULL}<font color="red">{foreach from=$urlErr item=e}
           {$e}
        {/foreach} </font>{/if}
        <br>
        ・メールアドレス<input type="text" name="email" class="input-block-level" placeholder="mail_address">
        <br>
        {if $mailErr != NULL}<font color="red">{foreach from=$mailErr item=e}
           {$e}
        {/foreach} </font>{/if}
        <br>
        ・パスワード<input type="password" name="password" class="input-block-level" placeholder="Password">
        <br>
        {if $passwordErr != NULL}<font color="red">{foreach from=$passwordErr item=e}
           {$e}
        {/foreach} </font>{/if}
        <br>
        <label class="checkbox">
          <input type="checkbox" value="remember-me"> <a href="#">利用規約</a>に同意する
        </label>
        <button class="btn btn-primary" type="submit">スタート</button>
      </form>

    </div>
 </body>