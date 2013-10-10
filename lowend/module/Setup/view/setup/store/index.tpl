<br><br>
<form method="post" id="store_edit">
<div class="wrapper">
  <h2 class="heading">ストアについて</h2>
  <dl class="form_basic">
    <dd>
      <dl class="cols">
        <dt>ストアの名前</dt>
        <dd id="form_coupon">
          <input type="text" name="store_name" value="{$name}" ><input type="button" class="btn btn-primary" name="store_name_btn" value="変更" onClick="changeName()">
        </dd>
      </dl>
      <dl class="cols">
        <dt>ストアURL</dt>
        <dd class="horizon">
        <p class="btn_low_m">http://estore.{$domail}.jp</p>

        </dd>
      </dl>
      <dl class="cols">
        <dt>ストアの説明</dt>
        <dd class="horizon">
         <a href="/store/detail" id="desc"></a>    </dd>
      </dl>

      <dl class="cols">
        <dt>SNS連動</dt>
        <dd class="horizon">
          <a href="/store/sns" id="store_sns"></a>
         </dd>
      </dl>


      <dl class="cols">
        <dt>公開設定</dt>
        <dd class="horizon">
		<input type="button" id="public_btn" {if $public_status =='Y'}class="btn btn-primary"{else}class="btn btn-inverse"{/if} name="store_public" value="{if $public_status =='Y'}公開{else}非公開{/if}" onClick="changePublic();">
	      </dd>
      </dl>

            <dl class="cols">
        <dt>お支払い方法</dt>
        <dd class="horizon">
        <input type="button" name="store_ketsai" onClick="location.href='/store/paymethod'" value="設定" class="btn btn-primary">
  		         </dd>
        </dl>

            <dl class="cols">
        <dt>送料設定</dt>
        <dd class="horizon">
        <input type="text" name="scharge" value="{$scharge}">円&nbsp;&nbsp;&nbsp;　
        <input type="button" name="store_ketsai"  onClick="changeScharge();" value="設定" class="btn btn-primary">
  		         </dd>
        </dl>


      <dl class="cols">
        <dt>特定商取引法に基づく表</dt>
        <dd class="horizon">
         <input type="button" onClick="location.href='/store/asct'" name="store_tokutei" value="登録" class="btn btn-primary">
         </dd>
      </dl>
      <dl class="cols">
        <dd></dd>
      </dl>
    </dd>
  </dl>
</div>

</form>


<!-- before -->




{literal}
<script type="text/javascript">

{/literal}
hasDesc = {$hasDesc};
hasSns = {$hasSns};


{literal}
$(function() {

    if(hasDesc){
		$("#desc").text('編集');
		$("#desc").removeClass().addClass('btn btn-inverse');
    }else{
		$("#desc").text('登録');
		$("#desc").removeClass().addClass('btn btn-primary');
	}
	    if(hasSns){
		$("#store_sns").text('編集');
		$("#store_sns").removeClass().addClass('btn btn-inverse');
    }else{
		$("#store_sns").text('登録');
		$("#store_sns").removeClass().addClass('btn btn-primary');
	}
});

function excuteData(action){
		document.store_edit.action.value = action;
		document.store_edit.submit();

}
function changeName(){

	$.ajax({
		url:'/store/changeName',
		dataType: 'json',
		data : $("#store_edit").serialize(),
		type: "POST",

	}).done(function(data) {
			if(data.error!=''){
			alert(data.msg);
		}else{
		alert("変更しました。");
		}
	});
}

function changePublic(){

	$.ajax({
		url:'/store/changePublic',
		dataType: 'json',
		data : $("#store_edit").serialize(),
		type: "POST",

	}).done(function(data) {
		if(data.public =='Y'){
			$("#public_btn").removeClass('btn btn-inverse');
			$("#public_btn").addClass('btn btn-primary');
			$("#public_btn").attr('value', '公開');
		}else{
			$("#public_btn").removeClass('btn btn-primary');
			$("#public_btn").addClass('btn btn-inverse');
			$("#public_btn").attr('value', '非公開');
		}



	});
}
function changeScharge(){

	$.ajax({
		url:'/store/scharge',
		dataType: 'json',
		data : $("#store_edit").serialize(),
		type: "POST",

	}).done(function(data) {
		if(data.error!=''){
			alert(data.msg);
		}else{
			alert("変更しました。");
		}
	});
}

</script>


{/literal}
<br>

<br>

<br>
<br>
<br>