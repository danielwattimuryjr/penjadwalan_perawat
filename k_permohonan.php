<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permohonan Jadwal Table - Nusa Indah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Permohonan Jadwal Table - Nusa Indah</h1>
        <table class="table  table-bordered">
            <thead class="table-info">
                <tr>
                    <th>ID Permohonan</th>
                    <th>ID Perawat</th>
                    <th>Hari</th>
                    <th>Tanggal</th>
                    <th>Waktu Shift</th>
                    <th>Keterangan</th>
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

                // Query to fetch data from the 'permohonan_jadwal' table where unit is 'Nusa Indah'
                $sql = "SELECT pj.id_permohonan, pj.id_perawat, pj.hari, pj.tanggal, pj.waktu_shift, pj.keterangan 
                        FROM permohonan_jadwal pj 
                        JOIN perawat p ON pj.id_perawat = p.id_perawat
                        WHERE p.unit = 'nusa indah'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id_permohonan']}</td>
                                <td>{$row['id_perawat']}</td>
                                <td>{$row['hari']}</td>
                                <td>{$row['tanggal']}</td>
                                <td>{$row['waktu_shift']}</td>
                                <td>{$row['keterangan']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center'>No data found</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
