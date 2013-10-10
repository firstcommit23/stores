<script type="text/javascript">

    var vari_countid="1";
    var stock_countid="1";
	function createVariRow(){

	     //バリエーションを追加ボタンを押したら在庫のinputを無くす
	     document.all.stockInput.style.display="none";
	     //document.all.menuBar.style.display="";

	     //1.必要なelement or textNode生成


	     var vari = document.createElement("input");
	     vari.setAttribute("type","text");
	     vari.setAttribute("id","vari"+vari_countid);
		 vari.value="";
		 vari.placeholder="ex:サイズ：S";
		 vari.id="vari";
		 vari.name="vari"+vari_countid;


		 var vari_stock = document.createElement("input");
		 vari_stock.setAttribute("type","text");
		 vari_stock.value="";
		 vari_stock.id="vari_stock";
		 vari_stock.name="vari_stock";
		 vari_stock.setAttribute("name","vari_stock"+stock_countid);

		 var del = document.createElement("input");
		 del.setAttribute("type","button");
		 del.value="delete";
		 del.setAttribute("class","btn");
		 del.id="del";

		 // del.onclick = removeHang

		 del.setAttribute("onclick" , "removeHang(this)") ;

         //2. tableを探す
    	 var taList = document.getElementById("variationList");

         //3. 探したtableに行を追加
		 //alert("現在行のながさ : taList.rows.length : " + taList.rows.length);

        // var err = document.createElement("div");
        // err.

		 var variDiv = document.createElement("div");
	     variDiv.setAttribute("id",vari_countid);
	     taList.appendChild(variDiv);
	     variDiv.appendChild(vari);
         variDiv.appendChild(vari_stock);
         variDiv.appendChild(del);
         //variDiv.append(err);

		 //var row = taList.insertRow(taList.rows.length);

         //4. 生成された行に列を追加
		 //var td1 = row.insertCell(0);
		 //var td2 = row.insertCell(1);
		 //var td3 = row.insertCell(2);

         //5. 各列にelementやtextNodeを追加する
		 //td1.appendChild(vari);
		 //td2.appendChild(vari_stock);
		 //td3.appendChild(del);

		 var newVariCount = document.getElementById('newVariCount');
		 newVariCount.value = vari_countid;

         vari_countid++;
	     stock_countid++;


		}

        //削除
		function removeHang(obj){
			//button削除
			//obj.parentNode.removeChild(obj);

            //buttonのある行を削除
     		var td = obj.parentNode;
			var tr = td.parentNode;
			var table = tr.parentNode;
			table.removeChild(tr);

		}

        //category追加popup
		function add_category(){
		    window.name="addCate";
            window.open('http://zf2-tutorial.localhost/item/insertCategory','lowend','width=800px,height=500px,left=300px');
        }

        //カテゴリ追加
        function insertCategory(cateInputValue){
            $.ajax({
                url      : "insertCateAjax" ,
                dataType : "json" ,
                data     : {
                         'newCate' : cateInputValue
                },
                type     : "POST" ,
                success  : function(data){
                    $("p").append(" <div id='categoryAjaxDiv" + data.newCategoryId +"' >&nbsp;<input type='checkbox' name=' + data.newCategoryId +' >&nbsp;&nbsp;</div> ");
                    $("#categoryAjaxDiv" + data.newCategoryId ).append(data.newCategory);
                    $("#categoryAjaxDiv"+ data.newCategoryId).append("&nbsp;<a href='item/updateCategory/" + data.newCategoryId +"'>編集</a>  ");
                    $("#categoryAjaxDiv"+ data.newCategoryId).append("<a href='#' onclick='deleteCategory(data.newCategoryId);' >削除</a>  ");
                }

            });


        }

        //カテゴリ名編集
        function updateCategory(cateInputEditValue,cateId){
            $.ajax({
                url      : "updateCateAjax" ,
                dataType : "json" ,
                data     : {
                         'editCate' : cateInputEditValue,
                         'cateId'   : cateId
                },
                type     : "POST" ,
                success  : function(data){
                    $("#categoryAjaxDiv" + data.editCategoryId ).empty();
                    $("#categoryAjaxDiv" + data.editCategoryId ).append("&nbsp;<input type='checkbox' name=' + data.editCategoryId +' >&nbsp;&nbsp;");
                    $("#categoryAjaxDiv" + data.editCategoryId ).append(data.editCategory);
                    $("#categoryAjaxDiv" + data.editCategoryId ).append("&nbsp;<a href='item/updateCategory/" + data.editCategoryId +"'>編集</a>  ");
                    $("#categoryAjaxDiv" + data.editCategoryId ).append("<a href='#' onclick='deleteCategory(data.newCategoryId);'>削除</a>  ");
                }

            });


        }

        //カテゴリ名削除
        function deleteCategory(cateId){
        //alert(cateId);

            $.ajax({
                url      : "deleteCateAjax" ,
                dataType : "json" ,
                data     : {
                         'cateId'   : cateId
                },
                type     : "POST" ,
                success  : function(data){
                //alert(" #categoryAjaxDiv" + data.editCategoryId );
                    $("#categoryAjaxDiv" + data.deleteCategoryId ).remove();
                }

            });



        }

        //imageプレビュー
        var imageId = 1;
        function previewImage(targetObj, previewId) {

        var preview = document.getElementById(previewId); //div id
        var ua = window.navigator.userAgent;

        if (ua.indexOf("MSIE") > -1) {

            targetObj.select();

            try {
                var src = document.selection.createRange().text; // get file full path
                var ie_preview_error = document
                        .getElementById("ie_preview_error_" + previewId);

                if (ie_preview_error) {
                    preview.removeChild(ie_preview_error);
                }

                var img = document.getElementById(previewId);

                img.style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='"
                        + src + "', sizingMethod='scale')";
            } catch (e) {
                if (!document.getElementById("ie_preview_error_" + previewId)) {
                    var info = document.createElement("<p>");
                    info.id = "ie_preview_error_" + previewId;
                    info.innerHTML = "a";
                    preview.insertBefore(info, null);
                }
            }
        } else { //ieじゃない時
            var files = targetObj.files;
            for ( var i = 0; i < files.length; i++) {

                var file = files[i];

                var imageType = /image.*/;
                //imageファイルだけ表示する
                if (!file.type.match(imageType))
                    continue;

                //var prevImg = document.getElementById("prev_" + previewId);
                //以前のプレビューがあったら削除する
                //if (prevImg) {
                //    preview.removeChild(prevImg);
                //}



                var img = document.createElement("img");
                //chromeはdivにイメージが表示されないので、childElementを作る
                img.id = "prev_" + imageId;


                img.classList.add("obj");
                img.file = file;
                //基本設定のdivの中に表示する効果を上げるため、divと同じ大きさを指定する
                img.style.width = '70px';
                img.style.height ='70px';
                img.style.border = '2px solid black';

                preview.appendChild(img);

                if (window.FileReader) { // FireFox, Chrome, Operaか確認.
                    var reader = new FileReader();
                    reader.onloadend = (function(aImg) {
                        return function(e) {
                            aImg.src = e.target.result;
                        };
                    })(img);
                    reader.readAsDataURL(file);
                } else { // safari is not supported FileReader
                    //alert('not supported FileReader');
                    if (!document.getElementById("sfr_preview_error_"
                            + previewId)) {
                        var info = document.createElement("p");
                        info.id = "sfr_preview_error_" + previewId;
                        info.innerHTML = "not supported FileReader";
                        preview.insertBefore(info, null);
                    }
                }
            }
        }

        imageId++;
    }

    function deletePreview(){
    alert("dd");

         var prevImg = document.getElementById("prev_" + imageId);
         preview.removeChild(prevImg);

    }


