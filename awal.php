<?php 
error_reporting(0);
session_start();
include 'koneksi.php';

// Ambil data siswa dari database
$id_siswa = $_SESSION['idsi'];
$query_siswa = mysqli_query($koneksi, "SELECT * FROM tb_karyawan WHERE id_karyawan = '$id_siswa'");
$siswa = mysqli_fetch_array($query_siswa);

// Cek hari ini (3 = Rabu)
$hari_ini = date('N');
$boleh_absen = ($hari_ini == 3);

// Cek apakah sudah absen hari ini
$query_cek_absen = mysqli_query($koneksi, "SELECT * FROM tb_keterangan 
                                          WHERE id_karyawan = '$id_siswa' 
                                          AND DATE(waktu) = CURDATE()");
$sudah_absen = mysqli_num_rows($query_cek_absen) > 0;

// Proses form jika disubmit
if (isset($_POST['simpan'])) {
    // Validasi hari
    if (date('N') != 3) {
        die("<script>alert('Absen hanya bisa dilakukan pada hari Rabu!');window.history.back();</script>");
    }
    
    // Validasi absen ganda
    if ($sudah_absen) {
        die("<script>alert('Anda sudah melakukan absen hari ini!');window.history.back();</script>");
    }
    
    $id_karyawan = $_POST['id_karyawan'];
    $keterangan = $_POST['keterangan'];
    $alasan = $_POST['alasan'] ?? '';
    $waktu = $_POST['waktu'];

    // Validasi alasan jika sakit/izin
    if (($keterangan == 'sakit' || $keterangan == 'izin') && empty($alasan)) {
        die("<script>alert('Harap isi alasan untuk status ini!');window.history.back();</script>");
    }

    // Prepared statement untuk keamanan
    $stmt = $koneksi->prepare("INSERT INTO tb_keterangan (id_karyawan, keterangan, alasan, waktu) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $id_karyawan, $keterangan, $alasan, $waktu);

    if ($stmt->execute()) {
        echo "<script>
                alert('Absen berhasil dicatat!');
                window.location.href = '?m=awal';
              </script>";
    } else {
        echo "<script>
                alert('Gagal mencatat absen: ".addslashes($stmt->error)."');
                window.history.back();
              </script>";
    }
    
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Kehadiran | <?php echo $_SESSION['namasi']; ?></title>
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/images/logo-sekolah.png">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Animate CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --biru-tua: #1a3e72;
            --biru-muda: #4a8fe7;
            --hijau: #28a745;
            --kuning: #ffc107;
            --merah: #dc3545;
            --ungu: #6f42c1;
            --bg-light: #f8fafc;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
            min-height: 100vh;
            color: #333;
        }
        
        .card-custom {
            border-radius: 16px;
            box-shadow: var(--shadow);
            border: none;
            overflow: hidden;
            transition: transform 0.3s ease;
            background: white;
            margin: 20px 0;
        }
        
        .card-header-custom {
            background: linear-gradient(135deg, var(--biru-tua) 0%, var(--biru-muda) 100%);
            color: white;
            padding: 1.5rem;
            border-bottom: none;
            position: relative;
            overflow: hidden;
        }
        
        .card-header-custom::before {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
            transform: rotate(30deg);
        }
        
        .form-control-custom {
            border-radius: 10px;
            padding: 14px 18px;
            border: 2px solid #e0e6ed;
            transition: all 0.3s;
            font-size: 15px;
        }
        
        .form-control-custom:focus {
            border-color: var(--biru-muda);
            box-shadow: 0 0 0 4px rgba(74, 143, 231, 0.2);
        }
        
        .form-control-custom:read-only {
            background-color: var(--bg-light);
            border-left: 4px solid var(--biru-muda);
        }
        
        .btn-submit {
            background: linear-gradient(135deg, var(--biru-tua) 0%, var(--biru-muda) 100%);
            border: none;
            padding: 14px 32px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s;
            border-radius: 10px;
            font-size: 16px;
            position: relative;
            overflow: hidden;
        }
        
        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(26, 62, 114, 0.3);
        }
        
        .btn-submit::after {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.3) 0%, rgba(255,255,255,0) 70%);
            transform: rotate(30deg);
            transition: all 0.5s;
        }
        
        .btn-submit:hover::after {
            left: 100%;
        }
        
        .time-display {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--biru-tua);
            background-color: rgba(74, 143, 231, 0.1);
            padding: 12px 18px;
            border-radius: 10px;
            border: 2px dashed rgba(74, 143, 231, 0.3);
        }
        
        .alert-hari {
            border-left: 5px solid var(--merah);
        }
        
        /* Custom Radio Button */
        .status-options {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        
        .status-option {
            position: relative;
            padding-left: 40px;
            cursor: pointer;
            font-size: 16px;
            user-select: none;
            transition: all 0.3s;
            border: 2px solid #e0e6ed;
            border-radius: 10px;
            padding: 15px 15px 15px 50px;
            background-color: white;
        }
        
        .status-option:hover {
            border-color: var(--biru-muda);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        .status-option input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }
        
        .checkmark {
            position: absolute;
            top: 18px;
            left: 15px;
            height: 22px;
            width: 22px;
            background-color: #f8f9fa;
            border-radius: 50%;
            border: 2px solid #dee2e6;
            transition: all 0.3s;
        }
        
        .status-option:hover input ~ .checkmark {
            border-color: var(--biru-muda);
        }
        
        .status-option input:checked ~ .checkmark {
            background-color: var(--biru-tua);
            border-color: var(--biru-tua);
        }
        
        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }
        
        .status-option input:checked ~ .checkmark:after {
            display: block;
        }
        
        .status-option .checkmark:after {
            left: 5px;
            top: 2px;
            width: 7px;
            height: 12px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }
        
        .status-badge {
            font-size: 0.8rem;
            font-weight: 500;
            padding: 4px 8px;
            border-radius: 20px;
            margin-left: 8px;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .card-header-custom {
                padding: 1.2rem;
            }
            
            .form-control-custom {
                padding: 12px 15px;
            }
            
            .btn-submit {
                padding: 12px 24px;
                width: 100%;
            }
            
            .time-display {
                font-size: 1rem;
                padding: 10px 15px;
            }
            
            .status-option {
                padding: 12px 12px 12px 45px;
            }
        }
        
        @media (max-width: 576px) {
            .card-custom {
                border-radius: 0;
                margin: 0;
            }
            
            body {
                background: white;
            }
        }
    </style>
