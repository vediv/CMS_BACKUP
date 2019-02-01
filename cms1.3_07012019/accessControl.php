<?php
include_once 'corefunction.php';
$Entryid=$_POST['Entryid']; $getpageindex=$_POST['pageindex'];
$limitval=$_POST['limitval']; $searchInputall=$_POST['searchInputall'];
$selEntry="select country_data from entry where entryid='$Entryid'";
$f= db_select($conn,$selEntry);
$country_data=$f[0]['country_data'];
$textMsg='Anywhere';
if($country_data=='0'){   $textMsg='Allow Anywhere';  $disabled='disabled'; $country_allow_block=0; }
if($country_data=='1'){ $textMsg='Block from all countries'; $disabled='disabled'; $country_allow_block=1; }
if($country_data!='0' and $country_data!='1'){  $textMsg='Restricted Countries';$disabled=''; $country_allow_block='block'; }
?>
<div style="border: 1px solid #c7d1dd ; border-top: 0px; min-height:400px; padding:20px 0px 20px 4px">
<form method="post" id="formAccessControl" name="formAccessControl">   
<div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Authorized Countries - From where viewers can view </h3>
                  <div class="form-group">
                      <div class="radio">
                        <label>
                            <input type="radio" <?php if($country_data=='0'){ echo "checked"; }else{ echo "checked";} ?> name="countryaccess" id="countryaccess"   value="0"  onclick="getcountryAccess('0');">
                         Allow Everywhere
                        </label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="countryaccess" <?php if($country_data=='1'){ echo "checked"; } ?> id="countryaccess" value="1" onclick="getcountryAccess('1')";>
                          Block the video from all countries
                        </label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="countryaccess" id="countryaccess" <?php if($country_data!='1' and $country_data!='0'){ echo "checked"; } ?>  value="block" onclick="getcountryAccess('block');" />
                          Block the video from the following countries
                        </label>
                      </div>
                    </div>
                </div><!-- /.box-header -->
                <div class="">
                <table style='width:100%' border="1">
                    <tr>
                    <td width="45%">
                     <b>Countries List:</b><br/>
                     <div class="" id="drawCountryCode"> 
                     <span id="wait_loader_country"></span>   
                     </div>
                     </td>
                    <td style='width:8%;text-align:center;vertical-align:middle;'>
                        <input type='button' id='btnRight' class="test_button" value ='  >  ' onclick="return addOption(document.formAccessControl.SelectList,document.formAccessControl.countrylist,document.formAccessControl.country_name_code, true)"/>
                        <br/><input type='button' id='btnLeft' value ='  <  ' onclick="return addOption(document.formAccessControl.SelectList,document.formAccessControl.countrylist,document.formAccessControl.country_name_code, false)"/>
                    </td>
                    <td width="45%">
                        <b><span id="countryAcess"><?php echo $textMsg; ?></span>
                         <input type="hidden" value="<?php echo $country_allow_block; ?>" id="country_allow_block" ></b><br/>
                        <?php
                        if($country_data!='0' && $country_data!='1'){ 
                             $country_data_expload=explode(",", $country_data);
                            ?>
                         <select multiple="multiple" name="countrylist[]" id='countrylist' size="8" style="width: 100%; height:200px;" <?php echo $disabled; ?>>
                          <?php  include_once('countries.php');
                          foreach ($countries as $key => $value) {
                                   if (in_array($key, $country_data_expload)){
                              ?>
                          <option value="<?php echo $key;?>"  ><?php echo $value." (".$key.")" ?></option>
                          <?php } }  ?>
                         </select>
                       <?php 
                        }else {
                        ?>
                         <select multiple="multiple" name="countrylist[]" id='countrylist' size="8" style="width: 100%; height:200px;" <?php echo $disabled; ?>>
                         </select>
                        <?php } ?>
                      
                    </td>
                    <?php
                    if($country_data!='0' && $country_data!='1'){  
                     ?>
                    <input name="country_name_code"  type="hidden"  size="20" id="country_name_code" value="<?php echo $country_data; ?>" />
                    <?php } else { ?>
                    <input name="country_name_code"  type="hidden" size="20"   id="country_name_code" value="" />
                    <?php } ?>
                </tr>
             </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
          </div>
        <div class="modal-footer">
            <div class="col-sm-offset-3 col-sm-4" style="right: 6%;">
            <?php $disabled_button = (in_array(2, $UserRight) ? "" : "disabled"); ?>
            <button type="button" name="save_access" <?php echo $disabled_button; ?>  id="save_country" class="btn btn-primary" onclick="save_access_metdata('save_access_metadata','<?php echo $Entryid; ?>','<?php echo $getpageindex;  ?>','<?php echo $limitval;  ?>');" >Save</button>
            <span id="saving_loader"> </span>  
         </div>
        </div>
        </form>
     
