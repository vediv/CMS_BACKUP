<?php
include_once 'corefunction.php';
$act=$_POST['action'];
switch($act)
{
     case "active_inactive_category":
?>
<style>

* { margin: 0; padding: 0; }

#page-wrap {
  margin: auto 0;
}

.treeview {
  margin: 10px 0 0 20px;
}

ul { 
  list-style: none;
}

.treeview li {
  background: url(http://jquery.bassistance.de/treeview/images/treeview-default-line.gif) 0 0 no-repeat;
  padding: 2px 0 2px 16px;
}

.treeview > li:first-child > label {
  /* style for the root element - IE8 supports :first-child
  but not :last-child ..... */
  
}

.treeview li.last {
  background-position: 0 -1766px;
}

.treeview li > input {
  height: 16px;
  width: 16px;
  /* hide the inputs but keep them in the layout with events (use opacity) */
  opacity: 0;
  filter: alpha(opacity=0); /* internet explorer */ 
  -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(opacity=0)"; /*IE8*/
}

.treeview li > label {
  background: url(https://www.thecssninja.com/demo/css_custom-forms/gr_custom-inputs.png) 0 -1px no-repeat;
  /* move left to cover the original checkbox area */
  margin-left: -20px;
  /* pad the text to make room for image */
  padding-left: 20px;
}

/* Unchecked styles */

.treeview .custom-unchecked {
  background-position: 0 -1px;
}
.treeview .custom-unchecked:hover {
  background-position: 0 -21px;
}

/* Checked styles */

.treeview .custom-checked { 
  background-position: 0 -81px;
}
.treeview .custom-checked:hover { 
  background-position: 0 -101px; 
}

/* Indeterminate styles */

.treeview .custom-indeterminate { 
  background-position: 0 -141px; 
}
.treeview .custom-indeterminate:hover { 
  background-position: 0 -121px; 
}
</style>
<div class="modal-header" style=" background-color: #0480be; color: white;">
    <button type="button" class="close" data-dismiss="modal"  style="color: black !important;">&times;</button>
          <h4 class="modal-title"><i><b>Category Active/Inactive</b></i></h4>
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
    $('#result_category_list').slimScroll({
    	 height: '400px',
    	// width:  '352px',
    	  size: '8px'
    	 //color: '#f5f5f5'
    });
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
                chtml+='<ul class="treeview" style="list-style-type:none">';
                var catLen=r.items.length;
                var data=r.items;
                 for(var i=0;i<catLen;i++)
                {
                   var pcatid=data[i].category_id;
                   var cat_name=data[i].cat_name;
                   var pchildrenLen=data[i].children_data.length;
                   var child_data=data[i].children_data;
                   chtml+='<li class="has" style="list-style-type:none">';
                   chtml+='<input   type="checkbox" name="categories[]" value="'+pcatid+'">';  
                   chtml+=' <label>' +cat_name+' <span class="total"></span></label>';
                    if((pchildrenLen > 0)&& (child_data != '0'))
                    {
                       chtml+='<ul style="list-style-type:none">';
                       for(var j=0;j<pchildrenLen;j++)
                       {
                          var ch1_id=data[i].children_data[j].category_id;
                          var ch1_cat_name=data[i].children_data[j].cat_name;
                          chtml+='<li class="" style="list-style-type:none">';
                          chtml+='<input  type="checkbox" name="categories[]" value="'+ch1_id+'">';
                          chtml+='<label>'+ch1_cat_name+' </label>';
                           var pchildrenLen1=data[i].children_data[j].children_data.length;
                           var child_data1=data[i].children_data[j].children_data;
                           if((pchildrenLen1 > 0)&& (child_data1 != '0'))
                           {
                                chtml+='<ul style="list-style-type:none">';
                                  for(var k=0;k<pchildrenLen1;k++)
                                  {
                                      var ch2_id=data[i].children_data[j].children_data[k].category_id;
                                      var ch2_cat_name=data[i].children_data[j].children_data[k].cat_name;
                                      chtml+='<li class="" style="list-style-type:none">';
                                      chtml+='<input  type="checkbox" name="categories[]" value="'+ch2_id+'">';
                                      chtml+='<label>'+ch2_cat_name+' </label>';
                                       var pchildrenLen2=data[i].children_data[j].children_data[k].children_data.length;
                                  var child_data2=data[i].children_data[j].children_data[k].children_data;
                                    if((pchildrenLen2 > 0)&& (child_data2 != '0'))
                           {
                                chtml+='<ul style="list-style-type:none">';
                                  for(var l=0;l<pchildrenLen2;l++)
                                  {
                                      var ch3_id=data[i].children_data[j].children_data[k].children_data[l].category_id;
                                      var ch3_cat_name=data[i].children_data[j].children_data[k].children_data[l].cat_name; 
                                      chtml+='<li class="" style="list-style-type:none">';
                                      chtml+='<input  type="checkbox" name="categories[]" value="'+ch3_id+'">';
                                      chtml+='<label>'+ch3_cat_name+' </label>';
                                        var pchildrenLen3=data[i].children_data[j].children_data[k].children_data[l].children_data.length;
                                  var child_data3=data[i].children_data[j].children_data[k].children_data[l].children_data;
                                    if((pchildrenLen3 > 0)&& (child_data3 != '0'))
                           {
                                chtml+='<ul style="list-style-type:none">';
                                  for(var m=0;m<pchildrenLen3;m++)
                                  {
                                      var ch4_id=data[i].children_data[j].children_data[k].children_data[l].children_data[m].category_id;
                                      var ch4_cat_name=data[i].children_data[j].children_data[k].children_data[l].children_data[m].cat_name; 
                                      chtml+='<li class="" style="list-style-type:none">';
                                      chtml+='<input  type="checkbox" name="categories[]" value="'+ch4_id+'">';
                                      chtml+='<label>'+ch4_cat_name+' </label>';
                                      chtml+='</li>';  
                                  }
                                  chtml+='</ul>';
                            }
                                      chtml+='</li>';  
                                  }
                                  chtml+='</ul>';
                            }
                                      chtml+='</li>';  
                                  }
                                  chtml+='</ul>';
                            }
                          chtml+='</li>';  

                       }
                       chtml+='</ul>';
                           }chtml+='</li>';
                }
                chtml+='</ul>';   
                $(function() {

  $('input[type="checkbox"]').change(checkboxChanged);

  function checkboxChanged() {
    var $this = $(this),
        checked = $this.prop("checked"),
        container = $this.parent(),
        siblings = container.siblings();

    container.find('input[type="checkbox"]')
    .prop({
        indeterminate: false,
        checked: checked
    })
    .siblings('label')
    .removeClass('custom-checked custom-unchecked custom-indeterminate')
    .addClass(checked ? 'custom-checked' : 'custom-unchecked');

    checkSiblings(container, checked);
  }

  function checkSiblings($el, checked) {
    var parent = $el.parent().parent(),
        all = true,
        indeterminate = false;

    $el.siblings().each(function() {
      return all = ($(this).children('input[type="checkbox"]').prop("checked") === checked);
    });

    if (all && checked) {
      parent.children('input[type="checkbox"]')
      .prop({
          indeterminate: false,
          checked: checked
      })
      .siblings('label')
      .removeClass('custom-checked custom-unchecked custom-indeterminate')
      .addClass(checked ? 'custom-checked' : 'custom-unchecked');

      checkSiblings(parent, checked);
    } 
    else if (all && !checked) {
      indeterminate = parent.find('input[type="checkbox"]:checked').length > 1;

      parent.children('input[type="checkbox"]')
      .prop("checked", checked)
      .prop("indeterminate", indeterminate)
      .siblings('label')
      .removeClass('custom-checked custom-unchecked custom-indeterminate')
      .addClass(indeterminate ? 'custom-indeterminate' : (checked ? 'custom-checked' : 'custom-unchecked'));

      checkSiblings(parent, checked);
    } 
    else {
      $el.parents("li").children('input[type="checkbox"]')
      .prop({
          indeterminate: true,
          checked: false
      })
      .siblings('label')
      .removeClass('custom-checked custom-unchecked custom-indeterminate')
      .addClass('custom-indeterminate');
    }
  }
});
                
                $('#load_in_modal').hide();
                $('#result_category_list').css("opacity",1);
           	$("#result_category_list").html(chtml);
           }
      });
}


</script>


