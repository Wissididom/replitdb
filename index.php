<!DOCTYPE html>
<html>
	<head>
		<title>replit Database Manipulator</title>
		<link rel="stylesheet" href="index.css">
	</head>
	<body>
		<form method="POST" action="cors.php" target="result">
			<div class="grid">
				<label class="col-1" for="replit_db_url">REPLIT_DB_URL:</label>
				<input class="col-2" type="text" id="replit_db_url" name="replit_db_url" placeholder="echo $REPLIT_DB_URL">
				<label class="col-1" for="db_key">DB Key:</label>
				<input class="col-2" type="text" id="db_key" name="db_key" placeholder="DB Key">
				<label class="col-1" for="method">Method:</label>
				<select class="col-2" id="method" name="method" value="get">
					<option value="get" selected>Get</option>
					<option value="set">Set</option>
					<option value="delete">Delete</option>
					<option value="list">List</option>
				</select>
				<label class="col-1" for="db_value">DB Value:</label>
				<textarea class="col-2" id="db_value" name="db_value" placeholder="DB Value (or prefix in case of List)"></textarea><br />
				<input class="span-cols" type="submit" value="Execute">
			</div>
		</form>
		<br />
		<div class="grid">
			<label class="col-1" for="result">Response:</label><br />
			<iframe class="span-cols" name="result" id="result">IFrames aren't supported in this browser</iframe>
		</div>
	</body>
</html>
