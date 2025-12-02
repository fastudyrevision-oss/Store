import os
from PIL import Image, ImageDraw, ImageFilter

# Folder paths
folder_path = r"C:\Users\User\Desktop\ART_STATIONERY"
output_folder = os.path.join(folder_path, "round_mask_shadow")

os.makedirs(output_folder, exist_ok=True)

def apply_soft_round_mask_with_shadow(image, blur_radius=80, shadow_offset=(20, 20), shadow_blur=50):
    # Convert to RGBA
    image = image.convert("RGBA")
    width, height = image.size

    # --- Step 1: Create circular gradient mask ---
    mask = Image.new("L", (width, height), 0)
    draw = ImageDraw.Draw(mask)

    # Draw a white circle (centered)
    circle_diameter = min(width, height) * 0.9
    left = (width - circle_diameter) / 2
    top = (height - circle_diameter) / 2
    right = left + circle_diameter
    bottom = top + circle_diameter

    draw.ellipse((left, top, right, bottom), fill=255)
    mask = mask.filter(ImageFilter.GaussianBlur(blur_radius))  # soft fade edges

    # Apply mask to image (keep edges soft)
    soft_round = image.copy()
    soft_round.putalpha(mask)

    # --- Step 2: Create soft shadow ---
    shadow = Image.new("RGBA", image.size, (0, 0, 0, 0))
    shadow_draw = ImageDraw.Draw(shadow)
    shadow_draw.ellipse((left, top, right, bottom), fill=(0, 0, 0, 180))
    shadow = shadow.filter(ImageFilter.GaussianBlur(shadow_blur))

    # Create final canvas (slightly larger to fit shadow)
    final_w = width + abs(shadow_offset[0])
    final_h = height + abs(shadow_offset[1])
    final = Image.new("RGBA", (final_w, final_h), (0, 0, 0, 0))

    # Paste shadow then the soft-round image
    shadow_pos = (max(shadow_offset[0], 0), max(shadow_offset[1], 0))
    img_pos = (max(-shadow_offset[0], 0), max(-shadow_offset[1], 0))
    final.paste(shadow, shadow_pos, shadow)
    final.paste(soft_round, img_pos, soft_round)

    return final


for filename in os.listdir(folder_path):
    if filename.lower().endswith((".jpg", ".jpeg", ".png")):
        input_path = os.path.join(folder_path, filename)
        output_path = os.path.join(output_folder, filename.replace(".jpg", ".png").replace(".jpeg", ".png"))

        with Image.open(input_path) as img:
            final_img = apply_soft_round_mask_with_shadow(img)
            final_img.save(output_path, "PNG", optimize=True)

        print(f"✅ Applied round mask + soft shadow: {filename}")

print("\n✨ All images saved in:", output_folder)
