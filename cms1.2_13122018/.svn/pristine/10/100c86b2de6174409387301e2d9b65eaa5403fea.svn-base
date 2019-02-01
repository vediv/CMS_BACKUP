<?php
include_once 'corefunction.php';
$config_file_path=TEMPLATE_CONFIG_PATH;
$action=(isset($_POST['act']))? $_POST['act']: "";
switch($action)
{
             case "create":
             $img_array = array();
             $clr_array = array();
             $api_crd_array = array(); 
             $temp = array(); 
           
             $template                  =$_POST['templateName'];  
             $temp['appname']           =$_POST['appname'];  
             $temp['baseurl']           =$_POST['baseurl'];  
             $temp['URLfont_file']      =$_POST['textfontfile'];
             $img_array['URLlogin_bgimg']       =$_POST['textloginbgimg1'];   
             $img_array['URLsplash_bgimg1']     =$_POST['textsplashbgimg1'];  
             $img_array['splash_bgimg1']        =$_POST['splash_bgimg1'];  

             $img_array['URLbgimg1']            =$_POST['textbgimg1'];  ;  
             $img_array['URLlogin_logo']        =$_POST['textloginlogo'];  
             $img_array['URLplaceh_img']        =$_POST['textplacehimg'];  ;  
             $img_array['URLlauncher_img']      =$_POST['textlauncherimg']; 
             $clr_array['Thumb_bg_clr']    =$_POST['thumbbgname'];  
             $clr_array['Title_br_clr']    =$_POST['titbarcolorcode'];  
             $clr_array['Text_tl_clr']     =$_POST['txttitlecode']; 
             $clr_array['Text_clr']        =$_POST['textcolorcode'];  
             $clr_array['Font_clr']        =$_POST['fontcolorcode'];  
             $clr_array['Icon_clr']        =$_POST['iconcolor'];  
             $clr_array['menu_color']      =$_POST['menucolor'];  
             $clr_array['tabstrip_color']  =$_POST['tabstripcolor']; 
             $clr_array['Bg_clr']          =$_POST['bgcolor']; 
             $clr_array['Category_clr']    =$_POST['categorycode']; 
             $clr_array['Tab_clr']         =$_POST['tabcolor']; 
             $api_crd_array['Username']    =$_POST['username'];  
             $api_crd_array['Password']    =$_POST['password'];  
             $api_crd_array['Partner_Id']  =$_POST['passid']; 
             $DBname=DATABASE_Name;
             $new_path = $config_file_path.$DBname;
             if(is_dir($new_path)) {
             } else {
             mkdir($new_path, 0777,true);
              //echo "T he Directory $new_path was created";
             }
            $filePath=$new_path."/".$template.".json";
            if (file_exists($filePath)) {
            echo 3; //file all ready exist
            } else {
            $fp = fopen($filePath, "w+");   
            $savestringArr =array("App_Details"=>$temp,"Image"=>$img_array,"Color"=>$clr_array,"API_Credentials"=>$api_crd_array);
            $savestring = arr2ini($savestringArr);
            fwrite($fp, $savestring);
            fclose($fp);
            echo 1;  
           
          }
         break;    
         case "edit":
            
          $img_array = array();
             $clr_array = array();
             $api_crd_array = array(); 
             $temp = array(); 
           
             $template                  =$_POST['templateName'];  
             $temp['appname']           =$_POST['appname'];  
             $temp['baseurl']           =$_POST['baseurl'];  
             $temp['URLfont_file']      =$_POST['textfontfile'];
             $img_array['URLlogin_bgimg']       =$_POST['textloginbgimg1'];   
             $img_array['URLsplash_bgimg1']     =$_POST['textsplashbgimg1'];  
             $img_array['splash_bgimg1']        =$_POST['splash_bgimg1'];  

             $img_array['URLbgimg1']            =$_POST['textbgimg1'];  ;  
             $img_array['URLlogin_logo']        =$_POST['textloginlogo'];  
             $img_array['URLplaceh_img']        =$_POST['textplacehimg'];  ;  
             $img_array['URLlauncher_img']      =$_POST['textlauncherimg']; 
             $clr_array['Thumb_bg_clr']    =$_POST['thumbbgname'];  
             $clr_array['Title_br_clr']    =$_POST['titbarcolorcode'];  
             $clr_array['Text_tl_clr']     =$_POST['txttitlecode']; 
             $clr_array['Text_clr']        =$_POST['textcolorcode'];  
             $clr_array['Font_clr']        =$_POST['fontcolorcode'];  
             $clr_array['Icon_clr']        =$_POST['iconcolor'];  
             $clr_array['menu_color']      =$_POST['menucolor'];  
             $clr_array['tabstrip_color']  =$_POST['tabstripcolor']; 
             $clr_array['Bg_clr']          =$_POST['bgcolor']; 
             $clr_array['Category_clr']    =$_POST['categorycode']; 
             $clr_array['Tab_clr']         =$_POST['tabcolor']; 
             $api_crd_array['Username']    =$_POST['username'];  
             $api_crd_array['Password']    =$_POST['password'];  
             $api_crd_array['Partner_Id']  =$_POST['passid']; 
           $config_file_path=TEMPLATE_CONFIG_PATH;
           $DBname=DATABASE_Name;
           $new_path = $config_file_path.$DBname."/";
           $filePath=$new_path.$template;
             
           
            $fp = fopen($filePath, "w+");   
            $savestringArr =array("App_Details"=>$temp,"Image"=>$img_array,"Color"=>$clr_array,"API_Credentials"=>$api_crd_array);
            $savestring = arr2ini($savestringArr);
            fwrite($fp, $savestring);
            fclose($fp); 
            echo 1;  
          
   
         break;    
   }
function arr2ini(array $a, array $parent = array())
{
    $out = '';
    foreach ($a as $k => $v)
    {
        if (is_array($v))
        {
            //subsection case
            //merge all the sections into one array...
            $sec = array_merge((array) $parent, (array) $k);
            //add section information to the output
            $out .= '[' . join('.', $sec) . ']' . PHP_EOL;
            //recursively traverse deeper
            $out .= arr2ini($v, $sec);
        }
        else
        {
            //plain key->value case
            $out .= "$k=$v" . PHP_EOL;
        }
    }
    return $out;
}


   ?>
