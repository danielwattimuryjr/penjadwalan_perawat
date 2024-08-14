<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excel to MySQL Importer</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .box {
            width: 80px;
            height: 60px;
            background-color: aliceblue;
            margin: 0 auto;
            text-align: center;
            color: green;
            margin-top:5px;
            margin-bottom:50px;
            border-radius : 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Import Excel to MySQL</h1>
        <form action="process.php" method="post" enctype="multipart/form-data">
            <input type="file" name="file" id="file" required>
            <button type="submit" name="submit">Upload</button>
        </form>
    </div>
</body>
</html>
