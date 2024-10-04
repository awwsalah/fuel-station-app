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
    <style>
        body {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        .sidebar {
            max-width: 150px;
            background-color: #343a40;
            padding-top: 20px;
        }

        .sidebar a {
            padding: 10px 15px;
            text-decoration: none;
            font-size: 18px;
            color: white;
            display: block;
        }

        .sidebar a:hover {
            background-color: #575d63;
            color: white;
        }

        .content {
            flex-grow: 1;
            padding: 20px;
            overflow-y: auto;
        }

        .action-btn {
            width: 100px;
            margin: 2px;
        }

        .btn-edit {
            background-color: #ffc107;
            border-color: #ffc107;
        }

        .btn-delete {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-invoice {
            background-color: #17a2b8;
            border-color: #17a2b8;
        }

        @media (max-width: 668px) {
            body {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                display: flex;
                flex-direction: row;
                justify-content: space-around;
                align-items: center;
                max-width: 100%;
            }

            .sidebar a {
                float: none;
                text-align: center;
                padding: 10px;
                flex-grow: 1;
            }

            .content {
                margin-top: 0;
                flex-grow: 1;
            }
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-white text-center"><?php echo $lang_strings['fuel_station']; ?></h4>
        <!-- Home link -->
        <a href="index.php?lang=<?php echo $lang; ?>"><?php echo $lang_strings['home']; ?></a>
        <!-- Other links -->
        <a href="view_fuel.php?lang=<?= $lang ?>"><?php echo $lang_strings['view_fuel']; ?></a>
        <a href="add_fuel.php?lang=<?= $lang ?>"><?php echo $lang_strings['add_fuel']; ?></a>
        <!-- Add more links to other routes if needed -->
    </div>

    <!-- Main content area -->
    <div class="content bg-light">
        <div class="container mt-5">
            <h1 class="text-center"><?php echo $lang_strings['view_fuel']; ?></h1>
            <div class="col-md-10 offset-md-1">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th><?php echo $lang_strings['fuel_type']; ?></th>
                            <th><?php echo $lang_strings['quantity']; ?></th>
                            <th><?php echo $lang_strings['price']; ?> (USD)</th>
                            <th><?php echo $lang_strings['total']; ?> (USD)</th>
                            <th><?php echo $lang_strings['date_added']; ?></th>
                            <th><?php echo $lang_strings['actions']; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Initialize grand total
                        $grand_total = 0;

                        // Fetch the fuel data from the database
                        $sql = "SELECT * FROM fuels";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                // Calculate total for each row (quantity * price)
                                $total_for_row = $row['fuel_quantity'] * $row['fuel_price'];
                                // Add to grand total
                                $grand_total += $total_for_row;

                                echo "<tr id='fuel-{$row['id']}'>
                                        <td>{$row['id']}</td>
                                        <td>{$row['fuel_type']}</td>
                                        <td>{$row['fuel_quantity']}</td>
                                        <td>{$row['fuel_price']}</td>
                                        <td>{$total_for_row}</td>
                                        <td>{$row['date_added']}</td>
                                        <td>
                                            <!-- Edit Button -->
                                            <button class='btn btn-edit btn-sm action-btn' onclick=\"editFuel({$row['id']}, '{$row['fuel_type']}', '{$row['fuel_quantity']}', '{$row['fuel_price']}')\">{$lang_strings['edit']}</button>

                                            <!-- Delete Button -->
                                            <button class='btn btn-delete btn-sm action-btn' onclick=\"confirmDelete({$row['id']})\">{$lang_strings['delete']}</button>

                                            <!-- Print Invoice Button -->
                                            <a href='invoice.php?id={$row['id']}&lang={$lang}' class='btn btn-invoice btn-sm action-btn'>{$lang_strings['invoice']}</a>
                                        </td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7' class='text-center'>{$lang_strings['no_data']}</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>

                <!-- Display the grand total -->
                <div class="row">
                    <div class="col-md-6 offset-md-6 text-end">
                        <p><strong><?php echo $lang_strings['grand_total']; ?> (USD):</strong> $<?php echo $grand_total; ?></p>
                    </div>
                </div>
            </div>
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
                    <form id="editFuelForm">
                        <input type="hidden" id="editFuelId">
                        <div class="mb-3">
                            <label for="editFuelType" class="form-label"><?php echo $lang_strings['fuel_type']; ?></label>
                            <input type="text" class="form-control" id="editFuelType">
                        </div>
                        <div class="mb-3">
                            <label for="editFuelQuantity" class="form-label"><?php echo $lang_strings['quantity']; ?></label>
                            <input type="text" class="form-control" id="editFuelQuantity">
                        </div>
                        <div class="mb-3">
                            <label for="editFuelPrice" class="form-label"><?php echo $lang_strings['price']; ?> (USD)</label>
                            <input type="text" class="form-control" id="editFuelPrice">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo $lang_strings['close']; ?></button>
                    <button type="button" class="btn btn-primary" onclick="saveFuelEdit()"><?php echo $lang_strings['save_changes']; ?></button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel"><?php echo $lang_strings['delete_fuel']; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php echo $lang_strings['confirm_delete']; ?>
                    <input type="hidden" id="deleteFuelId">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo $lang_strings['close']; ?></button>
                    <button type="button" class="btn btn-danger" onclick="deleteFuel()"><?php echo $lang_strings['delete']; ?></button>
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

        // Save the edited fuel (Add server request logic here)
        function saveFuelEdit() {
            // Example: Send data to the server via AJAX
            console.log("Saving edited fuel...");
            // Add your AJAX request here to send the form data to the server
        }

        // Trigger the Delete Modal and set the ID for deletion
        function confirmDelete(id) {
            document.getElementById('deleteFuelId').value = id;
            var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }

        // Delete the fuel (Add server request logic here)
        function deleteFuel() {
            // Example: Send request to the server to delete the fuel
            console.log("Deleting fuel...");
            // Add your AJAX request here to delete the fuel
        }
    </script>
</body>

</html>