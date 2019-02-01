<?php
include_once 'auths.php';
function pagination($page,$limit,$total_pages,$adjacent,$targetpage,$searchTextMatch,$fromdate,$todate,$pageUrl,$filtervalue)
{
//$page = 1;
//$page;			//if no page var is given, default to 1.
$prev = $page - 1;	//previous page is page - 1
$next = $page + 1;
//$limit=$pager->pageSize;	//next page is page + 1
$lastpage = ceil($total_pages/$limit);
$adjacents = $adjacent;				
$lpm1 = $lastpage - 1;					
$pagination = "";
if($lastpage > 1)
	{	
	    $pagination .= "<div class=\"pagination\">"; 
		//previous button
           	if ($page >1)   
		 $pagination.= '<a href="javascript:void(0)"  onclick="changePagination(\''.$prev.'\',\''.$limit.'\',\''.$searchTextMatch.'\',\''.$fromdate.'\',\''.$todate.'\',\''.$pageUrl.'\',\''.$filtervalue.'\')"><i class="fa fa-long-arrow-left" aria-hidden="true"></i>
Previous</a>';		
		else
			$pagination.= "<span class=\"disabled \"> <i class='fa fa-long-arrow-left' aria-hidden='true'></i> Previous</span>";	
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
                    
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
		          ?>
			<?php 	if ($counter == $page)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
				
				    $pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$counter.'\',\''.$limit.'\',\''.$searchTextMatch.'\',\''.$fromdate.'\',\''.$todate.'\',\''.$pageUrl.'\',\''.$filtervalue.'\')">'.$counter.'</a>';		
				    //$content .='<a  href="javascript:void(0)" onclick="changePagination(\''.$i.'\',\''.$i.'_no\')">'.($i+1).'</a>';
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
		{
    
			//close to beginning; only hide later pages
			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						//$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";	
					    $pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$counter.'\',\''.$limit.'\',\''.$searchTextMatch.'\',\''.$fromdate.'\',\''.$todate.'\',\''.$pageUrl.'\',\''.$filtervalue.'\')">'.$counter.'</a>';				
				}
				$pagination.= "...";
				//$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>"; 
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$lpm1.'\',\''.$limit.'\',\''.$searchTextMatch.'\',\''.$fromdate.'\',\''.$todate.'\',\''.$pageUrl.'\',\''.$filtervalue.'\')">'.$lpm1.'</a>';
				
				//$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";	
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$lastpage.'\',\''.$limit.'\',\''.$searchTextMatch.'\',\''.$fromdate.'\',\''.$todate.'\',\''.$pageUrl.'\',\''.$filtervalue.'\')">'.$lastpage.'</a>';	
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
                           
				//$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\'1\',\''.$limit.'\',\''.$searchTextMatch.'\',\''.$fromdate.'\',\''.$todate.'\',\''.$pageUrl.'\',\''.$filtervalue.'\')">1</a>';	
				//$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\'2\',\''.$limit.'\',\''.$searchTextMatch.'\',\''.$fromdate.'\',\''.$todate.'\',\''.$pageUrl.'\',\''.$filtervalue.'\')">2</a>';
				$pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
					//$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";	
					$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$counter.'\',\''.$limit.'\',\''.$searchTextMatch.'\',\''.$fromdate.'\',\''.$todate.'\',\''.$pageUrl.'\',\''.$filtervalue.'\')">'.$counter.'</a>';				
				}
				$pagination.= "...";
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$lpm1.'\',\''.$limit.'\',\''.$searchTextMatch.'\',\''.$fromdate.'\',\''.$todate.'\',\''.$pageUrl.'\',\''.$filtervalue.'\')">'.$lpm1.'</a>';
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$lastpage.'\',\''.$limit.'\',\''.$searchTextMatch.'\',\''.$fromdate.'\',\''.$todate.'\',\''.$pageUrl.'\',\''.$filtervalue.'\')">'.$lastpage.'</a>';	
			}
			//close to end; only hide early pages
			else
			{   
				
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\'1\',\''.$limit.'\',\''.$searchTextMatch.'\',\''.$fromdate.'\',\''.$todate.'\',\''.$pageUrl.'\',\''.$filtervalue.'\')">1</a>';	
				//$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\'2\',\''.$limit.'\',\''.$searchTextMatch.'\',\''.$fromdate.'\',\''.$todate.'\',\''.$pageUrl.'\',\''.$filtervalue.'\')">2</a>';
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
				    if ($counter == $page)
				      $pagination.= "<span class=\"current\">$counter</span>";
				    else
				      $pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$counter.'\',\''.$limit.'\',\''.$searchTextMatch.'\',\''.$fromdate.'\',\''.$todate.'\',\''.$pageUrl.'\',\''.$filtervalue.'\')">'.$counter.'</a>';					
				}
			}
		}
		
		//next button
		if ($page < $counter - 1) 
			//$pagination.= "<a href=\"$targetpage?page=$next\">next �</a>";
		    $pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$next.'\',\''.$limit.'\',\''.$searchTextMatch.'\',\''.$fromdate.'\',\''.$todate.'\',\''.$pageUrl.'\',\''.$filtervalue.'\')">Next  <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>';	 
		else
			$pagination.= "<span class=\"disabled\"> Next <i class='fa fa-long-arrow-right' aria-hidden='true'></i></span>";
		$pagination.= "</div>\n";		
	}
          return $pagination;
    
}
















