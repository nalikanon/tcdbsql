<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Directory</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --primary-hover: #4f46e5;
            --bg-color: #0f172a;
            --text-color: #f8fafc;
            --card-bg: rgba(30, 41, 59, 0.7);
            --border-color: rgba(255, 255, 255, 0.1);
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-color);
            background-image: 
                radial-gradient(at 0% 0%, hsla(253,16%,7%,1) 0, transparent 50%), 
                radial-gradient(at 50% 0%, hsla(225,39%,30%,1) 0, transparent 50%), 
                radial-gradient(at 100% 0%, hsla(339,49%,30%,1) 0, transparent 50%);
            background-attachment: fixed;
            color: var(--text-color);
            margin: 0;
            padding: 2rem;
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
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
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        th, td {
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.05em;
            color: #94a3b8;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tbody tr {
            transition: all 0.2s ease;
        }

        tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.05);
            transform: scale(1.01);
        }

        .badge {
            background: rgba(99, 102, 241, 0.2);
            color: #818cf8;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        
        .salary {
            font-weight: 600;
            color: #10b981;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #94a3b8;
        }

        .btn {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: all 0.2s ease;
        }
        .btn-primary {
            background-color: var(--primary);
            color: white;
        }
        .btn-primary:hover {
            background-color: var(--primary-hover);
        }
        .btn-danger {
            background-color: #ef4444;
            color: white;
            padding: 0.25rem 0.5rem;
            font-size: 0.85rem;
        }
        .btn-danger:hover {
            background-color: #dc2626;
        }
        .action-form {
            margin: 0;
            padding: 0;
        }

    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Employee Directory</h1>
            <a href="/employees/create" class="btn btn-primary">Add Employee</a>
        </header>
        
        <div class="glass-panel">
            <?php if (count($employees) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Job Title</th>
                        <th>Salary</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($employees as $emp): ?>
                    <tr>
                        <td><?= htmlspecialchars($emp['Employee'] ?? '') ?></td>
                        <td><?= htmlspecialchars($emp['FIRSTNAME'] ?? '') ?></td>
                        <td><?= htmlspecialchars($emp['LASTNAME'] ?? '') ?></td>
                        <td><?= htmlspecialchars($emp['Email'] ?? '') ?></td>
                        <td><span class="badge"><?= htmlspecialchars($emp['Job'] ?? '') ?></span></td>
                        <td class="salary">$<?= htmlspecialchars(number_format((float)($emp['Salary'] ?? 0), 2)) ?></td>
                        <td>
                            <form method="POST" action="/employees/delete" class="action-form" onsubmit="return confirm('Are you sure you want to delete this employee?');">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($emp['Employee'] ?? '') ?>">
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <div class="empty-state">
                <h2>No employees found</h2>
                <p>There is currently no data in the database.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
