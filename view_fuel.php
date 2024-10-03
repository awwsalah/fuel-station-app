<?php
include 'db.php';
$lang = isset($_GET['lang']) ? $_GET['lang'] : 'en';

// Load the appropriate language file
if ($lang === 'so') {
    include 'lang/somali.php';
} else {
    include 'lang/english.php';
}
?>

<!DOCTYPE html>
<html lang="<?= $lang ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $lang_strings['view_fuel']; ?></title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center"><?php echo $lang_strings['view_fuel']; ?></h1>
        <div class="col-md-10 offset-md-1">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th><?php echo $lang_strings['fuel_type']; ?></th>
                        <th><?php echo $lang_strings['quantity']; ?></th>
                        <th><?php echo $lang_strings['price']; ?></th>
                        <th><?php echo $lang_strings['date_added']; ?></th>
                        <th><?php echo $lang_strings['actions']; ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch the fuel data from the database
                    $sql = "SELECT * FROM fuels";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr id='fuel-{$row['id']}'>
                                    <td>{$row['id']}</td>
                                    <td>{$row['fuel_type']}</td>
                                    <td>{$row['fuel_quantity']}</td>
                                    <td>{$row['fuel_price']}</td>
                                    <td>{$row['date_added']}</td>
                                    <td>
                                        <!-- Edit Button Trigger -->
                                        <button class='btn btn-warning btn-sm' onclick=\"editFuel({$row['id']}, '{$row['fuel_type']}', '{$row['fuel_quantity']}', '{$row['fuel_price']}')\">{$lang_strings['edit']}</button>

                                        <!-- Delete Button Trigger -->
                                        <button class='btn btn-danger btn-sm' onclick=\"confirmDelete({$row['id']})\">{$lang_strings['delete']}</button>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center'>{$lang_strings['no_data']}</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel"><?php echo $lang_strings['edit_fuel']; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm" method="POST">
                        <input type="hidden" id="editFuelId" name="fuel_id">
                        <div class="mb-3">
                            <label for="editFuelType" class="form-label"><?php echo $lang_strings['fuel_type']; ?></label>
                            <input type="text" class="form-control" id="editFuelType" name="fuel_type" required>
                        </div>
                        <div class="mb-3">
                            <label for="editFuelQuantity" class="form-label"><?php echo $lang_strings['quantity']; ?></label>
                            <input type="number" class="form-control" id="editFuelQuantity" name="fuel_quantity" required>
                        </div>
                        <div class="mb-3">
                            <label for="editFuelPrice" class="form-label"><?php echo $lang_strings['price']; ?></label>
                            <input type="number" class="form-control" id="editFuelPrice" name="fuel_price" required>
                        </div>
                        <button type="submit" class="btn btn-primary"><?php echo $lang_strings['save_changes']; ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel"><?php echo $lang_strings['confirm_delete']; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><?php echo $lang_strings['confirm_delete']; ?></p>
                </div>
                <div class="modal-footer">
                    <form id="deleteForm" method="POST">
                        <input type="hidden" id="deleteFuelId" name="fuel_id">
                        <button type="submit" class="btn btn-danger"><?php echo $lang_strings['delete']; ?></button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo $lang_strings['cancel']; ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/bootstrap.bundle.min.js"></script>

    <script>
        // Trigger the Edit Modal and populate it with data
        function editFuel(id, type, quantity, price) {
            document.getElementById('editFuelId').value = id;
            document.getElementById('editFuelType').value = type;
            document.getElementById('editFuelQuantity').value = quantity;
            document.getElementById('editFuelPrice').value = price;
            var editModal = new bootstrap.Modal(document.getElementById('editModal'));
            editModal.show();
        }

        // Trigger the Delete Modal and set the ID for deletion
        function confirmDelete(id) {
            document.getElementById('deleteFuelId').value = id;
            var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }
    </script>
</body>

</html>