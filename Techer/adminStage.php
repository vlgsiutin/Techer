<!DOCTYPE HTML>
<!--
	Prologue by HTML5 UP
	html5up.net | @n33co
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>

<?php
session_start();
	if (!(isset($_SESSION['user_id']) && $_SESSION['user_id'] != '')) {
		header ("Location: login.php");
	}
	include 'function.php';
/*
$_SESSION['target_id'] ='';
include 'function.php';
$conn = connect_to_database();
*/
	
	
	$sql = "SELECT * FROM techer_users WHERE user_id ='" . $_SESSION['user_id'] . "'";
		
	$con = mysql_connect("localhost", "seadmin", "19931113") or  
		die("Could not connect: " . mysql_error());  
	mysql_select_db("seproject");
	$retval =  mysql_query( $sql);
	if(! $retval ){
		die('Could not get data: ' . mysql_error());
	}	
	while($row = mysql_fetch_array($retval, MYSQL_ASSOC)){				
		
		$user_id = $row["user_id"];
		$user_name = $row["user_name"];
		$user_type = $row["user_type"];
		$user_gender = $row["user_gender"];
		$user_email = $row["user_email"];
		$user_phone = $row["user_phone"];
		$user_educationBackground = $row["user_educationBackground"];		
		$user_icon = $row["icon"];
		$user_cover = $row["cover"];		
		$user_regDay = $row["registrationDate"];
	}
