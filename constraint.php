<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Constraint Table</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Constraint Penjadwalan</h1>
        <table class="table  table-bordered">
            <thead class="table-info">
                <tr>
                    <th>ID Constraint</th>
                    <th>Keterangan</th>
                    <th>Jenis</th>
                    <th>Konstanta</th>
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

                // Query to fetch data from the 'constraint' table
                $sql = "SELECT id_constraint, keterangan, jenis, konstanta FROM `constraint`";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id_constraint']}</td>
                                <td>{$row['keterangan']}</td>
                                <td>{$row['jenis']}</td>
                                <td>{$row['konstanta']}</td>
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
