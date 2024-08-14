<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perawat Table - Nusa Indah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Perawat Table - Nusa Indah</h1>
        <table class="table  table-bordered">
            <thead class="table-info">
                <tr>
                    <th>No </th>
                    <th>Username</th>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>Unit</th>
                    <th>Jabatan</th>
                    <th>Status</th>
                    <th>Alamat</th>
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

                // Query to fetch data from the 'perawat' table where unit is 'Nusa Indah'
                $sql = "SELECT id_perawat, username, nama, jenis_kelamin, unit, jabatan, status, alamat 
                        FROM perawat 
                        WHERE unit = 'Nusa Indah'";
                $result = $conn->query($sql);
                $no=0;

                if ($result->num_rows > 0) {
                  
                    // Output data of each row
                    while($row = $result->fetch_assoc()) {
                        $no++;
                        echo "<tr>
                                <td>$no</td>
                                <td>{$row['username']}</td>
                                <td>{$row['nama']}</td>
                                <td>{$row['jenis_kelamin']}</td>
                                <td>{$row['unit']}</td>
                                <td>{$row['jabatan']}</td>
                                <td>{$row['status']}</td>
                                <td>{$row['alamat']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8' class='text-center'>No data found</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
