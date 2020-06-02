<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<form action="" method="post" enctype="multipart/form-data">
		@csrf
		<input type="file" name="file">
		<button>Valider</button>
	</form>
	<img src="{{ asset('./storage/Capture.PNG') }}" alt="^^" title="">
</body>
</html>