<?php
if(isset($_GET['l']))
{
	if($_GET['l'] == "lr")
	{
		$_SESSION['msg'] = "<strong>Cadastrado</strong> com sucesso!";
		$_SESSION['alert'] = "alert-success";
	}
}
if(isset($_POST['email']) && isset($_POST['senha']))
{
	session_start();

	require_once ("classes/Usuario.php");
	$usuario = new Usuario();

	if(isset($_GET['a']))
	$usuario->add();
	else
	$usuario->login();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login N+</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="images/favicon-edit.ico"/>
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<!--===============================================================================================-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<style>
	.pop{
		margin-top: 130px;
		margin-left: 50px;
		position:absolute;
		width: 270px;
	}
	</style>
</head>
<body>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-t-0 p-b-0">
				<div class="pop text-center">
					<?php if(isset($_SESSION['msg'])) :?>
						<div class="alert <?php echo $_SESSION['alert'];?>">
							<?php echo $_SESSION['msg'];?>
						</div>
					<?php endif?>
				</div>
				<form class="login100-form validate-form" action="
				<?php
				if(isset($_GET['a']))
				echo "index2.php?a=r";
				else
				echo "index2.php";
				?>
				" method="post">
				<span class="login100-form-title p-b-0">
					N<b id="plus" class="small">+</b>
					<hr>
				</span>
				<span class="login100-form-title p-b-0">
					<?php
					if(isset($_GET['a']))
					echo "REGISTRAR";
					else
					echo "LOGIN";
					?>
				</span>
				<div class="wrap-input100 validate-input m-t-85 m-b-35" data-validate = "DIGITE SEU USUÁRIO">
					<input class="input100" type="text" name="email"  >
					<span class="focus-input100" data-placeholder="Usuário"></span>
				</div>

				<div class="wrap-input100 validate-input m-b-50" data-validate="DIGITE SUA SENHA">
					<input class="input100" type="password" name="senha"  >
					<span class="focus-input100" data-placeholder="Senha"></span>
				</div>

				<div class="container-login100-form-btn">
					<button class="login100-form-btn">
						<?php
						if(isset($_GET['a']))
						echo "REGISTRAR";
						else
						echo "LOGIN";
						?>
					</button>
				</div>
				<div class="container-login100-form-btn m-t-10" style="cursor: pointer;" id="registre">
					<?php
					if(isset($_GET['a']))
					echo "LOGIN";
					else
					echo "REGISTRE-SE";
					?>
				</div>
			</form>
		</div>
	</div>
</div>


<div id="dropDownSelect1"></div>

<script type="text/javascript">
$(document).ready(function(){
	$("#registre").click(function(){
		<?php
		if(isset($_GET['a']))
		echo 'window.location.href = "index2.php";';
		else
		echo 'window.location.href = "index2.php?a=r";';
		?>
	});
});
</script>
<!--===============================================================================================-->
<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/bootstrap/js/popper.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/daterangepicker/moment.min.js"></script>
<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
<script src="js/main2.js"></script>

</body>
</html>
