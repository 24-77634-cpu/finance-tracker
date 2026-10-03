<?php
require_once 'config.php';

// Fetch all transactions sorted by the latest date
$stmt = $pdo->query("SELECT * FROM transactions ORDER BY date DESC, id DESC");
$transactions = $stmt->fetchAll();

// Calculate totals
$total_income = 0;
$total_expense = 0;

foreach ($transactions as $t) {
    if ($t['type'] === 'income') {
        $total_income += $t['amount'];
    } else {
        $total_expense += $t['amount'];
    }
}
$net_balance = $total_income - $total_expense;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Finance & Budget Tracker</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://jsdelivr.net" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2">💰 Personal Finance Tracker</h1>
        <a href="create.php" class="btn btn-primary">+ Add New Transaction</a>
    </div>

    <!-- Summary Metrics Dashboard -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-white text-dark p-3">
                <small class="text-uppercase text-muted fw-bold">Net Balance</small>
                <h3 class="mt-1 fw-bold <?php echo $net_balance >= 0 ? 'text-success' : 'text-danger'; ?>">
                    $<?php echo number_format($net_balance, 2); ?>
                </h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-white text-dark p-3">
                <small class="text-uppercase text-muted fw-bold text-success">Total Income</small>
                <h3 class="mt-1 text-success fw-bold">$<?php echo number_format($total_income, 2); ?></h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-white text-dark p-3">
                <small class="text-uppercase text-muted fw-bold text-danger">Total Expenses</small>
                <h3 class="mt-1 text-danger fw-bold">$<?php echo number_format($total_expense, 2); ?></h3>
            </div>
        </div>
    </div>

    <!-- Transactions Ledger -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-4">Date</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Amount</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($transactions)): ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">No records found. Click "+ Add New Transaction" to start tracking!</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($transactions as $t): ?>
                                <tr>
                                    <td class="ps-4"><?php echo htmlspecialchars($t['date']); ?></td>
                                    <td class="fw-semibold"><?php echo htmlspecialchars($t['title']); ?></td>
                                    <td><span class="badge bg-secondary"><?php echo htmlspecialchars($t['category']); ?></span></td>
                                    <td class="<?php echo $t['type'] === 'income' ? 'text-success fw-bold' : 'text-danger fw-bold'; ?>">
                                        <?php echo $t['type'] === 'income' ? '+' : '-'; ?>$<?php echo number_format($t['amount'], 2); ?>
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="update.php?id=<?php echo $t['id']; ?>" class="btn btn-sm btn-outline-secondary me-1">Edit</a>
                                        <a href="delete.php?id=<?php echo $t['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to remove this transaction?');">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>