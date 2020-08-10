<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<p>{{$details['header']}}</p>
	<p>{{$details['p1']}}</p>
	@if(isset($details['p2']))
	<p>{{$details['p2']}}</p>
	<p>{{$details['p3']}}</p>
	@endif
	@if(!isset($details['p8']))
	Cliquez dès maintenant sur le lien suivant pour y accéder :<a href="https://www.mmp06.fr">https://www.mmp06.fr</a>
	<br>
	Cordialement
	<br>
	L'équipe de MMP
	@endif
</body>
</html>