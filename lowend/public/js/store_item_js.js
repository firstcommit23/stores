/*****
 *
 * item index js
 *
 *****/

//sort data
    function searchOrder(action, searchValue){

         document.search_form.action.value = action;
         document.search_form.searchValue.value = searchValue;
         document.search_form.submit();
    }

    //並び替え変更上へボタン
    function moveUpItem(currentMark){


        var idStr='#' + currentMark;
        var prevHtml=$(idStr).prev().html();
        if( prevHtml == null){
           // alert("一番上");
            return;
        }
        var prevcurrentMark=$(idStr).prev().attr("id");

        var currentMark=$(idStr).attr("id");
        var currHtml=$(idStr).html();

        //value変更
        $(idStr).html(prevHtml);
        $(idStr).prev().html(currHtml);

        //id value変更
        $(idStr).prev().attr("id","TEMP_TR");
        $(idStr).attr("id",prevcurrentMark);
        $("#TEMP_TR").attr("id",currentMark);

        var mNo = currentMark -1;

        var spanId1 = document.getElementById('item_no'+currentMark);
        spanId1.id ='item_no'+mNo;

        var spanId2 = document.getElementById('item_no'+mNo);
        spanId2.id='item_no'+currentMark;
       // alert("test");
        //exit();

        //alert('item_no'+currentMark);
        $("#item_no" + currentMark ).empty();
        $("#item_no" + currentMark ).append(mNo);
        $("#item_no" + mNo ).empty();
        $("#item_no" + mNo).append(currentMark);
       alert("test");
       //exit();

        //var changeNo = currentMark -1;

         $.ajax({
                url      : "item/changeTableRow" ,
                dataType : "json" ,
                data     : {
                 //        'flag'      : "up",
                         'currentNo' : currentMark,
                 //        'upNo'      : currentMark -1,
                 //        'downNo'    : currentMark +1
                },
                type     : "POST" ,
                success  : function(data){
                  //  $("#item_no" + currentMark ).empty();
                  //  $("#item_no" + currentMark ).append(mNo);
                  //  $("#item_no" + mNo ).empty();
                  //  $("#item_no" + mNo).append(currentMark);
                   //alert("success");
                }

            });
    }

   //並び替え変更下へボタン
   function moveDownItem(currentMark){

       var idStr='#' + currentMark;
       var nextHtml=$(idStr).next().html();
       if( nextHtml == null){
           //alert("一番下");
           return;
       }
       var nextcurrentMark=$(idStr).next().attr("id");
       var currcurrentMark=$(idStr).attr("id");
       var currHtml=$(idStr).html();
       $(idStr).next().html(currHtml);
       // $(idStr).next().attr("id",currcurrentMark);

       //value変更
       $(idStr).html(nextHtml);

       //id value変更
       $(idStr).next().attr("id","TEMP_TR");
       $(idStr).attr("id",nextcurrentMark);
       $("#TEMP_TR").attr("id",currcurrentMark);

   }



/*****
 *
 * item add js
 *
 *****/


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


    //item image upload & preview
	function ajaxFileUpload()
	{
		$.ajaxFileUpload
		(
			{
				dataType: 'json',
				url:'/item/fileupload',
				data : $("#form").serialize(),
				type: "post",
				secureuri:false,
				fileElementId:'fileToUpload',

				success: function (data, status)
				{
					if(typeof(data.error) != 'undefined')
					{
						if(data.error != '')
						{
							alert(data.error);
						}else
						{
                                                $("#previewId").append('<img alt="img"  width="100px" height="100px" src="/upload/temp/'  + data.file_name + '" />');
						}
					}
				},

				error: function (data, status, e)
				{
					alert(e);
				}



			}
		)
		return false;
	}
