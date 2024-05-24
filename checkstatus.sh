#!/bin/bash

log_file="script.log"
max_lines=1000

# Vòng lặp vô hạn
while true; do
    # Truy cập vào trang web domain và ghi log vào tệp
    wget -q --spider http://cocolux.com >> "$log_file" 2>&1 && echo "Trang cocolux.com đã tải thành công lúc $(date)." >> "$log_file"

    # Kiểm tra kết quả của lệnh wget
    if [ $? -eq 0 ]; then
        echo "Trang cocolux.com đã tải thành công."
    else
        echo "Trang cocolux.com không tải được. Khởi động lại php-fpm lúc $(date)">> "$log_file"
        # Thực hiện lệnh để khởi động lại php74-fpm. Thay thế bằng lệnh thích hợp trên hệ thống của bạn.
        systemctl restart php-fpm
    fi
    
    # Giới hạn so dòng trong tệp log
    line_count=$(wc -l < "$log_file")
    if [ "$line_count" -gt "$max_lines" ]; then
        sed -i '1,'"$((line_count - max_lines))"'d' "$log_file"
    fi
    
    # Đợi 30 giây trước khi lặp lại
    sleep 30
done

