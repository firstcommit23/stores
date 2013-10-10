<h1>商品登録&nbsp;<input type="button" value="一覧へ戻る" class="btn btn-primary" onclick="location.href='http://zf2-tutorial.localhost/item/'" /></h1>

<form name="item_add" method="POST" action="add">
<input type="hidden" name="newVariCount" id="newVariCount">
<input type="hidden" name="item_no" id="item_no">

<table border="1">
    <tr>
        <td width="100">・商品名</td>
        <td width="500">
            <input type="text" name="item_name" value=""><br>
            {if isset($itemErr)}
                <font color="red">
                    {$itemErr.itemNameErr}
                 </font>
            {/if}
        </td>
    </tr>
    <tr>
        <td>・価額</td>
        <td>
            <input type="text" name="coast" value="">円<br>
            {if isset($itemErr)}
                <font color="red">
                    {$itemErr.itemCoastErr}
                 </font>
            {/if}
        </td>
    </tr>
    <tr>
        <td>・画像</td>
    <td>
        <input name="fileToUpload" id="fileToUpload" type="file" value="アップロード"  onChange="return ajaxFileUpload();"><br>
        {if isset($itemErr)}
                <font color="red">
                    {$itemErr.itemImageListErr}
                 </font>
        {/if}
        <tr>
           <td><br></td>
           <td>
               <div id='previewId'>
                   <!-- image   -->
               </div>
           </td>
        </tr>
    </td>

    </td>

    </tr>
    <tr>
        <td>・商品紹介文</td>
        <td><textarea  rows="5" cols="40"  name="description" value="" ></textarea></td>
    </tr>
    <tr>
        <td>・在庫</td>
        <td>
            <table id="variationList">
                <div id="menubar">
                    <th>バリエーション</th>
                    <th>在庫数</th>
                    <th>削除</th>
                </div>
            </table>
            <input id="stockInput" type="text" name="stock" value="" />
            {if isset($itemErr)}
                <font color="red">
                    {$itemErr.itemStockErr}
                 </font>
            {/if}
            <input type="button" value="バリエーション追加" class="btn btn-info" onclick="createVariRow()"/>
        </td>
    </tr>
    <tr>

        <td>・カテゴリ</td>
        <td>
            {foreach from=$cate item=c}
                <div id=categoryAjaxDiv{$c.id}>
                &nbsp;<input type="checkbox" name="cate[]" value="{$c.id}">&nbsp;&nbsp;{$c.name}&nbsp;
                <a href="#" onclick="window.open('http://zf2-tutorial.localhost/item/updateCategory/{$c.id} ','lowend','width=800px,height=500px,left=300px') ">編集</a>
                <a href="#" onclick="deleteCategory({$c.id});">削除</a>
                <br>
                </div>
            {/foreach}

            <input type="button" value="カテゴリーを追加" class="btn btn-info" onclick="add_category()" />
        </td>
    </tr>
    <tr>
        <td>・新品・中古</td>
        <td>
            <select id="selectCode" name="item_status" size="1">
                <option value="Y">新品</option>
                <option value="N">中古</option>
            </select>
        </td>
    </tr>

    <tr>
        <td>・タグ</td>
        <td>
           <textarea  rows="5" cols="40"  name="tag" value="" ></textarea>
        </td>
    </tr>
    <tr>
        <td>・ショッピングフィードカテゴリ</td>
        <td>
            <select id="shopCateList" name="shoppingFieldCategory" size="1">
               {foreach from=$shopCateList item=s}
                   <option value="{$s.id}">{$s.name}</option>
               {/foreach}
            </select>
        </td>
    </tr>
    <tr>
        <td>・ショッピングフィード公開設定</td>
        <td>
            <select id="selectCode" name="shoppingFieldStatus" size="1">
                <option value="Y">公開</option>
                <option value="N">非公開</option>
            </select>
        </td>
    </tr>
    <tr>
        <td>・公開設定</td>
        <td>
            <select id="selectCode" name="status" size="1">
                <option value="Y">公開</option>
                <option value="N">非公開</option>
            </select>
        </td>
    </tr>


</table>

<br><br>
<input type="submit" value="登録" class="btn btn-inverse" />
<input type="button" value="キャンセル" class="btn btn-inverse" onclick="location.href='http://zf2-tutorial.localhost/item/'" />

</form>


