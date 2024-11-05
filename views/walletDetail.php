<div class="flex flex-col gap-4 p-10 w-full">
    <div>
        <h1 class="text-2xl font-bold"><?= htmlspecialchars($title) ?></h1>
        <div class="breadcrumbs text-sm px-2">
            <ul>
                <li><a href="/">Dashboard</a></li>
                <li><a href="/wallets">Wallets</a></li>
                <li>Wallet <?= htmlspecialchars($wallet->wallet_id) ?></li>
            </ul>
        </div>
    </div>
    <div class="overflow-x-auto px-4">
        <?php if ($wallet): ?>
            <div class="flex">
                <div class="flex flex-col space-y-4">
                        <span><strong>Wallet ID:</strong> <?= htmlspecialchars($wallet->wallet_id) ?></span>
                        <span><strong>User:</strong> <?= htmlspecialchars($wallet->user->username) ?></span>
                        <span><strong>Balance:</strong> <?= htmlspecialchars($wallet->balance) ?> <?= htmlspecialchars($wallet->coin->symbol) ?></span>
                        <span><strong>Status:</strong> <?= htmlspecialchars($wallet->status) ?></span>
                        <span><strong>Created At:</strong> <?= htmlspecialchars($wallet->created_at) ?></span>
                    </div>
                </div>
                <canvas id="cryptoLineChart" width="400" height="200"></canvas>
            </div>
        <?php else: ?>
            <p>Wallet not found.</p>
        <?php endif; ?>
    </div>
</div>