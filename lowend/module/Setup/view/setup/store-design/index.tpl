<!-- editer -->

<div class="panel">
<div>
	<a href="/setup" class="btn btn-info">←戻る</a>
	<input type="button" value="保存" class="btn btn-success" onClick="save()"/>
</div>
<div class="slidheader">
	<h3>LOGO</h3>

	<div>
	<form method="post" id="logoForm" enctype="multipart/form-data">
    		<input type="button" id="logoDeleteBtn" class="btn btn-danger" value="削除" />
    		<input type="file" class='upload' name="LogoToUpload" id="LogoToUpload" type="file" value="アップロード"  onChange="return ajaxLogoUpload();" />
    </form>
    </div>

</div>

<div class="slidheader">
	<h3>layout</h3>
	<div>
		<ul>
	   	 {foreach from=$layout_arr item=layout}
    			<li class="layoutview" style="background-image: url({$layout.img})" onClick="setLayoutStyle('{$layout.className}');"> </li>
    	{/foreach}
    	</ul>
	</div>
</div>

<div class="slidheader">
		<h3>背景</h3>
		<div class="mheader">単色</div>
		    <div><ul>
		    {foreach from=$background_color_arr item=color}
		   		<li onClick="setBackgroundColor('{$color}')" class="color-box" style="background: {$color}" ></li>
    		{/foreach}
    		</ul></div>
    		<div class="mheader">イメージ</div>
			<div><ul>
    		{foreach from=$backgound_img_arr item=img}
		   		<li onClick="setBackgroundImg('{$img}')" class="color-box" style="background-image: url({$img});" ></li>
    		{/foreach}
    		</ul></div>
    		<div class="mheader">オリジナル背景</div>
    		<form method="post" id="form" enctype="multipart/form-data">
            	<input type="hidden" value="code" name="background">
   				<input name="fileToUpload" id="fileToUpload" type="file" value="アップロード"  onChange="return ajaxFileUpload();">
   				<input type="checkbox" onClick="background_repeat(background_original_repeat);" id="backori_repeat" checked>タイル状に配置
			</form>
</div>

<div class="slidheader">
    	 <h3 >テキストカラー</h3>
    		<div class="mheader">ストア名</div>
    			<ul>
    			{foreach from=$background_color_arr item=color}
    			<li class="color-box" onClick="setStoreNameFontColor('{$color}');" style="background: {$color}"></li>
    			{/foreach}
				</ul>
    		<div class="mheader" id="menue_text">メニュー</div>
    		<ul>
    		    {foreach from=$background_color_arr item=color}
    			<li class="color-box" onClick="setMenuFontColor('{$color}');" style="background: {$color}"></li>
    			{/foreach}

			</ul>
    		<div class="mheader">アイテム名</div>
    		<ul>
    			 {foreach from=$background_color_arr item=color}
    			<li class="color-box" onClick="setItemFontColor('{$color}');" style="background: {$color}"></li>
    			{/foreach}
			</ul>
    		<div class="mheader">価格</div>
    		<ul>
    			 {foreach from=$background_color_arr item=color}
    			<li class="color-box" onClick="setPriceFontColor('{$color}');" style="background: {$color}"></li>
    			{/foreach}
   			</ul>
</div>
<div class="slidheader">
    		<h3 id="header">表示設定</h3>
    		<div class="mheader">アイテム名</div>
    		<li onClick="item_hover(display_price);" id="display_item_state">ON</li>

    		<div class="mheader">価格</div>
    		<li class="bg_img"  id="price_0">ON</li>
    	    <li class="bg_img"  id="price_1">OFF</li>

    		<div class="mheader">アイテムフレー</div>
    	    <li class="bg_img" onClick="toggle_frame(display_frame);" id="display_frame_state">OFF</li>

</div>





<div style="clear:both;"></div>

</div>
<a class="trigger" href="#">ToolBox</a>

<!-- Editor End -->

<!-- preview -->
  <div id="preview">
    <div id="layout_pattern">
      <div id="header">
        <h1 id="store_logo" style="color: rgb(102, 102, 102);">
          <span id="logo_img" class="mark"><img src="{if $store->logo != ''}/upload/temp/{$store->logo}{/if}" alt="logo" {if $store->logo == ''}style="display: none;"{/if} ></span>
          <span class="shop_title"><b>{$title}</b></span>
        </h1>

        <div id="navi_main" class="shop_menu" style="" ng-show="categories || hasAbout"><br>
          <dl style="font-family: Allerta">
            <dd style="z-index:500;"><a href="">HOME</a></dd>
            <dd style="z-index: 500;"><a href="" >ABOUT</a></dd>
            <dd style="z-index:500;" class="btn_dropdown">
              <a href="">CATEGORY</a>
              <ul class="dropdown" style="display: none;">
                <!-- ngRepeat: category in categories -->
                	<li><a href="#" class="ng-binding">category1</a></li>
                	<li><a href="#" class="ng-binding">category2</a></li>
              </ul>
            </dd>
          </dl>
        </div>
      </div>
      <div style="display:block;"></div>

      <div id="item_list">

     {foreach from=$itemList item=item}
  	 <div class="items" style="background-color:#ffffff ; color: rgb(153, 153, 153); background-position: initial initial; background-repeat: initial initial;">
          <div class="item_inner">
            <div class="thumb">
              <img width="100%" src="{$item.img}">
            </div>
            <div class="data" style="display: block; opacity: 1;">
              <dl>
                <dd class="name" style="height: 18px;">{$item.title}</dd>
                <dd class="price">¥{$item.price}</dd>
              </dl>
            </div>
          </div>
        </div>

     {/foreach}

    </div>
  </div>

<!-- preview end-->

