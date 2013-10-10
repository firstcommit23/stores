{if ($flag=="ok")}
<h2>ご登録ありがとうございました。まずは、ストアデザインを行ってください。</h2>
<form  name="add" action="/isError" method="POST" class="form-signin">
<button class="btn btn-primary" type="submit">スタート</button>
</form>
{else}
<h2>ページが見つかりませんでした。お確かめください。</h2>
{/if}