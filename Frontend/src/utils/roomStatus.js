export const getRoomStatusLabel = (status) => {
    switch (status) {
        case 'available':
            return 'Phòng trống';
        case 'booked':
            return 'Phòng đã đặt';
        case 'cleaned':
            return 'Đã dọn dẹp';
        case 'not_cleaned':
            return 'Chưa dọn dẹp';
        case 'under_repair':
            return 'Sửa chữa';
        default:
            return 'Không xác định';
    }
};