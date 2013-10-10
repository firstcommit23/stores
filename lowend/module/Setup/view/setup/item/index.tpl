{literal}
 <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css" />
  <script src="http://code.jquery.com/jquery-1.8.3.js"></script>
  <script src="http://code.jquery.com/ui/1.10.0/jquery-ui.js"></script>
  <script>

  //drop&down変更
  $(function() {
    $( "#sortable" ).sortable();
    //$( "#sortable" ).disableSelection();
  });

  function viewArray(){
    var result = $('#sortable').sortable('toArray');
    alert( 'value:' + result );
    alert( 'first value:' + result[0] );
}

  </script>

{/literal}




<h1>商品一覧</h1>
<p>
    <a href="item/add">商品登録</a>
</p>
<form class="form-search" name="search_form" method="post" action="/item">
<input type="hidden" name="action">
<input type="hidden" name="searchValue">

検索：<input type="text" name="searchStr"  placeholder="検索文字を入力してください。"  {if isset($searchStr)} value="{$searchStr}" {/if}>
<input type="button" class="btn" onClick="searchOrder('searchStr',document.search_form.searchStr.value);" value="Search" >&nbsp;&nbsp;
カテゴリ：


<select id="selectCtegory" name="selectCtegory" size="1" onChange="searchOrder('category',this.value);">
{foreach from=$categoryList item=c}
<option value="{$c.id}" {if $selectCategory == {$c.id}} selected{/if}>{$c.name}</option>
{/foreach}
</select>

公開設定：<select id="selectCode" name="selectCode" size="1" onChange="searchOrder('status',this.value);">
<option value="Y" {if $selectStatus=='Y'} selected {/if}>公開</option>
<option value="N" {if $selectStatus=='N'} selected {/if}>非公開</option>
</select>

<table class="table" >
<tr>
    <th>並び順</th>
    <th>画像</th>
    <th>アイテム名</th>
    <th>価額</th>
    <th>在庫</th>
    <th>公開設定</th>
    <th>編集/削除</th>
</tr>
{if (count($item)) }
<tbody id="sortable">
{foreach from=$item item=a}
<tr id={$a.item_no}>
    <td>{if $a.status === 'Y'}<input type="button" value="↑" onclick="moveUpItem({$a.item_no});"><input type="button" value="↓" onclick="moveDownItem({$a.item_no});">{/if}<span id=item_no{$a.item_no}>{$a.item_no}</span></td>
    <td>{$a.img1}</td>
    <td>{$a.item_name}</td>
    <td>{$a.coast}</td>
    <td>{$a.stock}</td>
    <td><select id="selectCode" name="selectCode" size="1" onChange="selectCode(this.value)">
            <option value="open" {if $a.status === 'Y'} selected{/if}>公開</option>
            <option value="closed" {if $a.status === 'N'} selected{/if}>非公開</option>
        </select></td>
    <td>
        <a href="item/update/{$a.id}">編集</a>
        <a href="item/delete/{$a.id}">削除</a>
    </td>
</tr>
{/foreach}
</tbody>
</table>
{/if}


{if $page->pageCount}

<div class="pagination">
<ul>
  <!-- Previous page link -->
  {if isset($page->previous)}
    <li>
      <a href="/item/{$page->previous}">&larr; Prev</a>
    </li>
  {else}
    <li class="disabled"><a>&larr; Prev</a></li>
  {/if}
 <!-- Numbered page links -->
  {foreach from=$page->pagesInRange item=p}
    {if ($p != $page->current)}
      <li>
        <a href="/item/{$p}">
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
      <a href="/item/{$page->next}">Next &rarr;</a>
    </li>
  {else}
    <li class="disabled"><a>Next &rarr;</a></li>
 {/if}
  </ul>
</div>
{/if}

</form>