</script>


<h1>商品情報編集&nbsp;<input type="button" value="一覧へ戻る" class="btn btn-info" onclick="location.href='http://zf2-tutorial.localhost/item/'" /></h1>

<form name="update" method="POST" action="update">
<input type="hidden" name="id" value="{$id}">
<input type="hidden" name="newVariCount" id="newVariCount">
<input type="hidden" name="item_no" id="item_no">

<table border="1">

    <tr>
        <td width="100">・商品名</td>
        <td width="500">
            <input type="text" name="item_name" value="{$itemData.item_name}"><br>
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
            <input type="text" name="coast" value="{$itemData.coast}">円<br>
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
        <input type="file"  name="imageFile[]" value="ファイル選択" onchange="previewImage(this,'previewId');" multiple /><br>
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
        <td><textarea  rows="5" cols="40"  name="description" value="{$itemData.description}" ></textarea></td>
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
                &nbsp;<input type="checkbox" name="{$c.id}">&nbsp;&nbsp;{$c.name}&nbsp;
                <a href="#" onclick="window.open('http://zf2-tutorial.localhost/item/updateCategory/{$c.id} ','lowend','width=800px,height=500px,left=300px') ">編集</a>
                <a href="#" onclick="deleteCategory({$c.id});">削除</a>
                <br>
                </div>
            {/foreach}
            <p></p>
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
           <textarea  rows="5" cols="40"  name="tag" value="{$itemData.tag}" ></textarea>
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


