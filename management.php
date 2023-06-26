<!DOCTYPE HTML>
<html>
<head>
    <title>Jawatan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .card-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #eaeaea;
        }
        .card {
            width: 300px;
            padding: 20px;
            margin: 0 10px;
            text-align: center;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card a {
            text-decoration: none;
            color: inherit;
        }
        .card i {
            font-size: 48px;
            margin-bottom: 20px;
        }
        h3 {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="card-container">
        <div class="card">
            <h3>Staf</h3>
            <a href="staff/staff-index.php">
                <i class="fas fa-users"></i>
            </a>
        </div>
        <div class="card">
            <h3>Admin / CEO</h3>
            <a href="admin/admin-index.php">
                <i class="fas fa-user-large"></i>
            </a>
        </div>
    </div>
</body>
</html>
