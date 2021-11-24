<table class="table table-striped table-bordered table-hover" id="dataTables-example1">
<thead>
<tr>
	<th><a href="/sort_users.php?s=telegram_id">telegram_id</a></th>
<th><a href="/sort_users.php?s=language">Language</a></th>
	<th><a href="/sort_users.php?s=last_action">Last action</a></th>
	<th><a href="/sort_users.php?s=email_amir">Email amir</a></th>
	<th><a href="/sort_users.php?s=name">Name</a></th>
	<th><a href="/sort_users.php?s=username_ambosador">User ambassador</a></th>
	<th><a href="/sort_users.php?s=status">Status</a></th>
	<th><a href="/sort_users.php?s=username_partner">Partner</a></th>
<th></th>
<th></th>
</tr>
</thead>
<tbody>
	

	
	



	

<?

 

    
    
    
        
       $param_term = $_GET["search"];
	$mysqli = new mysqli('localhost', 'telegram_investpartners2021', 'investpartners2021', 'telegram_bot_invest_partners', '3306');
	$mysqli->set_charset("utf8");
	
	if($param_term!=''){
	
	$res2 = $mysqli->query("SELECT * FROM users  WHERE telegram_id LIKE '%$param_term%' || language LIKE '%$param_term%' || last_action LIKE '%$param_term%' || email_amir LIKE '%$param_term%' || name LIKE '%$param_term%' || username_ambosador LIKE '%$param_term%' || status LIKE '%$param_term%' || username_partner LIKE '%$param_term%'");
	$mes='';
	}else{
		$res2 = $mysqli->query("SELECT * FROM users");
	$mes='';
		
	}
	
while($row2 = $res2->fetch_assoc()):
	?>
        
   
<tr class="odd gradeX">
    <td><? echo $row2['telegram_id'];?></td>
<td><? echo $row2['language'];?></td>
<td><? echo $row2['last_action'];?></td>
<td><? echo $row2['email_amir'];?></td>
<td><? echo $row2['name'];?></td>
<td><? echo $row2['username_ambosador'];?></td>
<td><? echo $row2['status'];?></td>
<td><? echo $row2['username_partner'];?></td>
    <td><a href="https://investpartners.link/index.php/dashboard/edit_user/<? echo $row2['telegram_id'];?>">Edit</a></td>
<td><a href="https://investpartners.link/index.php/dashboard/delete_user/<? echo $row2['telegram_id'];?>">Delete</a></td>
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