?>

	<head>
		<title>Admin's Stage</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="assets/css/adminStageCss.css" />
		
		<link rel="stylesheet" href="assets/css/rate.css" />
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
		<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
	</head>
	
	<body onload="sorter.size(5)">

		<!-- Header -->
		<?php get_admin_menu($user_id); ?>

		<!-- Main -->
			<div id="main">
				
				<!-- Add New Users --> 				
				<section id="addUser" class="one dark">
					<div class="container">
						<header>
							<h2>Add New User </h2>
						</header>

													
						<form action="adminReg.php" method="post" enctype="multipart/form-data">
							<label>User type :</label>
							<select id="user_type" name="user_type">
								<option value="t0">Select...</option>
								<option value="s">Student</option>
								<option value="t">Tutor</option>
								<option value="a">Admin</option> 
							</select>
							
							<label>User Gender :</label>
							<select id="user_gender" name="user_gender">
								<option value="g0">Select...</option>
								<option value="female">Female</option>
								<option value="male">Male</option>
								
							</select>
							
							<label>UserName :</label>
							<input id="user_name" name="user_name" placeholder="" type="text">
							<label>Password :</label>
							<input id="user_password" name="user_password" placeholder="" type="password">
							
							<label>Comfirm Password :</label>                                
							<input id="com_password" name="com_password" placeholder="" type="password">
							<label>User Email :</label>
							<input id="user_email" name="user_email" type="text">
							<label>Phone Number :</label>
							<input id="phone_number" name="phone_number" type="text">
														
															
							</br>
							
							<input name="submit" value="Submit" type="submit" >
							</br>
							
							<input type="hidden" name="form_token" value="<?php echo $form_token; ?>" />
							
						</form>
					
					</div>
				</section>
					

				<!-- Display All Users --> 
					<section id="displayUser" class="two">
						<div class="container">

						<h2 >Display Users' Information</h2>
							
						<script>
							function showUser() {
								var str = document.getElementById('search').value;

								if(document.getElementById('t').checked)
									var type = document.getElementById('t').value;

								if(document.getElementById('s').checked)
									var type = document.getElementById('s').value;

								if(document.getElementById('a').checked)
									var type = document.getElementById('a').value;

								$.ajax({
									type: 'GET',
									url: 'showUser.php',		
									data: 'str=' +str+ '&type=' +type,
									cache: false,
	
									success:function(response){
										$('#searchResult').html(response);
									},
									error:function(){
										$('#searchResult').html = ('Error');
									}
								});
							};
						</script>
						
						<div class="searchbox">
							<form id="searchUser" method='GET'>
								<input type='radio' value='t' id='t' name='stype' onchange='showUser()'>Tutor
								
								<input type='radio' value='s' id='s' name='stype' onchange='showUser()'>Student

								<input type='radio' value='a' id='a' name='stype' onchange='showUser()'>Admin

								<input autocomplete='off' class='search' type='search' id='search' name='search' placeholder='SEARCH HERE' data-col='all' oninput='showUser()'/>
							</form>
						</div>
														
						<div id='searchResult' class="sortable">
							<p>User info will be listed here...</p>
							
							<table class="" id="t02" width="40" >
								<thead><tr>
									<th>ID</th>
									<th>Name</th>
									<th>Type</th>
									<th>Gender</th>
									<th>Email</th>
									<th>Phone</th>
									<th>Education Background</th>
									<th>RegDate</th>
									<th>User Access</th>
									<th>Status</th>
								</tr></thead>
								
								<tbody>
						<?php
						$sql = "SELECT * FROM techer_users";
						$con = mysql_connect("localhost", "seadmin", "19931113") or  
							die("Could not connect: " . mysql_error());  
						mysql_select_db("seproject");
						$retval =  mysql_query( $sql);
						if(! $retval ){
							die('Could not get data: ' . mysql_error());
						}
						
						while($row = mysql_fetch_array($retval, MYSQL_ASSOC)){	
							echo '<tr><td>' . $row['user_id']. '</td>' ;echo '<td>' .$row['user_name']. '</td>';
							echo '<td>' .$row['user_type']. '</td>';
							echo '<td>' .$row['user_gender']. '</td>';
							echo '<td>' .$row['user_email']. '</td>';
							echo '<td>' .$row['user_phone']. '</td>';
							echo '<td>' .$row['user_educationBackground']. '</td>';
							echo '<td>' .$row['registrationDate']. '</td>';
							echo '<td>' .$row['user_access']. '</td>';
							echo '<td>'	. $row['status']. '</td></tr>';
						}
						?>
						</tbody>
						</table>
						
						</div>
							
						<!-- pager -->							
						<div id="controls">
							<div id="perpage">
								<select onchange="sorter.size(this.value)">
									<option value="5">5</option>
									<option value="10">10</option>
									<option value="20">20</option>
									<option value="50">50</option>
									<option value="100">100</option>
								</select>
								<span>Entries Per Page</span>
							</div>
							<div id="navigation">
								<img src="images/first.gif" width="16" height="16" alt="First Page" onclick="sorter.move(-1,true)" />
								<img src="images/previous.gif" width="16" height="16" alt="First Page" onclick="sorter.move(-1)" />
								<img src="images/next.gif" width="16" height="16" alt="First Page" onclick="sorter.move(1)" />
								<img src="images/last.gif" width="16" height="16" alt="Last Page" onclick="sorter.move(1,true)" />
							</div>
							<div id="text">Displaying Page <span id="currentpage"></span> of <span id="pagelimit"></span></div>
						</div>
						</div>

					</section>


				<!-- Registration Requests --> 
					<section id="registration" class="three" >
						<div class="container">

							<header>
								<h2>Registration Requests </h2>
							</header>

							<table id="t01" >
								  <tr>
									<th>user name</th>
									<th>telephone</th>		
									<th>email</th>
									<th>education Background</th>
									<th> </th>
								  </tr>
								  <tr>
							<?php
							$ids=array();
							$i =0;
							$sql = "SELECT user_id, user_name, user_email, user_phone, user_educationBackground FROM techer_users WHERE status ='N' AND user_type='t'";
							$con = mysql_connect("localhost", "seadmin", "19931113") or  
								die("Could not connect: " . mysql_error());  
							mysql_select_db("seproject");
							$retval =  mysql_query( $sql);
							if(! $retval ){
								die('Could not get data: ' . mysql_error());
							}	
							while($row = mysql_fetch_array($retval, MYSQL_ASSOC)){	

								echo '<FORM method="POST" action="registration_details.php">';
								echo '<td>' . $row["user_name"] . '</td>' ;
								echo '<td>' . $row["user_email"] . '</td>' ;
								echo '<td>' . $row["user_phone"] . '</td>' ;
								echo '<td>' . $row["user_educationBackground"] . '</td>' ;
								echo '<td><input type="hidden" name="idss" value="'.$row["user_id"].'"/>									
									<input type="submit" value="Detail"/>
									</FORM>
									</td></tr>';

							}
							?>
							</table>
							
						</div>
					</section>
					
				<!-- Advertisement Requests --
				<section id="advertisement" class="two" style="padding-bottom: 200px;">
					<div class="container">

							<header>
								<h2 style="color:white;">Advertisement Requests </h2>
							</header>

							<?php get_all_tutor_ads_request();
							//<table id="t02" >
							?>
							
						</div>
				</section>-->

				<!-- Message -->
					<section id="message" class="four" >
						<div class="container">

							<header>
								<h2>Messages</h2>
							</header>
							

							<table id="t01" >
								  <tr>
									<th>From (user)</th>
									<th>Content</th>
									<th>Send reply</th>
								  </tr>
								  <?php loop_message();?>

							</table>							
						</div>
					</section>

				<!-- Statistics -->
					<section id="statistics" class="five" >
						<div class="container">

							<header>
								<h2 style="color:white;">Statistics</h2>
							</header>	
								
							<div class="stat">
								<!--<p>Total login : <?php stats("log");?></p>-->
								<p>Total Students : <?php stats("student");?></p>
								<p>Total Tutor : <?php stats("tutor");?></p>
								<p>Total Classes : <?php stats("class");?></p>
							</div>
							

						</div>
					</section>			
					
			</div>


		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/jquery.scrollzer.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="assets/js/main.js"></script>
			<script src="assets/js/jquery.tablesorter.js"></script>
			<script>
			var sorter = new TINY.table.sorter("sorter");
			sorter.head = "head";
			sorter.asc = "asc";
			sorter.desc = "desc";
			sorter.even = "evenrow";
			sorter.odd = "oddrow";
			sorter.evensel = "evenselected";
			sorter.oddsel = "oddselected";
			sorter.paginate = true;
			sorter.currentid = "currentpage";
			sorter.limitid = "pagelimit";
			sorter.init("t02",1);
			</script>
			

	</body>
</html>