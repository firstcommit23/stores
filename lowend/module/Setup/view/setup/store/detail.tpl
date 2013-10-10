<h4>ストアの説明</h4>

<br>
<form name="detail" action="/store/detail" method="post" id="detailEditForm">
<textarea name="detail" rows="10" style="width:800px; height:350;">{if $detail->description}{$detail->description}{/if}</textarea>
<br>
<input type="hidden" name="store_id" value="{$detail->store_id}">
<input type="button" value="キャンセル" onClick="location.href='/store'">
<input type="submit" value="登録する">
</form>
<br>
<br>


{literal}
<script>
  $(document).ready(function(){
    $("#detailEditForm").validate({

    rules: {
    	detail: {   maxlength:1000 },

    },

    messages: {

    	detail: {
    		maxlength: "1000文字以内で入力してください"
    	},
    }

    });
  });

</script>

{/literal}
