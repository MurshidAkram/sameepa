<div class="form-container">
    <h2>Edit Facility</h2>
    <form action="<?php echo URLROOT; ?>/facilities/edit/<?php echo $data['id']; ?>" method="POST">
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
                <option value="Available" <?php echo ($data['status'] == 'Available') ? 'selected' : ''; ?>>Available</option>
                <option value="Unavailable" <?php echo ($data['status'] == 'Unavailable') ? 'selected' : ''; ?>>Unavailable</option>
            </select>
        </div>
        
        <button type="submit" class="btn-submit">Update Facility</button>
    </form>
</div>
