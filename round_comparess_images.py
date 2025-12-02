import os
from PIL import Image, ImageDraw, ImageOps

# Folder containing your original images
folder_path = r"C:\Users\User\Desktop\ART_STATIONERY"
output_folder = os.path.join(folder_path, "rounded")

os.makedirs(output_folder, exist_ok=True)

def make_rounded(image):
    # Ensure image is square by cropping center
    width, height = image.size
    min_side = min(width, height)
    left = (width - min_side) // 2
    top = (height - min_side) // 2
    right = left + min_side
    bottom = top + min_side
    image = image.crop((left, top, right, bottom))

    # Create same-size mask with a white circle
    mask = Image.new("L", image.size, 0)
    draw = ImageDraw.Draw(mask)
    draw.ellipse((0, 0, image.size[0], image.size[1]), fill=255)

    # Apply the circular mask
    rounded = ImageOps.fit(image, mask.size, centering=(0.5, 0.5))
    rounded.putalpha(mask)
    return rounded

for filename in os.listdir(folder_path):
    if filename.lower().endswith((".jpg", ".jpeg", ".png")):
        input_path = os.path.join(folder_path, filename)
        output_path = os.path.join(output_folder, filename)

        with Image.open(input_path).convert("RGBA") as img:
            # Apply round mask
            rounded_img = make_rounded(img)

            # Compress and save as PNG to preserve transparency
            rounded_img.save(output_path, "PNG", optimize=True)

        print(f"✅ Processed: {filename}")

print("\n✨ All images saved with round aesthetic mask in:", output_folder)
