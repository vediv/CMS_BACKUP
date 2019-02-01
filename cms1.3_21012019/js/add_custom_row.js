function addRow() {
  	var tableLength = $("#productTable tbody tr").length;
	var tableRow;
	var arrayNumber;
	var count;
        if(tableLength>4){ alert("Add only 5 custom data. "); $("#addRowBtn").prop("disabled", true); return false; }
	if(tableLength > 0) {		
		tableRow = $("#productTable tbody tr:last").attr('id');
		arrayNumber = $("#productTable tbody tr:last").attr('class');
		count = tableRow.substring(3);	
		count = Number(count) + 1;
		arrayNumber = Number(arrayNumber) + 1;					
	} else {
		// no table row
		count = 1;
		arrayNumber = 0;
	}
var tr = '<tr id="row'+count+'" class="'+arrayNumber+'">'+			  				
'<td style="padding-left:20px;">'+
        '<input type="text" name="key_desc[]" maxlength="35" id="key_desc'+count+'"  placeholder="key name" class="form-control" />'+
'<span class="help-block has-error" id="key_desc'+count+'-error" style="color:red;"></span></td> :'+
'<td style="padding-left:20px;">'+
        '<input type="text" name="key_val[]"  maxlength="35" id="key_val'+count+'"  placeholder="key value" class="form-control"  />'+
        '<span class="help-block has-error" id="key_val'+count+'-error" style="color:red;"></span>'+
'</td>'+

'<td>'+
        '<button class="btn btn-default removeProductRowBtn" type="button" onclick="removeProductRow('+count+')"><i class="glyphicon glyphicon-trash"></i></button>'+
'</td>'+
'</tr>';

        if(tableLength > 0) {							
                $("#productTable tbody tr:last").after(tr);
        } else {				
                $("#productTable tbody").append(tr);
        }
        $("#addRowBtn").button("reset");
        

} // /add row

function removeProductRow(row) {
	if(row) {
		$("#row"+row).remove();
                $("#addRowBtn").prop("disabled", false);
		//subAmount();
	} else {
		alert('error! Refresh the page again');
	}
}


function addRowCurrency(TotalCurrencyCountry)
{
    var tableLength = $("#currencyTable tbody tr").length;
	var tableRow;
	var arrayNumber;
	var count;
        if(tableLength>=TotalCurrencyCountry){ alert("Only "+TotalCurrencyCountry+" countries allowed"); $("#addRowBtnCurrency").prop("disabled", true); return false; }
	if(tableLength > 0) {		
		tableRow = $("#currencyTable tbody tr:last").attr('id');
		arrayNumber = $("#currencyTable tbody tr:last").attr('class');
		count = tableRow.substring(3);	
		count = Number(count) + 1;
		arrayNumber = Number(arrayNumber) + 1;					
	} else {
		// no table row
		count = 1;
		arrayNumber = 0;
	}
       
       $.ajax({
		url: 'planDetailModal.php',
                type: 'post',
		data: 'action=get_currency',
                dataType: 'json',
		success:function(response) {
			$("#addRowBtnCurrency").button("reset");			
			var tr = '<tr id="row'+count+'" class="'+arrayNumber+'">'+			  				
				'<td>'+
					'<select class="form-control" name="currency[]" id="currency'+count+'" >'+
				        '<option value="">--Select Currency--</option>';
					    //console.log(response.length);
                                            for(var i=0; i<response.length;i++){
                                                var name=response[i].name;
                                                var country_code=response[i].country_code;
							tr += '<option value="'+country_code+'">'+name+'</option>';							
	                                    }
			    tr += '</select>'+
                                    
			   	'<span class="help-block has-error" id="currency'+count+'-error" style="color:red;"></span></td>'+
				'<td style="padding-left:20px;"">'+
					'<input type="text" name="price[]" id="price'+count+'" placeholder="price" class="form-control" />'+
				'<span class="help-block has-error" id="price'+count+'-error" style="color:red;"></span></td>'+
				'<td>'+
					'<button class="btn btn-default removeProductRowBtn" type="button" onclick="removeProductRow('+count+')"><i class="glyphicon glyphicon-trash"></i></button>'+
				'</td>'+
			'</tr>';
			if(tableLength > 0) {							
				$("#currencyTable tbody tr:last").after(tr);
			} else {				
				$("#currencyTable tbody").append(tr);
			}		

		} // /success
	});
        
    
}
