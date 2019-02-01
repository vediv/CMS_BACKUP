//case "content_partner_list":
$sqlQry="select pub.par_id,pub.name,pub.acess_level from publisher ";
$fetch = db_select($conn,$sqlQry);
?>
<select id="category_value"  style="width: 350px;">
<?php foreach ($fetch as $fetchCat) {
     $category_id=$fetchCat['category_id'];  $header_name=$fetchCat['header_name'];
     $sel=$category_id==$categoryid?'selected':'';
?>
<option value="<?php echo $category_id;?>" <?php echo $sel;  ?>  ><?php echo $header_name; ?></option>
<?php }  ?>
</select>
<?php
//break;




<div class="input-group">

  <select name="year_t" id="year_t" class="form-control" style="width:110px;">
    <?php
    $min = $year-5;
    $max = $year;
    for($i=$max; $i>=$min; $i--) {
        echo '<option value='.$i.'>'.$i.'</option>';
     } ?>
  </select>
    <select name="month_t" id="month_t" class="form-control"  style="width:110px;" onchange="getTranscodedVideoInfo('search_month');">
        <?php for( $m=1; $m<=12; ++$m ) {
            $month_label = date('F', mktime(0, 0, 0, $m, 2));
         ?>
        <option value="<?php echo $m; ?>"><?php echo $month_label; ?></option>
      <?php } ?>
    </select>
    <select name="week_t" id="week_t" class="form-control"  style="width:130px;" onchange="getTranscodedVideoInfo('search_month');">
        <option value=''>-Select Week-</option>
        <option value='1'>1 Week</option>
        <option value='2'>2 Week</option>
        <option value='3'>3 Week</option>
        <option value='4'>4 Week</option>
     </select>
     <select name="day_t" id="day_t" class="form-control"  style="width:130px;" onchange="getTranscodedVideoInfo('search_month');">
         <option value=''>-Select Day-</option>
         <?php for( $m=1; $m<=31; ++$m ) {

          ?>
         <option value="<?php echo $m; ?>"><?php echo $m; ?></option>
       <?php } ?>
     </select>
</div>
