<?php
include_once 'corefunction.php';
$action=(isset($_POST['action']))? $_POST['action']: "";
switch($action)
{
	case "add_new_channel":
        ?> 
        <div class="modal-body">
          <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" onclick="CloseModal('myModal_add_new_channel','view_modal_new_channel');">
                       <span aria-hidden="true">&times;</span>
                       <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                  <b>Add New Channel</b>
                </h4>
            </div>
        <br/>
       <div style=" border:1px solid #c7d1dd ;">
      <form class="form-horizontal" role="form" action="javascript:" method="post" name="form_save_live" id="form_save_live" onsubmit="return LiveAddChannel()">
      <div id="msg" style="text-align: center; margin-bottom: 10px; color:red;"> </div>
       <div class="form-group">
            <label for="channelname" class="control-label col-xs-4">Channel Name *:</label>
            <div class="col-xs-6">
                <input type="text" maxlength="35" class="form-control" id="channelname" name="channelname" placeholder="Channel Name" required>
            </div>
        </div>
        <div class="form-group">
            <label for="url" class="control-label col-xs-4">URL *:</label>
            <div class="col-xs-6">
                <input type="url" class="form-control"  maxlength="300" id="url" name="url" placeholder="live URL" required>
            </div> 
        </div>
      <div class="form-group">
        <label for="tags_1" class="control-label col-xs-4">Tags:</label>
        <div class="col-xs-6" id="drawTags">
            <span id="wait_loader_tags"></span>
        </div>
      </div> 
         <div class="form-group">
            <label for="description" class="control-label col-xs-4">Description:</label>
            <div class="col-xs-6">
            <textarea class="form-control" rows="1"  maxlength="300" id="description" name="description" placeholder="Description" ></textarea>
            </div> 
        </div>
     
    <!-- <div class="form-group">
    <div class="col-xs-offset-4 col-xs-8">
        <button type="button" class="btn btn-primary" onclick="return LiveAddChannel();" >Save & Close</button>
    </div>
      </div>-->
     <div class="modal-footer">
            <div class="pull-left col-sm-7" style="border:0px solid red;">
             <button type="submit" name="save" id="save_live" class="btn btn-primary" >Save</button>   
            </div>
            <div align="left" class="pull-right col-sm-5" style="border:0px solid red;">
               <span id="saving_loader"> </span>
            </div>
      </div>
  
    </form>   
	
         </div>
        <script type="text/javascript">
        drawTags();     
        function drawTags()
        {
            $("#wait_loader_tags").fadeIn(400).html('Loading... <img src="img/image_process.gif" />');
            var dataString ='action=tags_in_live_metaData';
            $.ajax({                                                                                                                                        
            type: "POST",
            url: "ajax_common.php",
            data: dataString,
            cache: false,
            success: function(result){
                $("#wait_loader_tags").hide();
                $("#drawTags").html(result);
             }
            });  
          }
         </script>  
	</div> 
      
        <?php   
        break;    
        case "edit_plan":
        $planid=$_POST['planid']; $pageindex=$_POST['pageindex']; $limitval=$_POST['limitval'];
        $query1="select planName,pValue,pduration,pdescription,planuniquename,currency from plandetail where planID='$planid'";
        $fetch= db_select($conn,$query1);
        $plan_name =$fetch[0]['planName']; $plan_duration =$fetch[0]['pduration'];  $plan_amount =$fetch[0]['pValue'];
        $plan_desc=$fetch[0]['pdescription']; $plantype=$fetch[0]['planuniquename']; $currency=$fetch[0]['currency'];
        
         ?>   
        <div class="modal-body">
         <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" onclick="CloseModal('LegalModal_modal_edit','edit_modal_plan');" >
         <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
         <h4 class="modal-title" id="myModalLabel"> <b>Edit Plan Details - <?php echo $planid; ?> </b></h4> 
         </div>
         <br/>
       <div style=" border:1px solid #c7d1dd ;">
	 <form class="form-horizontal" role="form" action="javascript:" method="post" onsubmit="return save_editPlan('<?php echo $planid; ?>','<?php echo $pageindex; ?>','<?php echo $limitval;  ?>')" id="editPlan" style="border: 0px solid red;">
          <span class="help-block has-error span12 text-center" id="error_msg-error" style="color:red;"></span>		 
             <div class="form-group" style=" margin-top: 12px;">
		      <label class="control-label col-sm-3">Plan Name *:</label>
		      <div class="col-sm-5">
                          <input type="text" maxlength="15"  class="form-control" id="plan_name"  name="plan_name" value="<?php echo $plan_name;  ?>" placeholder="Plan Name">
                          <span class="help-block has-error" id="plan_name-error" style="color:red;"></span>
		      </div>
		    </div>
             <div class="form-group">
                <label for="category_value" class="control-label col-xs-3">Currency:</label>
                <div class="col-xs-8">
                       <button type="button" class="btn btn-default" onclick="addRowCurrency()" id="addRowBtnCurrency" > <i class="glyphicon glyphicon-plus-sign"></i> Add Currency</button>
                   </div>
             </div>
            <div  style="border:0px solid red;" >   
            <table class="table" id="currencyTable" style="width:80%;">
            <tbody>
            <?php
            $arrayNumber = 0;
            $json_customdataCurrency  = json_decode($currency,true);
            $x=1;
            foreach($json_customdataCurrency as $currencyCode => $CurrencyPrice)
            { ?>
            <tr id="row<?php echo $x; ?>" class="<?php echo $arrayNumber; ?>">			  				
            <td style="margin-left:20px;">
            <select class="form-control" name="currency[]" id="currency<?php echo $x; ?>">
             <option value="">--Select Currency--</option>
              <?php
                    $currencySql = "Select name,currency,country_code from countries_currency where status='1' order by  name";
                    $data = db_select($conn,$currencySql);
                    foreach ($data as $row){
                    $country_code=$row['country_code'];
                    ?>
                      <option value="<?php echo $country_code;  ?>" <?php if($country_code==$currencyCode){ echo "selected";} ?> ><?php echo $row['name'];?> </option>
                <?php     
                    } 
              ?>
             </select>
             <span class="help-block has-error" id="currency<?php echo $x; ?>-error" style="color:red;"></span>   
             <td style="padding-left:20px;">
                  <input type="text" name="price[]"  id="price<?php echo $x; ?>" value="<?php echo $CurrencyPrice; ?>" placeholder="price" class="form-control"  />
                  <span class="help-block has-error" id="price<?php echo $x; ?>-error" style="color:red;"></span>
              </td>
              <td>
                <button class="btn btn-default removeProductRowBtn" disabled type="button" id="removeProductRowBtn" onclick="removeProductRow(<?php echo $x; ?>)"><i class="glyphicon glyphicon-trash"></i></button>
              </td>
             </tr>
                <?php
                $x++;
                $arrayNumber++;
                
                } // /for
                ?>
               </tbody>			  	
                 </table>
              </div>
          
          
		    <div class="form-group">
		      <label class="control-label col-sm-3">Plan Duration *:</label> 
		      <div class="col-sm-5">
                          <input type="text" class="form-control" maxlength="10"  name="plan_duration" id="plan_duration" value="<?php echo $plan_duration;  ?>" placeholder="Plan Duration"> 
		          <span class="help-block has-error" id="plan_duration-error" style="color:red;"></span>
                      </div>
		    </div>
		    <div class="form-group">
                      <label class="control-label col-sm-3">Plan Description:</label>
                         <div class="col-sm-5">
                             <textarea class="form-control" maxlength="50" placeholder="max. 50 characters" name="plan_desc" id="plan_desc"><?php echo $plan_desc; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
		      <label class="control-label col-sm-3">Plan Type*:</label> 
		      <div class="col-sm-5">
                          <select name="plantype" id="plantype"  style="width: 220px;"> 
                               <option value="">--Select Plan Type--</option>
                               <option value="f" <?php echo $plantype=='f'? 'selected': ''; ?> >Free</option>
                               <option value="p" <?php echo $plantype=='p'? 'selected': ''; ?>>Premium</option> 
                          </select> 
                         <span class="help-block has-error" id="plantype-error" style="color:red;"></span> 
		      </div>
		    </div>
                    <div class="modal-footer">
                      <div class="col-sm-offset-3 col-sm-4" style="right: 6%;">
                        <button type="submit" name="save_plan" id="save_plan" class="btn btn-primary" >Update Plan</button>
                       <span id="saving_loader"> </span>  
                      </div>
                      </div>
            </form>
         </div> 
        </div>    
        <script src="js/add_custom_row.js" type="text/javascript"></script>
        <?php 
        break;   
        case "subcription_detail_summary": 
        $orderid=(isset($_POST['orderid']))? $_POST['orderid']: "";
        $userid=(isset($_POST['userid']))? $_POST['userid']: "";
        $sql="SELECT upd.*,ur.uid,ur.uname
        FROM user_payment_details upd left join user_registration ur ON upd.userid=ur.uid where upd.userid='".$userid."' order by added_date DESC"  ;
        $que = db_select($conn,$sql);
        $countRow=  db_totalRow($conn,$sql);
        $uname=$que[0]['uname'];
       
       ?>   
        <div class="modal-body" style="min-height: 600px;">
          <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" onclick="CloseModal('myModal_show_subscription','view_modal_user_subscription');">
                       <span aria-hidden="true">&times;</span>
                       <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                  <b>Subscription Detail of <?php echo $uname ."(".$userid.")"; ?></b>
                </h4>
            </div>
        
<div>Total Subscription: <?php echo $countRow; ?></div>        
<style type="text/css"></style>
<div style=" border:1px solid #c7d1dd ;">
 
<div class="tbl-header">
        <table style="width:100%;" border='1'>
          <thead>
        <tr>
         <th width="5%">UserID</th>
          <th width="10%">UserName</th>
          <th width="10%">Order ID</th>
          <th>Transaction ID</th>
          <th>Plan Days</th>
          <th>Amount (INR)</th>
          <th>Payment Mode</th>
          <th>Order Date</th>
          <th>Expire Date</th>
          <th>Order Status</th>
         </tr>
         </thead>
        </table>
  </div>
    
<div style="width:100%; max-height:600px; overflow-x:scroll; overflow-y: scroll;">
   <table style="width:100%;">
    <?php
    foreach($que as $fetch)
    {
     $userid=$fetch['userid'];  $orderid=$fetch['orderid']; $trans_id=$fetch['trans_id']; $order_status=$fetch['order_status']; 
     $payment_mode=$fetch['payment_mode']; $status_code=$fetch['status_code']; $currency=$fetch['currency']; 
     $amount=$fetch['amount']; $plan_days=$fetch['plan_days']; $added_date=$fetch['added_date'];$expire_date=$fetch['expire_date'];
     $trans_date=$fetch['trans_date']; $added_date_new=$fetch['added_date_new'];
     $uname=$fetch['uname'];
     //$query = "SELECT userid FROM user_payment_details where userid='$userid'"; 
      //$total_subscription = db_totalRow($conn,$query);
    ?>   
     <tr>
     <td width="5%"><?php echo $userid; ?></td>
     <td width="10%"><?php echo $uname; ?></td>
     <td width="10%"><?php echo $orderid; ?></td>
     <td width=""><?php echo $trans_id; ?></td>
     <td width=""><?php echo $plan_days; ?></td>
     <td width=""><?php echo $amount; ?></td>
     <td width=""><?php echo $payment_mode; ?></td>
     <td width=""><?php echo $added_date_new; ?></td>
     <td width=""><?php echo $expire_date; ?></td>
     <td width=""><?php echo $order_status; ?></td>
     
     </tr>
    <?php } ?>
    </table>
   </div>
         </div>
	</div>
        <?php 
         break;
         case "create_currency":
         ?>
         <div class="modal-body">
          <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" onclick="CloseModal('myModal_add_new_plan','view_modal_new_plan');">
                       <span aria-hidden="true">&times;</span>
                       <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                  <b>Country Currency List</b>
                </h4>
            </div>
         <?php
         $sql="Select * from countries_currency order by  name ";
         $que = db_select($conn,$sql);
         $countRow=  db_totalRow($conn,$sql);
         //ccid,name,country_code,currency,status,symbol_native
         ?>    
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                      <th>Currency Name</th>
                      <th>Country Code</th>
                      <th>Currency</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                   <?php 
                   foreach($que as $fetch)
                   {
                    $ccid=$fetch['ccid'];  $name=$fetch['name']; $country_code=$fetch['country_code']; 
                    $status_cc=$fetch['status']; $currency=$fetch['currency']; 
                    $status=$status_cc==1? "<span class='label label-success'>active</span>": "<span class='label label-danger'>inactive</span>";
                    ?>
                    <tr>
                      <td><?php echo $name; ?></td>
                      <td><?php echo $country_code; ?></td>
                      <td><?php echo $currency; ?></td>
                      <td id="getstatus<?php  echo $ccid; ?>"><?php echo $status; ?></td>
                      <td>
                      <input type="hidden" size="2" id="act_deact_status_country<?php echo $ccid;  ?>" value="<?php echo $status_cc; ?>" > 
                      <a href="javascript:void(0)">
                       <i id="icon_status<?php echo $ccid; ?>" class="status-icon fa <?php  echo ($status_cc == 1) ? 'fa-check-square-o':'fa-ban';?>" onclick="act_dect_country_currency('<?php echo $ccid; ?>')" ></i>
                      </a>
                      </td>
                    </tr>
                   <?php } ?>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
          </div>
	</div> 
        <script type="text/javascript">
        function act_dect_country_currency(ccid){
                var cc_status=document.getElementById('act_deact_status_country'+ccid).value;
                var msg = (cc_status == 1) ? "inactive":"active";
                var c=confirm("Are you sure you want to "+msg+ " This?")
                if(c)
                {	
                 $.ajax({
                   type: "POST",
                   url: "core_active_deactive.php",
                   data:'ccid='+ccid+'&cc_status='+cc_status+'&action=country_currency',
                   success: function(reslide){
                          if(reslide==0)
                           { 
                             var img_status=document.getElementById('getstatus'+ccid).innerHTML="<span class='label label-danger'>inactive</span>";
                             $('#icon_status'+ccid).removeClass('fa-check-square-o').addClass('fa-ban');
                           }
                           if(reslide==1)
                           {
                                var img_status=document.getElementById('getstatus'+ccid).innerHTML="<span class='label label-success'>active</span>";
                                $('#icon_status'+ccid).removeClass('fa-ban').addClass('fa-check-square-o');
                           }
                           $('#act_deact_status_country'+ccid).val(reslide);
                     }

                   });
                 }  

                }

        
         <?php    
         break;  
         case "get_currency":
         $sql="Select * from countries_currency where status='1' order by  name ";
         $data = db_select($conn,$sql);
         echo json_encode($data); 
        break;  
        }
?>
