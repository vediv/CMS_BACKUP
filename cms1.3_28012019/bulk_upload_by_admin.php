<?php include_once 'corefunction.php'; ?>
<style type="text/javascript">
.form-group { margin-bottom: 10px !important; }
</style>
<link rel="stylesheet" href="upload_css/jquery.fileupload.css">
<link rel="stylesheet" href="upload_css/jquery.fileupload-ui.css">
 <div id="msg" style="text-align:center; width:400px; margin-left: 257px"> </div>
   <div style=" border:1px solid #c7d1dd ;">
      <form class="form-horizontal" id="upload_form" name ="broadcast" enctype="multipart/form-data"   method="post" role="form" style="margin-left:50px; padding-top: 23px; padding-left: 9px">

            <div class="form-group">
                <label class="control-label col-sm-2" style=" float: left;  right: 4%;">Upload CSV:</label>
                <div class="row">
                    <div class="col-sm-5">
                        <input type="file"  accept=".csv"  name="fileUpload"  id="fileUpload"/>
                        <div id="waitPreview" style="border: 0px solid red;color:red;"> </div>
                  
                    </div>

            
            <div class="form-group" style="display: inline-block">        
                <div class="col-sm-offset-2 col-sm-10">
                     <button type="button" name="save_upload_image" id="save_upload_image" onclick="saveImgeProfile('saveimage')" class="btn btn-success btn-default1 btnSubmit">Upload</button>

                </div>
                </div>
            </div>
          </div>
          <div style="border:0px solid red;" id="uploadCSV"></div>

       </form>
        
    </div>
   </div>
