<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manga - Đọc truyện tranh online</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logo/3monline_logo2.png') }}">
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

    <!-- Main Content -->
    <main class="main-content">
        <section class="hero-banner">
            <div class="container-fluid container-xl">
                <div class="swiper hero-swiper">
                    <div class="swiper-wrapper">
                        @forelse($bannerTruyen as $truyen)
                            <div class="swiper-slide">
                                <!-- <div class="hero-slide" style="background-image: url('{{ asset('assets/img/anh_banner/' . $truyen->anh_banner) }}')"> -->
                                <div class="hero-slide" style="background-image: url('{{ asset('assets/img/cover_img/' . $truyen->anh_bia) }}')">
                                    <div class="hero-content">
                                        <h2>{{ $truyen->ten_truyen }}</h2>
                                        <p>{{ $truyen->mo_ta }}</p>
                                        <a href="{{ route('truyen.show', $truyen->id) }}" class="btn btn-primary">Đọc ngay</a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="swiper-slide">
                                <div class="hero-slide" style="background-image: url('https://via.placeholder.com/1200x400/3498db/ffffff?text=Manga+Website')">
                                    <div class="hero-content">
                                        <h2>Chào mừng đến với HieuNghiaDev Manga</h2>
                                        <p>Trang web đọc truyện tranh online tuyệt vời</p>
                                        <a href="{{ route('truyen.index') }}" class="btn btn-primary">Khám phá ngay</a>
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
        </section>

        <!-- Truyện đề xuất -->
        <section class="manga-section">
            <div class="container-fluid container-xl">
                <div class="section-title">
                    <h2><i class="fas fa-star text-warning me-2"></i>Truyện Đề Xuất</h2>
                    <a href="{{ route('truyen.index') }}" class="view-all">Xem tất cả <i class="fas fa-angle-right ms-1"></i></a>
                </div>
                <div class="row">
                    @foreach($truyenDeXuat as $truyen)
                        <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
                            <div class="manga-card">
                                <div class="manga-card-img">
                                    @if($truyen->luot_xem > 1000)
                                        <span class="manga-status">Hot</span>
                                    @endif
                                    @if($truyen->ngay_update > now()->subDays(7))
                                        <span class="manga-status new">Mới</span>
                                    @endif
                                    @if($truyen->luot_xem > 999 && $truyen->ngay_update > now()->subDays(7))
                                        <span class="manga-status hot">Mới</span>
                                    @endif
                                    <a href="{{ route('truyen.show', $truyen->id) }}">
                                        <img src="{{ asset('assets/img/cover_img/' . $truyen->anh_bia) }}" alt="{{ $truyen->ten_truyen }}" class="img-fluid">
                                    </a>
                                    <div class="manga-card-actions">
                                        <a href="{{ route('truyen.show', $truyen->id) }}" class="btn-read"><i class="fas fa-book-open"></i> Đọc ngay</a>
                                        <!-- <a href="#" class="btn-favorite"><i class="far fa-heart"></i></a> -->
                                    </div>
                                </div>
                                <div class="manga-card-body">
                                    <h5 class="manga-title"><a href="{{ route('truyen.show', $truyen->id) }}">{{ $truyen->ten_truyen }}</a></h5>
                                    <div class="manga-info">
                                        <span><i class="fas fa-eye"></i> 
                                                    @if($truyen->luot_xem >= 1000)
                                                        {{ number_format($truyen->luot_xem / 1000, 1) }}k
                                                    @else
                                                        {{ $truyen->luot_xem }}
                                                    @endif
                                                    lượt xem</span>
                                        <span> {{ number_format($truyen->rating, 1, '.', '') }}/5 <i class="fas fa-star text-warning"></i></span>
                                    </div>
                                    <div class="manga-update">Chap mới nhất</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Truyện mới cập nhật -->
        <section class="manga-section">
            <div class="container-fluid container-xl">
                <div class="section-title">
                    <h2><i class="fas fa-calendar-alt text-info me-2"></i>Mới cập nhật</h2>
                    <a href="{{ route('truyen.index') }}" class="view-all">Xem tất cả <i class="fas fa-angle-right ms-1"></i></a>
                </div>
                <div class="row">
                    @foreach($truyenMoi as $truyen)
                        <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
                            <div class="manga-card">
                                <div class="manga-card-img">
                                    @if($truyen->ngay_update > now()->subDays(7))
                                        <span class="manga-status new">Mới</span>
                                        <!-- <span class="manga-status">Hot</span> -->
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
                                                        {{ $truyen->luot_xem }}
                                                    @endif
                                                    lượt xem
                                        </span>
                                         <span> {{ number_format($truyen->rating, 1, '.', '') }}/5 <i class="fas fa-star text-warning"></i> </span>
                                    </div>
                                    <div class="manga-update">Chap {{ $truyen->chap_moi_nhat }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Truyện Chữ -->
        <section class="manga-section">
            <div class="container-fluid container-xl">
                <div class="section-title">
                    <h2><i class="fa-solid fa-book text-info me-2"></i>Truyện Chữ</h2>
                    <a href="{{ route('truyen.index') }}" class="view-all">Xem tất cả <i class="fas fa-angle-right ms-1"></i></a>
                </div>
                <div class="row">
                    @foreach($truyenMoi as $truyen)
                        <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
                            <div class="manga-card">
                                <div class="manga-card-img">
                                    @if($truyen->ngay_update > now()->subDays(7))
                                        <span class="manga-status new">Mới</span>
                                        <!-- <span class="manga-status">Hot</span> -->
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
                                                        {{ $truyen->luot_xem }}
                                                    @endif
                                                    lượt xem
                                        </span>
                                         <span>{{ number_format($truyen->rating, 1, '.', '') }}/5 <i class="fas fa-star text-warning"></i> </span>
                                    </div>
                                    <div class="manga-update">Chap {{ $truyen->chap_moi_nhat }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

       <!-- Truyện hot -->
        <section class="manga-section bg-light py-5">
            <div class="container-fluid container-xl">
                <div class="section-title">
                    <h2><i class="fas fa-fire text-danger me-2"></i>Truyện HOT</h2>
                    <a href="{{ route('truyen.index') }}" class="view-all">Xem tất cả <i class="fas fa-angle-right ms-1"></i></a>
                </div>
                <div class="row">
                    @foreach($truyenHot as $truyen)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="manga-featured">
                                <div class="row g-0">
                                    <div class="col-4">
                                        <a href="{{ route('truyen.show', $truyen->id) }}">
                                            <img src="{{ asset('assets/img/cover_img/' . $truyen->anh_bia) }}" alt="{{ $truyen->ten_truyen }}" class="img-fluid">
                                        </a>
                                    </div>
                                    <div class="col-8">
                                        <div class="manga-featured-body">
                                            <h4 class="manga-title">
                                                <a href="{{ route('truyen.show', $truyen->id) }}">{{ $truyen->ten_truyen }}</a>
                                            </h4>
                                            <div class="manga-genres">
                                                @php
                                                    $colors = ['bg-primary', 'bg-success', 'bg-danger', 'bg-warning', 'bg-info', 'bg-dark'];
                                                @endphp

                                                @foreach($truyen->theLoai as $theLoai)
                                                    @php
                                                        $randomColor = $colors[array_rand($colors)];
                                                    @endphp
                                                    <span class="badge {{ $randomColor }}">{{ $theLoai->ten_the_loai }}</span>
                                                @endforeach
                                            </div>
                                            <div class="manga-info my-2">
                                                <div><i class="fas fa-eye"></i> 
                                                    @if($truyen->luot_xem >= 1000)
                                                        {{ number_format($truyen->luot_xem / 1000, 1) }}k
                                                    @else
                                                        {{ $truyen->luot_xem }}
                                                    @endif
                                                    lượt xem
                                                </div>
                                                 <span>{{ number_format($truyen->rating, 1, '.', '') }}/5 <i class="fas fa-star text-warning"></i> </span>
                                                <div><i class="fas fa-bookmark"></i> Chap {{ $truyen->chap_moi_nhat }}</div>
                                            </div>
                                            <p class="manga-desc">{{ \Illuminate\Support\Str::limit($truyen->mo_ta, 100, '...') }}</p>
                                            <a href="{{ route('truyen.show', $truyen->id) }}" class="btn btn-sm btn-primary">Đọc ngay</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    @include('layouts.footer')

    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Custom JavaScript -->
    <!-- <script src="{{ asset('assets/js/yeuthich.js') }}"></script> -->
</body>
</html>