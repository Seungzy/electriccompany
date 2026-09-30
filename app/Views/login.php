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

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger" role="alert"><?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success" role="status"><?= esc(session()->getFlashdata('success')) ?></div>
        <?php endif; ?>
        <form action="<?= base_url('login') ?>" method="post">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label for="dashboard-username" class="form-label">Username</label>
                <input id="dashboard-username" name="username" type="text" class="form-control" value="<?= esc(old('username')) ?>" autocomplete="username" required maxlength="100">
            </div>
            <div class="mb-3">
                <label for="dashboard-password" class="form-label">Password</label>
                <input id="dashboard-password" name="password" type="password" class="form-control" autocomplete="current-password" required>
            </div>
            <button type="submit" class="btn login-button w-100"><i class="fas fa-sign-in-alt me-2" aria-hidden="true"></i>Login</button>
        </form>

        <div class="text-center mt-3">
            <a href="<?= base_url() ?>">Return to Home</a>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
