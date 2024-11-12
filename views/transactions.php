<div class="flex flex-col gap-4 p-10 w-full">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold"><?= htmlspecialchars($title) ?></h1>
            <div class="breadcrumbs text-sm px-2">
                <ul>
                    <li><a href="/">Dashboard</a></li>
                    <li>Transactions</li>
                </ul>
            </div>
        </div>
        <div>
            <?php if ($transactions): ?>
                <?php
                    $currentUser = $_SESSION['user'] ?? null;
                    if ($currentUser && in_array($currentUser['role'], ['admin', 'moderator'])):
                ?>
                    <button class="btn" onclick="my_modal_2.showModal()">Post Transaction</button>
                <?php else: ?>
                    <span>Can't post Transactions because you are not admin or moderator</span>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <dialog id="my_modal_2" class="modal">
            <div class="modal-box w-11/12 max-w-5xl">
                <h3 class="text-lg font-bold">Post Transaction</h3>
                <div class="modal-action flex flex-col">
                    <form action="/transaction/post?action=post" method="POST" class="px-4">
                        <div class="space-y-2">
                            <div class="space-y-2">
                                <label for="user" class="block text-sm font-medium">User:</label>
                                <select id="user" name="user_id" class="select select-bordered w-full" onchange="updateWallets()">
                                    <option value="">Select User</option>
                                    <?php foreach ($users as $user): ?>
                                        <option value="<?= $user->user_id ?>">
                                            <?= htmlspecialchars($user->username) ?> (ID: <?= htmlspecialchars($user->user_id) ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div id="wallet-container" class="space-y-2 hidden">
                                <label for="wallet" class="block text-sm font-medium">Wallet:</label>
                                <select id="wallet" name="wallet_id" class="select select-bordered w-full">
                                </select>
                            </div>

                            <div class="space-y-2">
                                <label for="amount" class="block text-sm font-medium">Amount:</label>
                                <input type="number" id="amount" name="amount" class="input input-bordered w-full">
                            </div>

                            <div class="space-y-2">
                                <label for="coin" class="block text-sm font-medium">Coin:</label>
                                <select id="coin" name="coin_id" class="select select-bordered w-full">
                                    <?php foreach ($coins as $coin): ?>
                                        <option value="<?= htmlspecialchars($coin->coin_id) ?>">
                                            <?= htmlspecialchars($coin->coin_name) ?> (<?= htmlspecialchars($coin->symbol) ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="space-y-2">
                                <label for="transaction_type" class="block text-sm font-medium">Transaction Type:</label>
                                <select id="transaction_type" name="transaction_type" class="select select-bordered w-full">
                                    <option value="buy">Buy</option>
                                    <option value="sell">Sell</option>
                                </select>
                            </div>

                            <div class="space-y-2">
                                <label for="status" class="block text-sm font-medium">Status:</label>
                                <select id="status" name="status" class="select select-bordered w-full">
                                    <option value="pending">Pending</option>
                                    <option value="completed">Completed</option>
                                    <option value="failed">Failed</option>
                                </select>
                            </div>

                            <div class="space-y-2">
                                <label for="fee" class="block text-sm font-medium">Fee:</label>
                                <input type="number" step="0.01" id="fee" name="fee" class="input input-bordered w-full">
                            </div>

                            <div class="space-y-2">
                                <label for="notes" class="block text-sm font-medium">Notes:</label>
                                <input type="text" id="notes" name="notes" class="textarea textarea-bordered w-full"></input>
                            </div>

                            <button type="submit" class="btn">Post Transaction</button>
                        </div>
                    </form>
                    <form method="dialog">
                        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                    </form>
                </div>
            </div>
        </dialog>
    </div>
    <div class="mx-auto">
        <?php if (!empty($transactions)): ?>
            <div class="table divide-y">
                <div class="table-header-group">
                    <div class="table-row">
                        <div class="table-cell px-6 py-3 text-left uppercase tracking-wider font-medium">Transaction ID</div>
                        <div class="table-cell px-6 py-3 text-left uppercase tracking-wider font-medium">User</div>
                        <div class="table-cell px-6 py-3 text-left uppercase tracking-wider font-medium">Amount</div>
                        <div class="table-cell px-6 py-3 text-left uppercase tracking-wider font-medium">Coin Name</div>
                        <div class="table-cell px-6 py-3 text-left uppercase tracking-wider font-medium">Type</div>
                        <div class="table-cell px-6 py-3 text-left uppercase tracking-wider font-medium">Ref</div>
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
                            <div class="table-cell px-6 py-4"><?= htmlspecialchars($transaction->reference_id) ?></div>
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

<script>
    const usersData = <?= json_encode($users) ?>;

    function updateWallets() {
        const userId = document.getElementById('user').value;
        const walletContainer = document.getElementById('wallet-container');
        const walletSelect = document.getElementById('wallet');

        walletSelect.innerHTML = '';
        
        if (!userId) {
            walletContainer.classList.add('hidden');
            return;
        }

        const user = usersData.find(u => u.user_id == userId);
        if (user && user.wallets.length > 0) {
            walletContainer.classList.remove('hidden');
            user.wallets.forEach(wallet => {
                const option = document.createElement('option');
                option.value = wallet.wallet_id;
                option.textContent = `${wallet.wallet_address} (ID: ${wallet.wallet_id})`;
                walletSelect.appendChild(option);
            });
        } else {
            walletContainer.classList.add('hidden');
        }
    }
</script>