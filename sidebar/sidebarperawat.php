<nav class="col-md-3 col-lg-2 d-md-block sidebar">
    <div class="position-sticky">
        <div class="text-center py-4">
            <img src="img/logo.png" alt="Logo" class="img-fluid">
            <h4>RSU Bhakti Asih Tangerang</h4>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="?halaman=dashboard">Beranda</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" id="toggleScheduleRequest">
                    Permohonan Jadwal
                    <i class="bi bi-chevron-down ms-1"></i> <!-- Ikon Chevron -->
                </a>
                <ul class="nav flex-column ms-3" id="scheduleRequestSubmenu" style="display: none;">
                    <li class="nav-item">
                        <a class="nav-link" href="?halaman=cuti">Cuti</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?halaman=shift">Shift</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?halaman=jadwal">Jadwal</a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="?halaman=logout">Logout</a>
            </li>
        </ul>
    </div>
</nav>
