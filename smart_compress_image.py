import os
from PIL import Image

# === Folder settings ===
folder_path = r"C:\Users\User\Desktop\ART_STATIONERY\round_mask_shadow"
output_folder = os.path.join(folder_path, "compressed_rounded_images")

os.makedirs(output_folder, exist_ok=True)

def compress_image(input_path, output_path, quality=85):
    with Image.open(input_path) as img:
        img = img.convert("RGB")  # ensure compatibility
        
        # Step 1: Resize if image is extremely large (above 2000px)
        max_size = 2000
        if max(img.size) > max_size:
            img.thumbnail((max_size, max_size))
        
        # Step 2: Save optimized JPEG
        img.save(output_path, "JPEG", optimize=True, quality=quality)


for filename in os.listdir(folder_path):
    if filename.lower().endswith((".jpg", ".jpeg", ".png")):
        input_path = os.path.join(folder_path, filename)
        output_path = os.path.join(output_folder, filename.replace(".png", ".jpg"))

        # Compress
        compress_image(input_path, output_path, quality=85)

        # Show size reduction
        orig_size = os.path.getsize(input_path) / 1024
        new_size = os.path.getsize(output_path) / 1024
        reduction = 100 - (new_size / orig_size * 100)
        print(f"✅ {filename}: {orig_size:.1f} KB → {new_size:.1f} KB ({reduction:.0f}% smaller)")

print("\n✨ Compression complete! Check:", output_folder)
