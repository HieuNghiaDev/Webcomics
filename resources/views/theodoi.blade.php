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
        <section class="py-5">
            <div class="container-fluid container-xl">
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i> Trang chủ</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Truyện đang theo dõi</li>
                    </ol>
                </nav>

                <div class="section-title">
                    <h2><i class="fas fa-bell text-primary me-2"></i>Truyện đang theo dõi</h2>
                    <div class="total-count">
                        <span class="badge bg-primary">{{ $truyenTheoDoi->total() }} truyện</span>
                    </div>
                </div>

                <!-- truyện theo dõi trống -->
                @if($truyenTheoDoi->isEmpty())
                <div class="text-center p-5 bg-light rounded my-4">
                    <div class="mb-3">
                        <i class="fas fa-bell-slash fa-4x text-muted"></i>
                    </div>
                    <h3>Chưa có truyện nào đang theo dõi</h3>
                    <p class="text-muted">Bạn chưa theo dõi truyện nào. Hãy khám phá và theo dõi các truyện bạn yêu thích!</p>
                    <a href="{{ route('truyen.index') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-book me-2"></i> Khám phá truyện
                    </a>
                </div>
                @else
                <!-- Danh sách truyện theo dõi -->
                <div class="row">
                    @foreach($truyenTheoDoi as $truyen)
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
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
                                <div class="manga-genres small mb-2">
                                    @foreach($truyen->theLoai->take(3) as $tl)
                                        <span class="badge bg-primary">{{ $tl->ten_the_loai }}</span>
                                    @endforeach
                                </div>
                                <form action="{{ route('theo-doi.toggle', $truyen->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                                        <i class="fas fa-bell-slash me-1"></i> Hủy theo dõi
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Phân Trang -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $truyenTheoDoi->appends(request()->query())->links() }}
                </div>
                @endif
            </div>
        </section>
    </main>

    @include('layouts.footer')
   
</body>
</html>