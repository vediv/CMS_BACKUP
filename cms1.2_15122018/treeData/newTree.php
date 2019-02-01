<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<!-- jQuery -->
<title>phpzag.com : Demo Create Treeview with jsTree, PHP and MySQL</title>
<link rel="stylesheet" href="style.min.css" />
<script src="jstree.min.js"></script>
</head>
<body class="">
<div role="navigation" class="navbar navbar-default navbar-static-top">
    </div>
	<div class="container" style="min-height:500px;">
	
	
	<div class="container">
		
	<div class="row">	
		<div id="tree-data-container"></div>				
	</div>	
			
</div>
<script type="text/javascript">
$(document).ready(function(){ 
     $('#tree-data-container').jstree({
	'plugins': ["wholerow", "checkbox"],
        'core' : {
            'data' : {
                "url" : "../coreData.php?action=treeNew",
                "dataType" : "json" 
            }
        }
    }) 
});
</script>
</div>
</body>
</html>