function mkTimestamp($year,$month,$day, $hours=0,$minutes=0,$seconds=0){
    return mktime($hours,$minutes,$seconds, $month,$day,$year);
}



function convert_sec_to($totaldursecond)
{
                       $seconds= $totaldursecond;
			//for seconds
			if($seconds> 0)
			{
			$sec= "" . ($seconds%60);
			if($seconds % 60 <10)
			{
			$sec= "0" . ($seconds%60);
			}
			}
			else{ $sec="00"; }
			//for mins
			if($seconds >= 60)
				{
				$mins= "". ($seconds/60%60);
				if(($seconds/60%60)<10)
				{
				$mins= "0" . ($seconds/60%60);
				}
				}
				else
				{
				$mins= "00";
				}
			//for hours
			if($seconds/60 > 60)
			{
			$hours= "". floor($seconds/60/60);
			if(($seconds/60/60) < 10)
			{
			$hours= "0" . floor($seconds/60/60);
			}
			
			}
			else
			{
			$hours= "00";
			}

            return   $time_format= "" . $hours . ":" . $mins . ":" . $sec; //00:15:00  
}

function pagination_url($page,$limit,$total_pages,$adjacent,$targetpage,$searchTextMatch,$fromdate,$todate)
{
//$page = 1;
//$page;			//if no page var is given, default to 1.
$prev = $page - 1;	//previous page is page - 1
$next = $page + 1;
//$limit=$pager->pageSize;	//next page is page + 1
$lastpage = ceil($total_pages/$limit);
$adjacents = $adjacent;				
$lpm1 = $lastpage - 1;					
$pagination = "";
$addParameter='';
if($searchTextMatch!=''){ $addParameter= "&filter_user=$searchTextMatch"; }
if($lastpage > 1)
{
    $pagination .= "<div class=\"pagination\">"; 
     if ($page >1)   
    // $pagination.= '<a href="javascript:void(0)"  onclick="changePagination(\''.$prev.'\',\''.$limit.'\',\''.$searchTextMatch.'\',\''.$fromdate.'\',\''.$todate.'\',\''.$pageUrl.'\',\''.$filtervalue.'\')"><i class="fa fa-long-arrow-left" aria-hidden="true"></i>
//Previous</a>';		
$pagination.= "<a href=\"$targetpage&page=$prev$addParameter\"><i class='fa fa-long-arrow-left' aria-hidden='true'></i> previous</a>";     
 else
	$pagination.= "<span class=\"disabled \"> <i class='fa fa-long-arrow-left' aria-hidden='true'></i> Previous</span>";	
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
                    
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
		          ?>
			<?php 	if ($counter == $page)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
				$pagination.= "<a href=\"$targetpage&page=$counter$addParameter\">$counter</a>";
				    
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
		{
    
			//close to beginning; only hide later pages
			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage&page=$counter$addParameter\">$counter</a>";	
					 }
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage&page=$lpm1$addParameter\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage&page=$lastpage$addParameter\">$lastpage</a>";	
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
                              $pagination.= "<a href=\"$targetpage&page=1$addParameter\">1</a>";
				$pagination.= "<a href=\"$targetpage&page=2$addParameter\">2</a>";
				$pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage&page=$counter$addParameter\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage&page=$lpm1$addParameter\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage&page=$lastpage$addParameter\">$lastpage</a>";   
		        }
			//close to end; only hide early pages
			else
			{   
				
				$pagination.= "<a href=\"$targetpage&page=1$addParameter\">1</a>";
				$pagination.= "<a href=\"$targetpage&page=2$addParameter\">2</a>";
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage&page=$counter$addParameter\">$counter</a>";					
				}
			}
		}
		
		//next button
		if ($page < $counter - 1) 
			$pagination.= "<a href=\"$targetpage&page=$next$addParameter\">Next <i class='fa fa-long-arrow-right' aria-hidden='true'></i></a>";
		else
			$pagination.= "<span class=\"disabled\">Next <i class='fa fa-long-arrow-right' aria-hidden='true'></i></span>";
		$pagination.= "</div>\n";	
	}
          return $pagination;
    
}

