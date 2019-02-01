<?php
include_once 'corefunction.php';
$action=(isset($_POST['action']))? $_POST['action']: "";
switch($action)
{
	case "add_new_plan":
        ?>
        <div class="modal-body">
          <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" onclick="CloseModal('myModal_add_new_plan','view_modal_new_plan');">
                       <span aria-hidden="true">&times;</span>
                       <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                  <b>Create Plan</b>
                </h4>
            </div>
        <br/>
       <div style=" border:1px solid #c7d1dd ;">
	 <form class="form-horizontal" role="form" action="javascript:" method="post" onsubmit="return save_new_plan()" id="addNewPlan" style="border: 0px solid red;">
          <span class="help-block has-error span12 text-center" id="error_msg-error" style="color:red;"></span>

                    <div class="form-group" style=" margin-top: 12px;">
		      <label class="control-label col-sm-3">Plan Name* :</label>
		      <div class="col-sm-7">
                          <input type="text" maxlength="15"  class="form-control" id="plan_name"  name="plan_name" placeholder="Plan Name">
                          <span class="help-block has-error" id="plan_name-error" style="color:red;"></span>
		      </div>
		    </div>
                    <!--<div class="form-group">
		      <label class="control-label col-sm-3">Country* :</label>
                      <div class="col-sm-5" id="countryName">
                          <span id="wait_loader_category"></span>

                      </div>
                      <span id="showCurrency"></span>
		    </div>-->
    <?php
    $sql="Select name,currency,country_code from countries_currency where status='1' order by  name ";
    $TotalCurrencyCountry = db_totalRow($conn,$sql);
    $data = db_select($conn,$sql);
    ?>
    <div class="form-group">
    <label for="category_value" class="control-label col-xs-3">Country :</label>
    <!--<div class="col-xs-8">
           <button type="button" class="btn btn-default" onclick="addRowCurrency('<?php echo $TotalCurrencyCountry; ?>')" id="addRowBtnCurrency" > <i class="glyphicon glyphicon-plus-sign"></i> Add Currency</button>
       </div>-->
    <div class="col-md-8">

        <table class="table" id="currencyTable" style="width:87%;">
        <tr><th>Currency</th><th>Price</th></tr>
    <tbody>
    <?php
    $arrayNumber = 0;
    $x = 1;
    if($TotalCurrencyCountry>0){
    foreach ($data as $fdata)
    {
    ?>
    <tr id="row<?php echo $x; ?>" class="<?php echo $arrayNumber; ?>">
    <td style="margin-left:20px;">
     <input type="hidden" name="currency[]"  id="currency<?php echo $x; ?>" readonly  placeholder="price" class="form-control" value="<?php echo $fdata['country_code']; ?>"   />
     <input type="text" readonly  placeholder="currency" class="form-control" value="<?php echo $fdata['name']; ?>"   />
     <span class="help-block has-error" id="currency<?php echo $x; ?>-error" style="color:red;"></span>
     <td style="padding-left:20px;">
     <input type="text" name="price[]"  id="price<?php echo $x; ?>"  placeholder="price" class="form-control"  />
     <span class="help-block has-error" id="price<?php echo $x; ?>-error" style="color:red;"></span>
     </td>
     <td>
     <button class="btn btn-default removeProductRowBtn" disabled type="button" id="removeProductRowBtn" onclick="removeProductRow(<?php echo $x; ?>)"><i class="glyphicon glyphicon-trash"></i></button>
     </td>
     </tr>
        <?php
        $x++;
         }
       }
        ?>
       </tbody>
       </table>
    </div>

    </div>
<div class="form-group">
  <label class="control-label col-sm-3">Plan Duration* :</label>
  <div class="col-sm-7">
      <input type="text" class="form-control" maxlength="10"  name="plan_duration" id="plan_duration" placeholder="Plan Duration">
      <span class="help-block has-error" id="plan_duration-error" style="color:red;"></span>
  </div>-Days.
</div>

<div class="form-group">
  <label class="control-label col-sm-3"> Plan Description:</label>
     <div class="col-sm-7">
         <textarea class="form-control" maxlength="50" style="resize: none; width:100%;" placeholder="max. 50 characters" size="100" name="plan_desc" id="plan_desc"></textarea>
    </div>
</div>
<div class="form-group">
  <label class="control-label col-sm-3">Content Type*:</label>
  <div class="col-sm-2">
      <select name="plantype" id="plantype"  style="width:330px;">
           <option value="">--Select Content Type--</option>
           <option value="f">Free</option>
           <option value="p">Premium</option>
      </select>
     <span class="help-block has-error" id="plantype-error" style="color:red;"></span>
  </div>
</div>
<div class="form-group">
 <label class="control-label col-sm-3">Used For:</label>
  <div class="col-sm-2">
      <select name="plan_used_for" id="plantype"  style="width:330px;">
           <option value="p">Plan</option>
           <?php  if(in_array(52, $getAllMenus)){ ?>  <option value="s">Subscription Code</option> <?php } ?>
					 <?php  if(in_array(40, $otherPermission)){ ?>  <option value="w">Web Series</option> <?php } ?>
      </select>
     <!--<span class="help-block has-error" id="plantype-error" style="color:red;"></span>-->
  </div>
</div>


<div class="modal-footer">
  <div class="col-sm-offset-3 col-sm-4" style="right: 6%;">
      <button type="submit" name="save_plan" id="save_plan" class="btn btn-primary" >Save Plan</button>
      <span id="saving_loader"> </span>
  </div>
  </div>
            </form>
         </div>
	</div>
        <script src="js/add_custom_row.js" type="text/javascript"></script>
<?php
break;
case "edit_plan":
$planid=$_POST['planid']; $pageindex=$_POST['pageindex']; $limitval=$_POST['limitval'];
$query1="select planName,pValue,pduration,pdescription,planuniquename,currency,plan_used_for from plandetail where planID='$planid'";
$fetch= db_select($conn,$query1);
$plan_name =$fetch[0]['planName']; $plan_duration =$fetch[0]['pduration'];  $plan_amount =$fetch[0]['pValue'];
$plan_desc=$fetch[0]['pdescription']; $plantype=$fetch[0]['planuniquename']; $currency=$fetch[0]['currency'];
$plan_used_for=$fetch[0]['plan_used_for'];
$json_customdataCurrency  = json_decode($currency,true);
$sql="Select name,currency,country_code from countries_currency where status='1'";
$TotalCurrencyCountry = db_totalRow($conn,$sql);
$data = db_select($conn,$sql);
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
               <div class="col-sm-8">
                   <input type="text" maxlength="15"  class="form-control" id="plan_name"  name="plan_name" value="<?php echo $plan_name;  ?>" placeholder="Plan Name">
                   <span class="help-block has-error" id="plan_name-error" style="color:red;"></span>
               </div>
             </div>
          <div class="form-group">
    <label for="category_value" class="control-label col-xs-3">Country :</label>
    <!--<div class="col-xs-8">
           <button type="button" class="btn btn-default" onclick="addRowCurrency('<?php echo $TotalCurrencyCountry; ?>')" id="addRowBtnCurrency" > <i class="glyphicon glyphicon-plus-sign"></i> Add Currency</button>
       </div>-->
    <div class="col-md-8">
        <table class="table" id="currencyTable" style="width:100%;">
        <tr><th>Currency</th><th>Price</th></tr>
    <tbody>
    <?php
    $arrayNumber = 0;
    $x = 1;
    if($TotalCurrencyCountry>0){
    foreach($json_customdataCurrency as $currencyCode => $CurrencyPrice)
    {
        $sqlGet="Select name,currency,country_code from countries_currency where status='1' and country_code='$currencyCode'";
        $dataGet = db_select($conn,$sqlGet);
        $cname=$dataGet[0]['name'];
    ?>
    <tr id="row<?php echo $x; ?>" class="<?php echo $arrayNumber; ?>">
    <td style="margin-left:20px;">
     <input type="hidden" name="currency[]"  id="currency<?php echo $x; ?>" readonly  placeholder="price" class="form-control" value="<?php echo $currencyCode; ?>"   />
     <input type="text" readonly  placeholder="currency" class="form-control" value="<?php echo $cname; ?>"   />
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
         }
       }
        ?>
       </tbody>
       </table>
    </div>

    </div>


            <div class="form-group">
               <label class="control-label col-sm-3">Plan Duration *:</label>
               <div class="col-sm-7">
                   <input type="text" class="form-control" maxlength="10"  name="plan_duration" id="plan_duration" value="<?php echo $plan_duration;  ?>" placeholder="Plan Duration">
                   <span class="help-block has-error" id="plan_duration-error" style="color:red;"></span>
               </div>-Days
             </div>
             <div class="form-group">
               <label class="control-label col-sm-3">Plan Description:</label>
                  <div class="col-sm-8">
                      <textarea class="form-control" style="resize: none; width:100%;" maxlength="50" placeholder="max. 50 characters" name="plan_desc" size="100" id="plan_desc"><?php echo $plan_desc; ?></textarea>
                 </div>
             </div>
             <div class="form-group">
               <label class="control-label col-sm-3">Content Type*:</label>
               <div class="col-sm-5">
                   <select name="plantype" id="plantype"  style="width: 370px;">
                        <option value="">--Select Content Type--</option>
                        <option value="f" <?php echo $plantype=='f'? 'selected': ''; ?> >Free</option>
                        <option value="p" <?php echo $plantype=='p'? 'selected': ''; ?>>Premium</option>
                   </select>
                  <span class="help-block has-error" id="plantype-error" style="color:red;"></span>
               </div>
             </div>
             <div class="form-group">
                <label class="control-label col-sm-3">Used For:</label>
                 <div class="col-sm-2">
                     <select name="plan_used_for" id="plantype"  style="width:370px;">
                          <option value="p" <?php echo $plan_used_for=='p'? 'selected': ''; ?> >Plan</option>
													 <?php  if(in_array(52, $getAllMenus)){ ?><option value="s" <?php echo $plan_used_for=='s'? 'selected': ''; ?> >Subscription Code</option> <?php } ?>
														<?php  if(in_array(40, $otherPermission)){ ?><option value="w" <?php echo $plan_used_for=='s'? 'selected': ''; ?> >Web Series</option> <?php } ?>

										   </select>
                    <!--<span class="help-block has-error" id="plantype-error" style="color:red;"></span>-->
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
                      <!--<th>Action</th>-->
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
                      <!--<a href="javascript:void(0)">
                       <i id="icon_status<?php echo $ccid; ?>" class="status-icon fa <?php  echo ($status_cc == 1) ? 'fa-check-square-o':'fa-ban';?>" onclick="act_dect_country_currency('<?php echo $ccid; ?>')" ></i>
                      </a>-->
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
        </script>
         <?php
         break;
         case "get_currency":
         $sql="Select * from countries_currency where status='1' order by  name ";
         $data = db_select($conn,$sql);
         echo json_encode($data);
         break;
         case "addNewPrice":
            $planid=$_POST['planid']; $pageindex=$_POST['pageindex']; $limitval=$_POST['limitval'];
            $query1="select planName,pValue,pduration,pdescription,planuniquename,currency from plandetail where planID='$planid'";
            $fetch= db_select($conn,$query1);
            $plan_name =$fetch[0]['planName']; $plan_duration =$fetch[0]['pduration'];  $plan_amount =$fetch[0]['pValue'];
            $plan_desc=$fetch[0]['pdescription']; $plantype=$fetch[0]['planuniquename']; $currency=$fetch[0]['currency'];
            $sql="Select name,currency,country_code from countries_currency where status='1'";
            $TotalCurrencyCountry = db_totalRow($conn,$sql);
            ?>
           <div class="modal-body">
         <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" onclick="CloseModal('LegalModal_modal_edit','edit_modal_plan');" >
         <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
         <h4 class="modal-title" id="myModalLabel"> <b>Add New Price - <?php echo $planid; ?> </b></h4>
         </div>
         <br/>
       <div style=" border:1px solid #c7d1dd ;">
	 <form class="form-horizontal" role="form" action="javascript:" method="post" onsubmit="return save_NewPrice('<?php echo $planid; ?>','<?php echo $pageindex; ?>','<?php echo $limitval;  ?>')" id="saveNewPrice" style="border: 0px solid red;">
          <span class="help-block has-error span12 text-center" id="error_msg-error" style="color:red;"></span>
            <div  style="border:0px solid red;" >
            <table class="table" id="currencyTable" style="width:100%;">
            <tr>
            <th>Currency</th><th>Old Price</th><th>New Price</th>
            </tr>
            <tbody>
            <?php
            $arrayNumber = 0;
            $json_customdataCurrency  = json_decode($currency,true);
            $x=1;
            if($currency!=''){
            foreach($json_customdataCurrency as $currencyCode => $CurrencyPrice)
            {
                $sqlGet="Select name,currency,country_code from countries_currency where status='1' and country_code='$currencyCode'";
                $dataGet = db_select($conn,$sqlGet);
                $cname=$dataGet[0]['name'];
            ?>
            <tr id="row<?php echo $x; ?>" class="<?php echo $arrayNumber; ?>">
            <td style="margin-left:20px;">
            <input type="hidden" name="currency[]"  id="currency<?php echo $x; ?>" readonly  placeholder="price" class="form-control" value="<?php echo $currencyCode; ?>"   />
            <input type="text" readonly  placeholder="currency" class="form-control" value="<?php echo $cname; ?>"   />
             <span class="help-block has-error" id="currency<?php echo $x; ?>-error" style="color:red;"></span>
             <td style="padding-left:20px;">
                  <input type="text" name="price[]"  id="price<?php echo $x; ?>" value="<?php echo $CurrencyPrice; ?>" placeholder="price" readonly class="form-control"  />
                  <span class="help-block has-error" id="price<?php echo $x; ?>-error" style="color:red;"></span>
              </td>
             <td style="padding-left:20px;">
                  <input type="text" name="newprice[]"  id="newprice<?php echo $x; ?>"  placeholder="new price" class="form-control"  />
                  <span class="help-block has-error" id="newprice<?php echo $x; ?>-error" style="color:red;"></span>
              </td>

             </tr>
                <?php
                $x++;
                $arrayNumber++;
              }
                } // /for
                ?>
               </tbody>
                 </table>
              </div>
                    <div class="modal-footer">
                      <div class="col-sm-offset-3 col-sm-5" style="right: 6%;">
                        <button type="submit" name="saveNewPrice" id="save_new_price" class="btn btn-primary" >Set New Price</button>
                       <span id="saving_loader"> </span>
                      </div>
                      </div>
            </form>
         </div>
        </div>
        <script src="js/add_custom_row.js" type="text/javascript"></script>
            <?php
            break;

    }
