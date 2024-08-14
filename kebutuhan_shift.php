<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kebutuhan Shift Table</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Kebutuhan Shift  Unit Nusa Indah</h1>
        <table class="table  table-bordered">
            <thead class="table-info">
                <tr>
                    <th>ID Kebutuhan Shift</th>
                    <th>Waktu Shift</th>
                    <th>Kebutuhan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Replace with your actual database connection details
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "db_penjadwalan";

                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Query to fetch data from the 'kebutuhan_shift' table
                $sql = "SELECT id_kebutuhanshift, waktu_shift, kebutuhan, unit FROM `kebutuhan_shift`";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id_kebutuhanshift']}</td>
                                <td>{$row['waktu_shift']}</td>
                                <td>{$row['kebutuhan']}</td>
                               
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' class='text-center'>No data found</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
