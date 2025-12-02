"""
Simple README.md to PDF converter using fpdf2
"""
import os
import sys
import re

try:
    from fpdf import FPDF
    import markdown2
except ImportError:
    print("Installing required packages...")
    import subprocess
    subprocess.check_call([sys.executable, "-m", "pip", "install", "fpdf2", "markdown2"])
    from fpdf import FPDF
    import markdown2

class PDF(FPDF):
    def header(self):
        self.set_font('Arial', 'B', 15)
        self.cell(0, 10, 'Art & Stationery Platform - README', 0, 1, 'C')
        self.ln(5)
    
    def footer(self):
        self.set_y(-15)
        self.set_font('Arial', 'I', 8)
        self.cell(0, 10, f'Page {self.page_no()}', 0, 0, 'C')
    
    def chapter_title(self, title, level=1):
        if level == 1:
            self.set_font('Arial', 'B', 16)
            self.set_text_color(44, 62, 80)
        elif level == 2:
            self.set_font('Arial', 'B', 14)
            self.set_text_color(52, 73, 94)
        elif level == 3:
            self.set_font('Arial', 'B', 12)
            self.set_text_color(44, 62, 80)
        else:
            self.set_font('Arial', 'B', 11)
            self.set_text_color(85, 85, 85)
        
        self.multi_cell(0, 10, title)
        self.ln(2)
        self.set_text_color(0, 0, 0)
    
    def chapter_body(self, body):
        self.set_font('Arial', '', 10)
        self.multi_cell(0, 5, body)
        self.ln()

def clean_markdown_for_pdf(md_content):
    """Clean markdown content for PDF conversion"""
    # Remove emojis
    md_content = re.sub(r'[^\x00-\x7F]+', '', md_content)
    # Remove HTML comments
    md_content = re.sub(r'<!--.*?-->', '', md_content, flags=re.DOTALL)
    return md_content

def parse_markdown_simple(md_file, pdf_file):
    """Parse markdown and create PDF"""
    
    # Read markdown
    with open(md_file, 'r', encoding='utf-8') as f:
        content = f.read()
    
    # Clean content
    content = clean_markdown_for_pdf(content)
    
    # Create PDF
    pdf = PDF()
    pdf.add_page()
    pdf.set_auto_page_break(auto=True, margin=15)
    
    # Parse line by line
    lines = content.split('\n')
    i = 0
    while i < len(lines):
        line = lines[i].strip()
        
        if not line:
            i += 1
            continue
        
        # Headers
        if line.startswith('# '):
            pdf.ln(3)
            pdf.chapter_title(line[2:], level=1)
        elif line.startswith('## '):
            pdf.ln(2)
            pdf.chapter_title(line[3:], level=2)
        elif line.startswith('### '):
            pdf.ln(2)
            pdf.chapter_title(line[4:], level=3)
        elif line.startswith('#### '):
            pdf.ln(1)
            pdf.chapter_title(line[5:], level=4)
        
        # Horizontal rule
        elif line.startswith('---') or line.startswith('***'):
            pdf.ln(2)
        
        # Code blocks
        elif line.startswith('```'):
            # Skip code blocks for simplicity
            i += 1
            while i < len(lines) and not lines[i].strip().startswith('```'):
                i += 1
        
        # Lists
        elif line.startswith('- ') or line.startswith('* ') or re.match(r'^\d+\.', line):
            # Clean list markers
            text = re.sub(r'^[-*]\s+', '  • ', line)
            text = re.sub(r'^\d+\.\s+', '  • ', text)
            # Remove markdown formatting
            text = re.sub(r'\*\*(.*?)\*\*', r'\1', text)  # Bold
            text = re.sub(r'\*(.*?)\*', r'\1', text)  # Italic
            text = re.sub(r'`(.*?)`', r'\1', text)  # Code
            text = re.sub(r'\[(.*?)\]\(.*?\)', r'\1', text)  # Links
            
            pdf.set_font('Arial', '', 10)
            try:
                pdf.multi_cell(0, 5, text)
            except:
                # Fallback for encoding issues
                pdf.multi_cell(0, 5, text.encode('latin-1', 'ignore').decode('latin-1'))
        
        # Regular paragraphs
        elif line and not line.startswith('#') and not line.startswith('|'):
            # Remove markdown formatting
            text = re.sub(r'\*\*(.*?)\*\*', r'\1', line)  # Bold
            text = re.sub(r'\*(.*?)\*', r'\1', line)  # Italic
            text = re.sub(r'`(.*?)`', r'\1', line)  # Code
            text = re.sub(r'\[(.*?)\]\(.*?\)', r'\1', line)  # Links
            
            pdf.set_font('Arial', '', 10)
            try:
                pdf.multi_cell(0, 5, text)
            except:
                # Fallback for encoding issues
                pdf.multi_cell(0, 5, text.encode('latin-1', 'ignore').decode('latin-1'))
            pdf.ln(1)
        
        i += 1
    
    # Save PDF
    pdf.output(pdf_file)
    print(f"✓ PDF created successfully: {pdf_file}")
    
    # Get file size
    size_kb = os.path.getsize(pdf_file) / 1024
    print(f"  File size: {size_kb:.1f} KB")
    print(f"  Total pages: {pdf.page_no()}")

if __name__ == "__main__":
    readme_md = "README.md"
    readme_pdf = "README.pdf"
    
    if not os.path.exists(readme_md):
        print(f"Error: {readme_md} not found!")
        sys.exit(1)
    
    try:
        print(f"Converting {readme_md} to PDF...")
        parse_markdown_simple(readme_md, readme_pdf)
    except Exception as e:
        print(f"Error: {e}")
        import traceback
        traceback.print_exc()
        sys.exit(1)
