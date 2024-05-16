<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page with Sidebars</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        .container {
            display: flex;
            justify-content: space-between;
            align-items: stretch;
            height: 100vh;
        }
        .sidebar {
            width: 200px;
            background-color: #333;
            color: #fff;
            padding: 20px;
            box-sizing: border-box;
        }
        .main-content {
            flex-grow: 1;
            padding: 20px;
        }
        .sidebar-left {
            order: -1;
        }
        .sidebar-right {
            order: 2;
        }
        /* For responsiveness */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }
            .sidebar {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar sidebar-left">
            <h2>Left Sidebar</h2>
            <p>This is the left sidebar content.</p>
        </div>
        <div class="main-content">
            <h1>Main Content</h1>
            <p>This is the main content of the landing page.</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum euismod mi ut nisi tristique, sit amet lobortis metus dictum. Integer dictum lacus nunc, in convallis odio placerat ac.</p>
        </div>
        <div class="sidebar sidebar-right">
            <h2>Right Sidebar</h2>
            <p>This is the right sidebar content.</p>
        </div>
    </div>
</body>
</html>

