<?php
if(isset($_POST['save_contact']))
{
     $cname=$_POST['cname']; $uemail=$_POST['uemail']; $uphone=$_POST['uphone'];
     $ucompany=$_POST['ucompany']; $upreferred_date=$_POST['upreferred_date'];
     $upreferred_time=$_POST['upreferred_time'];$business_interest=$_POST['business_interest'];
     $umsg=$_POST['umsg'];
     ini_set(sendmail_from,"permanderk.sw@esselshyam.net" ); // My usual e-mail address
     ini_set(SMTP, "mail5.esselshyam.net" );  // My usual sender
     ini_set(smtp_port,25);
     $msg='
    <table width="50%" border="0" align="center" cellpadding="3" cellspacing="0" style="border: 1px solid #e47474;">
<tr>
<td style=" background: linear-gradient(to right, #c4356a , #dd2e4b) !important; color: white"><h3 style="text-align: center; line-height: 1; padding-top: 12px">Meeting Request For IBC-2018</h3></td>
</tr>
</table>
<table width="50%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#fff"  style="border: 1px solid #e47474; border-top: 0px !important">
<tr> 
<td>
<table width="80%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
<tr>
<td ><strong>Name</strong></td>
<td >:</td>
<td> '.$cname  .' </td>
</tr>
  
<tr>
<td><strong>Phone/Mobile </strong></td>
<td>:</td>
<td>'.$uphone   .'</td>
</tr>
<tr>
<td><strong>Company </strong></td>
<td>:</td>
<td> '.$ucompany   .' </td>
</tr>
<tr>
<td><strong>Preferred Date </strong></td>
<td>:</td>
<td> '.$upreferred_date  .' </td>
</tr>
<tr>
<td><strong>Preferred Time </strong></td>
<td>:</td>
<td> '.$upreferred_time.' </td>
</tr>
<tr>
<td><strong>Business Interest </strong></td>
<td>:</td>
<td> '.$business_interest.'  </td>
</tr>
 
<tr>
<td valign="top"><strong>Massage </strong></td>
<td valign="top">:</td>
<td><textarea name="comment" cols="45" rows="5" id="comment" style="resize: none; border: 1px solid skyblue">  '.$umsg.' </textarea></td>
</tr> 
</table>
</td> 
</tr>
</table> ';
     //$bcc='parmanandt@planetc.net';
     $bcc='babli.sw@planetc.net';
     $subject='Meeting Request From IBC-2018';
     $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
     $headers .= "From: ".$cname."<".$uemail.">\r\n";
     $headers .= "Bcc: ".$bcc."\r\n";
     //$headers .= "Return- ".$user_info['emailid']."\r\n";
     //$headers .= "Message-Id: <".time()."@".$_SERVER['SERVER_NAME'].">\r\n";
     $headers .= "X-Mailer: php-mail-function-0.2\r\n";
     //$to="mnvyas@planetc.net,rajesh@adore.sg,sanjayduda@planetc.net,satyandrey@planetc.net";
     $to="santosh.sw@planetc.net";
     $mail=mail($to,$subject,$msg,$headers);
     if($mail){ header("location:ibc_mail.php?msg=1"); }
     
     //else{ $msg="somthing wrong"; }
     
}
$msg=isset($_GET['msg'])?$_GET['msg']:'';
?>
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
  <title>IBC-2018</title>  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<style>
