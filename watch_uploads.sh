#!/bin/bash

# Source and destination directories
SRC_DIR="/work/finalstyle/cocolux/storage/app/public/upload_image/files/"
DEST_BASE_DIR="/work/finalstyle/cocolux/storage/app/thumbs/public/upload_image/files/"

# Create base destination directory if it doesn't exist
mkdir -p "$DEST_BASE_DIR"

# Function to process new files
process_file() {
    local file="$1"
    local relative_path="${file#$SRC_DIR}"
    local dest_file="${DEST_BASE_DIR}${relative_path%.*}.webp"
    local dest_dir=$(dirname "$dest_file")

    # Create destination directory if it doesn't exist
    mkdir -p "$dest_dir"

    # Resize and convert to webp using mogrify
    mogrify -path "$dest_dir" -resize 300x300 -format webp "$file"

    echo "Processed: $file -> $dest_file"
}

# Watch for new files in the source directory
inotifywait -m -e close_write --format "%w%f" "$SRC_DIR" | while read file; do
    process_file "$file"
done
