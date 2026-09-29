<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<style>
    .dashboard-login-section {
        min-height: calc(100vh - 76px);
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f5f7fa;
        padding: 48px 16px;
    }

    .dashboard-login-card {
        width: 100%;
        max-width: 400px;
        padding: 32px;
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
    }

    .dashboard-login-card .login-icon {
        color: #f59e0b;
        font-size: 2.5rem;
    }

    .dashboard-login-card h1 {
        color: #1e40af;
        font-size: 1.6rem;
        font-weight: 700;
    }

    .dashboard-login-card .login-button {
        background: #f59e0b;
        border-color: #f59e0b;
        color: #fff;
        border-radius: 25px;
    }

    .dashboard-login-card .login-button:hover {
        background: #d97706;
        border-color: #d97706;
    }
</style>

<section class="dashboard-login-section">
    <div class="dashboard-login-card">
        <div class="text-center mb-4">
            <i class="fas fa-bolt login-icon" aria-hidden="true"></i>
            <h1 class="mt-2 mb-1">Dashboard Login</h1>
            <p class="text-muted mb-0">Enter your username and password.</p>
        </div>

        <form action="<?= base_url('dashboard') ?>" method="get">
            <div class="mb-3">
                <label for="dashboard-username" class="form-label">Username</label>
                <input id="dashboard-username" type="text" class="form-control" placeholder="Enter any username" autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="dashboard-password" class="form-label">Password</label>
                <input id="dashboard-password" type="password" class="form-control" placeholder="Enter any password" autocomplete="off">
            </div>
            <button type="submit" class="btn login-button w-100"><i class="fas fa-sign-in-alt me-2" aria-hidden="true"></i>Login</button>
        </form>

        <div class="text-center mt-3">
            <a href="<?= base_url() ?>">Return to Home</a>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
