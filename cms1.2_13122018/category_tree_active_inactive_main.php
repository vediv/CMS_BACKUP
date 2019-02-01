<?php
include_once 'corefunction.php';
$act=$_POST['action'];
switch($act)
{
     case "active_inactive_category":
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Category Active/Inactive</h4>
</div>
<div class="modal-body" >
    <form class="form-horizontal" method="post" action="#">    
<div class="box">
    
<h3>Category List</h3>
<div id="load_in_modal" style="display:none; text-align: center !important;"></div>
<div class="box-body"  id="result_category_list" style="background-color: lightgrey;" >

</div>    
</div> 
<?php if(in_array(2, $UserRight)){ ?>   
    <button type="submit" name="save_priority" data-dismiss="modal2"  class="btn btn-primary center-block">Save Priority</button>
<?php } else { ?>
<button type="submit" disabled name="save_priority" data-dismiss="modal2" class="btn btn-primary center-block">Changes Priority</button>
<?php } ?> 

</form>
</div>
<?php break;   
         
} ?>
<script src="js/jquery.slimscroll.min.js" type="text/javascript"></script>  
<script type="text/javascript">
$(function(){
    $('#inner-content-div').slimScroll({
    	 height: '400px',
    	// width:  '352px',
    	  size: '8px', 
    	 //color: '#f5f5f5'
    });
});
$(document).on('click', '.tree label', function(e) {
  $(this).next('ul').fadeToggle();
  e.stopPropagation();
});

$(document).on('change', '.tree input[type=checkbox]', function(e) {
  $(this).siblings('ul').find("input[type='checkbox']").prop('checked', this.checked);
  $(this).parentsUntil('.tree').children("input[type='checkbox']").prop('checked', this.checked);
  e.stopPropagation();
});
getAllgategoryTree('0');
function getAllgategoryTree(catparentid)
{
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
                var chtml='';
                chtml+='<ul class="tree">';
                var catLen=r.items.length;
                var data=r.items;
                for(var i=0;i<catLen;i++)
                {
                   var pcatid=data[i].category_id;
                   alert(pcatid);
                   var cat_name=data[i].cat_name;
                   chtml+='<li class="has">';
                   chtml+='<input type="checkbox" name="domain[]" value="'+pcatid+'">';
                   chtml+=' <label>' +cat_name+' <span class="total"></span></label>';
                   var pchildrenLen=data[i].children_data.length;
                    if(pchildrenLen > 0)
                    {
                       chtml+='<ul>';
                       for(var j=0;j<pchildrenLen;j++)
                       {
                          var ch1_id=data[i].children_data[j].category_id;
                          var ch1_cat_name=data[i].children_data[j].cat_name;
                          chtml+='<li class="">';
                          chtml+='<input type="checkbox" name="subdomain[]" value="'+ch1_id+'">';
                          chtml+='<label>'+ch1_cat_name+' </label>';
                          chtml+='</li>';  

                       }
                       chtml+='</ul>';
                    }
                   chtml+='</li>';
                }
                chtml+='</ul>';   
                
                $('#load_in_modal').hide();
                $('#result_category_list').css("opacity",1);
           	$("#result_category_list").html(chtml);
           }
      });
}


</script>


