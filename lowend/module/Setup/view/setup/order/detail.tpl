
<h2>オーダー情報詳細</h2><br><br>

<a href="/order">オーダーリスト</a>

<br>

<table class="table" align="left">
<tr>
	<td>ステータス</td>
	<td>{if $order.state === '1'}未配送{/if}
    	{if $order.state === '3'}返金済み{/if}
    	{if $order.state === '2'}配送済み{/if}</td>
</tr>
<tr>
	<td>オーダー番号</td>
	<td>{$order.order_id}</td>
</tr>
<tr>
	<td>オーダー日</td>
	<td>{$order.created}</td>
</tr>
<tr>
	<td>購入者</td>
	<td>{$order.purchaser_name}</td>
</tr>
<tr>
	<td>配送先郵便番号</td>
	<td>{$order.zip_code}</td>
</tr>
<tr>
	<td>配送先住所</td>
	<td>{$order.prefectures}{$order.address}</td>
</tr>
<tr>
	<td>電話番号</td>
	<td>{$order.tel}</td>
</tr>
<tr>
	<td>メールアドレス</td>
	<td>{$order.email}</td>
</tr>
<tr>
	<td>お支払い方法</td>
	<td>{if $order.payment === '1'}クレジットカード{/if}</td>
</tr>
<tr>
	<td>備考</td>
	<td>{$order.notes}</td>
</tr>
</table>

<br><br>
<h5>購入アイテム</h5>

<table class="table" align="left">

<tr>
	<td colspan="2">アイテム名</td>
	<td>バリエーション</td>
	<td>価格</td>
	<td>個数</td>
	<td>小計</td>
</tr>
  {foreach from=$products item=product}
<tr>
	<td><img src="/images/{$product->image_name}" width="50" height="50"></td>
	<td>{$product->name}</td>
	<td>{$product->variation_name}</td>
	<td>{$product->price}</td>
	<td>{$product->count}</td>
	<td>{$product->price * $product->count} </td>
</tr>
{/foreach}
<tr>
	<td colspan="6">
		<div align="right">配送料　{$order.scharge} <br>
							手数料　{$order.fee}<br><br>
							会計<font color="red"> {$order.total}</font><br>
		</div>
	</td>
</tr>
</table>
{literal}
<script type="text/javascript">

function excuteState(state){
	var answer = confirm('本当にステータスを変更しますか？');

	if(answer){
		document.execute.STATUE.value = state;
		document.execute.submit();
	}else{
	}
}

</script>


{/literal}

<form name="execute" action="/order/execute"  method="post">
	<input type="hidden" name="ORDERID" value="{$order.order_id}">
	<input type="hidden" name="STATUE">
	<input type="button" value="返金済み" onClick="excuteState(3)">
	<input type="button" value="未発送" onClick="excuteState(1)">
	<input type="button" value="発送済み" onClick="excuteState(2)">

</form>