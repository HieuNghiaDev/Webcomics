@extends('layouts.author')

@section('title', 'Quản lý truyện')

@section('header', 'Danh sách truyện')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Danh sách truyện của bạn</h5>
            <a href="{{ route('author.addComic') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Thêm truyện mới
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th width="5%">ID</th>
                        <th width="10%">Ảnh bìa</th>
                        <th width="25%">Tên truyện</th>
                        <th width="15%">Tác giả</th>
                        <th width="15%">Tình trạng</th>
                        <th width="15%">Ngày cập nhật</th>
                        <th width="15%">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($comics as $comic)
                    <tr>
                        <td>{{ $comic->id }}</td>
                        <td>
                             <img src="{{ asset('assets/img/cover_img/' . $comic->anh_bia) }}" alt="{{ $comic->ten_truyen }}" class="img-thumbnail" style="width: 60px; height: 80px; object-fit: cover;">
                        </td>
                        <td>{{ $comic->ten_truyen }}</td>
                        <td>{{ $comic->tac_gia }}</td>
                        <td>
                            @if($comic->tinh_trang == '0')
                                <span class="badge bg-primary">Đang tiến hành</span>
                            @else
                                <span class="badge bg-success">Hoàn thành</span>
                            @endif
                        </td>
                        <td>{{ date('d/m/Y H:i', strtotime($comic->ngay_update)) }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('author.viewsComic', $comic->id) }}" class="btn btn-info btn-sm" title="Xem chi tiết">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('author.editComic', $comic->id) }}" class="btn btn-primary btn-sm" title="Chỉnh sửa">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('author.delete_comic', $comic->id) }}" class="btn btn-danger btn-sm" 
                                   onclick="return confirm('Bạn có chắc muốn xóa truyện này?')" title="Xóa">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Bạn chưa có truyện nào.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-center mt-3">
            {{ $comics->links() }}
        </div>
    </div>
</div>
@endsection