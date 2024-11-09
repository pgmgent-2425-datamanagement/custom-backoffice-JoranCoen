<header class="flex justify-evenly gap-4 p-4 w-full sticky top-0 z-50 bg-base-300">
    <div class="flex justify-around items-center gap-4">
        <label class="btn btn-circle swap swap-rotate">
            <input type="checkbox" @click="open = ! open" />
            <svg
                class="swap-off fill-current"
                xmlns="http://www.w3.org/2000/svg"
                width="32"
                height="32"
                viewBox="0 0 512 512">
                <path d="M64,384H448V341.33H64Zm0-106.67H448V234.67H64ZM64,128v42.67H448V128Z" />
            </svg>
            <svg
                class="swap-on fill-current"
                xmlns="http://www.w3.org/2000/svg"
                width="32"
                height="32"
                viewBox="0 0 512 512">
                <polygon
                points="400 145.49 366.51 112 256 222.51 145.49 112 112 145.49 222.51 256 112 366.51 145.49 400 256 289.49 366.51 400 400 366.51 289.49 256 400 145.49" />
            </svg>
        </label>
        <a href="/" class="text-2xl font-bold"><h1>BitVault</h1></a>
    </div>
    <form action="/search?action=post" method="POST" class="input input-bordered flex grow items-center gap-2" aria-label="Search input">
        <input 
            id="search" 
            name="search" 
            type="text" 
            class="grow" 
            placeholder="Search" 
            aria-label="Search" 
        />
        <button type="submit">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 16 16"
                fill="currentColor"
                class="h-4 w-4 opacity-70">
                <path
                    fill-rule="evenodd"
                    d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z"
                    clip-rule="evenodd" />
            </svg>
        </button>
    </form>
    <div>
        <button class="btn" onclick="my_modal_1.showModal()" aria-label="Open notifications">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M14.9997 19C14.9997 20.6569 13.6566 22 11.9997 22C10.3429 22 8.99972 20.6569 8.99972 19M13.7962 6.23856C14.2317 5.78864 14.4997 5.17562 14.4997 4.5C14.4997 3.11929 13.3804 2 11.9997 2C10.619 2 9.49972 3.11929 9.49972 4.5C9.49972 5.17562 9.76772 5.78864 10.2032 6.23856M17.9997 11.2C17.9997 9.82087 17.3676 8.49823 16.2424 7.52304C15.1171 6.54786 13.591 6 11.9997 6C10.4084 6 8.8823 6.54786 7.75708 7.52304C6.63186 8.49823 5.99972 9.82087 5.99972 11.2C5.99972 13.4818 5.43385 15.1506 4.72778 16.3447C3.92306 17.7056 3.5207 18.3861 3.53659 18.5486C3.55476 18.7346 3.58824 18.7933 3.73906 18.9036C3.87089 19 4.53323 19 5.85791 19H18.1415C19.4662 19 20.1286 19 20.2604 18.9036C20.4112 18.7933 20.4447 18.7346 20.4629 18.5486C20.4787 18.3861 20.0764 17.7056 19.2717 16.3447C18.5656 15.1506 17.9997 13.4818 17.9997 11.2Z" stroke="#828894" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
        </button>
        <dialog id="my_modal_1" class="modal" aria-labelledby="modalTitle" aria-describedby="modalDescription">
            <div class="modal-box">
                <h3 id="modalTitle" class="font-bold text-lg mb-4">Notifications</h3>
                <div class="overflow-x-auto">
                    <?php if (!empty($notifications)): ?>
                        <ul class="space-y-4" id="modalDescription">
                            <?php foreach ($notifications as $notification): ?>
                                <li class="p-4 rounded bg-base-200">
                                    <p><?= htmlspecialchars($notification->message) ?></p>
                                    <span class="text-xs text-gray-500"><?= htmlspecialchars($notification->created_at) ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p id="modalDescription">No notifications available.</p>
                    <?php endif; ?>
                </div>
                <div class="modal-action">
                    <form method="dialog">
                        <button class="btn">Close</button>
                    </form>
                </div>
            </div>
        </dialog>
    </div>
    <a href="/profile" class="flex items-center gap-2">
        <?php if (isset($_SESSION['user'])): ?>
            <img src="<?= htmlspecialchars($_SESSION['user']['profile_picture']) ?>" class="w-10 h-10 rounded-full" alt="avatar" />
            <div class="text-nowrap">
                <p class="text-lg font-bold"><?= htmlspecialchars($_SESSION['user']['username']) ?></p>
                <p class="text-xs"><?= htmlspecialchars($_SESSION['user']['role'] ?? 'User') ?></p>
            </div>
        <?php endif; ?>
    </a>
    <div class="flex items-center">
        <input type="checkbox" id="theme-toggle" class="toggle theme-controller" />
    </div>
</header>

