<div class="flex flex-col gap-4 p-10 w-full">
    <div>
        <h1 class="text-2xl font-bold"><?= htmlspecialchars($title) ?></h1>
        <div class="breadcrumbs text-sm px-2">
            <ul>
                <li><a href="/">Dashboard</a></li>
                <li><a href="/transactions">Transactions</a></li>
                <li>Transaction <?= htmlspecialchars($transaction->transaction_id) ?></li>
            </ul>
        </div>
    </div>
    <div class="overflow-x-auto px-4">
        <?php if ($transaction): ?>
            <div class="flex flex-col space-y-4">
                    <span><strong>Transaction ID:</strong> <?= htmlspecialchars($transaction->transaction_id) ?></span>
                    <span><strong>User:</strong> <?= htmlspecialchars($transaction->user->username) ?></span>
                    <span><strong>Amount:</strong> <?= htmlspecialchars($transaction->amount) ?> <?= htmlspecialchars($transaction->coin->symbol) ?></span>
                    <span><strong>Coin Name:</strong> <?= htmlspecialchars($transaction->coin->coin_name) ?></span>
                    <span><strong>Type:</strong> <?= htmlspecialchars($transaction->transaction_type) ?></span>
                    <span><strong>Date:</strong> <?= htmlspecialchars($transaction->transaction_date) ?></span>
                    <span><strong>Status:</strong> <?= htmlspecialchars($transaction->status) ?></span>
                    <span><strong>Fee:</strong> <?= htmlspecialchars($transaction->fee) ?> <?= htmlspecialchars($transaction->coin->symbol) ?></span>
                </div>
            </div>
        <?php else: ?>
            <p>Transaction not found.</p>
        <?php endif; ?>
    </div>
</div>