function pagination_video_thumb($page,$limit,$total_pages,$adjacent,$targetpage,$searchTextMatch,$fromdate,$todate,$pageUrl,$filtervalue)
{
//$page = 1;
//$page;			//if no page var is given, default to 1.
$prev = $page - 1;	//previous page is page - 1
$next = $page + 1;
//$limit=$pager->pageSize;	//next page is page + 1
$lastpage = ceil($total_pages/$limit);
$adjacents = $adjacent;				
$lpm1 = $lastpage - 1;					
$pagination = "";
if($lastpage > 1)
	{	
	    $pagination .= "<div class=\"pagination\">"; 
		//previous button
           	if ($page >1)   
		 $pagination.= '<a href="javascript:void(0)"  onclick="changePagination_thumbnail(\''.$prev.'\',\''.$limit.'\',\''.$searchTextMatch.'\',\''.$fromdate.'\',\''.$todate.'\',\''.$pageUrl.'\',\''.$filtervalue.'\')"><i class="fa fa-long-arrow-left" aria-hidden="true"></i>
Previous</a>';		
		else
			$pagination.= "<span class=\"disabled \"> <i class='fa fa-long-arrow-left' aria-hidden='true'></i> Previous</span>";	
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
                    
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
		          ?>
			<?php 	if ($counter == $page)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
				
				    $pagination.= '<a href="javascript:void(0)" onclick="changePagination_thumbnail(\''.$counter.'\',\''.$limit.'\',\''.$searchTextMatch.'\',\''.$fromdate.'\',\''.$todate.'\',\''.$pageUrl.'\',\''.$filtervalue.'\')">'.$counter.'</a>';		
				    //$content .='<a  href="javascript:void(0)" onclick="changePagination(\''.$i.'\',\''.$i.'_no\')">'.($i+1).'</a>';
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
		{
    
			//close to beginning; only hide later pages
			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						//$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";	
					    $pagination.= '<a href="javascript:void(0)" onclick="changePagination_thumbnail(\''.$counter.'\',\''.$limit.'\',\''.$searchTextMatch.'\',\''.$fromdate.'\',\''.$todate.'\',\''.$pageUrl.'\',\''.$filtervalue.'\')">'.$counter.'</a>';				
				}
				$pagination.= "...";
				//$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>"; 
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination_thumbnail(\''.$lpm1.'\',\''.$limit.'\',\''.$searchTextMatch.'\',\''.$fromdate.'\',\''.$todate.'\',\''.$pageUrl.'\',\''.$filtervalue.'\')">'.$lpm1.'</a>';
				
				//$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";	
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination_thumbnail(\''.$lastpage.'\',\''.$limit.'\',\''.$searchTextMatch.'\',\''.$fromdate.'\',\''.$todate.'\',\''.$pageUrl.'\',\''.$filtervalue.'\')">'.$lastpage.'</a>';	
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
                           
				//$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination_thumbnail(\'1\',\''.$limit.'\',\''.$searchTextMatch.'\',\''.$fromdate.'\',\''.$todate.'\',\''.$pageUrl.'\',\''.$filtervalue.'\')">1</a>';	
				//$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination_thumbnail(\'2\',\''.$limit.'\',\''.$searchTextMatch.'\',\''.$fromdate.'\',\''.$todate.'\',\''.$pageUrl.'\',\''.$filtervalue.'\')">2</a>';
				$pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
					//$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";	
					$pagination.= '<a href="javascript:void(0)" onclick="changePagination_thumbnail(\''.$counter.'\',\''.$limit.'\',\''.$searchTextMatch.'\',\''.$fromdate.'\',\''.$todate.'\',\''.$pageUrl.'\',\''.$filtervalue.'\')">'.$counter.'</a>';				
				}
				$pagination.= "...";
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination_thumbnail(\''.$lpm1.'\',\''.$limit.'\',\''.$searchTextMatch.'\',\''.$fromdate.'\',\''.$todate.'\',\''.$pageUrl.'\',\''.$filtervalue.'\')">'.$lpm1.'</a>';
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination_thumbnail(\''.$lastpage.'\',\''.$limit.'\',\''.$searchTextMatch.'\',\''.$fromdate.'\',\''.$todate.'\',\''.$pageUrl.'\',\''.$filtervalue.'\')">'.$lastpage.'</a>';	
			}
			//close to end; only hide early pages
			else
			{   
				
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination_thumbnail(\'1\',\''.$limit.'\',\''.$searchTextMatch.'\',\''.$fromdate.'\',\''.$todate.'\',\''.$pageUrl.'\',\''.$filtervalue.'\')">1</a>';	
				//$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination_thumbnail(\'2\',\''.$limit.'\',\''.$searchTextMatch.'\',\''.$fromdate.'\',\''.$todate.'\',\''.$pageUrl.'\',\''.$filtervalue.'\')">2</a>';
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
				    if ($counter == $page)
				      $pagination.= "<span class=\"current\">$counter</span>";
				    else
				      $pagination.= '<a href="javascript:void(0)" onclick="changePagination_thumbnail(\''.$counter.'\',\''.$limit.'\',\''.$searchTextMatch.'\',\''.$fromdate.'\',\''.$todate.'\',\''.$pageUrl.'\',\''.$filtervalue.'\')">'.$counter.'</a>';					
				}
			}
		}
		
		//next button
		if ($page < $counter - 1) 
			//$pagination.= "<a href=\"$targetpage?page=$next\">next �</a>";
		    $pagination.= '<a href="javascript:void(0)" onclick="changePagination_thumbnail(\''.$next.'\',\''.$limit.'\',\''.$searchTextMatch.'\',\''.$fromdate.'\',\''.$todate.'\',\''.$pageUrl.'\',\''.$filtervalue.'\')">Next  <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>';	 
		else
			$pagination.= "<span class=\"disabled\"> Next <i class='fa fa-long-arrow-right' aria-hidden='true'></i></span>";
		$pagination.= "</div>\n";		
	}
          return $pagination;
    
}


?>