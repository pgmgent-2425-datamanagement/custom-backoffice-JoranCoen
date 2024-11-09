<?php

foreach ($coins as $coin) {
    if (isset($coin->prices) && count($coin->prices) > 0) {
        $initialPrice = $coin->prices[0]->price; 
        $currentPrice = $coin->prices[count($coin->prices) - 1]->price; 

        if (is_numeric($initialPrice) && is_numeric($currentPrice) && $initialPrice != 0) {
            $changePercentage = (($currentPrice - $initialPrice) / $initialPrice) * 100;
        } else {
            $changePercentage = 0; 
        }
    } else {
        $changePercentage = 0; 
    }
    $coin->change_percentage = $changePercentage;
}
function format($amount) {
    if ($amount < 1_000) {
        return "$" . number_format($amount, 2);
    } elseif ($amount < 1_000_000) {
        return "$" . number_format($amount / 1_000, 2) . "K";
    } elseif ($amount < 1_000_000_000) {
        return "$" . number_format($amount / 1_000_000, 2) . "M";
    } else {
        return "$" . number_format($amount / 1_000_000_000, 2) . "B";
    }
}

?>

<div class="flex flex-col gap-4 p-10 w-full">
    <div>
        <h1 class="text-3xl font-bold"><?= htmlspecialchars($title) ?></h1>
        <div class="breadcrumbs text-sm px-2">
            <ul>
                <li><a href="/"><?= htmlspecialchars($title) ?></a></li>
            </ul>
        </div>
    </div>
    <div id="users" class="space-y-2 flex flex-col px-4">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold">Users</h2>
            <div>
                <?php if ($users): ?>
                    <?php
                        $currentUser = $_SESSION['user'] ?? null;
                        if ($currentUser && in_array($currentUser['role'], ['admin', 'moderator'])):
                    ?>
                        <button class="btn" onclick="my_modal_2.showModal()">Post User</button>
                    <?php else: ?>
                        <span>Can't post Transactions because you are not admin or moderator</span>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <dialog id="my_modal_2" class="modal">
                <div class="modal-box w-11/12 max-w-5xl">
                    <h3 class="text-lg font-bold">Post Wallet</h3>
                    <div class="modal-action flex flex-col">
                        <form action="/user/post?action=post" method="POST" enctype="multipart/form-data" class="px-4">
                            <div class="space-y-2">
                                <div class="space-y-2">
                                    <label for="username" class="block text-sm font-medium">Username:</label>
                                    <input type="text" id="username" name="username" class="input input-bordered w-full">
                                </div>

                                <div class="space-y-2">
                                    <label for="email" class="block text-sm font-medium">Email:</label>
                                    <input type="email" id="email" name="email" class="input input-bordered w-full">
                                </div>

                                <div class="space-y-2">
                                    <label for="password" class="block text-sm font-medium">Password:</label>
                                    <input type="password" id="password" name="password" class="input input-bordered w-full">
                                </div>

                                <div class="space-y-2">
                                    <label for="coin" class="block text-sm font-medium">Status:</label>
                                    <select id="status" name="status" class="select select-bordered w-full">
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                        <option value="suspended">Suspended</option>
                                    </select>
                                </div>

                                <div class="space-y-2">
                                    <label for="role" class="block text-sm font-medium">Role:</label>
                                    <select id="role" name="role" class="select select-bordered w-full">
                                        <?php foreach ($roles as $role): ?>
                                            <option value="<?= $role->role_name ?>">
                                                <?= htmlspecialchars($role->role_name) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="space-y-2">
                                    <label for="profile_picture" class="block text-sm font-medium">Profile Picture:</label>
                                    <input type="file" id="profile_picture" name="profile_picture" class="file-input file-input-bordered w-full max-w-xs">
                                </div>

                                <button type="submit" class="btn">Post User</button>
                            </div>
                        </form>
                        <form method="dialog">
                            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                        </form>
                    </div>
                </div>
            </dialog>
        </div>
        <?php if (!empty($users)): ?>
            <div class="table divide-y">
                <div class="table-header-group">
                    <div class="table-row">
                        <div class="table-cell px-6 py-3 text-left uppercase tracking-wider font-medium">User</div>
                        <div class="table-cell px-6 py-3 text-left uppercase tracking-wider font-medium">Email</div>
                        <div class="table-cell px-6 py-3 text-left uppercase tracking-wider font-medium">Role</div>
                        <div class="table-cell px-6 py-3 text-left uppercase tracking-wider font-medium">Status</div>
                        <div class="table-cell px-6 py-3 text-left uppercase tracking-wider font-medium">Created At</div>
                    </div>
                </div>
                <div class="table-row-group">
                    <?php foreach ($users as $user): ?>
                        <a href="/user/<?= htmlspecialchars($user->user_id) ?>" class="table-row hover:bg-base-300">
                            <div class="table-cell px-6 py-4"><?= htmlspecialchars($user->username) ?></div>
                            <div class="table-cell px-6 py-4"><?= htmlspecialchars($user->email) ?></div>
                            <div class="table-cell px-6 py-4"><?= htmlspecialchars($user->role) ?></div>
                            <div class="table-cell px-6 py-4"><?= htmlspecialchars($user->status) ?></div>
                            <div class="table-cell px-6 py-4"><?= htmlspecialchars($user->created_at) ?></div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php else: ?>
            <p class="text-gray-500">No users available.</p>
        <?php endif; ?>
    </div>
    
    <div id="coins" class="mx-auto"> 
        <div class="space-y-2 flex flex-col items-center">
            <h2 class="text-2xl font-bold">Crypto Coins</h2>
            <div class="carousel max-w-3xl">
                <?php if (!empty($coins)): ?>
                    <?php foreach ($coins as $index => $coin): ?>
                        <div id="slide<?= $index ?>" class="carousel-item flex flex-col w-full">
                            <div class="stats stats-horizontal flex justify-center">
                                <div class="stat">
                                    <h2 class="stat-title"><?= htmlspecialchars($coin->coin_name) ?> (<?= htmlspecialchars($coin->symbol) ?>)</h2>
                                    <span class="stat-value"><?= htmlspecialchars(format($coin->price)) ?></span>
                                    <div class="stat-desc">Gain/Loss: 
                                        <span class="<?= htmlspecialchars($coin->change_percentage) >= 0 ? 'text-green-500' : 'text-red-500' ?>">
                                            <?= htmlspecialchars(format($coin->change_percentage)) ?>%
                                        </span>
                                    </div>
                                </div>
                                <div class="stat flex flex-col items-end">
                                    <span class="stat-title">Market Cap: <?= htmlspecialchars(format($coin->market_cap)) ?></span>
                                    <span class="stat-title">Total supply: <?= htmlspecialchars(format($coin->total_supply)) ?></span>
                                    <span class="stat-title">Circulating supply: <?= htmlspecialchars(format($coin->circulating_supply)) ?></span>
                                </div>
                            </div>
                            <div class="flex justify-between">
                                <a href="#slide<?= $index - 1 ?>" class="btn btn-circle">❮</a>
                                <a href="#slide<?= $index + 1 ?>" class="btn btn-circle">❯</a>
                            </div>
                            <canvas id="cryptoLineChart<?= $index ?>"></canvas>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <span>No coins available.</span>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    <?php foreach ($coins as $index => $coin): ?>
        (function() {
            const ctx = document.getElementById('cryptoLineChart<?= $index ?>').getContext('2d');
            
            const priceData = [
                <?php 
                $prices = array_map(function($price) {
                    return $price->price; 
                }, $coin->prices);
                echo implode(', ', $prices); 
                ?>
            ];

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    datasets: [{
                        label: '<?= htmlspecialchars($coin->coin_name) ?> Price (in USD)',
                        data: priceData,  
                        fill: false,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                        },
                    },
                    interaction: {
                        intersect: false,
                    },
                    scales: {
                        x: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Month'
                            }
                        },
                        y: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Price (USD)'
                            },
                        }
                    }
                }
            });
        })(); 
    <?php endforeach; ?>
</script>
