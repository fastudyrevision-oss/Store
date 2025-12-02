import os
from PIL import Image, ImageDraw, ImageOps, ImageFilter

# Folder containing your original images
folder_path = r"C:\Users\User\Desktop\ART_STATIONERY"
output_folder = os.path.join(folder_path, "rounded_shadow")

os.makedirs(output_folder, exist_ok=True)

def add_rounded_shadow(im, radius=60, shadow_offset=(10, 10), shadow_blur=30):
    # Ensure RGBA mode
    im = im.convert("RGBA")

    # Create rounded mask
    mask = Image.new("L", im.size, 0)
    draw = ImageDraw.Draw(mask)
    draw.rounded_rectangle([(0, 0), im.size], radius=radius, fill=255)

    # Apply mask to image
    rounded = im.copy()
    rounded.putalpha(mask)

    # Create shadow layer
    shadow = Image.new("RGBA", im.size, (0, 0, 0, 0))
    shadow_draw = ImageDraw.Draw(shadow)
    shadow_draw.rounded_rectangle([(0, 0), im.size], radius=radius, fill=(0, 0, 0, 180))

    # Blur the shadow for softness
    shadow = shadow.filter(ImageFilter.GaussianBlur(shadow_blur))

    # Calculate new canvas to include shadow offset
    total_width = im.width + abs(shadow_offset[0])
    total_height = im.height + abs(shadow_offset[1])
    final_img = Image.new("RGBA", (total_width, total_height), (0, 0, 0, 0))

    # Paste shadow and then image
    shadow_pos = (max(shadow_offset[0], 0), max(shadow_offset[1], 0))
    img_pos = (max(-shadow_offset[0], 0), max(-shadow_offset[1], 0))
    final_img.paste(shadow, shadow_pos, shadow)
    final_img.paste(rounded, img_pos, rounded)

    return final_img


for filename in os.listdir(folder_path):
    if filename.lower().endswith((".jpg", ".jpeg", ".png")):
        input_path = os.path.join(folder_path, filename)
        output_path = os.path.join(output_folder, filename.replace(".jpg", ".png").replace(".jpeg", ".png"))

        with Image.open(input_path) as img:
            result = add_rounded_shadow(img, radius=70, shadow_offset=(20, 20), shadow_blur=40)
            result.save(output_path, "PNG", optimize=True)

        print(f"✅ Rounded + shadow added: {filename}")

print("\n✨ All images saved beautifully with rounded corners and shadows in:", output_folder)



