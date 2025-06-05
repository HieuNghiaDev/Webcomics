<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/header.css') }}">
</head>
<body>
    <!-- Header -->
    <header class="fixed-top">
        <div class="container-fluid container-xl">
            <div class="top-header py-2">
                <div class="row align-items-center">
                    <!-- Logo -->
                    <div class="col-lg-2 col-6">
                        <a href="/" class="logo d-flex align-items-center">
                           <img src="{{ asset('assets/img/logo/3monline_logo2.png') }}" alt="3M online" height="50">
                        </a>
                    </div>
                    
                    <!-- Search -->
                    <div class="col-lg-7 d-none d-lg-block">
                        <div class="search-bar">
                            <form action="{{ route('truyen.search') }}" method="get">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="keyword" placeholder="Tìm kiếm truyện, tác giả..." aria-label="Search">
                                    <button class="btn search-btn" type="submit">
                                        <i class="fas fa-search"></i> Tìm kiếm
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <!-- User Menu -->
                    <div class="col-lg-3 col-6 text-end">
                        <div class="user-menu">
                            <div class="dropdown">
                                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    @if(Auth::user()->avatar)
                                        <img src="{{ asset(Auth::user()->avatar) }}" alt="User Avatar" class="user-avatar">
                                    @else
                                        <img src="https://cdn.vectorstock.com/i/500p/17/16/default-avatar-anime-girl-profile-icon-vector-21171716.jpg" alt="User Avatar" class="user-avatar">
                                    @endif
                                    <div class="user-info ms-2 d-none d-sm-block">
                                        <div class="user-name">{{ Auth::user()->name }}</div>
                                        @if(Auth::user()->role == 2)
                                            <small class="text-danger">Quản trị viên</small>
                                        @elseif(Auth::user()->role == 1)
                                            <small class="text-success">Tài khoản dịch thuật</small>
                                        @else
                                            <small class="text-secondary">Người dùng</small>
                                        @endif
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end user-dropdown" aria-labelledby="userDropdown">
                                    <li class="dropdown-header">
                                        <div class="d-flex align-items-center">
                                            @if(Auth::user()->avatar)
                                                <img src="{{ asset(Auth::user()->avatar) }}" alt="User Avatar" class="user-avatar-sm me-2">
                                            @else
                                                <img src="https://cdn.vectorstock.com/i/500p/17/16/default-avatar-anime-girl-profile-icon-vector-21171716.jpg" alt="User Avatar" class="user-avatar-sm me-2">
                                            @endif
                                            <div>
                                                <div>{{ Auth::user()->name }}</div>
                                                <small>{{ Auth::user()->email }}</small>
                                            </div>
                                        </div>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="fas fa-user-circle me-2"></i>Hồ sơ của tôi</a></li>
                                    <li><a class="dropdown-item" href="{{ route('theo-doi.index') }}"><i class="fas fa-bell me-2"></i>Truyện theo dõi</a></li>
                                    @if(Auth::user()->role == 1)
                                       <li><a class="dropdown-item" href="{{ route('author.dashboard') }}"><i class="fa-solid fa-book"></i>Quản lý truyện</a></li>
                                    @endif
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST" id="logout-form">
                                            @csrf
                                            <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                <i class="fas fa-sign-out-alt me-2"></i>Đăng xuất
                                            </a>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 d-lg-none mt-2">
                        <div class="search-bar-mobile">
                            <form action="{{ route('truyen.search') }}" method="get">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="keyword" placeholder="Tìm kiếm truyện, tác giả..." aria-label="Search">
                                    <button class="btn search-btn" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Nav -->
            <nav class="navbar navbar-expand-lg main-nav">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i> MENU
                </button>
                <div class="collapse navbar-collapse" id="navbarMain">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" href="/"><i class="fas fa-home me-1"></i>Trang chủ</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-tags me-1"></i>Thể loại
                            </a>
                            <ul class="dropdown-menu category-dropdown" aria-labelledby="navbarDropdown">
                                <div class="row g-0">
                                    <div class="col-sm-4">
                                        <h6 class="dropdown-header">Phổ biến</h6>
                                        @foreach($theLoai as $key => $tl)
                                            @if($key % 3 == 0)
                                                <li><a class="dropdown-item" href="{{ url('the-loai/' . $tl->id) }}">{{ $tl->ten_the_loai }}</a></li>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="col-sm-4">
                                        <h6 class="dropdown-header">Đang hot</h6>
                                        @foreach($theLoai as $key => $tl)
                                            @if($key % 3 == 1)
                                                <li><a class="dropdown-item" href="{{ url('the-loai/' . $tl->id) }}">{{ $tl->ten_the_loai }}</a></li>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="col-sm-4">
                                        <h6 class="dropdown-header">Khám phá</h6>
                                        @foreach($theLoai as $key => $tl)
                                            @if($key % 3 == 2)
                                               <li><a class="dropdown-item" href="{{ url('the-loai/' . $tl->id) }}">{{ $tl->ten_the_loai }}</a></li>
                                            @endif
                                        @endforeach
                                        <li><a class="dropdown-item view-all" href="{{ url('the-loai') }}">Xem tất cả <i class="fas fa-angle-right ms-1"></i></a></li>
                                    </div>
                                </div>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="fas fa-chart-line me-1"></i>Bảng xếp hạng</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="fas fa-fire me-1"></i>Truyện Hot</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="fas fa-calendar-alt me-1"></i>Mới cập nhật</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="fas fa-book-open me-1"></i>Đã hoàn thành</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>
</body>
</html>