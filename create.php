<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $amount = floatval($_POST['amount']);
    $type = $_POST['type'];
    $category = trim($_POST['category']);
    $date = $_POST['date'];

    if (!empty($title) && $amount > 0 && !empty($date)) {
        $stmt = $pdo->prepare("INSERT INTO transactions (title, amount, type, category, date) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$title, $amount, $type, $category, $date]);
        header("Location: read.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Transaction</title>
    <link href="https://jsdelivr.net" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container my-5" style="max-width: 600px;">
    <div class="card border-0 shadow-sm p-4">
        <h2 class="mb-4">➕ Add Transaction</h2>
        <form method="POST" action="create.php">
            <div class="mb-3">
                <label class="form-label">Description / Title</label>
                <input type="text" name="title" class="form-control" placeholder="e.g., Grocery Shopping" required>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Amount ($)</label>
                    <input type="number" step="0.01" name="amount" class="form-control" placeholder="0.00" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Transaction Type</label>
                    <select name="type" class="form-select">
                        <option value="expense">Expense</option>
                        <option value="income">Income</option>
                    </select>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="form-label">Category</label>
                    <input type="text" name="category" class="form-control" placeholder="e.g., Food, Salary, Utilities" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Date</label>
                    <input type="date" name="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <a href="read.php" class="btn btn-outline-secondary">Back to Dashboard</a>
                <button type="submit" class="btn btn-primary">Save Transaction</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>