body{color:#424141; background: #efefef;}
 .form-group .required .control-label:after {  content:"*";color:red;}
 .form-group .form-control:focus {  box-shadow: none;  border-bottom-color: rgba(0, 0, 0, 0.4);}
 .form-group .form-control:focus ~ .animated-label {  top: 0;  opacity: 1;  color: #8e44ad;  font-size: 12px;}
 .form-group .form-control:focus ~ .animated-label:after {  visibility: visible;  width: 100%;  left: 0;}
 .bg-dark {    background-color:#c6c6c6 !important}
 .pt-5, .py-5 {    padding-top: 1rem !important; padding-bottom: 1rem !important;}
 .btn{border-radius: 0px !important; background: linear-gradient(to right, #c4356a , #dd2e4b) !important; color: white}
 @keyframes pulse {  25% {    transform: scale(1.1);  }
  75% {    transform: scale(0.9);  }
}
.pulse {  display: inline-block;  -webkit-tap-highlight-color: rgba(0, 0, 0, 0);  transform: translateZ(0);  box-shadow: 0 0 1px rgba(0, 0, 0, 0);}
.pulse:hover {  animation-name: pulse;  animation-duration: 1s;  animation-timing-function: linear;  animation-iteration-count: infinite;}
  
</style>
  </head>

  <body>
  
    <div class="container" style=" ">

      <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

          <h3 class="my-4">Planetcast @ IBC 2018
            <small> </small>
          </h3>
          
          <div class="card mb-4">
            <img class="card-img-top" src="IBC_2018.png" alt="Card image cap">
            <div class="card-body"> 
              <p class="card-text">Planetcast cordially invites dynamic industry professionals for an exclusive preview of its disruptive Secure Cloud Media Services at IBC 2018. Drop by our stall number 1.F05 to take your business to the next level.
             </p>
             <p class="card-text">At IBC 2018, Planetcast would be revealing its avante-garde technologies in Cloud Playout, Media Asset Management, Teleport Services and Disaster Recovery. At our stall you have an opportunity to discuss:</p>
           
			  <p style="text-align:justify; padding:0;">
			    <span style="font-weight: 900;"> Cloud.X - </span> Cloud based playout . Get a live demo of the user interface plus complete information on the delivery chain of our cloud based playout which is successfully running channel operations for reputed International broadcasters like AMC networks.</p>
		 	  <p style=" text-align:justify;">
			   <span style="font-weight: 900;"> Brick Storage - </span>  Media Storage Solution. Explore our unique Brick Storage solution which is intelligent enough to know exactly what you need, no more, no less.</p>
			  <p style="text-align:justify; "> 
			    <span style="font-weight: 900;"> 	Disaster Recovery - </span> Seamless business operations. Secure your business by deploying our best-in-class disaster recovery services. Get your operations secured at multiple locations through our omnipresent infrastructure.
			  </p>	     
			 <p style="text-align:justify;padding:0;"> 
			 	<span style="font-weight: 900;"> OTT Platform Services - </span> Launch your OTT channel with our platform to deliver broadcast quality channels over the internet in no time.
			 </p>              
           
            </div>
          <div class="card-footer text-muted" style="display: inline-block">
             <div class="col-sm-offset-4 col-sm-10">   Locate us at IBC - 
            <a href="http://ibc18.mapyourshow.com/7_0/floorplan/?hallID=A&selectedBooth=F05&s hareguid=C37D0FDE-EDE5-CD67-C0BC19CE5EF6559A"> <button type="submit" class="btn button pulse ">Click Here</button>
             </a>
            </div> </div>
          </div> 
 
        </div>

        <!-- Sidebar Widgets Column -->
        <div class="col-md-4">

          <!-- form Widget -->
          <div class="card my-4">
            <h5 class="card-header">SCHEDULE A MEETING </h5>
            <div class="card-body">
            <?php
            if($msg==1){ ?>  
             <div class="alert alert-info" style="font-size: 14px !important">
                   <strong>Thank You,</strong> your meeting is confirmed.
             </div>
             <?php } ?>  
             <form name="contact" method="post">
               	
    <div class="form-group required">
      <label for="cname">Name:</label> 
      <input type="text" class="form-control" name="cname" id="cname" required="">
    </div>
    <div class="form-group">
      <label for="uemail">Email:</label>
      <input type="email" class="form-control" id="uemail" name="uemail" required="">
    </div>
     <div class="form-group">
      <label for="uphone">Phone:</label>
      <input type="text" class="form-control" id="uphone" name="uphone">
    </div>
    <div class="form-group">
      <label for="ucompany">Company:</label>
      <input type="text" class="form-control" id="ucompany" name="ucompany">
    </div>
    <div class="form-group"> 
    	<label for="upreferred_date">Preferred Date:</label>
       <select class="form-control" id="upreferred_date"   name="upreferred_date" style=" height: calc(2.25rem + 2px);" >
       <option value="14th Sept"> 14th Sept</option>
        <option value="15th Sept"> 15th Sept</option>
        <option value="16th Sept"> 16th Sept</option>
        <option value="17th Sept"> 17th Sept</option>
        <option value="18th Sept"> 18th Sept</option>
        <option value="19th Sept"> 19th Sept</option>
      </select>
     </div>
     
      <div class="form-group"> 
    	 <label for="upreferred_time">Preferred Time:</label>
      <select class="form-control" id="upreferred_time"  name="upreferred_time" style=" height: calc(2.25rem + 2px);">
      <option value="First Half">First half</option>
	  <option value="Second Half">Second half</option> 
      </select>
     </div>
     
     
      <div class="form-group"> 
    	 <label for="business_interest">Business Interest </label>
      <select class="form-control" id="business_interest"  name="business_interest" style=" height: calc(2.25rem + 2px);">
        <option value="Playout Services">Playout Services</option>
        <option value="Teleport Services">Teleport Services</option>
        <option value="OTT Services"> OTT Services</option>
        <option value="Media Asset Management"> Media Asset Management</option>
        <option value="Disaster Recovery Services">Disaster Recovery Services</option>
        <option value="System Integration"> System Integration</option>
      </select>
     </div>
     
	   <div class="form-group">
	   <label for="umsg">Massage:</label>
           <textarea class="form-control"  id="umsg" name="umsg"  rows="1" cols="20" maxlength="200" placeholder="Type your massage here."></textarea>
	   </div> 
   
      <div class="form-group">
      <div class="col-sm-offset-4 col-sm-10">
          <button type="submit" class="btn button pulse " name="save_contact">Submit</button>
      </div>
      </div>
  </form>
  
            </div>
          </div>

        

          

        </div>

      </div>
      <!-- /.row -->

    </div>
    <!-- /.container -->

    <!-- Footer -->
    <footer class="py-5 bg-dark">
      <div class="container">
        <p class="m-0 text-center  ">Copyright &copy; Planetcast 2018</p>
      </div>
      <!-- /.container -->
    </footer>

   
  </body>

</html>
