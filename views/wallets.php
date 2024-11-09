<div class="flex flex-col gap-4 p-10 w-full">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold"><?= htmlspecialchars($title) ?></h1>
            <div class="breadcrumbs text-sm px-2">
                <ul>
                    <li><a href="/">Dashboard</a></li>
                    <li><?= htmlspecialchars($title) ?></li>
                </ul>
            </div>
        </div>
        <div>
            <?php if ($wallets): ?>
                <?php
                    $currentUser = $_SESSION['user'] ?? null;
                    if ($currentUser && in_array($currentUser['role'], ['admin', 'moderator'])):
                ?>
                    <button class="btn" onclick="my_modal_2.showModal()">Post Wallet</button>
                <?php else: ?>
                    <span>Can't post Transactions because you are not admin or moderator</span>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <dialog id="my_modal_2" class="modal">
            <div class="modal-box w-11/12 max-w-5xl">
                <h3 class="text-lg font-bold">Post Wallet</h3>
                <div class="modal-action flex flex-col">
                    <form action="/wallet/post?action=post" method="POST" class="px-4">
                        <div class="space-y-2">
                            <div class="space-y-2">
                                <label for="user" class="block text-sm font-medium">User:</label>
                                <select id="user" name="user_id" class="select select-bordered w-full">
                                    <?php foreach ($users as $user): ?>
                                        <option value="<?= $user->user_id ?>">
                                            <?= htmlspecialchars($user->username) ?> (ID: <?= htmlspecialchars($user->user_id) ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="space-y-2">
                                <label for="balance" class="block text-sm font-medium">Balance:</label>
                                <input type="number" id="balance" name="balance" class="input input-bordered w-full">
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
                                <label for="status" class="block text-sm font-medium">Status:</label>
                                <select id="status" name="status" class="select select-bordered w-full">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>

                            <div class="space-y-2">
                                <label for="notes" class="block text-sm font-medium">Notes:</label>
                                <input type="text" id="notes" name="notes" class="textarea textarea-bordered w-full"></input>
                            </div>

                            <button type="submit" class="btn">Post Wallet</button>
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
        <?php if (!empty($wallets)): ?>
            <div class="table divide-y">
                <div class="table-header-group">
                    <div class="table-row">
                        <div class="table-cell px-6 py-3 text-left uppercase tracking-wider font-medium">Wallet ID</div>
                        <div class="table-cell px-6 py-3 text-left uppercase tracking-wider font-medium">User ID</div>
                        <div class="table-cell px-6 py-3 text-left uppercase tracking-wider font-medium">Balance</div>
                        <div class="table-cell px-6 py-3 text-left uppercase tracking-wider font-medium">Coin Name</div>
                        <div class="table-cell px-6 py-3 text-left uppercase tracking-wider font-medium">Wallet Address</div>
                        <div class="table-cell px-6 py-3 text-left uppercase tracking-wider font-medium">Status</div>
                        <div class="table-cell px-6 py-3 text-left uppercase tracking-wider font-medium">Notes</div>
                    </div>
                </div>
                <div class="table-row-group">
                    <?php foreach ($wallets as $wallet): ?>
                        <a href="/wallets/<?= htmlspecialchars($wallet->wallet_id) ?>" class="table-row hover:bg-base-300">
                            <div class="table-cell px-6 py-4"><?= htmlspecialchars($wallet->wallet_id) ?></div>
                            <div class="table-cell px-6 py-4"><?= htmlspecialchars($wallet->user->username) ?></div>
                            <div class="table-cell px-6 py-4"><?= htmlspecialchars($wallet->balance) ?> <?= htmlspecialchars($wallet->coin->symbol) ?></div>
                            <div class="table-cell px-6 py-4"><?= htmlspecialchars($wallet->coin->coin_name) ?></div>
                            <div class="table-cell px-6 py-4"><?= htmlspecialchars($wallet->wallet_address) ?></div>
                            <div class="table-cell px-6 py-4"><?= htmlspecialchars($wallet->status) ?></div>
                            <div class="table-cell px-6 py-4"><?= htmlspecialchars($wallet->notes) ?></div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php else: ?>
            <p>No wallets available.</p>
        <?php endif; ?>
    </div>
</div>