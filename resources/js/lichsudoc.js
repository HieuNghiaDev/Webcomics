// // Lưu trữ lịch sử đọc truyện
// function saveReadingHistory(truyenId, chapterId, chapterTitle) {
//     // Tạo đối tượng lịch sử đọc
//     const historyItem = {
//         truyenId: truyenId,
//         chapterId: chapterId,
//         chapterTitle: chapterTitle,
//         timestamp: new Date().getTime()
//     };
    
//     // Lấy lịch sử hiện tại
//     let readingHistory = JSON.parse(localStorage.getItem('readingHistory')) || [];
    
//     // Kiểm tra xem truyện đã có trong lịch sử chưa
//     const existingIndex = readingHistory.findIndex(item => item.truyenId === truyenId);
    
//     if (existingIndex !== -1) {
//         // Nếu có, cập nhật
//         readingHistory[existingIndex] = historyItem;
//     } else {
//         // Nếu chưa, thêm mới
//         readingHistory.push(historyItem);
//     }
    
//     // Giới hạn lịch sử đọc tối đa 20 truyện
//     if (readingHistory.length > 20) {
//         readingHistory = readingHistory.slice(-20);
//     }
    
//     // Lưu lại vào localStorage
//     localStorage.setItem('readingHistory', JSON.stringify(readingHistory));
// }

// // Lấy lịch sử đọc của một truyện cụ thể
// function getReadingHistory(truyenId) {
//     const readingHistory = JSON.parse(localStorage.getItem('readingHistory')) || [];
//     return readingHistory.find(item => parseInt(item.truyenId) === parseInt(truyenId));
// }