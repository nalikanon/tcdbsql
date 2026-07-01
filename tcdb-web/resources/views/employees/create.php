<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --primary-hover: #4f46e5;
            --bg-color: #000000;
            --text-color: #f8fafc;
            --card-bg: rgba(30, 41, 59, 0.7);
            --border-color: rgba(255, 255, 255, 0.1);
            --input-bg: rgba(15, 23, 42, 0.5);
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            margin: 0;
            padding: 2rem;
            min-height: 100vh;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin: 0;
            background: linear-gradient(to right, #818cf8, #c084fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .glass-panel {
            background: var(--card-bg);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #94a3b8;
        }

        input {
            width: 100%;
            padding: 0.75rem;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            background-color: var(--input-bg);
            color: white;
            font-family: inherit;
            box-sizing: border-box;
            transition: border-color 0.2s ease;
        }

        input:focus {
            outline: none;
            border-color: var(--primary);
        }

        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: all 0.2s ease;
            width: 100%;
            font-size: 1rem;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
        }

        .btn-secondary {
            background-color: transparent;
            color: #94a3b8;
            border: 1px solid var(--border-color);
            margin-top: 1rem;
            text-align: center;
        }
        
        .btn-secondary:hover {
            background-color: rgba(255, 255, 255, 0.05);
            color: white;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            body { padding: 1rem; }
            .glass-panel { padding: 1.5rem; }
            h1 { font-size: 2rem; }
        }
        
        @media (max-width: 480px) {
            header { flex-direction: column; gap: 1rem; text-align: center; }
            h1 { font-size: 1.75rem; }
            input { font-size: 1rem; padding: 0.65rem; }
            .btn { font-size: 0.95rem; }
        }

    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Add New Employee</h1>
        </header>
        
        <div class="glass-panel">
            <?php if (!empty($error)): ?>
            <div style="background-color: rgba(239, 68, 68, 0.2); border: 1px solid #ef4444; color: #fca5a5; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
                <?= htmlspecialchars($error) ?>
            </div>
            <?php endif; ?>
            <form method="POST" action="/employees">
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" id="first_name" name="first_name" required>
                </div>
                
                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" id="last_name" name="last_name" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="job">Job Title</label>
                    <input type="text" id="job" name="job" required>
                </div>
                
                <div class="form-group">
                    <label for="salary">Salary</label>
                    <input type="number" step="0.01" id="salary" name="salary" required>
                </div>
                
                <button type="submit" class="btn btn-primary">Save Employee</button>
                <a href="/" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</body>
</html>
