<div class="form-container">
    <h2>Edit Facility</h2>
    <script>
    function validateEditForm() {
        const name = document.querySelector('input[name="name"]').value.trim();
        const description = document.querySelector('textarea[name="description"]').value.trim();
        const capacity = parseInt(document.querySelector('input[name="capacity"]').value);

        if (name.length < 3 || name.length > 255) {
            alert('Facility name must be between 3 and 255 characters');
            return false;
        }

        if (description.length < 10) {
            alert('Description must be at least 10 characters');
            return false;
        }

        if (isNaN(capacity) || capacity <= 0) {
            alert('Capacity must be a positive number');
            return false;
        }

        return true;
    }
    </script>
    <form action="<?php echo URLROOT; ?>/facilities/edit/<?php echo $data['id']; ?>" method="POST" onsubmit="return validateEditForm()">
        <div class="form-group">
            <label for="name">Facility Name</label>
            <input type="text" name="name" value="<?php echo $data['name']; ?>" required>
        </div>
        
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" required><?php echo $data['description']; ?></textarea>
        </div>
        
        <div class="form-group">
            <label for="capacity">Capacity</label>
            <input type="number" name="capacity" value="<?php echo $data['capacity']; ?>" required>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select name="status">
                <option value="available" <?php echo ($data['status'] ?? 'available') == 'available' ? 'selected' : ''; ?>>available</option>
                <option value="unavailable" <?php echo ($data['status'] ?? 'available') == 'unavailable' ? 'selected' : ''; ?>>unavailable</option>
            </select>
        </div>
        
        <button type="submit" class="btn-submit">Update Facility</button>
    </form>
</div>
