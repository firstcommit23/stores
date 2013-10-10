<h4>SNS連携</h4>
<br>
<form name="detail" action="/store/sns" method="post" id="snsForm">
Twitter : <input type="text" name="twitter" value="{$sns->twitter}"><br>
Facebook : <input type="text" name="facebook" value="{$sns->facebook}"><br>

<br>
<input type="button" value="キャンセル" onClick="location.href='/store'">
<input type="submit" value="登録する">
</form>
<br>
<br>
{literal}
<script>


  $(document).ready(function(){
    $("#snsForm").validate({

    rules: {
    	twitter: { maxlength:100,alphanum:true

		 },

    	facebook: { maxlength:100, alphanum:true },

    },

    messages: {

    	twitter: {
    		maxlength: "100文字以内で入力してください",
    		alphanum: "英語・数字のみ入力可能"

    	},
    	facebook: {
    		maxlength: "100文字以内で入力してください",
    		alphanum: "英語・数字のみ入力可能"
    	},
    }



    });
  });

</script>

{/literal}
