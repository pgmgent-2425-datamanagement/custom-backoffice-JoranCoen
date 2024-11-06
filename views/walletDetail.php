<div class="flex flex-col gap-4 p-10 w-full">
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
    <div class="overflow-x-auto px-4">
        <?php if ($wallet): ?>
            <div class="flex flex-col space-y-4">
                <form action="/wallet/<?= htmlspecialchars($wallet->wallet_id) ?>?action=update" method="POST" class="flex gap-10">
                    <input type="hidden" name="wallet_id" value="<?= htmlspecialchars($wallet->wallet_id) ?>">

                    <div class="space-y-4 w-1/2">
                        <div class="space-y-2">
                            <label for="wallet_address" class="block text-sm font-medium">Wallet Address:</label>
                            <input type="text" id="wallet_address" name="wallet_address" value="<?= htmlspecialchars($wallet->wallet_address) ?>" class="input input-bordered w-full">
                        </div>

                        <div class="space-y-2">
                            <label for="balance" class="block text-sm font-medium">Balance:</label>
                            <input type="number" id="balance" name="balance" value="<?= htmlspecialchars($wallet->balance) ?>" class="input input-bordered w-full">
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
                </form>
            </div>
        <?php else: ?>
            <p>Wallet not found.</p>
        <?php endif; ?>
    </div>
</div>