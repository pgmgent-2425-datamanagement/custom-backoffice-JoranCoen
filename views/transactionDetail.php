<div class="flex flex-col gap-4 p-10 w-full">
    <div>
        <h1 class="text-3xl font-bold"><?= htmlspecialchars($title) ?></h1>
        <div class="breadcrumbs text-sm px-2">
            <ul>
                <li><a href="/">Dashboard</a></li>
                <li><a href="/transactions">Transactions</a></li>
                <li><?= htmlspecialchars($title) ?> <?= htmlspecialchars($transaction->transaction_id) ?></li>
            </ul>
        </div>
    </div>
    <div class="px-4">
        <?php if ($transaction): ?>
            <?php 
            $currentUser = $_SESSION['user'] ?? null;
            if ($currentUser && in_array($currentUser['role'], ['admin', 'moderator'])): 
            ?>
                <form action="/transaction/<?= htmlspecialchars($transaction->transaction_id) ?>?action=update" method="POST">
                    <input type="hidden" name="transaction_id" value="<?= htmlspecialchars($transaction->transaction_id) ?>">

                    <div class="space-y-2">
                        <div class="space-y-2">
                            <label for="amount" class="block text-sm font-medium">Amount:</label>
                            <input type="number" id="amount" name="amount" value="<?= htmlspecialchars($transaction->amount) ?>" class="input input-bordered w-full">
                        </div>

                        <div class="space-y-2">
                            <label for="coin" class="block text-sm font-medium">Coin:</label>
                            <select id="coin" name="coin_id" class="select select-bordered w-full">
                                <?php foreach ($coins as $coin): ?>
                                    <option value="<?= htmlspecialchars($coin->coin_id) ?>" <?= htmlspecialchars($transaction->coin->coin_id) === htmlspecialchars($coin->coin_id) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($coin->coin_name) ?> (<?= htmlspecialchars($coin->symbol) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label for="transaction_type" class="block text-sm font-medium">Transaction Type:</label>
                            <select id="transaction_type" name="transaction_type" class="select select-bordered w-full">
                                <option value="buy" <?= htmlspecialchars($transaction->transaction_type) === 'buy' ? 'selected' : '' ?>>Buy</option>
                                <option value="sell" <?= htmlspecialchars($transaction->transaction_type) === 'sell' ? 'selected' : '' ?>>Sell</option>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label for="status" class="block text-sm font-medium">Status:</label>
                            <select id="status" name="status" class="select select-bordered w-full">
                                <option value="pending" <?= htmlspecialchars($transaction->status) === 'pending' ? 'selected' : '' ?>>Pending</option>
                                <option value="completed" <?= htmlspecialchars($transaction->status) === 'completed' ? 'selected' : '' ?>>Completed</option>
                                <option value="failed" <?= htmlspecialchars($transaction->status) === 'failed' ? 'selected' : '' ?>>Failed</option>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label for="fee" class="block text-sm font-medium">Fee:</label>
                            <input type="number" step="0.01" id="fee" name="fee" value="<?= htmlspecialchars($transaction->fee) ?>" class="input input-bordered w-full">
                        </div>

                        <div class="space-y-2">
                            <label for="notes" class="block text-sm font-medium">Notes:</label>
                            <textarea id="notes" name="notes" class="textarea textarea-bordered w-full"><?= htmlspecialchars($transaction->notes) ?></textarea>
                        </div>

                        <div class="space-y-2">
                            <label for="date" class="block text-sm font-medium">Date:</label>
                            <input type="text" id="date" name="date" value="<?= htmlspecialchars($transaction->transaction_date) ?>" class="input input-bordered w-full">
                        </div>

                        <div class="space-y-2">
                            <button type="submit" class="btn">Update Transaction</button>
                        </div>
                    </div>
                </form>
            <?php else: ?>
                <div class="flex flex-col space-y-4">
                    <span><strong>Transaction ID:</strong> <?= htmlspecialchars($transaction->transaction_id) ?></span>
                    <span><strong>Amount:</strong> <?= htmlspecialchars($transaction->amount) ?> <?= htmlspecialchars($transaction->coin->symbol) ?></span>
                    <span><strong>Coin:</strong> <?= htmlspecialchars($transaction->coin->coin_name) ?> (<?= htmlspecialchars($transaction->coin->symbol) ?>)</span>
                    <span><strong>Transaction Type:</strong> <?= htmlspecialchars($transaction->transaction_type) ?></span>
                    <span><strong>Status:</strong> <?= htmlspecialchars($transaction->status) ?></span>
                    <span><strong>Fee:</strong> <?= htmlspecialchars($transaction->fee) ?> <?= htmlspecialchars($transaction->coin->symbol) ?></span>
                    <span><strong>Notes:</strong> <?= htmlspecialchars($transaction->notes) ?></span>
                    <span><strong>Date:</strong> <?= htmlspecialchars($transaction->transaction_date) ?></span>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <p>Transaction not found.</p>
        <?php endif; ?>
    </div>
</div>
