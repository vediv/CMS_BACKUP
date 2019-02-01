<?php 
include_once 'auths.php';  
//include_once 'auth.php'; 
//$get_user_id // this define in auth.php
function getMenuRights($get_user_id) {
        global $conn;
        $get_user_id = intval($get_user_id);
        $uquery="SELECT menu_permission FROM publisher where par_id='".$get_user_id."'";
        $fetch_access_list= db_select($conn,$uquery);
        $get_access_list = $fetch_access_list[0]['menu_permission'];
        return $get_access_list;
    }
    function getUserMainMenus($get_user_id) {
        global $conn;
        $get_user_id = intval($get_user_id);
        $rights = getMenuRights($get_user_id);
        $get_main_menu_query = "SELECT mid,mname,menu_url,mparentid,multilevel,child_id,icon_class FROM menus where mid IN ($rights) and mparentid='0' and mstatus='1' order by priority ASC ";
        $results=  db_select($conn,$get_main_menu_query);
        return $results;
    }
    function getUserChildMenu($parent_menu_id, $get_user_id) {
        global $conn;
        $parent_menu_id = intval($parent_menu_id);
        $get_user_id = intval($get_user_id);
        $rights = getMenuRights($get_user_id);
        $get_sub_menu = "SELECT mid,mname,menu_url,icon_class FROM menus where mid IN ($rights) and mparentid='".$parent_menu_id."' and mstatus='1'";
        $results=  db_select($conn,$get_sub_menu);
        return $results;
    }
?>
<aside class="main-sidebar">
   <section class="sidebar">
      <div class="user-panel">
         <div class="pull-left image">
          </div>
            <!--<div class="pull-left info">
              <p> Welcome <?php //echo $_SESSION['publisher_info']['username'];?> !</p>
 </div>-->
          </div>
<style type="text/css">
.skin-blue .sidebar-menu>li>a:hover, .skin-blue .sidebar-menu>li.active>a {
color: #fff;
background:#000000;
border-left-color: #3c8dbc;
}
</style>
<?php  
$pagenamerequest= basename($_SERVER['REQUEST_URI']);
$pname=explode("?",$pagenamerequest);
$ExactName=trim($pname[0]); 
$qry="SELECT mid FROM menus where menu_url='".$ExactName."' ";
$fet=  db_select($conn,$qry);
$menuid=$fet[0]['mid']
?>       
          <ul class="sidebar-menu">
            <li class="treeview <?php echo $ExactName=="dashboard.php" ? "active" :"";   ?>">
              <a href="dashboard.php">
                <i class="fa fa-dashboard"></i> <span>Dashboard <?php //echo session_id(); echo "<br/>" ;print_r($_SESSION); ?></span>
              </a>
            </li>
            <?php
            if (is_array(getUserMainMenus($get_user_id))) {
            foreach (getUserMainMenus($get_user_id) as $get_main_menu) { 
                 $mid=($get_main_menu['mid']);$main_menu_url=trim($get_main_menu['menu_url']);  $multilevel=$get_main_menu['multilevel'];
                 $mparentid=$get_main_menu['mparentid']; $multilevel=$get_main_menu['multilevel'];  $child_id=$get_main_menu['child_id'];
                 $icon_class=$get_main_menu['icon_class'];
                 $childid=explode(',',$child_id);
                 if(in_array($menuid,$childid)) { $active="active"; } else { $active=""; };
                ?>
               <?php if($multilevel=='1'){ ?>
                <li class="treeview <?php echo $active; ?> ">
                <a href="#">
                  <i class="fa <?php echo $icon_class; ?>"></i> <span><?php echo ucwords($get_main_menu['mname']);?></span>
                  <i class="fa fa-angle-left pull-right"></i>
                </a>
                <?php } else {  ?>
                <li class="treeview <?php echo $ExactName==$main_menu_url || $ExactName==$main_menu_url ?"active" :"";   ?> ">   
                 <a href="<?php echo $main_menu_url; ?>">
                  <i class="fa <?php echo $icon_class; ?>"></i> <span><?php echo ucwords($get_main_menu['mname']) ?></span>
                </a> 
                <?php } ?>   
                <?php if($multilevel=='1'){   ?>     
               <ul class="treeview-menu">
              <?php foreach (getUserChildMenu($get_main_menu['mid'],$get_user_id) as $row) { 
                        $sub_menu_url=trim($row['menu_url']); $sub_icon_class=$row['icon_class'];
                        $act=$ExactName==$sub_menu_url ? "active" :""; 
                  ?>
             <li class="<?php echo $act ?>">
             <a href="<?php echo $sub_menu_url; ?>"><i class="fa <?php echo $sub_icon_class; ?>"></i><?php echo  ucwords($row['mname']); ?></a></li>
             <?php } ?>
              </ul>
                <?php } ?>    
             </li>   
            <?php } } ?>
            
          </ul>
          
        </section>
      
       
      </aside>

