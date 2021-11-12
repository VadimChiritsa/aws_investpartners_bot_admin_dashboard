<table class="table table-striped table-bordered table-hover" id="dataTables-example3">
<thead>
<tr>
	<th><a href="/sort_ads.php?s=username">Username</a></th>
	<th><a href="/sort_ads.php?s=amount">Amount</a></th>
	<th><a href="/sort_ads.php?s=type">Type</a></th>
	<th><a href="/sort_ads.php?s=pay">Pay</a></th>
	<th><a href="/sort_ads.php?s=currency">Currency</a></th>
	<th><a href="/sort_ads.php?s=city">City</a></th>
	<th><a href="/sort_ads.php?s=rates">Rates</a></th>
	<th><a href="/sort_ads.php?s=comment">Comment</a></th>
<th></th>
</tr>
</thead>
<tbody>

    
    

	

	
	



	

<?

 

    
    
    
        
       $param_term = $_GET["search"];
	$mysqli = new mysqli('localhost', 'telegram_investpartners2021', 'investpartners2021', 'telegram_bot_invest_partners', '3306');
	$mysqli->set_charset("utf8");
	
	if($param_term!=''){
	
	$res2 = $mysqli->query("SELECT * FROM ads  WHERE username LIKE '%$param_term%' || amount LIKE '%$param_term%' || type LIKE '%$param_term%' || pay LIKE '%$param_term%' || currency LIKE '%$param_term%' || city LIKE '%$param_term%' || rates LIKE '%$param_term%' || comment LIKE '%$param_term%'");
	$mes='';
	}else{
		$res2 = $mysqli->query("SELECT * FROM ads");
	$mes='';
		
	}
	
while($row2 = $res2->fetch_assoc()):
	?>
        
   
<tr class="odd gradeX">
    <td><? echo $row2['username'];?></td>
    <td><? echo $row2['amount'];?></td>
    <td><? echo $row2['type'];?></td>
    <td><? echo $row2['pay'];?></td>
    <td><? echo $row2['currency'];?></td>
    <td><? echo $row2['city'];?></td>
    <td><? echo $row2['rates'];?></td>
    <td><? echo $row2['comment'];?></td>
    <td><a href="https://investpartners.link/index.php/dashboard/delete_ads/<? echo $row2['id_ads'];?>">Delete</a></td>
    </tr>
    
       
           
	
            
            
          
         
     
   
    
<? endwhile ?>
	
	

 


	</tbody>
</table>

<!-- PAGINATION -->
	<style>
		.pagin{
			margin: 5px;
		}
	</style>
	<?
	$pervpage='';
	$nextpage='';
	$page2left='';
	$page1left='';
	$page2right='';
	$page1right='';
						  
	
if ($_SESSION['cur_page'] != 1) $pervpage = '<a class="pagin" href="/page_user.php?page=1"><<</a>
                               <a class="pagin" href= "/page_user.php?page='. ($_SESSION['cur_page'] - 1) .'"><</a> ';

if ($_SESSION['cur_page'] != $_SESSION['total_pages']) $nextpage = ' <a class="pagin" href= "/page_user.php?page='. ($_SESSION['cur_page'] + 1) .'">></a>
                                   <a class="pagin" href= "/page_user.php?page=' .$_SESSION['total_pages'].'">>></a>';


if($_SESSION['cur_page'] - 2 > 0) $page2left = ' <a class="pagin" href= "/page_user.php?page='. ($_SESSION['cur_page'] - 2) .'">'. ($_SESSION['cur_page'] - 2) .'</a>';
if($_SESSION['cur_page'] - 1 > 0) $page1left = '<a class="pagin" href= "/page_user.php?page='. ($_SESSION['cur_page'] - 1) .'">'. ($_SESSION['cur_page'] - 1) .'</a>';
if($_SESSION['cur_page'] + 2 <= $_SESSION['total_pages']) $page2right = '<a class="pagin" href= "/page_user.php?page='. ($_SESSION['cur_page'] + 2) .'">'. ($_SESSION['cur_page'] + 2) .'</a>';
if($_SESSION['cur_page'] + 1 <= $_SESSION['total_pages']) $page1right = '<a class="pagin" href= "/page_user.php?page='. ($_SESSION['cur_page'] + 1) .'">'. ($_SESSION['cur_page'] + 1) .'</a>';


		  if($_SESSION['total_pages']>1){
echo $pervpage.$page2left.$page1left.'<span class="pagin active" style="text-decoration:none">'.$_SESSION['cur_page'].'</span>'.$page1right.$page2right.$nextpage;
		  }
						  ?>