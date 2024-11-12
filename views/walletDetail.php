<div class="flex flex-col gap-4 p-10 w-full">
<div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold"><?= htmlspecialchars($title) ?></h1>
            <div class="breadcrumbs text-sm px-2">
                <ul>
                    <li><a href="/">Dashboard</a></li>
                    <li><a href="/wallets">Wallets</a></li>
                    <li><?= htmlspecialchars($title) ?> <?= htmlspecialchars($wallet->wallet_id) ?></li>
                </ul>
            </div>
        </div>
        <div>
        <?php if ($wallet): ?>
            <?php
                $currentUser = $_SESSION['user'] ?? null;
                $hasTransactions = !empty($wallet->transactions); 
                if ($currentUser && in_array($currentUser['role'], ['admin', 'moderator'])):
            ?>
                <div class="flex flex-col items-end space-y-2">
                    <form action="/wallet/delete?action=delete" method="POST">
                        <input type="hidden" name="wallet_id" value="<?= htmlspecialchars($wallet->wallet_id) ?>">
                        <button type="submit" class="btn" <?= $hasTransactions ? 'disabled' : '' ?>>Delete Wallet</button>
                    </form>
                    <?php if ($hasTransactions): ?>
                        <span>Can't delete Wallets with Transactions.</span>
                    <?php endif; ?>
                </div>
                <?php else: ?>
                    <span>Can't update / delete Wallet because you are not admin or moderator</span>
            <?php endif; ?>
        <?php endif; ?>
        </div>
    </div>
    
    <div class="px-4">
        <?php if ($wallet): ?>
            <?php 
            $currentUser = $_SESSION['user'] ?? null;
            if ($currentUser && in_array($currentUser['role'], ['admin', 'moderator'])): 
            ?>
                <form action="/wallet/update?action=update" method="POST" class="flex gap-10">
                    <input type="hidden" name="wallet_id" value="<?= htmlspecialchars($wallet->wallet_id) ?>">

                    <div class="space-y-4 w-1/2">
                        <div class="space-y-2">
                            <label for="wallet_address" class="block text-sm font-medium">Wallet Address:</label>
                            <input type="text" id="wallet_address" name="wallet_address" value="<?= htmlspecialchars($wallet->wallet_address) ?>" class="input input-bordered w-full">
                        </div>

                        <div class="space-y-2">
                            <label for="balance" class="block text-sm font-medium">Balance:</label>
                            <input type="number" id="balance" name="balance" step="0.01" value="<?= htmlspecialchars($wallet->balance) ?>" class="input input-bordered w-full">
                        </div>

                        <div class="space-y-2">
                            <label for="coin" class="block text-sm font-medium">Coin:</label>
                            <select id="coin" name="coin_id" class="select select-bordered w-full">
                                <?php foreach ($coins as $coin): ?>
                                    <option value="<?= htmlspecialchars($coin->coin_id) ?>" <?= htmlspecialchars($wallet->coin->coin_id) === htmlspecialchars($coin->coin_id) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($coin->coin_name) ?> (<?= htmlspecialchars($coin->symbol) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label for="status" class="block text-sm font-medium">Status:</label>
                            <select id="status" name="status" class="select select-bordered w-full">
                                <option value="active" <?= htmlspecialchars($wallet->status) === 'active' ? 'selected' : '' ?>>Active</option>
                                <option value="inactive" <?= htmlspecialchars($wallet->status) === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label for="notes" class="block text-sm font-medium">Notes:</label>
                            <textarea id="notes" name="notes" class="textarea textarea-bordered w-full"><?= htmlspecialchars($wallet->notes) ?></textarea>
                        </div>

                        <div class="space-y-2">
                            <button type="submit" class="btn">Update Wallet</button>
                        </div>
                    </div>

                    <div class="space-y-4 w-1/2">
                        <?php if (isset($wallet->transactions) && is_array($wallet->transactions) && count($wallet->transactions) > 0): ?>
                            <?php foreach ($wallet->transactions as $index => $transaction): ?>
                                <div class="collapse collapse-plus bg-base-200">
                                    <input type="radio" name="my-accordion" <?= $index === 0 ? 'checked="checked"' : '' ?> />
                                    <div class="collapse-title text-xl font-medium">
                                        <span><strong>Transaction ID:</strong> <?= htmlspecialchars($transaction->transaction_id) ?></span>
                                    </div>
                                    <div class="collapse-content flex flex-col gap-2">
                                        <span><strong>Amount:</strong> <?= htmlspecialchars($transaction->amount) ?> <?= htmlspecialchars($transaction->coin->symbol) ?></span>
                                        <span><strong>Coin:</strong> <?= htmlspecialchars($transaction->coin->coin_name) ?> <?= htmlspecialchars($transaction->coin->symbol) ?></span>
                                        <span><strong>Transaction Type:</strong> <?= htmlspecialchars($transaction->transaction_type) ?></span>
                                        <span><strong>Transaction Status:</strong> <?= htmlspecialchars($transaction->status) ?></span>
                                        <span><strong>Fee:</strong> <?= htmlspecialchars($transaction->fee) ?> <?= htmlspecialchars($transaction->coin->symbol) ?></span>
                                        <span><strong>Notes:</strong> <?= htmlspecialchars($transaction->notes) ?></span>
                                        <span><strong>Date:</strong> <?= htmlspecialchars($transaction->transaction_date) ?></span>
                                        <a href="/transactions/<?= htmlspecialchars($transaction->transaction_id) ?>" class="btn bg-base-300">Go to transaction</a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No transactions yet.</p>
                        <?php endif; ?>
                    </div>
                </form>
            <?php else: ?>
                <div class="flex gap-10">
                    <div class="flex flex-col space-y-4 w-1/2">
                        <span><strong>Wallet ID:</strong> <?= htmlspecialchars($wallet->wallet_id) ?></span>
                        <span><strong>Wallet Address:</strong> <?= htmlspecialchars($wallet->wallet_address) ?></span>
                        <span><strong>Balance:</strong> <?= htmlspecialchars($wallet->balance) ?></span>
                        <span><strong>Status:</strong> <?= htmlspecialchars($wallet->status) ?></span>
                        <span><strong>Notes:</strong> <?= htmlspecialchars($wallet->notes) ?></span>
                    </div>
                    <div class="space-y-4 w-1/2">
                        <?php if (isset($wallet->transactions) && is_array($wallet->transactions) && count($wallet->transactions) > 0): ?>
                            <?php foreach ($wallet->transactions as $index => $transaction): ?>
                                <div class="collapse collapse-plus bg-base-200">
                                    <input type="radio" name="my-accordion" <?= $index === 0 ? 'checked="checked"' : '' ?> />
                                    <div class="collapse-title text-xl font-medium">
                                        <span><strong>Transaction ID:</strong> <?= htmlspecialchars($transaction->transaction_id) ?></span>
                                    </div>
                                    <div class="collapse-content flex flex-col gap-2">
                                        <span><strong>Amount:</strong> <?= htmlspecialchars($transaction->amount) ?> <?= htmlspecialchars($transaction->coin->symbol) ?></span>
                                        <span><strong>Coin:</strong> <?= htmlspecialchars($transaction->coin->coin_name) ?> <?= htmlspecialchars($transaction->coin->symbol) ?></span>
                                        <span><strong>Transaction Type:</strong> <?= htmlspecialchars($transaction->transaction_type) ?></span>
                                        <span><strong>Transaction Status:</strong> <?= htmlspecialchars($transaction->status) ?></span>
                                        <span><strong>Fee:</strong> <?= htmlspecialchars($transaction->fee) ?> <?= htmlspecialchars($transaction->coin->symbol) ?></span>
                                        <span><strong>Notes:</strong> <?= htmlspecialchars($transaction->notes) ?></span>
                                        <span><strong>Date:</strong> <?= htmlspecialchars($transaction->transaction_date) ?></span>
                                        <a href="/transactions/<?= htmlspecialchars($transaction->transaction_id) ?>" class="btn bg-base-300">Go to transaction</a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No transactions yet.</p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <p>Wallet not found.</p>
        <?php endif; ?>
    </div>
</div>