#!/bin/bash

# Source and destination directories
SRC_DIR="/work/finalstyle/cocolux/storage/app/public/upload_image/"
DEST_BASE_DIR="/work/finalstyle/cocolux/storage/app/thumbs/public/upload_image/"

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

# Function to convert images to webp
convert_to_webp() {
    local file="$1"
    local extension="${file##*.}"
    extension="${extension,,}" # convert to lowercase

    if [[ "$extension" =~ ^(jpg|jpeg|png)$ ]]; then
        local relative_path="${file#$SRC_DIR}"
        local dest_file="${SRC_DIR}${relative_path%.*}.webp"
        local dest_dir=$(dirname "$dest_file")

        # Create destination directory if it doesn't exist
        mkdir -p "$dest_dir"

        # Convert to webp using mogrify
        mogrify -format webp "$file"

        echo "Converted to WebP: $file -> $dest_file"
    else
        echo "Skipped: $file (not a supported image type)"
    fi
}

# Watch for new files in the source directory
inotifywait -m -r -e close_write --format "%w%f" "$SRC_DIR" | while read file; do
    process_file "$file"
    convert_to_webp "$file"
done
