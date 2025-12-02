import os
from PIL import Image

# Folder path
folder_path = r"C:\Users\User\Desktop\ART_STATIONERY"
output_folder = os.path.join(folder_path, "compressed")

# Create output folder if not exists
os.makedirs(output_folder, exist_ok=True)

# Loop through all JPG/JPEG images
for filename in os.listdir(folder_path):
    if filename.lower().endswith((".jpg", ".jpeg")):
        file_path = os.path.join(folder_path, filename)
        output_path = os.path.join(output_folder, filename)

        with Image.open(file_path) as img:
            # Convert to RGB (in case of some image modes)
            img = img.convert("RGB")

            # Compress and save
            img.save(output_path, "JPEG", optimize=True, quality=85)

        original_size = os.path.getsize(file_path) / 1024
        compressed_size = os.path.getsize(output_path) / 1024

        print(f"{filename}: {original_size:.1f} KB → {compressed_size:.1f} KB")

print("\n✅ Compression complete! Files saved in:", output_folder)
