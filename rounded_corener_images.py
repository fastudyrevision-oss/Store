import os
from PIL import Image, ImageDraw, ImageOps

# Folder containing your original images
folder_path = r"C:\Users\User\Desktop\ART_STATIONERY"
output_folder = os.path.join(folder_path, "rounded_corners")

os.makedirs(output_folder, exist_ok=True)

def add_rounded_corners(im, radius=50):
    # Create mask for rounded corners
    mask = Image.new("L", im.size, 0)
    draw = ImageDraw.Draw(mask)
    draw.rounded_rectangle([(0, 0), im.size], radius=radius, fill=255)

    # Apply mask to image (preserving transparency)
    rounded = im.convert("RGBA")
    rounded.putalpha(mask)
    return rounded

for filename in os.listdir(folder_path):
    if filename.lower().endswith((".jpg", ".jpeg", ".png")):
        input_path = os.path.join(folder_path, filename)
        output_path = os.path.join(output_folder, filename.replace(".jpg", ".png").replace(".jpeg", ".png"))

        with Image.open(input_path) as img:
            # Apply rounded corner overlay
            rounded_img = add_rounded_corners(img, radius=80)

            # Save as PNG (to preserve transparent corners)
            rounded_img.save(output_path, "PNG", optimize=True)

        print(f"✅ Rounded: {filename}")

print("\n✨ All images saved with soft rounded corners in:", output_folder)
