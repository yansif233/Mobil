<?php
session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


if (!isset($_SESSION['cars_for_sale'])) {
    $_SESSION['cars_for_sale'] = [];
}
if (!isset($_SESSION['cars_to_buy'])) {
    $_SESSION['cars_to_buy'] = [];
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sell_submit'])) {
    $car_name = $_POST['sell_car_name'];
    $price = $_POST['sell_price'];
    $_SESSION['cars_for_sale'][] = ['name' => $car_name, 'price' => $price];
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buy_submit'])) {
    $car_name = $_POST['buy_car_name'];
    $budget = $_POST['buy_budget'];
    $_SESSION['cars_to_buy'][] = ['name' => $car_name, 'budget' => $budget];
}


if (isset($_GET['delete_sell'])) {
    unset($_SESSION['cars_for_sale'][$_GET['delete_sell']]);
}
if (isset($_GET['delete_buy'])) {
    unset($_SESSION['cars_to_buy'][$_GET['delete_buy']]);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e5f3fd;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        .dashboard-container {
            background-color: #fff;
            border-radius: 10px;
            padding: 30px;
            display: inline-block;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 30px auto;
        }
        h1, h2 {
            color: #228B22;
        }
        form {
            margin: 20px 0;
        }
        input[type="text"], input[type="number"] {
            width: 70%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        .logout-btn {
            background-color: #dc3545;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .logout-btn:hover {
            background-color: #c82333;
        }
        .car-section {
            margin-top: 20px;
        }
        .car-list {
            list-style-type: none;
            padding: 0;
        }
        .car-list li {
            background-color: #f9f9f9;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin: 10px;
            padding: 15px;
            position: relative;
        }
        .delete-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #dc3545;
            padding: 5px 10px;
            border-radius: 5px;
            color: white;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h1>Selamat Datang di Dashboard!</h1>
        <p>Anda berhasil login sebagai <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>.</p>
        <a href="logout.php" class="logout-btn">Logout</a>

        <div class="car-section">
            <h2>Jual Mobil</h2>
            <form method="post">
                <input type="text" name="sell_car_name" placeholder="Nama Mobil" required><br>
                <input type="number" name="sell_price" placeholder="Harga" required><br>
                <button type="submit" name="sell_submit">Jual Mobil</button>
            </form>
        </div>

        <div class="car-section">
            <h2>Beli Mobil</h2>
            <form method="post">
                <input type="text" name="buy_car_name" placeholder="Nama Mobil" required><br>
                <input type="number" name="buy_budget" placeholder="Budget" required><br>
                <button type="submit" name="buy_submit">Beli Mobil</button>
            </form>
        </div>


        <div class="car-section">
            <h2>Mobil Dijual</h2>
            <ul class="car-list">
                <?php foreach ($_SESSION['cars_for_sale'] as $index => $car): ?>
                    <li>
                        <strong><?php echo htmlspecialchars($car['name']); ?></strong> - <?php echo htmlspecialchars($car['price']); ?>
                        <a href="?delete_sell=<?php echo $index; ?>" class="delete-btn">Hapus</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="car-section">
            <h2>Mobil Dibeli</h2>
            <ul class="car-list">
                <?php foreach ($_SESSION['cars_to_buy'] as $index => $car): ?>
                    <li>
                        <strong><?php echo htmlspecialchars($car['name']); ?></strong> - Budget: <?php echo htmlspecialchars($car['budget']); ?>
                        <a href="?delete_buy=<?php echo $index; ?>" class="delete-btn">Hapus</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</body>
</html>
