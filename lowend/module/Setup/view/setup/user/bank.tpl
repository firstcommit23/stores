{literal}
<script>

	function selectBank(){

		window.open("/user/selectBank", "select bank","width=600,height=500,resizable=yes,scrollbars=yes");
		return false;
	}

</script>

{/literal}
<br>
<br>

<h4>入金先口座登録</h4>
<form name="bankForm" id="bankForm" action="/user/bank" method="POST">
<input type="hidden" name="bank_code"  value="0">
<input type="hidden" name="branch_code"  value="0">
<br>
銀行名 :<input type="hidden" value="{$store_bank->bank}" name="bank"  id="bankInput"> <span class="bank">{$store_bank->bank}</span><input type="button" value="銀行選択" onClick="selectBank();">
<br>
支店名 : <span class="branch">{$store_bank->branch}</span>
<input type="hidden" name="branch"  id="branchInput" value="{$store_bank->branch}">
<br>
口座種類: <select size="1" name="type">
	<option value="1" {if $store_bank->type ==='1'} selected{/if}>普通</option>
	<option value="2"{if $store_bank->type ==='2'} selected{/if}>当座</option>
	<option value="3"{if $store_bank->type ==='3'} selected{/if}>貯蓄</option>
	</select>

<br>
口座番号 : <input type="text" name="account_no" value="{$store_bank->account_no}">
<br>
口座名義 : <input type="text" name="account_name" value="{$store_bank->account_name}"> 例）ヤマダタロウ
<br>
<br>
<input type="button" value="キャンセル" onClick="location.href='/user'">
<input type="submit" value="登録する" id="bankFormSubmitBtn">
</form>
<br>

<br>
{literal}
<script>


  $("#bankFormSubmitBtn").click(function(){
    $("#bankForm").validate({
	    rules: {
	    	bank: {required: true},
	    	branch: {required: true},
	    	account_no: { required: true,  maxlength:20, digits : true},
	    	account_name: { required: true, maxlength:100 , kana: true},
	    },
	    messages: {

	    	account_no: {
	    		required : "口座番号入力してください",
	    		maxlength: "20文字以内で入力してください",
	    		digits: "数字だけ入力"
	    	},
	    account_name: {
	    		required : "口座名義入力してください",
	    		maxlength: "100文字以内で入力してください",
	    	},
	    }
    });
 });

</script>

{/literal}