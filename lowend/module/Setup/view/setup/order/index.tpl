{literal}
<script type="text/javascript">
function searchOrder(action, searchValue){

	document.search_form.action.value = action;
	document.search_form.searchValue.value = searchValue;
	document.search_form.submit();
}

</script>
{/literal}

<h2>オーダーリスト</h2><br><br>
<form class="form-search" name="search_form" method="post" action="/order">

	<input type="hidden" name="action">
	<input type="hidden" name="searchValue">

	期間
	<select size="1" name="date_search" class="input-medium" onChange="searchOrder('order_date',this.value);">
	{foreach from=$dayList item=day}
		<option value="{$day}" {if $selectDay == $day} selected{/if}>{$day}</option>
	{/foreach}
	</select>

	配送情報
	<select size="1" class="input-medium" onChange="searchOrder('state',this.value);">
		<option value="1" {if $selectState=='1'} selected{/if}>未配送</option>
		<option value="2" {if $selectState=='2'} selected{/if}>配送済み</option>
		<option value="3" {if $selectState=='3'} selected{/if}>返金済み</option>
	</select>　

	支払い方法<select size="1" class="input-medium">
		<option value="1">クレジットカード</option>
	</select>

	検索
 	<input name="searchStr" type="text" {if isset($searchStr)}value="{$searchStr}" {/if}class="input-medium search-query">
	<input type="button" onClick="searchOrder('searchStr',document.search_form.searchStr.value);" value="Search" class="btn">
</form>

<br>

{if (count($order)) }
<table class="table">
<tr>
    <th>オーダー番号</th>
    <th>オーダー日</th>
    <th>購入者</th>
    <th>会計金</th>
    <th>お支払い方法</th>
    <th>ステータス</th>
</tr>

{foreach from=$order item=ord}
<tr>
    <td><a href="/order/detail/{$ord.id}">{$ord.id}</a></td>
    <td>{$ord.created}</td>
    <td>{$ord.purchaser_name}</td>
    <td>{$ord.total}</td>
    <td>{if $ord.payment === '1'}クレジットカード{/if}</td>
    <td>{if $ord.state === '1'}未配送{/if}
    	{if $ord.state === '3'}返金済み{/if}
    	{if $ord.state === '2'}配送済み{/if}</td>

</tr>
{/foreach}
</table>
{else}

表示するオーダー情報がないです。

{/if}

{if $page->pageCount}

<div class="pagination">
<ul>
  <!-- Previous page link -->
  {if isset($page->previous)}
    <li>
      <a href="/order/{$page->previous}">&larr; Prev</a>
    </li>
  {else}
    <li class="disabled"><a>&larr; Prev</a></li>
  {/if}
 <!-- Numbered page links -->
  {foreach from=$page->pagesInRange item=p}
    {if ($p != $page->current)}
      <li>
        <a href="/order/{$p}">
          {$p}
        </a>
      </li>
    {else}
      <li class="active"><a>{$p}</a></li>
    {/if}
  {/foreach}

  <!-- Next page link -->
  {if isset($page->next)}
    <li>
      <a href="/order/{$page->next}">Next &rarr;</a>
    </li>
  {else}
    <li class="disabled"><a>Next &rarr;</a></li>
 {/if}
  </ul>
</div>
{/if}
