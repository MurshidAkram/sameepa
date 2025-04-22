<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/payments/create_request.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/form-styles.css">
    <title>Create Payment Request | <?php echo SITENAME; ?></title>
</head>
<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>
    
    <div class="dashboard-container">
        <?php 
        switch($_SESSION['user_role_id']) {
            case 1:
                require APPROOT . '/views/inc/components/side_panel_resident.php';
                break;
            case 2:
                require APPROOT . '/views/inc/components/side_panel_admin.php';
                break;
            case 3:
                require APPROOT . '/views/inc/components/side_panel_superadmin.php';
                break;
        }
        ?>

        <main class="payments-main">
            <div class="create-request-container">
                <h2>Create New Payment Request</h2>

                <?php flash('payment_request_message'); ?>

                <form action="<?php echo URLROOT; ?>/payments/create_request" method="post">
                    <div class="form-group">
                        <label for="user_id">Resident: <sup>*</sup></label>
                        <select name="user_id" class="form-control <?php echo (!empty($data['user_id_err'])) ? 'is-invalid' : ''; ?>">
                            <option value="">Select Resident</option>
                            <?php foreach($data['residents'] as $resident): ?>
                                <option value="<?php echo $resident->id; ?>" <?php echo ($data['user_id'] == $resident->id) ? 'selected' : ''; ?>>
                                    <?php echo $resident->name; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <span class="invalid-feedback"><?php echo $data['user_id_err']; ?></span>
                    </div>
                    
                    <div class="form-group">
                        <label for="amount">Amount: <sup>*</sup></label>
                        <input type="number" step="0.01" name="amount" class="form-control <?php echo (!empty($data['amount_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['amount']; ?>">
                        <span class="invalid-feedback"><?php echo $data['amount_err']; ?></span>
                    </div>
                    
                    <div class="form-group">
                        <label for="description">Description: <sup>*</sup></label>
                        <textarea name="description" class="form-control <?php echo (!empty($data['description_err'])) ? 'is-invalid' : ''; ?>"><?php echo $data['description']; ?></textarea>
                        <span class="invalid-feedback"><?php echo $data['description_err']; ?></span>
                    </div>
                    
                    <div class="form-group">
                        <label for="due_date">Due Date: <sup>*</sup></label>
                        <input type="date" name="due_date" class="form-control <?php echo (!empty($data['due_date_err'])) ? 'is-invalid' : ''; ?>" 
                               value="<?php echo $data['due_date']; ?>" 
                               min="<?php echo date('Y-m-d'); ?>">
                        <span class="invalid-feedback"><?php echo $data['due_date_err']; ?></span>
                    </div>
                    
                    <div class="form-buttons">
                        <button type="submit" class="btn btn-primary">Create Request</button>
                        <a href="<?php echo URLROOT; ?>/payments/requests" class="btn btn-cancel">Cancel</a>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</body>
</html>