<?php
include_once 'corefunction.php';
$act=$_POST['act']; $planuniquename=$_POST['planuniquename']; 
switch($act)
{
    case "show":
    switch($planuniquename) 
    {
        case "f":
        $queryPlan="select planID,planName from plandetail where pstatus=1 and planuniquename='f'";
        $Getplan =db_select($conn,$queryPlan);
        if(empty($Getplan))
        {
            echo "Plan Not Exist";
            exit;
        }
        ?>
        <label for="inputPassword" class="control-label col-xs-2">Select Plan :</label>
        <select id="example-getting-started1" multiple="multiple" >
        <?php 
        foreach ($Getplan as $planvalue) {
                      $planID=$planvalue['planID']; $planName=$planvalue['planName'];  $planuniquename=$planvalue['planuniquename'];
                      $Idsdlist = explode(',',$GetplanEntery[0]['planIDs']);
                      $selected=in_array($planID, $Idsdlist) ? "selected" : '';
          ?>

        <option <?php echo $selected;  ?>   value="<?php echo $planID;?>"><?php echo ucwords(($planName));   //print_r($GetplanEntery); ?></option>
        <?php  } ?> 
        </select>
     
       <?php 
        break;
        case "t":
        $queryPlan="select planID,planName from plandetail where pstatus=1 and planuniquename='t'";
        $Getplan =db_select($conn,$queryPlan);
        if(empty($Getplan))
        {
            echo "Plan Not Exist";
            exit;
        }
        ?>
        <label for="inputPassword" class="control-label col-xs-2">Select Plan :</label>
        <select id="example-getting-started1" multiple="multiple" >
        <?php 
        foreach ($Getplan as $planvalue) {
                      $planID=$planvalue['planID']; $planName=$planvalue['planName'];  $planuniquename=$planvalue['planuniquename'];
                      $Idsdlist = explode(',',$GetplanEntery[0]['planIDs']);
                      $selected=in_array($planID, $Idsdlist) ? "selected" : '';
          ?>

        <option <?php echo $selected;  ?>   value="<?php echo $planID;?>"><?php echo ucwords(($planName));   //print_r($GetplanEntery); ?></option>
        <?php  } ?> 
        </select>
     
       <?php   
        break;    
        case "p":
        $queryPlan="select planID,planName from plandetail where pstatus=1 and planuniquename='p'";
        $Getplan =db_select($conn,$queryPlan);
        if(empty($Getplan))
        {
            echo "Plan Not Exist";
            exit;
        }
        ?>
        <label for="inputPassword" class="control-label col-xs-2">Select Plan :</label>
        <select id="example-getting-started1" multiple="multiple" >
        <?php 
        foreach ($Getplan as $planvalue) {
                      $planID=$planvalue['planID']; $planName=$planvalue['planName'];  $planuniquename=$planvalue['planuniquename'];
                      $Idsdlist = explode(',',$GetplanEntery[0]['planIDs']);
                      $selected=in_array($planID, $Idsdlist) ? "selected" : '';
          ?>

        <option <?php echo $selected;  ?>   value="<?php echo $planID;?>"><?php echo ucwords(($planName));   //print_r($GetplanEntery); ?></option>
        <?php  } ?> 
        </select>
     
       <?php      
        break; 
        default:
            
    }    
        
    break; 
    
    case "showedit":
    $entryid=$_POST['entryid'];     
    $queryPlanentry="select planid from entry where entryid='$entryid'";
    $GetplanEntery =db_select($conn,$queryPlanentry);
    switch($planuniquename) 
    {
        case "f":
        $queryPlan="select planID,planName,planuniquename from plandetail where pstatus=1 and planuniquename='f'";
        $Getplan =db_select($conn,$queryPlan);
        if(empty($Getplan))
        {
            echo "Plan Not Exist";
            exit;
        }
        ?>
        <label for="inputPassword" class="control-label col-xs-2">Select Plan :</label>
        <select id="example-getting-started1" multiple="multiple" >
        <?php
        foreach ($Getplan as $planvalue) {
                      $planID=$planvalue['planID']; $planName=$planvalue['planName'];  
                      $planuniquename=$planvalue['planuniquename'];
                      $Idsdlist = explode(',',$GetplanEntery[0]['planid']);
                      $selected=in_array($planID, $Idsdlist) ? "selected" : '';
          ?>
        <option <?php echo $selected;  ?>   value="<?php echo $planID;?>"><?php echo ucwords(($planName));   ?></option>
        <?php  } ?> 
        </select>
       <?php 
        break;
        case "t":
        $queryPlan="select planID,planName from plandetail where pstatus=1 and planuniquename='t'";
        $Getplan =db_select($conn,$queryPlan);
        if(empty($Getplan))
        {
            echo "Plan Not Exist";
            exit;
        }
        ?>
        <label for="inputPassword" class="control-label col-xs-2">Select Plan :</label>
        <select id="example-getting-started1" multiple="multiple" >
        <?php 
        foreach ($Getplan as $planvalue) {
                      $planID=$planvalue['planID']; $planName=$planvalue['planName'];  $planuniquename=$planvalue['planuniquename'];
                      $Idsdlist = explode(',',$GetplanEntery[0]['planid']);
                      $selected=in_array($planID, $Idsdlist) ? "selected" : '';
          ?>

        <option <?php echo $selected;  ?>   value="<?php echo $planID;?>"><?php echo ucwords(($planName));   //print_r($GetplanEntery); ?></option>
        <?php  } ?> 
        </select>
     
       <?php   
        break;    
        case "p":
        $queryPlan="select planID,planName from plandetail where pstatus=1 and planuniquename='p'";
        $Getplan =db_select($conn,$queryPlan);
        if(empty($Getplan))
        {
            echo "Plan Not Exist";
            exit;
        }
        ?>
        <label for="inputPassword" class="control-label col-xs-2">Select Plan :</label>
        <select id="example-getting-started1" multiple="multiple" >
        <?php 
        foreach ($Getplan as $planvalue) {
                      $planID=$planvalue['planID']; $planName=$planvalue['planName'];  $planuniquename=$planvalue['planuniquename'];
                      $Idsdlist = explode(',',$GetplanEntery[0]['planid']);
                      $selected=in_array($planID, $Idsdlist) ? "selected" : '';
          ?>

        <option <?php echo $selected;  ?>   value="<?php echo $planID;?>"><?php echo ucwords(($planName));   //print_r($GetplanEntery); ?></option>
        <?php  } ?> 
        </select>
     
       <?php      
        break; 
        default:
            
    }    
        
    break;    
    
    
    
    
    
}





?>
