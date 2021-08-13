<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>
	<form action="{{ route('uploaded.store') }}" method="POST" enctype="multipart/form-data">
		@csrf
		<input type="file" name="gambar"> &nbsp&nbsp&nbsp
		<button type="submit" name="submit">Simpan</button>
	</form>
</body>
</html>