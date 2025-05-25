<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $currentTheLoai->ten_the_loai }} - HieuNghiaDev Manga</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    @include('layouts.header')

    <main class="main-content py-5">
        <div class="container-fluid container-xl">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i> Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('the-loai') }}">Thể loại</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $currentTheLoai->ten_the_loai }}</li>
                </ol>
            </nav>

            <div class="section-title mb-4">
                <h2>
                    <i class="fas fa-tag text-primary me-2"></i>
                    Thể loại: {{ $currentTheLoai->ten_the_loai }}
                </h2>
                <div>Tìm thấy {{ $truyens->total() }} truyện</div>
            </div>

            <!--danh sách truyện-->
            <div class="row">
                @forelse($truyens as $truyen)
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
                                    <span><i class="fas fa-book"></i> 
                                        {{ $truyen->chapters_count ?? 0 }} chương
                                    </span>
                                </div>
                                <div class="manga-genres small">
                                    @foreach($truyen->theLoai as $tl)
                                        <span class="badge bg-primary">{{ $tl->ten_the_loai }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Không có truyện nào thuộc thể loại {{ $currentTheLoai->ten_the_loai }}
                            <div class="mt-2">
                                <a href="/" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-home me-1"></i> Về trang chủ
                                </a>
                                <a href="{{ route('truyen.index') }}" class="btn btn-outline-success btn-sm ms-2">
                                    <i class="fas fa-book me-1"></i> Xem tất cả truyện
                                </a>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
            
            <!-- phân trang -->
            <div class="d-flex justify-content-center mt-4">
                {{ $truyens->links() }}
            </div>

            <!-- thê loại liên quan -->
            <div class="mt-5 p-4 bg-white rounded shadow-sm">
                <h4 class="mb-3">Thể loại liên quan</h4>
                <div class="d-flex flex-wrap gap-2">
                    @foreach($theLoai as $tl)
                        @if($tl->id != $currentTheLoai->id)
                            <a href="{{ url('the-loai/' . $tl->id) }}" class="btn btn-outline-primary btn-sm">
                                {{ $tl->ten_the_loai }}
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </main>

    @include('layouts.footer')
</body>
</html>