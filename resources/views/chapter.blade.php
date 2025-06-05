<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $truyen->ten_truyen }} - {{ $chapter->ten_chap }}</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
    
    <link rel="stylesheet" href="{{ asset('assets/css/chapter.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/comments.css') }}">
</head>
<body>
    <div class="reading-container">
        <div class="chapter-header">
            <div class="container">
                <h1 class="truyen-title">{{ $truyen->ten_truyen }}</h1>
                <h3 class="chapter-title">{{ $chapter->ten_chap }}</h3>
            </div>
        </div>
        
        <div class="container mt-3">
            <nav aria-label="breadcrumb" class="custom-breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i> Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('truyen.show', $truyen->id) }}">{{ $truyen->ten_truyen }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $chapter->ten_chap }}</li>
                </ol>
            </nav>
            
            <div class="row">
                <div class="col-12">
                    <div class="chapter-navigation">
                        <div class="d-flex justify-content-between">
                            <a href="{{ $prevChapter ? route('chapter.show', ['truyen' => $truyen->id, 'chapter' => $prevChapter->id]) : '#' }}" 
                               class="btn btn-outline-primary {{ !$prevChapter ? 'disabled' : '' }} action-button">
                                <i class="fas fa-chevron-left"></i> Chương trước
                            </a>
                            
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary dropdown-toggle action-button" type="button" id="chapterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    Chương {{ $chapter->so_chap }}
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="chapterDropdown" style="max-height: 300px; overflow-y: auto;">
                                    @foreach($truyen->chapters()->orderBy('so_chap', 'desc')->get() as $chap)
                                        <li>
                                            <a class="dropdown-item {{ $chap->id == $chapter->id ? 'active' : '' }}" 
                                               href="{{ route('chapter.show', ['truyen' => $truyen->id, 'chapter' => $chap->id]) }}">
                                                {{ $chap->ten_chap }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            
                            <a href="{{ route('truyen.show', $truyen->id) }}" class="btn btn-outline-secondary action-button">
                                <i class="fas fa-list"></i> DS chương
                            </a>
                            
                            <a href="{{ $nextChapter ? route('chapter.show', ['truyen' => $truyen->id, 'chapter' => $nextChapter->id]) : '#' }}" 
                               class="btn btn-outline-primary {{ !$nextChapter ? 'disabled' : '' }} action-button">
                                Chương sau <i class="fas fa-chevron-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Nội dung chapter -->
            <div class="chapter-content">
                @foreach($chapter->anh as $index => $anh)
                    <div class="image-container">
                        <img src="{{ asset('assets/img/chapter/' . $anh->anh_url) }}" alt="Trang {{ $anh->so_trang }}" class="img-fluid">
                        <!-- <div class="page-number-overlay">{{ $index + 1 }}/{{ count($chapter->anh) }}</div> -->
                    </div>
                @endforeach
            </div>
            
            <div class="chapter-navigation mt-3">
                <div class="d-flex justify-content-between">
                    <a href="{{ $prevChapter ? route('chapter.show', ['truyen' => $truyen->id, 'chapter' => $prevChapter->id]) : '#' }}" 
                       class="btn btn-outline-primary {{ !$prevChapter ? 'disabled' : '' }} action-button">
                        <i class="fas fa-chevron-left"></i> Chương trước
                    </a>
                    
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle action-button" type="button" id="chapterDropdown2" data-bs-toggle="dropdown" aria-expanded="false">
                            Chương {{ $chapter->so_chap }}
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="chapterDropdown2" style="max-height: 300px; overflow-y: auto;">
                            @foreach($truyen->chapters()->orderBy('so_chap', 'desc')->get() as $chap)
                                <li>
                                    <a class="dropdown-item {{ $chap->id == $chapter->id ? 'active' : '' }}" 
                                       href="{{ route('chapter.show', ['truyen' => $truyen->id, 'chapter' => $chap->id]) }}">
                                        {{ $chap->ten_chap }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    
                    <a href="{{ route('truyen.show', $truyen->id) }}" class="btn btn-outline-secondary action-button">
                        <i class="fas fa-list"></i> DS chương
                    </a>
                    
                    <a href="{{ $nextChapter ? route('chapter.show', ['truyen' => $truyen->id, 'chapter' => $nextChapter->id]) : '#' }}" 
                       class="btn btn-outline-primary {{ !$nextChapter ? 'disabled' : '' }} action-button">
                        Chương sau <i class="fas fa-chevron-right"></i>
                    </a>
                </div>
            </div>
            
            <!-- Phần bình luận -->
            <div class="comments-section mt-5" id="comments">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <i class="fas fa-comments me-2"></i> Bình luận ({{ $comments->total() }})
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        
                        @auth
                            <form action="{{ route('comment.store', $chapter->id) }}#comments" method="POST" class="mb-4">
                                @csrf
                                <input type="hidden" name="parent_id" value="0">
                                <div class="mb-3">
                                    <textarea class="form-control" name="noi_dung" rows="3" placeholder="Viết bình luận của bạn..."></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane me-1"></i> Gửi bình luận
                                </button>
                            </form>
                        @else
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i> Bạn cần <a href="{{ route('login') }}">đăng nhập</a> để bình luận.
                            </div>
                        @endauth
                        
                        <div class="comments-list">
                            @forelse($comments as $comment)
                                <div class="comment-item" id="comment-{{ $comment->id }}">
                                    <div class="comment-header d-flex align-items-center">
                                        @if($comment->user->avatar)
                                            <img src="{{ asset($comment->user->avatar) }}" alt="{{ $comment->user->name }}" class="rounded-circle" width="40" height="40">
                                        @else
                                            <img src="https://cdn.vectorstock.com/i/500p/17/16/default-avatar-anime-girl-profile-icon-vector-21171716.jpg" alt="{{ $comment->user->name }}" class="rounded-circle" width="40" height="40">
                                        @endif
                                        <div>
                                            @if($comment->user->role == '1')
                                                <h5 class="mb-0">{{ $comment->user->name }} <span class="badge bg-danger">Tài Khoản dịch thuật</span></h5>
                                            @else
                                                <h5 class="mb-0">{{ $comment->user->name }}</h5>
                                            @endif
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($comment->ngay_dang)->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                    <div class="comment-body my-2">
                                        {{ $comment->noi_dung }}
                                    </div>
                                    <div class="comment-actions">
                                        @auth
                                            <button class="btn btn-sm btn-light reply-btn" data-comment-id="{{ $comment->id }}">
                                                <i class="fas fa-reply"></i> Trả lời
                                            </button>
                                        @endauth
                                    </div>
                                    
                                    <!-- Form phản hồi -->
                                    <div class="reply-form mt-2" id="reply-form-{{ $comment->id }}" style="display: none;">
                                        <form action="{{ route('comment.store', $chapter->id) }}#comment-{{ $comment->id }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                            <div class="input-group">
                                                <textarea class="form-control form-control-sm" name="noi_dung" rows="1" placeholder="Trả lời..."></textarea>
                                                <button type="submit" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-paper-plane"></i> Gửi
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    
                                    <!-- phản hồi -->
                                    @if($comment->replies->count() > 0)
                                        <div class="replies-list mt-3 ms-4">
                                            @foreach($comment->replies as $reply)
                                                <div class="reply-item mb-2" id="reply-{{ $reply->id }}">
                                                    <div class="reply-header d-flex align-items-center">
                                                        @if($reply->user->avatar)
                                                            <img src="{{ asset($reply->user->avatar) }}" alt="{{ $reply->user->name }}" class="rounded-circle" width="30" height="30">
                                                        @else
                                                            <img src="https://cdn.vectorstock.com/i/500p/17/16/default-avatar-anime-girl-profile-icon-vector-21171716.jpg" alt="{{ $reply->user->name }}" class="rounded-circle" width="30" height="30">
                                                        @endif
                                                        <div>
                                                            @if($reply->user->role == '1')
                                                                <h6 class="mb-0">{{ $reply->user->name }} <span class="badge bg-danger">Tài Khoản dịch thuật</span></h6>
                                                            @else
                                                                <h6 class="mb-0">{{ $reply->user->name }}</h6>
                                                            @endif
                                                            <small class="text-muted">{{ \Carbon\Carbon::parse($reply->ngay_dang)->diffForHumans() }}</small>
                                                        </div>
                                                    </div>
                                                    <div class="reply-body ms-4 my-1">
                                                        {{ $reply->noi_dung }}
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                                <hr>
                            @empty
                                <div class="text-center text-muted my-4">
                                    <i class="fas fa-comments fa-2x mb-2"></i>
                                    <p>Chưa có bình luận nào. Hãy là người đầu tiên bình luận!</p>
                                </div>
                            @endforelse
                            
                            <!-- Phân trang -->
                            <div class="d-flex justify-content-center mt-4">
                                {{ $comments->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Nút quay lại đầu trang-->
        <div class="floating-buttons">
            <a href="#" class="btn to-top-btn" id="backToTop"><i class="fas fa-arrow-up"></i></a>
        </div>
        
        <!-- Lưu thông tin chapter để JavaScript có thể sử dụng -->
        <input type="hidden" id="current-truyen-id" value="{{ $truyen->id }}">
        <input type="hidden" id="current-chapter-id" value="{{ $chapter->id }}">
        <input type="hidden" id="current-chapter-title" value="{{ $chapter->ten_chap }}">
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Xử lý sự kiện click cho nút "Trả lời" trong bình luận
        $(document).on('click', '.reply-btn', function() {
            var commentId = $(this).data('comment-id');
            $('#reply-form-' + commentId).toggle();
        }); 
    </script>

</body>
</html>