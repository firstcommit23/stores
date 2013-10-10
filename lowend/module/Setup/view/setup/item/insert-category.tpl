{literal}
<style type="text/css">
      body {
        padding-top: 100px;
        padding-bottom: 40px;
        background: url(images/bg.jpg) no-repeat center center fixed;
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

 <script type="text/javascript">

    function submitCategoryInput(){

    var cateInputValue = categoryAdd.categoryName.value;

    //親にinputのvalueを渡す
    opener.insertCategory(cateInputValue);


    //閉じる
    self.close();

   }

</script>
{/literal}


<div class="container">

      <form  id="categoryAdd" name="categoryAdd" method="POST" class="form-signin">
        <input type="hidden" name="id" >
        <h2 class="form-signin-heading">カテゴリを追加</h2>
        <input type="text" name="categoryName" id="categoryName" class="input-block-level" placeholder="カテゴリ名を入力" >
        <input type="button" value="キャンセル" class="btn btn-primary"  onClick="window.close();">
        <input type="button" id="categoryList"class="btn btn-primary" value="追加"  onclick="submitCategoryInput();">
      </form>

</div>
