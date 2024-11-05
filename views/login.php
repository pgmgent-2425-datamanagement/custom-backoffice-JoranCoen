<div class="hero">
    <div class="hero-content flex-col lg:flex-row w-full">
        <div class="text-center lg:text-left">
            <h2 class="text-5xl font-bold">Login now!</h2>
            <p class="py-6">
                Don't have an account? 
                <a href="#" class="link link-hover">Sign up here</a>
            </p>
        </div>
    <div class="card bg-base-100 w-full max-w-sm shrink-0 shadow-2xl">
        <form class="card-body" action="login?action=login" method="POST">
            <div class="form-control">
                <label class="label" for="username">
                    <span class="label-text">Username:</span>
                </label>
                <input type="text" placeholder="Username" id="username" name="username" class="input input-bordered" required />
            </div>
            <div class="form-control">
                <label class="label" for="password">
                    <span class="label-text">Password:</span>
                </label>
                <input type="password" placeholder="password" id="password" name="password" class="input input-bordered" required />
                <label class="label">
                    <a href="#" class="label-text-alt link link-hover">Forgot password?</a>
                </label>
            </div>
            <div class="form-control mt-6">
                <button class="btn btn-primary">Login</button>
            </div>
        </form>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="p-2 rounded mb-4">
                <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>
    </div>
  </div>
</div>

