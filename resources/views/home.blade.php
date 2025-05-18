<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .navbar {
            background-color: #4e73df !important;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .navbar-brand {
            font-weight: 700;
            color: white !important;
        }
        .navbar-nav .nav-link {
            color: rgba(255,255,255,0.85) !important;
        }
        .navbar-nav .nav-link:hover {
            color: white !important;
        }
        .main-content {
            flex: 1;
            padding: 40px 0;
        }
        .welcome-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            transition: transform 0.3s;
        }
        .welcome-card:hover {
            transform: translateY(-5px);
        }
        .user-avatar {
            width: 120px;
            height: 120px;
            margin: 20px auto;
            background-color: #4e73df;
            color: white;
            font-size: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .navbar .user-menu {
            display: flex;
            align-items: center;
        }
        .navbar .user-menu img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            margin-right: 5px;
        }
        .footer {
            background-color: #fff;
            padding: 20px 0;
            box-shadow: 0 -2px 5px rgba(0,0,0,0.05);
        }
        .btn-logout {
            background-color: transparent;
            border: 1px solid rgba(255,255,255,0.5);
            color: white;
        }
        .btn-logout:hover {
            background-color: rgba(255,255,255,0.1);
            color: white;
            border: 1px solid white;
        }
        .stat-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.05);
            transition: all 0.3s;
        }
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
        }
        .stat-icon.bg-primary {
            background-color: #4e73df;
        }
        .stat-icon.bg-success {
            background-color: #1cc88a;
        }
        .stat-icon.bg-info {
            background-color: #36b9cc;
        }
        .stat-icon.bg-warning {
            background-color: #f6c23e;
        }
        .stat-icon i {
            font-size: 28px;
            color: white;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="/home">
                <i class="fas fa-home me-2"></i> Trang Chủ
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-tachometer-alt me-1"></i> Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-user-cog me-1"></i> Cài đặt</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-question-circle me-1"></i> Trợ giúp</a>
                    </li>
                </ul>
                <div class="user-menu">
                    <div class="d-flex align-items-center me-3">
                        <div class="bg-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">
                            <i class="fas fa-user text-primary"></i>
                        </div>
                        <span class="text-white">{{ Auth::user()->name }}</span>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-logout">
                            <i class="fas fa-sign-out-alt me-1"></i> Đăng xuất
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card welcome-card">
                        <div class="card-body text-center">
                            <div class="user-avatar">
                                <i class="fas fa-user"></i>
                            </div>
                            <h2>Chào mừng, {{ Auth::user()->name }}!</h2>
                            <p class="text-muted">Bạn đã đăng nhập thành công vào hệ thống.</p>
                            <p>Hôm nay là: {{ date('d/m/Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-3 mb-4">
                    <div class="card stat-card">
                        <div class="card-body d-flex align-items-center">
                            <div class="stat-icon bg-primary">
                                <i class="fas fa-users"></i>
                            </div>
                            <div>
                                <h6 class="card-title mb-0">Người dùng</h6>
                                <h3 class="mb-0">356</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card stat-card">
                        <div class="card-body d-flex align-items-center">
                            <div class="stat-icon bg-success">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div>
                                <h6 class="card-title mb-0">Lượt xem</h6>
                                <h3 class="mb-0">2,487</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card stat-card">
                        <div class="card-body d-flex align-items-center">
                            <div class="stat-icon bg-info">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <div>
                                <h6 class="card-title mb-0">Tài liệu</h6>
                                <h3 class="mb-0">154</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card stat-card">
                        <div class="card-body d-flex align-items-center">
                            <div class="stat-icon bg-warning">
                                <i class="fas fa-trophy"></i>
                            </div>
                            <div>
                                <h6 class="card-title mb-0">Thành tựu</h6>
                                <h3 class="mb-0">22</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-bell me-2"></i>Thông báo gần đây</h5>
                        </div>
                        <div class="card-body">
                            <div class="list-group">
                                <a href="#" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">Cập nhật hệ thống</h6>
                                        <small>3 ngày trước</small>
                                    </div>
                                    <p class="mb-1">Hệ thống vừa được cập nhật lên phiên bản mới nhất.</p>
                                </a>
                                <a href="#" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">Bảo trì hệ thống</h6>
                                        <small>1 tuần trước</small>
                                    </div>
                                    <p class="mb-1">Hệ thống sẽ bảo trì vào ngày 15/05/2025.</p>
                                </a>
                                <a href="#" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">Tính năng mới</h6>
                                        <small>2 tuần trước</small>
                                    </div>
                                    <p class="mb-1">Chúng tôi vừa ra mắt tính năng mới.</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-tasks me-2"></i>Công việc cần làm</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Cập nhật thông tin cá nhân
                                    <span class="badge bg-primary rounded-pill">1</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Xác minh email
                                    <span class="badge bg-warning rounded-pill">1</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Hoàn thành hồ sơ
                                    <span class="badge bg-info rounded-pill">3</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0">&copy; {{ date('Y') }} HieuNghiaDev. Tất cả các quyền được bảo lưu.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <p class="mb-0">Laravel v{{ app()->version() }}</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>