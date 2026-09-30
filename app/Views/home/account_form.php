<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $account ? 'Edit' : 'Add' ?> Customer Account - Puihaha Electric</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<main class="container py-5" style="max-width: 850px">
    <div class="card shadow-sm">
        <div class="card-body p-4">
            <h1 class="h3 mb-4"><?= $account ? 'Edit' : 'Add' ?> Customer Account</h1>
            <?php if ($errors): ?>
                <div class="alert alert-danger" role="alert">
                    <ul class="mb-0"><?php foreach ($errors as $error): ?><li><?= esc($error) ?></li><?php endforeach; ?></ul>
                </div>
            <?php endif; ?>
            <form method="post" action="<?= base_url($account ? 'account/' . $account['id'] . '/edit' : 'account') ?>">
                <?= csrf_field() ?>
                <div class="row g-3">
                    <?php foreach ([
                        ['account_number', 'Account Number', 'text', true],
                        ['customer_name', 'Customer Name', 'text', true],
                        ['address', 'Address', 'text', true],
                        ['phone', 'Phone', 'tel', false],
                        ['email', 'Email', 'email', false],
                        ['meter_number', 'Meter Number', 'text', false],
                    ] as [$name, $label, $type, $required]): ?>
                        <div class="col-md-6">
                            <label class="form-label" for="<?= $name ?>"><?= $label ?></label>
                            <input class="form-control" id="<?= $name ?>" name="<?= $name ?>" type="<?= $type ?>"
                                value="<?= esc(old($name, $account[$name] ?? '')) ?>" <?= $required ? 'required' : '' ?>>
                        </div>
                    <?php endforeach; ?>
                    <div class="col-md-6">
                        <label class="form-label" for="connection_type">Connection Type</label>
                        <select class="form-select" id="connection_type" name="connection_type" required>
                            <?php foreach (['residential', 'commercial', 'industrial'] as $type): ?>
                                <option value="<?= $type ?>" <?= old('connection_type', $account['connection_type'] ?? 'residential') === $type ? 'selected' : '' ?>><?= ucfirst($type) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="status">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <?php foreach (['active', 'inactive', 'suspended'] as $status): ?>
                                <option value="<?= $status ?>" <?= old('status', $account['status'] ?? 'active') === $status ? 'selected' : '' ?>><?= ucfirst($status) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="d-flex gap-2 mt-4">
                    <button class="btn btn-primary" type="submit"><?= $account ? 'Save Changes' : 'Create Account' ?></button>
                    <a class="btn btn-outline-secondary" href="<?= base_url('dashboard') ?>">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</main>
</body>
</html>
