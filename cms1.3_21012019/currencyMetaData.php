<?php
include_once 'corefunction.php';
$Entryid=$_POST['Entryid']; $getpageindex=$_POST['pageindex'];$limitval=$_POST['limitval']; 
$searchInputall=$_POST['searchInputall'];
$selEntry="select currency_data from entry where entryid='$Entryid'";
$f=db_select($conn,$selEntry);
$currency_data_json=$f[0]['currency_data'];
$json_customdataCurrency  = json_decode($currency_data_json,true);
?>
<div style="border: 0px solid #c7d1dd ; border-top: 0px; padding:20px 0px 20px 4px ">
  <form method="post" id="formMetaDataCurrency" name="formMetaDataCurrency">   
<div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header1">
                  <div class="form-group">
                   <!--<label for="category_value" class="control-label col-xs-3">Country:</label>
                   <div class="col-xs-8">
                       <button type="button" class="btn btn-default" onclick="addRowCurrency()" id="addRowBtnCurrency" > <i class="glyphicon glyphicon-plus-sign"></i> Add Currency</button>
                    </div>-->
                   </div>
                 <div  style="border:0px solid red;">   
                     <?php
                     $sql="Select name,currency,country_code from countries_currency where status='1' order by  name ";
                     $TotalCurrencyCountry = db_totalRow($conn,$sql);
                     $data = db_select($conn,$sql);
                     if(!empty($json_customdataCurrency)){ ?>
                     <table class="table" id="currencyTable" style="width:87%;">
                        <tr><th>Currency</th><th>Price (INR)</th></tr>     
                        <tbody>
                        <?php
                        $arrayNumber = 0;
                        $x = 1;
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
                             <input type="text" name="price[]"  id="price<?php echo $x; ?>"  placeholder="price" class="form-control" value="<?php echo $CurrencyPrice; ?>" />
                         <span class="help-block has-error" id="price<?php echo $x; ?>-error" style="color:red;"></span>
                         </td>
                         <td>
                         <button class="btn btn-default removeProductRowBtn" disabled type="button" id="removeProductRowBtn" onclick="removeProductRow(<?php echo $x; ?>)"><i class="glyphicon glyphicon-trash"></i></button>
                         </td>
                        </tr>
                        <?php
                        $x++;
                         }
                        ?>
                       </tbody>			  	
                    </table>
                      
                     <?php 
                     } else{ 
                     ?>
                     <table class="table" id="currencyTable" style="width:87%;">
                        <tr><th>Currency</th><th>Price</th></tr>     
                        <tbody>
                        <?php
                        $arrayNumber = 0;
                        $x = 1;
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
                        ?>
                       </tbody>			  	
                    </table>
                     <?php } ?>
                 </div>
                </div>
               
              </div>
            </div>
          </div>
        <div class="modal-footer">
            <div class="col-sm-offset-3 col-sm-4" style="right: 6%;">
             <?php $disabled_button = (in_array(2, $UserRight) ? "" : "disabled"); ?>   
            <button type="button" name="save_currency" <?php echo $disabled_button; ?> id="save_currency" class="btn btn-primary" onclick="saveCurrencyMetaData('save_currency_metadata','<?php echo $Entryid; ?>','<?php echo $getpageindex;  ?>','<?php echo $limitval;  ?>');" >Save</button>
                <span id="saving_loader"> </span>  
            </div>
        </div>
        </form>
     
</div>
<script src="js/add_custom_row.js" type="text/javascript"></script>
<script type="text/javascript">
var searchInputall="<?php echo $searchInputall ?>";   
function saveCurrencyMetaData(smatadata,entryid,pageindex,limitval)
{
    $(".has-error").html('');
    var currency = document.getElementsByName('currency[]');
    var validateCurrency=true;
    for (var x = 0; x < currency.length; x++) {     
    var currency_id = currency[x].id;
     if(currency[x].value == '')
         {	    		    	
            $("#"+currency_id+"-error").html('select currency.');
            validateCurrency = false;
         }
     }
     var regexp = /^\d+(\.\d{1,2})?$/;
     var price = document.getElementsByName('price[]');
      var validatePrice=true;
        for (var x = 0; x < price.length; x++) {       
            var price_Id = price[x].id;
             if(price[x].value == ''){	
                $("#"+price_Id+"-error").html('price is required!');
                validatePrice = false
               }
              else if(!regexp.test(price[x].value))
              { 
                var mess="(Please enter numeric or Decimal value)  Eg:200,2.1.20.1 "; 
                $("#"+price_Id+"-error").html(mess);
                validatePrice = false;
              }  
        }  
    if(validateCurrency == false ||  validatePrice == false) { return false; } 
    $('#save_currency').attr('disabled',true);
    $("#saving_loader").show();
    $("#saving_loader").fadeIn(500).html('Saving..... <img src="img/image_process.gif" />');
    $.ajax({
      method : 'POST',
      url : 'media_paging.php',
      data : $('#formMetaDataCurrency').serialize() +
              "&entryid="+entryid+"&maction="+smatadata
              +"&pageindex="+pageindex+"&limitval="+limitval+"&searchInputall="+searchInputall,
      success: function(r){
               $("#save_currency").hide(); 
               $('#myModalVodEdit').modal('hide');
               $("#results").html(r);
               $("#msg").html("price saved successfully"); 
        }
      });  
    
}
</script>

                 
