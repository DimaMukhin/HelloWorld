<?php
	// define variables and set to empty values
	$name = $comment = "";
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") 
	{
		$name = $_POST["name"];
		$comment = $_POST["comment"];
		
		$serverName = "localhost";
		$dbName = "helloworld";

		// Create connection
		$conn = new mysqli($serverName, "root", "", $dbName);
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		
		if (strlen("$name") < 20 && strlen("$comment") < 200)
		{
			$sql = "INSERT INTO comments (Name, Comment) VALUES ('$name', '$comment');";
			$conn->query($sql);
		}
		else
		{
			echo "<script>alert('Name or comment is too long. Name 20 chars, comment 200 chars');</script>";
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
		<div class="container">
			<div class="page-header">
				<h1>Hello World! <small>Say something, the world is waiting.</small></h1>
			</div>
			
			<form class="form-horizontal" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<div class="form-group">
					<label for="name" class="col-sm-1 control-label">Name</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="name" name="name">
					</div>
				</div>
				<div class="form-group">
					<label for="comment" class="col-sm-1 control-label">Comment</label>
					<div class="col-sm-10">
						<textarea class="form-control" id="comment" rows="3" name="comment"></textarea>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-1 col-sm-10">
						<button type="submit" class="btn btn-default">Post</button>
					</div>
				</div>
			</form>
			
			<div id="comments">
				<?php
					$serverName = "localhost";
					$dbName = "helloworld";

					// Create connection
					$conn = new mysqli($serverName, "root", "", $dbName);
					// Check connection
					if ($conn->connect_error)
						die("Connection failed: " . $conn->connect_error);
					
					$sql = "SELECT * FROM comments";
					$comments = $conn->query($sql);
					
					$page = 0;
					if (isset($_GET["Page"]))
						$page = $_GET["Page"];
					
					$firstComment = $page * 5;
					$lastComment = $firstComment + 5;
					$index = 0;
					while ($comment = $comments->fetch_assoc())
					{
						if ($index < $firstComment)
						{
							$index++;
							continue;
						}
						elseif ($index >= $lastComment)
							break;
						
						$name = $comment["Name"];
						$message = $comment["Comment"];
						echo
						"
						<div class='panel panel-default'>
							<div class='panel-heading'>$name</div>
							<div class='panel-body'>
								$message
							</div>
						</div>
						";
						$index++;
					}
					
					$prevDisabled = "";
					$prevPage = $page - 1;
					if ($page == 0)
					{
						$prevDisabled = "disabled";
						$prevPage = 0;
					}
						
					$nextDisabled = "";
					$nextPage = $page + 1;
					if ($nextPage * 5 >= $comments->num_rows)
					{
						$nextDisabled = "disabled";
						$nextPage = $page;
					}
					
					echo 
					"
						<nav aria-label='...'>
							<ul class='pager'>
								<li class='previous $prevDisabled'><a href='index.php?Page=$prevPage'><span aria-hidden='true'>&larr;</span> Newer</a></li>
								<li class='next $nextDisabled'><a href='index.php?Page=$nextPage'>Older <span aria-hidden='true'>&rarr;</span></a></li>
							</ul>
						</nav>
					";
				?>
			</div>
		</div>
		
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="js/bootstrap.min.js"></script>
  </body>
</html>