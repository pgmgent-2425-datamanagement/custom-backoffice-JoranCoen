<div class="flex flex-col gap-4 p-10 w-full">
    <div>
        <h1 class="text-2xl font-bold"><?= htmlspecialchars($title) ?></h1>
        <div class="breadcrumbs text-sm px-2">
            <ul>
                <li><a href="/">Dashboard</a></li>
                <li><a href="/#users">Users</a></li>
                <li><?= htmlspecialchars($title) ?> <?= htmlspecialchars($user->user_id) ?></li>
            </ul>
        </div>
    </div>
    <div class="overflow-x-auto px-4">
        <?php if ($user): ?>
            <div class="flex flex-col gap-4">
                <?php 
                $currentUser = $_SESSION['user'] ?? null;
                if ($currentUser && in_array($currentUser['role'], ['admin', 'moderator'])): 
                ?>
                    <form action="/user/<?= htmlspecialchars($user->user_id) ?>?action=update" method="POST" class="flex gap-10">
                        <input type="hidden" name="user_id" value="<?= htmlspecialchars($user->user_id) ?>">

                        <div class="space-y-4 w-1/2">
                            <div class="space-y-2">
                                <label for="username" class="block text-sm font-medium">Username:</label>
                                <input type="text" id="username" name="username" value="<?= htmlspecialchars($user->username) ?>" class="input input-bordered w-full">
                            </div>

                            <div class="space-y-2">
                                <label for="email" class="block text-sm font-medium">Email:</label>
                                <input type="email" id="email" name="email" value="<?= htmlspecialchars($user->email) ?>" class="input input-bordered w-full">
                            </div>

                            <div class="space-y-2">
                                <label for="role" class="block text-sm font-medium">Role:</label>
                                <select id="role" name="role" class="select select-bordered w-full">
                                    <option value="user" <?= htmlspecialchars($user->role) === 'user' ? 'selected' : '' ?>>User</option>
                                    <option value="moderator" <?= htmlspecialchars($user->role) === 'moderator' ? 'selected' : '' ?>>Moderator</option>
                                    <option value="admin" <?= htmlspecialchars($user->role) === 'admin' ? 'selected' : '' ?>>Admin</option>
                                </select>
                            </div>

                            <div class="space-y-2">
                                <label for="status" class="block text-sm font-medium">Status:</label>
                                <select id="status" name="status" class="select select-bordered w-full">
                                    <option value="active" <?= htmlspecialchars($user->status) === 'active' ? 'selected' : '' ?>>Active</option>
                                    <option value="inactive" <?= htmlspecialchars($user->status) === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                                    <option value="suspended" <?= htmlspecialchars($user->status) === 'suspended' ? 'selected' : '' ?>>Suspended</option>
                                </select>
                            </div>

                            <div class="space-y-2">
                                <label for="created_at" class="block text-sm font-medium">Created At:</label>
                                <input type="text" id="created_at" name="created_at" value="<?= htmlspecialchars($user->created_at) ?>" class="input input-bordered w-full" readonly>
                            </div>
                            
                            <div class="space-y-2">
                                <button type="submit" class="btn">Update User</button>
                            </div>
                        </div>

                        <div class="space-y-4 w-1/2 ">
                            <?php if (isset($user->wallets) && is_array($user->wallets) && count($user->wallets) > 0): ?>
                                <?php foreach ($user->wallets as $index => $wallet): ?>
                                    <div class="collapse collapse-plus bg-base-200">
                                        <input type="radio" name="my-accordion" <?= $index === 0 ? 'checked="checked"' : '' ?> />
                                        <div class="collapse-title text-xl font-medium">
                                            <span><strong>Wallet ID:</strong> <?= htmlspecialchars($wallet->wallet_id) ?></span>
                                        </div>
                                        <div class="collapse-content flex flex-col gap-2">
                                            <span><strong>Wallet Address:</strong> <?= htmlspecialchars($wallet->wallet_address) ?></span>
                                            <span><strong>Balance:</strong> <?= htmlspecialchars($wallet->balance) ?> <?= htmlspecialchars($wallet->coin->symbol) ?></span>
                                            <span><strong>Status:</strong> <?= htmlspecialchars($wallet->status) ?></span>
                                            <span><strong>Notes:</strong> <?= htmlspecialchars($wallet->notes) ?></span>
                                            <span><strong>Created At:</strong> <?= htmlspecialchars($wallet->created_at) ?></span>
                                            <a href="/wallets/<?= htmlspecialchars($wallet->wallet_id) ?>" class="btn bg-base-300">Go to wallet</a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>No wallets yet.</p>
                            <?php endif; ?>
                        </div>
                    </form>
                <?php else: ?>
                    <div class="flex flex-col space-y-4">
                        <span><strong>User ID:</strong> <?= htmlspecialchars($user->user_id) ?></span>
                        <span><strong>Username:</strong> <?= htmlspecialchars($user->username) ?></span>
                        <span><strong>Email:</strong> <?= htmlspecialchars($user->email) ?></span>
                        <span><strong>Role:</strong> <?= htmlspecialchars($user->role) ?></span>
                        <span><strong>Status:</strong> <?= htmlspecialchars($user->status) ?></span>
                        <span><strong>Created At:</strong> <?= htmlspecialchars($user->created_at) ?></span>
                    </div>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <p>User not found.</p>
        <?php endif; ?>
    </div>
</div>