</div>
<script type="text/javascript">
var entryid="<?php echo $Entryid; ?>" ;
drawCountry(entryid);
function drawCountry(entryid)
{
    $("#wait_loader_country").fadeIn(400).html('Loading... <img src="img/image_process.gif" />');
    var dataString ='action=countryCode_in_metaData&entryid='+entryid;
    $.ajax({                                                                                                                                        
    type: "POST",
    url: "ajax_common.php",
    data: dataString,
    cache: false,
    success: function(r){
     $("#wait_loader_country").hide(); 
     $("#drawCountryCode").html(r); 
    //$('#save_button').attr('disabled',false);
    }
      
    });  
}    
function getcountryAccess(type)
{
    
     $('#country_allow_block').val(type)
     if(type=='0'){ var text='Allow Everywhere'; }
     if(type=='1'){ var text='Block from all countries'; }
     if(type=='block'){ var text='Restricted Countries'; }
     $('#countryAcess').html(text);
     if(type=='0'){  $('#SelectList').attr('disabled',true);$('#countrylist').attr('disabled',true); }
     if(type=='1'){  $('#SelectList').attr('disabled',true);$('#countrylist').attr('disabled',true); }
     if(type=='block'){ $('#SelectList').attr('disabled',false);$('#countrylist').attr('disabled',false);}
     
}
 
function addOption(SS1,SS2,updateField,adding)
{
    var SelID='';    var SelText='';	var from='';	var to='';	var projectType = '';
    if (adding) { from = SS1; to = SS2;	} 
    else { from = SS2; to = SS1;}	
    var j=0;
    // Move rows from SS1 to SS2 from bottom to top
    for (i=from.options.length - 1; i>=0; i--)
    {
        if (from.options[i].selected == true)
        {
            SelID=from.options[i].value;
            SelText=from.options[i].text;
	    var newRow = new Option(SelText,SelID);
            to.options[to.length]=newRow;
			from.options[i]=null;
			j++;
        }		
    }
    for (i=0; i<SS2.options.length; i++) { 
		if (i) projectType = projectType + ',';
		projectType = projectType + SS2.options[i].value;
    }
    updateField.value = projectType;
}
var searchInputall="<?php echo $searchInputall ?>"; 
function save_access_metdata(smatadata,entryid,pageindex,limitval){
var countrylist = $('#lstBox2').val();
var typ=$('#country_allow_block').val();
if(typ=='0'){ var text_msg='allowed Countries'; }
if(typ=='1'){ var text_msg='restricted Countries'; }
if(typ!='0' && typ!='1'){
var country_name_code =$('#country_name_code').val();
   if(country_name_code=='' || country_name_code==null)
       {    
            var text_msg='Countries';
            alert("please select "+ text_msg +" from country list");
            return false;
       }
    }      
     $("#saving_loader").fadeIn(400).html('Saving... <img src="img/image_process.gif" />');
     $('#save_country').attr('disabled',true);
     $.ajax({
      method : 'POST',
      url : 'media_paging.php',
      data : $('#formAccessControl').serialize() +
              "&entryid="+entryid+"&maction="+smatadata
              +"&pageindex="+pageindex+"&limitval="+limitval+"&searchInputall="+searchInputall,
      success: function(jsonResult){
            $("#saving_loader").hide(); 
            $('#myModalVodEdit').modal('hide');
            $("#results").html(jsonResult);
            $("#msg").html("access control saved successfully"); 
        }
      });  
  
}

</script>

                 
