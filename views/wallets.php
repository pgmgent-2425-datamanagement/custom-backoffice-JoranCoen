<div class="flex flex-col gap-4 p-10 w-full">
    <div>
        <h1 class="text-2xl font-bold"><?= htmlspecialchars($title) ?></h1>
        <div class="breadcrumbs text-sm px-2">
            <ul>
                <li><a href="/">Dashboard</a></li>
                <li>Wallets</li>
            </ul>
        </div>
    </div>

    <div class="overflow-x-auto w-full">
        <?php if (!empty($wallets)): ?>
            <div class="table divide-y">
                <div class="table-header-group">
                    <div class="table-row">
                        <div class="table-cell px-6 py-3 text-left uppercase tracking-wider font-medium">Wallet ID</div>
                        <div class="table-cell px-6 py-3 text-left uppercase tracking-wider font-medium">User ID</div>
                        <div class="table-cell px-6 py-3 text-left uppercase tracking-wider font-medium">Balance</div>
                        <div class="table-cell px-6 py-3 text-left uppercase tracking-wider font-medium">Coin Name</div>
                        <div class="table-cell px-6 py-3 text-left uppercase tracking-wider font-medium">Status</div>
                    </div>
                </div>
                <div class="table-row-group">
                    <?php foreach ($wallets as $wallet): ?>
                        <a href="/wallets/<?= htmlspecialchars($wallet->wallet_id) ?>" class="table-row hover:bg-base-300">
                            <div class="table-cell px-6 py-4"><?= htmlspecialchars($wallet->wallet_id) ?></div>
                            <div class="table-cell px-6 py-4"><?= htmlspecialchars($wallet->user->username) ?></div>
                            <div class="table-cell px-6 py-4"><?= htmlspecialchars($wallet->balance) ?> <?= htmlspecialchars($wallet->coin->symbol) ?></div>
                            <div class="table-cell px-6 py-4"><?= htmlspecialchars($wallet->coin->coin_name) ?></div>
                            <div class="table-cell px-6 py-4"><?= htmlspecialchars($wallet->status) ?></div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php else: ?>
            <p>No wallets available.</p>
        <?php endif; ?>
    </div>
</div>