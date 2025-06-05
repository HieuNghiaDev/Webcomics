<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Truyện đang theo dõi - HieuNghiaDev Manga</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>

@include('layouts.header')

<main class="main-content">
    <div class="container-fluid container-xl py-5">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i> Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Hồ sơ cá nhân</li>
            </ol>
        </nav>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <!-- Sidebar với thông tin người dùng -->
            <div class="col-lg-3 mb-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body text-center p-4">
                        <div class="avatar-wrapper mb-3">
                            @if($user->avatar)
                                <img src="{{ asset(Auth::user()->avatar) }}" alt="{{ $user->name }}" class="rounded-circle img-thumbnail" style="width: 140px; height: 140px; object-fit: cover;">
                            @else
                                <img src="https://cdn.vectorstock.com/i/500p/17/16/default-avatar-anime-girl-profile-icon-vector-21171716.jpg" alt="{{ $user->name }}" class="rounded-circle img-thumbnail" style="width: 140px; height: 140px; object-fit: cover;">
                            @endif
                        </div>
                        
                        <h4 class="mb-1">{{ $user->name }}</h4>
                        <div class="text-muted small mb-3">Thành viên từ {{ $user->created_at->format('d/m/Y') }}</div>
                        
                        <div class="d-grid gap-2">
                            <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                                <i class="fas fa-edit me-1"></i> Chỉnh sửa hồ sơ
                            </a>
                            <a href="{{ route('profile.password.form') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-lock me-1"></i> Đổi mật khẩu
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Thống kê -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0"><i class="fas fa-chart-bar text-primary me-2"></i>Thống kê</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center py-2">
                            <div class="icon-box bg-primary-light rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <i class="fas fa-bell text-primary"></i>
                            </div>
                            <div>
                                <div class="text-muted small">Truyện đang theo dõi</div>
                                <div class="fw-bold">{{ $user->truyenTheoDoi()->count() }}</div>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center py-2">
                            <div class="icon-box bg-success-light rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <i class="fas fa-book-open text-success"></i>
                            </div>
                            <div>
                                <div class="text-muted small">Lịch sử đọc</div>
                                <div class="fw-bold">0</div>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center py-2">
                            <div class="icon-box bg-info-light rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <i class="fas fa-comments text-info"></i>
                            </div>
                            <div>
                                <div class="text-muted small">Bình luận</div>
                                <div class="fw-bold">0</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Main content -->
            <div class="col-lg-9">
                <!-- Thông tin chi tiết -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0"><i class="fas fa-user text-primary me-2"></i>Thông tin cá nhân</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row mb-3 py-2 border-bottom">
                            <div class="col-md-4 text-muted">Họ và tên:</div>
                            <div class="col-md-8 fw-medium">{{ $user->name }}</div>
                        </div>
                        
                        <div class="row mb-3 py-2 border-bottom">
                            <div class="col-md-4 text-muted">Email:</div>
                            <div class="col-md-8">{{ $user->email }}</div>
                        </div>
                        
                        <div class="row mb-3 py-2 border-bottom">
                            <div class="col-md-4 text-muted">Ngày tham gia:</div>
                            <div class="col-md-8">{{ $user->created_at->format('d/m/Y') }}</div>
                        </div>
                    </div>
                </div>
                
                <!-- Truyện đang theo dõi -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0"><i class="fas fa-bell text-primary me-2"></i>Truyện đang theo dõi</h5>
                        @if($user->truyenTheoDoi()->count() > 0)
                            <a href="{{ route('theo-doi.index') }}" class="btn btn-sm btn-outline-primary">Xem tất cả</a>
                        @endif
                    </div>
                    <div class="card-body p-4">
                        @if($user->truyenTheoDoi()->count() > 0)
                            <div class="row">
                                @foreach($user->truyenTheoDoi()->with('theLoai')->orderBy('truyen.ngay_update', 'desc')->take(6)->get() as $truyen)
                                <div class="col-6 col-sm-4 col-lg-4 mb-4">
                                    <div class="manga-card">
                                        <div class="manga-card-img">
                                            @if($truyen->luot_xem > 1000)
                                                <span class="manga-status">Hot</span>
                                            @endif
                                            @if($truyen->ngay_update > now()->subDays(7))
                                                <span class="manga-status new">Mới</span>
                                            @endif
                                            <a href="{{ route('truyen.show', $truyen->id) }}">
                                                <img src="{{ asset('assets/img/cover_img/' . $truyen->anh_bia) }}" alt="{{ $truyen->ten_truyen }}" class="img-fluid">
                                            </a>
                                            <div class="manga-card-actions">
                                                <a href="{{ route('truyen.show', $truyen->id) }}" class="btn-read"><i class="fas fa-book-open"></i> Đọc ngay</a>
                                            </div>
                                        </div>
                                        <div class="manga-card-body">
                                            <h5 class="manga-title"><a href="{{ route('truyen.show', $truyen->id) }}">{{ $truyen->ten_truyen }}</a></h5>
                                            <div class="manga-info">
                                                <span><i class="fas fa-eye"></i> 
                                                    @if($truyen->luot_xem >= 1000)
                                                        {{ number_format($truyen->luot_xem / 1000, 1) }}k
                                                    @else
                                                        {{ $truyen->luot_xem ?? 0 }}
                                                    @endif
                                                </span>
                                                <span><i class="fas fa-star text-warning"></i> 4.8</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <i class="fas fa-bell-slash fa-3x text-muted"></i>
                                </div>
                                <p class="text-muted">Bạn chưa theo dõi truyện nào</p>
                                <a href="{{ route('truyen.index') }}" class="btn btn-primary mt-2">Khám phá truyện</a>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Lịch sử đọc -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0"><i class="fas fa-history text-primary me-2"></i>Lịch sử đọc gần đây</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="fas fa-history fa-3x text-muted"></i>
                            </div>
                            <p class="text-muted">Chưa có lịch sử đọc nào</p>
                            <a href="{{ route('truyen.index') }}" class="btn btn-primary mt-2">Khám phá truyện</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@include('layouts.footer')
</body>
</html>