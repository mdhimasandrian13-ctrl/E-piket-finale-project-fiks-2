<?php
/**
 * ============================================
 * E-PIKET SMEKDA - Detail Absensi dengan Foto
 * ============================================
 * File: admin/detail-absensi.php
 * Deskripsi: Melihat detail absensi siswa dengan foto
 * ============================================
 */

session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

require_once '../config/database.php';

// Get filter parameters
$filter_date = isset($_GET['date']) ? escape($_GET['date']) : date('Y-m-d');
$filter_class = isset($_GET['class']) ? escape($_GET['class']) : '';
$filter_status = isset($_GET['status']) ? escape($_GET['status']) : '';

// Query untuk get semua kelas
$classes = fetch_all("SELECT id, class_name FROM classes WHERE is_active = 1 ORDER BY class_name ASC");

// Build query
$where = "WHERE a.attendance_date = '$filter_date'";

if (!empty($filter_class)) {
    $where .= " AND c.id = '$filter_class'";
}

if (!empty($filter_status)) {
    $where .= " AND a.status = '$filter_status'";
}

// Query data absensi dengan foto
$attendances = fetch_all("SELECT 
    a.*,
    u.nis,
    u.full_name,
    c.class_name,
    s.shift,
    s.day_name
FROM attendances a
JOIN users u ON a.student_id = u.id
JOIN schedules s ON a.schedule_id = s.id
JOIN classes c ON u.class_id = c.id
$where
ORDER BY c.class_name, u.full_name");

$current_page = 'laporan';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Absensi - E-piket SMEKDA</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fa;
            color: #333;
        }

        .hamburger-btn {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 2000;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            transition: all 0.3s;
        }
        
        .hamburger-btn:hover {
            transform: translateY(-2px);
        }
        
        .sidebar {
            position: fixed;
            left: -260px;
            top: 0;
            height: 100vh;
            width: 260px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
            z-index: 1999;
            overflow-y: auto;
            transition: left 0.3s ease;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
        }
        
        .sidebar.active {
            left: 0;
        }
        
        .sidebar::-webkit-scrollbar {
            width: 5px;
        }
        
        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
        }
        
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1998;
            display: none;
        }
        
        .sidebar-overlay.active {
            display: block;
        }
        
        .sidebar-header {
            color: white;
            text-align: center;
            padding: 20px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            margin-bottom: 30px;
            margin-top: 40px;
        }
        
        .sidebar-header h3 {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .sidebar-header p {
            font-size: 12px;
            opacity: 0.8;
        }
        
        .close-sidebar {
            position: absolute;
            top: 20px;
            right: 20px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: none;
            width: 35px;
            height: 35px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }
        
        .close-sidebar:hover {
            background: rgba(255, 255, 255, 0.3);
        }
        
        .nav-menu {
            list-style: none;
        }
        
        .nav-item {
            margin-bottom: 5px;
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: white;
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.3s;
            font-size: 14px;
        }
        
        .nav-link:hover, .nav-link.active {
            background: rgba(255, 255, 255, 0.2);
            transform: translateX(5px);
        }
        
        .nav-link i {
            width: 20px;
            margin-right: 10px;
        }

        .main-content {
            margin-left: 0;
            padding: 20px;
            padding-top: 90px;
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            flex-wrap: wrap;
            gap: 15px;
        }

        .header-left h1 {
            font-size: 28px;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .header-left h1 i {
            color: #667eea;
        }

        .header-left p {
            color: #999;
            font-size: 14px;
        }

        .btn-kembali {
            padding: 12px 20px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 14px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-kembali:hover {
            background: #5568d3;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
            color: white;
        }

        .filter-section {
            background: white;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .filter-section h3 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #333;
        }

        .filter-section h3 i {
            color: #667eea;
        }

        .filter-form {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            align-items: flex-end;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-weight: 500;
            margin-bottom: 8px;
            color: #333;
            font-size: 14px;
        }

        .form-control {
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s;
            font-family: 'Poppins', sans-serif;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
            outline: none;
        }

        .btn-filter {
            padding: 12px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
            justify-content: center;
        }

        .btn-filter:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        .content-section {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .attendance-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .attendance-card {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            border-left: 4px solid #667eea;
            transition: all 0.3s;
        }

        .attendance-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 15px;
        }

        .student-info h5 {
            margin: 0 0 5px 0;
            color: #333;
            font-weight: 600;
            font-size: 16px;
        }

        .student-info p {
            margin: 0;
            color: #666;
            font-size: 13px;
        }

        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-success {
            background: #d4edda;
            color: #155724;
        }

        .badge-danger {
            background: #f8d7da;
            color: #721c24;
        }

        .badge-info {
            background: #d1ecf1;
            color: #0c5460;
        }

        .card-body {
            margin-bottom: 15px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 13px;
        }

        .info-label {
            color: #666;
        }

        .info-value {
            color: #333;
            font-weight: 500;
        }

        .photo-section {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #e0e0e0;
        }

        .photo-label {
            font-size: 12px;
            color: #666;
            margin-bottom: 8px;
            display: block;
        }

        .photo-thumbnail {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            border: 2px solid #e0e0e0;
        }

        .photo-thumbnail:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .no-photo {
            width: 100%;
            height: 200px;
            background: #f0f0f0;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #999;
            font-size: 14px;
            border: 2px dashed #ddd;
        }

        .photo-modal {
            display: none;
            position: fixed;
            z-index: 3000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.9);
            align-items: center;
            justify-content: center;
        }

        .photo-modal.show {
            display: flex;
        }

        .photo-modal-content {
            max-width: 90%;
            max-height: 90%;
            border-radius: 8px;
        }

        .photo-modal-close {
            position: absolute;
            top: 20px;
            right: 40px;
            color: white;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
        }

        .photo-modal-close:hover {
            color: #ccc;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }

        .empty-state i {
            font-size: 64px;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        @media (max-width: 768px) {
            .hamburger-btn {
                width: 45px;
                height: 45px;
                font-size: 18px;
            }
            
            .main-content {
                padding: 15px;
                padding-top: 85px;
            }
            
            .header-section {
                flex-direction: column;
                text-align: center;
            }
            
            .filter-form {
                grid-template-columns: 1fr;
            }
            
            .attendance-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Hamburger Button -->
    <button class="hamburger-btn" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>
    
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" onclick="toggleSidebar()"></div>
    
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <button class="close-sidebar" onclick="toggleSidebar()">
            <i class="fas fa-times"></i>
        </button>
        
        <div class="sidebar-header">
            <h3>E-PIKET</h3>
            <p>SMEKDA Admin</p>
        </div>
        
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="dashboard.php" class="nav-link">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="kelola-siswa.php" class="nav-link">
                    <i class="fas fa-user-graduate"></i>
                    <span>Kelola Siswa</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="kelola-guru.php" class="nav-link">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <span>Kelola Guru</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="kelola-kelas.php" class="nav-link">
                    <i class="fas fa-school"></i>
                    <span>Kelola Kelas</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="kelola-jadwal.php" class="nav-link">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Jadwal Piket</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="laporan.php" class="nav-link">
                    <i class="fas fa-chart-bar"></i>
                    <span>Laporan</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="detail-absensi.php" class="nav-link active">
                    <i class="fas fa-images"></i>
                    <span>Foto Absensi</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="pengaturan.php" class="nav-link">
                    <i class="fas fa-cog"></i>
                    <span>Pengaturan</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="main-content">
        <!-- Header Section -->
        <div class="header-section">
            <div class="header-left">
                <h1><i class="fas fa-images"></i> Detail Absensi dengan Foto</h1>
                <p>Lihat detail absensi siswa beserta foto</p>
            </div>
            <a href="laporan.php" class="btn-kembali">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <h3><i class="fas fa-filter"></i> Filter Data</h3>
            
            <form method="GET" action="" class="filter-form">
                <div class="form-group">
                    <label for="date">Tanggal</label>
                    <input type="date" name="date" id="date" class="form-control" value="<?php echo $filter_date; ?>">
                </div>

                <div class="form-group">
                    <label for="class">Kelas</label>
                    <select name="class" id="class" class="form-control">
                        <option value="">-- Semua Kelas --</option>
                        <?php foreach ($classes as $class): ?>
                            <option value="<?php echo $class['id']; ?>" <?php echo $filter_class == $class['id'] ? 'selected' : ''; ?>>
                                <?php echo $class['class_name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="">-- Semua Status --</option>
                        <option value="hadir" <?php echo $filter_status == 'hadir' ? 'selected' : ''; ?>>Hadir</option>
                        <option value="izin" <?php echo $filter_status == 'izin' ? 'selected' : ''; ?>>Izin</option>
                        <option value="sakit" <?php echo $filter_status == 'sakit' ? 'selected' : ''; ?>>Sakit</option>
                        <option value="alpha" <?php echo $filter_status == 'alpha' ? 'selected' : ''; ?>>Alpha</option>
                    </select>
                </div>

                <button type="submit" class="btn-filter">
                    <i class="fas fa-search"></i> Filter
                </button>
            </form>
        </div>

        <!-- Content Section -->
        <div class="content-section">
            <h3 style="margin-bottom: 20px; color: #333;">
                <i class="fas fa-list"></i> Data Absensi - <?php echo format_tanggal_indonesia($filter_date); ?>
                <span style="color: #999; font-size: 14px; font-weight: normal;">(<?php echo count($attendances); ?> data)</span>
            </h3>

            <?php if (count($attendances) > 0): ?>
            <div class="attendance-grid">
                <?php foreach ($attendances as $att): 
                    $badge_class = 'badge-success';
                    if ($att['status'] == 'alpha') $badge_class = 'badge-danger';
                    elseif (in_array($att['status'], ['izin', 'sakit'])) $badge_class = 'badge-info';
                ?>
                <div class="attendance-card">
                    <div class="card-header">
                        <div class="student-info">
                            <h5><?php echo $att['full_name']; ?></h5>
                            <p><i class="fas fa-id-card"></i> <?php echo $att['nis']; ?> | <?php echo $att['class_name']; ?></p>
                        </div>
                        <span class="badge <?php echo $badge_class; ?>">
                            <?php echo strtoupper($att['status']); ?>
                        </span>
                    </div>

                    <div class="card-body">
                        <div class="info-row">
                            <span class="info-label"><i class="fas fa-calendar"></i> Tanggal:</span>
                            <span class="info-value"><?php echo format_tanggal_indonesia($att['attendance_date']); ?></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label"><i class="fas fa-clock"></i> Shift:</span>
                            <span class="info-value"><?php echo ucfirst($att['shift']); ?> (<?php echo $att['day_name']; ?>)</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label"><i class="fas fa-sign-in-alt"></i> Check In:</span>
                            <span class="info-value"><?php echo $att['check_in_time'] ?? '-'; ?></span>
                        </div>
                        <?php if ($att['notes']): ?>
                        <div class="info-row">
                            <span class="info-label"><i class="fas fa-sticky-note"></i> Catatan:</span>
                            <span class="info-value"><?php echo $att['notes']; ?></span>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="photo-section">
                        <span class="photo-label"><i class="fas fa-camera"></i> Foto Absensi:</span>
                        <?php if ($att['photo_path']): ?>
                            <img src="../<?php echo $att['photo_path']; ?>" 
                                 alt="Foto Absensi" 
                                 class="photo-thumbnail"
                                 onclick="showPhotoModal('../<?php echo $att['photo_path']; ?>', '<?php echo addslashes($att['full_name']); ?>')">
                        <?php else: ?>
                            <div class="no-photo">
                                <i class="fas fa-image"></i> Tidak ada foto
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <p>Tidak ada data absensi untuk filter yang dipilih</p>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Photo Modal -->
    <div id="photoModal" class="photo-modal" onclick="closePhotoModal()">
        <span class="photo-modal-close">&times;</span>
        <img id="photoModalImg" class="photo-modal-content" src="" alt="Foto Absensi">
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.querySelector('.sidebar-overlay');
            
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        }

        function showPhotoModal(src, name) {
            const modal = document.getElementById('photoModal');
            const modalImg = document.getElementById('photoModalImg');
            modal.classList.add('show');
            modalImg.src = src;
            modalImg.alt = 'Foto Absensi - ' + name;
        }

        function closePhotoModal() {
            document.getElementById('photoModal').classList.remove('show');
        }

        // Close modal with ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closePhotoModal();
            }
        });
    </script>
</body>
</html>
