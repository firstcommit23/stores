<h1>商品削除&nbsp;<input type="button" value="一覧へ戻る" class="btn btn-info" onclick="history.back()" /></h1>
<p>この商品を削除しますか？
</p>
<form action="{$id}" method="post">
<div>
    <input type="hidden" name="id" value="{$id}" />
    <input type="submit" class="btn btn-inverse" name="del" value="Yes" />
    <input type="submit" class="btn btn-inverse" name="del" value="No" />
</div>
</form>