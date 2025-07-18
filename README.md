# Minisoft Web Tools Collection (v2.2)

A collection of simple yet powerful web-based tools for various text and HTML manipulation tasks. Some of these single-page applications run entirely in the browser with no server-side processing required.

## Tools Overview

### ContentExtr
HTML Element Extractor that allows you to extract content from HTML based on attribute selectors.
- Extract content by searching for specific attributes (class, id, data-attribute)
- View extracted elements' inner text, inner HTML, and outer HTML
- Copy all extracted texts to clipboard

### MagicTable
Interactive HTML table processor with filtering and sorting capabilities.
- Analyze HTML tables to identify columns
- Select which columns to include in the processed table
- Filter table rows by included or excluded text
- Sort columns by clicking on headers

### tabParse
Transform tabular data into interactive, sortable tables with filtering capabilities.
- Parse tab-separated, CSV, semicolon, pipe, or custom delimiter data
- Auto-detect delimiter format for intelligent parsing
- Interactive table with sortable columns and real-time search filtering
- Responsive design that works on desktop and mobile
- Live statistics showing filtered vs total rows

### QRGen
Real-time QR code generator that creates codes as you type.
- Instantly generates QR codes from any text input
- Scales properly for mobile devices
- Simple, clean interface

### RangExtr
Text Range Extractor for manipulating text by position.
- Extract or remove specific character ranges from text
- Process multiple lines at once
- Option to start counting from left or right
- Real-time preview of selected text ranges

### tBody Extractor
Tool for extracting specific columns from HTML tables.
- Process tbody HTML content
- Select specific columns by index
- Generate filtered table with only the selected columns

### Minify
PHP-based tool for minifying JavaScript code.
- Compress JavaScript by removing unnecessary whitespace and comments
- Reduce file size for faster loading
- Transform double spaces into single spaces for cleaner output

### Bulkd
Multi-URL File Downloader for batch downloading files.
- Parse multiple URLs (one per line)
- Download all files or individual files
- Clear status indicators for each download

### Bulkr
Bulk QR Code Generator for creating multiple QR codes at once.
- Generate multiple QR codes from a list of values
- Add a common prefix to all codes
- Customize code size and margins
- Download all codes as a PDF

### GitComp
GitHub Commit Comparison Tool for easily generating comparison URLs.
- Create GitHub comparison URLs by specifying repository and commits
- Compare between branches, tags, or specific commit hashes
- Copy generated URLs to clipboard
- Open comparisons directly in GitHub

## Technologies Used
- HTML, CSS, JavaScript
- Tailwind CSS
- jQuery (for MagicTable)
- QRCode-SVG, svg2pdf.js, and jsPDF libraries (for QR code generation)
- PHP

## Getting Started
Some tools can be run directly in the browser without server-side requirements. Simply open the HTML files in a modern web browser to use the tools. In some cases, a PHP-enabled server is required.

## JavaScript-Based Tools
- ContentExtr
- MagicTable
- tabParse
- QRGen
- rangExtr
- tBody Extractor
- Bulkd
- Bulkr
- GitComp

## PHP-Based Tools
- Minify