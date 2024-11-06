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

<div class="flex flex-col gap-10 p-10 w-full bg-base-100">
    <h1 class="text-2xl font-bold"><?= htmlspecialchars($title) ?></h1>

    <div id="users" class="overflow-x-auto px-4 space-y-4">
        <h2 class="text-2xl font-bold">Users</h2>
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
                        <div class="table-row hover:bg-base-200">
                            <div class="table-cell px-6 py-4"><?= htmlspecialchars($user->username) ?></div>
                            <div class="table-cell px-6 py-4"><?= htmlspecialchars($user->email) ?></div>
                            <div class="table-cell px-6 py-4"><?= htmlspecialchars($user->role) ?></div>
                            <div class="table-cell px-6 py-4"><?= htmlspecialchars($user->status) ?></div>
                            <div class="table-cell px-6 py-4"><?= htmlspecialchars($user->created_at) ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php else: ?>
            <p class="text-gray-500">No users available.</p>
        <?php endif; ?>
    </div>
    
    <div id="coins" class="overflow-x-auto px-4 space-y-4"> 
        <h2 class="text-2xl font-bold">Coins</h2>
        <div class="grid grid-cols-2 gap-4">
            <?php if (!empty($coins)): ?>
                <?php foreach ($coins as $index => $coin): ?>
                    <div class="card bg-base-200 shadow-xl mb-4">
                        <div class="card-body flex flex-row">
                            <div class="flex flex-col gap-2 w-1/2">
                                <h2 class="card-title"><?= htmlspecialchars($coin->coin_name) ?> (<?= htmlspecialchars($coin->symbol) ?>)</h2>
                                <span class="text-3xl uppercase"><?= htmlspecialchars(format($coin->price)) ?></span>
                                <span class="text-xs <?= $coin->change_percentage >= 0 ? 'text-green-500' : 'text-red-500' ?>">
                                    Gain/Loss: <?= htmlspecialchars(format($coin->change_percentage)) ?>%
                                </span>
                            </div>
                            <div class="divider divider-horizontal"></div>
                            <div class="flex flex-col items-end gap-2 w-1/2">
                                <span class="text-xl">Market Cap: <?= htmlspecialchars(format($coin->market_cap)) ?></span>
                                <span class="text-xl">Total supply: <?= htmlspecialchars(format($coin->total_supply)) ?></span>
                                <span class="text-xl">Circulating supply: <?= htmlspecialchars(format($coin->circulating_supply)) ?></span>
                            </div>
                        </div>
                        <canvas id="cryptoLineChart<?= $index ?>" width="400" height="200"></canvas>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-gray-500">No coins available.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    <?php foreach ($coins as $index => $coin): ?>
        (function() {
            const ctx = document.getElementById('cryptoLineChart<?= $index ?>').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    datasets: [{
                        label: '<?= htmlspecialchars($coin->coin_name) ?> Price (in USD)',
                        data: [
                            <?php 
                            $prices = array_map(function($price) {
                                return htmlspecialchars($price->price);
                            }, $coin->prices);
                            echo implode(', ', $prices); 
                            ?>
                        ],
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
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Price (USD)'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Month'
                            }
                        }
                    }
                }
            });
        })(); 
    <?php endforeach; ?>
</script>