</head>

<body class="d-flex align-items-center">
    <div class="container py-3">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-6">
                <div class="card card-custom animate__animated animate__fadeInUp">
                    <div class="card-header card-header-custom">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h3 class="mb-1 text-white">
                                    <i class="fas fa-calendar-check me-2"></i>Form Kehadiran
                                </h3>
                                <p class="text-white-50 mb-0">Halo, <?php echo $_SESSION['namasi']; ?>! Silakan isi status kehadiranmu</p>
                            </div>
                            <div class="ps-3">
                                <div class="bg-white bg-opacity-20 p-2 rounded-circle">
                                    <i class="fas fa-user-graduate text-white fs-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-body p-4 p-md-5">
                        <?php if ($sudah_absen): ?>
                            <div class="alert alert-success animate__animated animate__fadeIn">
                                <h5 class="alert-heading"><i class="fas fa-check-circle me-2"></i>Sudah Absen</h5>
                                <p class="mb-0">Anda sudah melakukan absen hari ini.</p>
                            </div>
                        <?php elseif (!$boleh_absen): ?>
                            <div class="alert alert-danger alert-hari animate__animated animate__shakeX">
                                <h5 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>Absen Ditolak!</h5>
                                <p class="mb-0">
                                    Absen hanya bisa dilakukan pada hari Rabu. Hari ini adalah hari <?php echo date('l'); ?>.
                                </p>
                            </div>
                        <?php endif; ?>
                        
                        <form action="" method="post" enctype="multipart/form-data" <?php if (!$boleh_absen || $sudah_absen) echo 'onsubmit="return false;"'; ?>>
                            <div class="mb-4">
                                <label class="form-label fw-bold text-uppercase small text-muted">Id Siswa</label>
                                <input type="text" class="form-control form-control-custom" name="id_karyawan" readonly value="<?php echo $siswa['id_karyawan']; ?>">
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold text-uppercase small text-muted">Nama Lengkap</label>
                                <input type="text" class="form-control form-control-custom" name="nama" readonly value="<?php echo $siswa['nama']; ?>">
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold text-uppercase small text-muted">Email</label>
                                <input type="text" class="form-control form-control-custom" name="email" readonly value="<?php echo $siswa['email']; ?>">
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold text-uppercase small text-muted">Kelas</label>
                                <input type="text" class="form-control form-control-custom" name="kelas" readonly value="<?php echo $siswa['kelas']; ?>">
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold text-uppercase small text-muted">Status Kehadiran</label>
                                <div class="status-options">
                                    <div class="status-option">
                                        <input type="radio" name="keterangan" id="hadir" value="hadir" checked onchange="toggleAlasan()" <?php if (!$boleh_absen || $sudah_absen) echo 'disabled'; ?>>
                                        <label for="hadir">Hadir <span class="status-badge" style="background-color: rgba(40, 167, 69, 0.2); color: var(--hijau);"><i class="fas fa-check-circle me-1"></i>Absen</span></label>
                                        <span class="checkmark"></span>
                                    </div>
                                    
                                    <div class="status-option">
                                        <input type="radio" name="keterangan" id="sakit" value="sakit" onchange="toggleAlasan()" <?php if (!$boleh_absen || $sudah_absen) echo 'disabled'; ?>>
                                        <label for="sakit">Sakit <span class="status-badge" style="background-color: rgba(255, 193, 7, 0.2); color: var(--kuning);"><i class="fas fa-procedures me-1"></i>Butuh Alasan</span></label>
                                        <span class="checkmark"></span>
                                    </div>
                                    
                                    <div class="status-option">
                                        <input type="radio" name="keterangan" id="izin" value="izin" onchange="toggleAlasan()" <?php if (!$boleh_absen || $sudah_absen) echo 'disabled'; ?>>
                                        <label for="izin">Izin <span class="status-badge" style="background-color: rgba(111, 66, 193, 0.2); color: var(--ungu);"><i class="fas fa-envelope me-1"></i>Butuh alasan</span></label>
                                        <span class="checkmark"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold text-uppercase small text-muted">Waktu Kehadiran</label>
                                <div class="d-flex align-items-center">
                                    <div class="time-display flex-grow-1 text-center">
                                        <i class="far fa-clock me-2"></i>
                                        <span id="live-time"><?php echo date('d-m-Y H:i:s'); ?></span>
                                        <input type="hidden" id="waktu" name="waktu" value="<?php echo date('Y-m-d H:i:s'); ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4 animate__animated" id="rowAlasan" style="display: none;">
                                <label class="form-label fw-bold text-uppercase small text-muted">Alasan</label>
                                <textarea class="form-control form-control-custom" id="alasan" name="alasan" rows="3" placeholder="Mohon jelaskan alasan Anda..." <?php if (!$boleh_absen || $sudah_absen) echo 'disabled'; ?>></textarea>
                                <small class="text-muted"><i class="fas fa-info-circle me-1"></i>Wajib diisi untuk status Sakit atau Izin</small>
                            </div>

                            <div class="text-center mt-5">
                                <button type="submit" name="simpan" class="btn btn-submit text-white px-5 py-3" <?php if (!$boleh_absen || $sudah_absen) echo 'disabled'; ?>>
                                    <i class="fas fa-paper-plane me-2"></i>Kirim Kehadiran
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="text-center mt-4 text-muted small">
                    <p>Sistem Kehadiran Digital &copy; <?php echo date('Y'); ?> It Club Trimulia</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script>
        function toggleAlasan() {
            const keterangan = document.querySelector('input[name="keterangan"]:checked').value;
            const rowAlasan = document.getElementById("rowAlasan");
            const alasanInput = document.getElementById("alasan");
            
            if (keterangan === "sakit" || keterangan === "izin") {
                rowAlasan.style.display = "block";
                rowAlasan.classList.add("animate__fadeIn");
                alasanInput.setAttribute("required", "required");
            } else {
                rowAlasan.style.display = "none";
                rowAlasan.classList.remove("animate__fadeIn");
                alasanInput.removeAttribute("required");
                alasanInput.value = "";
            }
        }
        
        // Update waktu secara real-time
        function updateTime() {
            const now = new Date();
            const options = { 
                weekday: 'long', 
                day: '2-digit', 
                month: 'long', 
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false
            };
            
            const dateString = now.toLocaleDateString('id-ID', options);
            const formattedDateTime = now.toISOString().slice(0, 19).replace('T', ' ');
            
            document.getElementById('live-time').textContent = dateString;
            document.getElementById('waktu').value = formattedDateTime;
        }
        
        // Update waktu langsung dan setiap detik
        updateTime();
        setInterval(updateTime, 1000);
    </script>
</body>
</html>