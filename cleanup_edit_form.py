#!/usr/bin/env python3
filepath = r"f:\Sempro TA\project\Laravel\TA\resources\views\Dosen\edit.blade.php"

# Read file
with open(filepath, 'r', encoding='utf-8') as f:
    lines = f.readlines()

print(f"Total lines before: {len(lines)}")

# Keep only first 206 lines
clean_lines = lines[:206]

# Write back
with open(filepath, 'w', encoding='utf-8') as f:
    f.writelines(clean_lines)

print(f"Total lines after: {len(clean_lines)}")
print("File truncated successfully!")
