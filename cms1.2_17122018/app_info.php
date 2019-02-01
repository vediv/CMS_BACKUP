<ul class="tree">
<li class="has">
 <input type="checkbox" name="domain[]" value="Biological Sciences">
 <label>Biological Sciences <span class="total">(19)</span></label>
                    <ul>
                      <li class="">
                        <input type="checkbox" name="subdomain[]" value="Biology">
                        <label>Biology </label>
                      </li>
                      <li class="has">
                        <input type="checkbox" name="subdomain[]" value="Biochemistry &amp; Molecular Biology">
                        <label>Biochemistry &amp; Molecular Biology <span class="total">(1)</span></label>
                        <ul>
                          <li>
                            <input type="checkbox" name="subject[]" value="Analytical Biochemistry">
                            <label>Analytical Biochemistry</label>
                            <ul>
                                <li>
                                 <input type="checkbox" name="subject[]" value="Analytical Biochemistry">
                                 <label>Analytical Biochemistry</label>
                                    <ul>
                                        <li>
                                         <input type="checkbox" name="subject[]" value="Analytical Biochemistry">
                                         <label>Analytical Biochemistry</label>
                                        </li>
                                   </ul>
                                </li>
                           </ul>
                          </li>
                        </ul>
                      </li>
                    </ul>
</li>
</ul>
function getAllgategoryTree(catparentid)
{
    alert("xZCzc");
    $('#load_in_modal').show();
    $('#result_category_list').css("opacity",0.1);
    var dataString ='parent_id='+catparentid+'&action=category_tree_view_data';
    $.ajax({
           type: "POST",
           url: "coreData.php",
           data: dataString,
           dataType: 'json',
           cache: false,
           success: function(r){
                var catLen=r.items.length;
                var data=r.items;
                //var chtml='';
                //chtml+='<ul class="tree">';
                //chtml+='<li class="has">'; 
                for(var i=0;i<catLen;i++)
                {
                   get only parent
                   var pcatid=data[i].category_id;
                   var cat_name=data[i].cat_name;
                   console.log(pcatid+"__"+cat_name);
                  // chtml+='<input type="checkbox" name="domain[]" value="Biological Sciences">';
                   //chtml+='<label>Biological Sciences <span class="total">(19)</span></label>';
                }
                //chtml+='</li>';
                //chtml+='</ul>';   
                
                $('#load_in_modal').hide();
                $('#result_category_list').css("opacity",1);
           	$("#result_category_list").html("sasasas");
           }
      });
}

<?php  
foreach($fcid as $fetcid)
     {   
         $category_id=$fetcid['category_id']; $parentid=$fetcid['parent_id'];  $priority=$fetcid['priority'];
         //$delete1 = "DELETE FROM categories where category_id='".$category_id."' and parent_id='".$delcategoryid."'";
         echo $delete1 = "update categories set status='3' where category_id='".$category_id."' and parent_id='".$delcategoryid."'";
         $dc=db_query($conn,$delete1);
         $qheaderMenu = "update header_menu set header_status='3' where category_id='$category_id'";
         $dc=db_query($conn,$qheaderMenu);
         // this category id remove from entry table in categoryid column
         $updateeEntryTable="update entry set categoryid=TRIM(BOTH ',' FROM REPLACE(CONCAT(',',categoryid,',') , ',$category_id,', ',')) where FIND_IN_SET($category_id,categoryid)";
         $uEntry=db_query($conn,$updateeEntryTable);
         //$delete2 = "DELETE FROM category_thumb_icon_url where category_id='".$category_id."'";
         //$dcu=db_query($conn,$delete2);
           // update priority
        $uppriority="update categories set priority=priority-1 where priority>$priority";
        db_query($conn,$uppriority);
     }
    //$deletem = "DELETE FROM categories where category_id='$delcategoryid'";
    echo $deletem = "update categories set='3' where category_id='$delcategoryid'";
    $dc=db_query($conn,$deletem);
    $qheaderMenu = "update header_menu set header_status='3' where category_id='$delcategoryid'";
    $dc=db_query($conn,$qheaderMenu);
    // this category id remove from entry table in categoryid column
    $updateeEntryTable="update entry set categoryid=TRIM(BOTH ',' FROM REPLACE(CONCAT(',',categoryid,',') , ',$delcategoryid,', ',')) where FIND_IN_SET($delcategoryid,categoryid)";
    $uEntry=db_query($conn,$updateeEntryTable);
     
     /*----------------------------update log file begin-------------------------------------------*/
     $error_level=1;$msg="delete Category($delcategoryid)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
     $qry=$delete1;
     write_log($error_level,$msg,$lusername,$qry);
  /*----------------------------update log file End---------------------------------------------*/ 
    $uppriority="update categories set priority=priority-1 where priority>$priorityParent";
    db_query($conn,$uppriority);
    //$delete_url = "DELETE FROM category_thumb_icon_url where category_id='$delcategoryid'";
    //$dcu=db_query($conn,$delete_url);
    $moveEntriesToParentCategory = KalturaNullableBoolean::NULL_VALUE;
    //$result = $client->category->delete($delcategoryid, $moveEntriesToParentCategory);
    ?>