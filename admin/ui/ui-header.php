<html>
	<head>
	
		<title><?php echo $pageInfo['name']; ?> - Studio Stein</title>
		
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<script src="https://kit.fontawesome.com/2699c07835.js" crossorigin="anonymous"></script>
		<link href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,300,400,600,700" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">

		<link rel="stylesheet" href="https://unpkg.com/cirrus-ui">
		
	</head>
	
	<body class="bg-light">
		<div class="header unselectable header-animated">
			<div class="header-brand">
				<div class="nav-item no-hover">
					<h6 class="title"><a href="index.php">Vlink</a></h6>
				</div>
				<div class="nav-item nav-btn" id="header-btn">
					<span></span>
					<span></span>
					<span></span>
				</div>
			</div>
			<div class="header-nav" id="header-menu">
				<div class="nav-left">
				</div>
				<div class="nav-center">
					<div class="nav-item">
						<a href="acessos.php">
							<span class="icon subtitle" style="font-size: 14px">
								<i class="far fa-wrapper fa-eye"></i>
							</span> 
							Acessos
						</a>
					</div>
					<div class="nav-item">
						<a href="users.php">
							<span class="icon subtitle" style="font-size: 14px">
								<i class="far fa-wrapper fa-user"></i>
							</span> 
							Usuários
						</a>
					</div>
					<div class="nav-item">
						<a href="forms.php">
							<span class="icon subtitle" style="font-size: 14px">
								<i class="far fa-wrapper fa-edit"></i>
							</span> 
							Formulários
						</a>
					</div>
				</div>
				<div class="nav-right">
					<div class="nav-item has-sub toggle-hover" id="dropdown">
						<figure class="avatar avatar--small u-center" data-text="<?php echo $_SESSION["login"]["initials"]; ?>"></figure>
						<a class="nav-dropdown-link"><?php echo $_SESSION["login"]["nome"]; ?></a>
						<ul class="dropdown-menu dropdown-animated" role="menu">
							<?php 
							
							if (in_array("master",$_SESSION["login"]["type"])) {
								echo '<li role="menu-item"><a href="admin/admin_clear_cookies.php">Clear Cookies</a></li>';
								echo '<li role="menu-item"><a href="admin/admin_convert_html.php">Convert HTML</a></li>';
								echo '<li class="dropdown-menu-divider"></li>';
							}
							
							?>
							<li role="menu-item"><a href="../">Acessar o Site</a></li>
							<li class="dropdown-menu-divider"></li>
							<li role="menu-item"><a href="?logout=1">Logout</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		
		<script>
			// Get all the nav-btns in the page
			navBtns = document.querySelectorAll('.nav-btn');

			// Add an event handler for all nav-btns to enable the dropdown functionality
			navBtns.forEach(function (ele) {
				ele.addEventListener('click', function() {
					// Get the dropdown-menu associated with this nav button (insert the id of your menu)
					dropDownMenu = document.getElementById('header-menu');

					// Toggle the nav-btn and the dropdown menu
					ele.classList.toggle('active');
					dropDownMenu.classList.toggle('active');
				});
			});
		</script>