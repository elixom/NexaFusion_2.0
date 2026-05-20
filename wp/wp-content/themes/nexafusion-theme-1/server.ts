import express from 'express';
import path from 'path';
import fs from 'fs';

const app = express();
const PORT = 3000;

// Helper to extract HTML from the PHP files for preview
// Note: In a real app we'd use a template engine, but for this demo 
// we will just serve the equivalent HTML since the layout is already provided.

const HEADER = `
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexaFusion | Clean Innovation</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;1,400&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'background': '#F5F5F5',
                        'surface': '#FFFFFF',
                        'primary': '#1A1A1A',
                        'secondary': '#6B7280',
                        'accent': '#9CA3AF',
                        'border': '#E5E7EB',
                    },
                    fontFamily: {
                        'sans': ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                        'serif': ['Playfair Display', 'ui-serif', 'Georgia', 'serif'],
                    }
                }
            }
        }
    </script>
    <style>
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        body { background-color: #F5F5F5; color: #1A1A1A; }
    </style>
</head>
<body class="font-sans">
`;

const FOOTER = `
</body>
</html>
`;

// Helper to extract content from block templates for preview
const renderTemplate = (templatePath: string) => {
    let content = fs.readFileSync(path.join(__dirname, templatePath), 'utf8');
    
    // Simple simulation of template parts
    if (content.includes('<!-- wp:template-part {"slug":"header"')) {
        const header = fs.readFileSync(path.join(__dirname, 'parts/header.html'), 'utf8');
        content = content.replace(/<!-- wp:template-part \{"slug":"header".*? \/-->/g, header);
    }
    if (content.includes('<!-- wp:template-part {"slug":"footer"')) {
        const footer = fs.readFileSync(path.join(__dirname, 'parts/footer.html'), 'utf8');
        content = content.replace(/<!-- wp:template-part \{"slug":"footer".*? \/-->/g, footer);
    }

    // Strip block comments for clean HTML preview
    content = content.replace(/<!-- \/?wp:.*? -->/g, '');
    
    return content;
};

app.get('/', (req, res) => {
    const content = renderTemplate('templates/index.html');
    res.send(HEADER + content + FOOTER);
});

app.get('/about', (req, res) => {
    const content = renderTemplate('templates/page-about.html');
    res.send(HEADER + content + FOOTER);
});

app.get('/services', (req, res) => {
    const content = renderTemplate('templates/page-services.html');
    res.send(HEADER + content + FOOTER);
});

app.get('/contact', (req, res) => {
    const content = renderTemplate('templates/page-contact.html');
    res.send(HEADER + content + FOOTER);
});

app.listen(PORT, '0.0.0.0', () => {
    console.log(`Preview server running on port ${PORT}`);
});
