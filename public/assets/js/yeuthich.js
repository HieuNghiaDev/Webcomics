$(document).ready(function() {
    // Token CSRF
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Xử lý sự kiện click vào nút yêu thích
    $(document).on('click', '.yeuthich-btn', function() {
        var button = $(this);
        var truyenId = button.data('truyen-id');
        var currentStatus = button.data('status');
        
        // Thêm hiệu ứng loading
        var icon = button.find('i');
        var originalClass = icon.attr('class');
        icon.attr('class', 'fas fa-spinner fa-spin');
        
        // Gửi request Ajax
        $.ajax({
            url: '/truyen/yeuthich',
            type: 'POST',
            data: {
                truyen_id: truyenId
            },
            success: function(response) {
                if (response.success) {
                    // Cập nhật giao diện
                    if (response.status === 'added') {
                        button.data('status', 'active');
                        icon.attr('class', 'fas fa-heart');
                        showToast('success', response.message);
                    } else {
                        button.data('status', 'inactive');
                        icon.attr('class', 'far fa-heart');
                        showToast('info', response.message);
                    }
                }
            },
            error: function(xhr) {
                // Khôi phục icon
                icon.attr('class', originalClass);
                
                // Xử lý lỗi
                if (xhr.status === 401) {
                    var response = xhr.responseJSON;
                    if (response && response.redirect) {
                        showToast('warning', response.message);
                        setTimeout(function() {
                            window.location.href = response.redirect;
                        }, 2000);
                    }
                } else {
                    showToast('error', 'Có lỗi xảy ra. Vui lòng thử lại!');
                }
            }
        });
    });

    // Hàm hiển thị thông báo
    function showToast(type, message) {
        // Kiểm tra xem đã có container toast chưa
        if ($('#toast-container').length === 0) {
            $('body').append('<div id="toast-container" class="position-fixed top-0 end-0 p-3" style="z-index: 1060"></div>');
        }
        
        // Tạo toast
        var toastId = 'toast-' + Date.now();
        var bgClass = 'bg-primary';
        var icon = '<i class="fas fa-info-circle me-2"></i>';
        
        if (type === 'success') {
            bgClass = 'bg-success';
            icon = '<i class="fas fa-check-circle me-2"></i>';
        } else if (type === 'error') {
            bgClass = 'bg-danger';
            icon = '<i class="fas fa-exclamation-circle me-2"></i>';
        } else if (type === 'warning') {
            bgClass = 'bg-warning';
            icon = '<i class="fas fa-exclamation-triangle me-2"></i>';
        } else if (type === 'info') {
            bgClass = 'bg-info';
            icon = '<i class="fas fa-info-circle me-2"></i>';
        }
        
        var toast = `
        <div id="${toastId}" class="toast align-items-center text-white ${bgClass} border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    ${icon} ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
        `;
        
        // Thêm toast vào container
        $('#toast-container').append(toast);
        
        // Hiển thị toast
        var toastElement = document.getElementById(toastId);
        var bsToast = new bootstrap.Toast(toastElement, {
            delay: 3000
        });
        bsToast.show();
        
        // Xóa toast sau khi ẩn
        $(toastElement).on('hidden.bs.toast', function() {
            $(this).remove();
        });
    }
});