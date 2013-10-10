{literal}
<script>

	function setReturn(){
	//	var bank = $(".bank").val();
		var bank = "りそな銀行";
		var branch = "厚木支店";

		window.opener.$(".branch").text(branch);
		window.opener.$(".bank").text(bank);
		window.opener.$("#branchInput").attr("value", branch);
		window.opener.$("#bankInput").attr("value", bank);
		window.close();

 	}

</script>

{/literal}
銀行名 ： <span class="bank">りそな銀行</span><br>
支店名 ： <span class="branch">厚木支店 </span><br>
<input type="button" class="btn" value="選択する" onClick="setReturn();">
