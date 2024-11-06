<div class="flex flex-col gap-4 p-10 w-full bg-base-100">
    <div>
        <h1 class="text-3xl font-bold"><?= htmlspecialchars($title) ?></h1>
        <div class="breadcrumbs text-sm px-2">
            <ul>
                <li><a href="/">Dashboard</a></li>
                <li>Transactions</li>
            </ul>
        </div>
    </div>
    <div class="overflow-x-auto w-full">
        <?php if (!empty($transactions)): ?>
            <div class="table divide-y">
                <div class="table-header-group">
                    <div class="table-row">
                        <div class="table-cell px-6 py-3 text-left uppercase tracking-wider font-medium">Transaction ID</div>
                        <div class="table-cell px-6 py-3 text-left uppercase tracking-wider font-medium">User</div>
                        <div class="table-cell px-6 py-3 text-left uppercase tracking-wider font-medium">Amount</div>
                        <div class="table-cell px-6 py-3 text-left uppercase tracking-wider font-medium">Coin Name</div>
                        <div class="table-cell px-6 py-3 text-left uppercase tracking-wider font-medium">Type</div>
                        <div class="table-cell px-6 py-3 text-left uppercase tracking-wider font-medium">Date</div>
                        <div class="table-cell px-6 py-3 text-left uppercase tracking-wider font-medium">Status</div>
                        <div class="table-cell px-6 py-3 text-left uppercase tracking-wider font-medium">Fee</div>
                    </div>
                </div>
                <div class="table-row-group">
                    <?php foreach ($transactions as $transaction): ?>
                        <a href="/transactions/<?= htmlspecialchars($transaction->transaction_id) ?>" class="table-row hover:bg-base-300">
                            <div class="table-cell px-6 py-4"><?= htmlspecialchars($transaction->transaction_id) ?></div>
                            <div class="table-cell px-6 py-4"><?= htmlspecialchars($transaction->user->username) ?></div>
                            <div class="table-cell px-6 py-4"><?= htmlspecialchars($transaction->amount) ?> <?= htmlspecialchars($transaction->coin->symbol) ?></div>
                            <div class="table-cell px-6 py-4"><?= htmlspecialchars($transaction->coin->coin_name) ?></div>
                            <div class="table-cell px-6 py-4"><?= htmlspecialchars($transaction->transaction_type) ?></div>
                            <div class="table-cell px-6 py-4"><?= htmlspecialchars($transaction->transaction_date) ?></div>
                            <div class="table-cell px-6 py-4"><?= htmlspecialchars($transaction->status) ?></div>
                            <div class="table-cell px-6 py-4"><?= htmlspecialchars($transaction->fee) ?> <?= htmlspecialchars($transaction->coin->symbol) ?></div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php else: ?>
            <p class="text-gray-500">No transactions available.</p>
        <?php endif; ?>
    </div>
</div>