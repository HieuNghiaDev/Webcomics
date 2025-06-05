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
                    <li class="breadcrumb-item"><a href="{{ route('profile') }}">Hồ sơ cá nhân</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Chỉnh sửa hồ sơ</li>
                </ol>
            </nav>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row">
                <!-- Sidebar với menu -->
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
                            
                            <a href="{{ route('profile') }}" class="btn btn-outline-primary btn-sm d-block">
                                <i class="fas fa-user me-1"></i> Xem hồ sơ
                            </a>
                        </div>
                    </div>

                    <div class="list-group mb-4 shadow-sm">
                        <a href="#edit-profile" class="list-group-item list-group-item-action active d-flex align-items-center">
                            <i class="fas fa-user-edit me-2"></i> Thông tin cá nhân
                        </a>
                        <a href="#edit-avatar" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="fas fa-image me-2"></i> Cập nhật ảnh đại diện
                        </a>
                        <a href="{{ route('profile.password.form') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="fas fa-lock me-2"></i> Đổi mật khẩu
                        </a>
                    </div>
                </div>
                
                <!-- Main content -->
                <div class="col-lg-9">
                    <!-- Chỉnh sửa thông tin -->
                    <div class="card border-0 shadow-sm mb-4" id="edit-profile">
                        <div class="card-header bg-white">
                            <h5 class="card-title mb-0"><i class="fas fa-user-edit text-primary me-2"></i>Chỉnh sửa thông tin</h5>
                        </div>
                        <div class="card-body p-4">
                            <form action="{{ route('profile.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="mb-3 row">
                                    <label for="name" class="col-md-3 col-form-label">Họ và tên</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" id="name" value="{{ $user->name }}" disabled>
                                        <div class="form-text text-muted">Bạn không thể thay đổi tên người dùng.</div>
                                    </div>
                                </div>
                                
                                <div class="mb-3 row">
                                    <label for="email" class="col-md-3 col-form-label">Email</label>
                                    <div class="col-md-9">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-9 offset-md-3">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-1"></i> Lưu thay đổi
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Cập nhật avatar -->
                    <div class="card border-0 shadow-sm" id="edit-avatar">
                        <div class="card-header bg-white">
                            <h5 class="card-title mb-0"><i class="fas fa-image text-primary me-2"></i>Cập nhật ảnh đại diện</h5>
                        </div>
                        <div class="card-body p-4">
                            <form action="{{ route('profile.update-avatar') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                
                                <div class="text-center mb-4">
                                    <div class="avatar-preview mb-3">
                                        @if($user->avatar)
                                            <img src="{{ asset('storage/'.$user->avatar) }}" alt="Avatar Preview" id="avatarPreview" class="rounded-circle img-thumbnail" style="width: 180px; height: 180px; object-fit: cover;">
                                        @else
                                            <img src="https://cdn.vectorstock.com/i/500p/17/16/default-avatar-anime-girl-profile-icon-vector-21171716.jpg" alt="Avatar Preview" id="avatarPreview" class="rounded-circle img-thumbnail" style="width: 180px; height: 180px; object-fit: cover;">
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="avatar" class="form-label">Chọn ảnh đại diện mới</label>
                                    <input class="form-control @error('avatar') is-invalid @enderror" type="file" id="avatar" name="avatar" accept="image/*">
                                    @error('avatar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Hỗ trợ: JPG, JPEG, PNG, GIF. Tối đa 2MB.</div>
                                </div>
                                
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-upload me-1"></i> Cập nhật avatar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Hiển thị preview avatar khi chọn file mới
        document.getElementById('avatar').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('avatarPreview').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>