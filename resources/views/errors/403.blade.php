<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Access Denied | Gymdesk15</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-color: #0b0c10;
            --primary: #D90429;
            --primary-glow: rgba(217, 4, 41, 0.4);
            --text-primary: #f0f0f0;
            --text-secondary: #a0a0ab;
            --heading-font: 'Outfit', sans-serif;
            --body-font: 'Outfit', sans-serif;
            --transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--body-font);
            background-color: var(--bg-color);
            color: var(--text-secondary);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background: radial-gradient(circle at 20% 30%, #1a0a0f 0%, #0b0c10 100%);
        }

        .container {
            text-align: center;
            max-width: 600px;
            padding: 40px;
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 40px 80px rgba(0,0,0,0.5);
        }

        h1 {
            font-family: var(--heading-font);
            font-size: 5rem;
            color: var(--primary);
            margin-bottom: 10px;
            line-height: 1;
        }

        h2 {
            font-size: 1.5rem;
            color: var(--text-primary);
            margin-bottom: 20px;
        }

        p {
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .actions {
            display: flex;
            gap: 16px;
            justify-content: center;
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            transition: var(--transition);
            cursor: pointer;
            text-decoration: none;
            font-family: var(--body-font);
            border: none;
        }

        .btn-primary {
            background-color: var(--primary);
            color: #fff;
        }

        .btn-primary:hover {
            box-shadow: 0 0 20px var(--primary-glow);
            transform: translateY(-2px);
        }

        .btn-outline {
            background-color: transparent;
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .btn-outline:hover {
            background-color: rgba(255, 255, 255, 0.05);
            border-color: #fff;
        }

        .icon {
            font-size: 4rem;
            margin-bottom: 20px;
            display: block;
        }
    </style>
</head>
<body>
    <div class="container">
        <span class="icon">🔒</span>
        <h1>403</h1>
        <h2>{{ $exception->getMessage() ?: 'Access Denied' }}</h2>
        <p>It looks like your gym subscription has expired or you don't have permission to view this page. Please contact your administrator or log out and sign in with a different account.</p>
        
        <div class="actions">
            <a href="{{ url('/') }}" class="btn btn-outline">Back to Home</a>
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-primary">Logout</button>
            </form>
        </div>
    </div>
</body>
</html>
