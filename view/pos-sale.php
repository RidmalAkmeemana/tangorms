<?php
include '../commons/session.php';
include_once '../commons/helpers/permission_helper.php';
include_once '../model/pos_model.php';
include_once '../model/customer_model.php';
include_once '../model/menu_model.php';


checkFunctionPermission($_SERVER['PHP_SELF']);

$userrow = $_SESSION["user"];
$user_id = $userrow["user_id"];

// Get user invoice no
$posObj = new POS();
$posResult = $posObj->getInvoiceNo();
$tableResult = $posObj->getTables();

// Get user customers for dropdown
$customerObj = new Customer();
$customerResult = $customerObj->getAllCustomers();

$menuObj = new Menu();
$categoryResult = $menuObj->getAllCategory();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>POS Sale</title>
    <?php include_once "../includes/bootstrap_css_includes.php"; ?>
    <link rel="stylesheet" type="text/css" href="../css/dataTables.bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            background-color: #5c5b5b;
            color: white;
            font-family: 'Segoe UI', sans-serif;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .list-group-item {
            background-color: #ffffff;
            border: 1px solid #FF6600;
            color: #333;
            font-weight: 500;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .list-group-item:hover {
            background-color: #FF6600;
            color: white;
        }

        .panel,
        .panel-body {
            background-color: #faf7f7;
            border: 1px solid #FF6600;
            box-shadow: 0 0 10px rgba(255, 102, 0, 0.3);
        }

        .panel-info>.panel-heading {
            background-color: #FF6600;
            color: white;
            font-weight: bold;
            text-align: center;
        }

        .container {
            padding-top: 30px;
        }

        label.control-label {
            color: white;
            font-weight: 500;
        }

        input.form-control,
        select.form-control {
            background-color: #f5f5f5;
            border: 1px solid #ccc;
            color: #333;
        }

        input.form-control:focus,
        select.form-control:focus {
            border-color: #FF6600;
            box-shadow: 0 0 5px rgba(255, 102, 0, 0.6);
        }

        .btn-danger {
            background-color: #aa3333;
            border-color: #aa3333;
        }

        .btn-danger:hover {
            background-color: #992222;
            border-color: #992222;
        }

        #img_prev {
            border: 1px solid #ccc;
            padding: 2px;
            margin-top: 5px;
            border-radius: 4px;
        }

        .mt-3 {
            margin-top: 1rem;
        }

        .table-striped {
            background-color: white;
            color: #333;
            border: 1px solid #ddd;
        }

        .table-striped thead th {
            background-color: #FF6600;
            color: white;
            font-weight: bold;
        }

        .table-striped tbody td {
            vertical-align: middle;
        }

        .table-striped tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .table-striped tbody tr:hover {
            background-color: #ffe6cc;
        }
    </style>
</head>

<body>
    <div class="container">
        <?php $pageName = "POS MANAGEMENT";
        include_once "../includes/header_row_includes.php"; ?>

        <div class="row">
            <?php require 'pos-management-sidebar.php'; ?>

            <form class="col-md-9" action="../controller/pos_controller.php?status=submit_order" method="post">
                <?php if (isset($_GET['msg'])): ?>
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2 alert alert-success text-center">
                            <?= base64_decode($_GET['msg']); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Receipt No and Customer -->
                <div class="row mt-3">
                    <div class="col-md-2"><label class="control-label">Receipt No:</label><label class="text-danger">*</label></div>
                    <div class="col-md-4"><input type="text" class="form-control" name="receipt_no" value="<?= $posResult; ?>" readonly></div>

                    <div class="col-md-2"><label class="control-label">Customer Name:</label><label class="text-danger">*</label></div>
                    <div class="col-md-4">
                        <select name="customer_id" id="customer_id" class="form-control" required>
                            <option value="">-- Select Customer --</option>
                            <?php while ($customerRow = $customerResult->fetch_assoc()): ?>
                                <option value="<?= $customerRow['customer_id']; ?>"><?= $customerRow['customer_name']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>

                <!-- Category, Item, Qty -->
                <div class="row mt-3 d-flex align-items-end">
                    <div class="col-md-3">
                        <label class="control-label">Category</label><label class="text-danger">*</label>
                        <select name="category_id" id="category_id" class="form-control">
                            <option value="">-- Select Category --</option>
                            <?php while ($categoryRow = $categoryResult->fetch_assoc()): ?>
                                <option value="<?= $categoryRow['category_id']; ?>"><?= $categoryRow['category_name']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="control-label">Item Name</label><label class="text-danger">*</label>
                        <select id="item_id" class="form-control">
                            <option value="">-- Select Item --</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="control-label">Qty</label><label class="text-danger">*</label>
                        <input type="number" id="item_qty" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <label class="control-label">Add to Cart</label>
                        <button style="width: 160%;" type="button" id="add_to_cart" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span></button>
                    </div>
                </div>

                <br>

                <!-- Item Cart Table -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle text-center table-striped" id="cart_table">
                                <thead>
                                    <tr>
                                        <th class="text-start">Item Code</th>
                                        <th class="text-start">Item Image</th>
                                        <th class="text-start">Item Name</th>
                                        <th class="text-center">Unit Price</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-center">Total Price</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="no-items-row">
                                        <td colspan="7" class="text-center">No items in the cart.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <!-- Discount and Payment -->
                <div class="row mt-3">
                    <div class="col-md-3">
                        <label>Sub Total</label><label class="text-danger">*</label>
                        <input readonly type="number" step="any" name="sub_total_amount" id="sub_total_amount" class="form-control" value="0">
                    </div>

                    <div class="col-md-3">
                        <label>Discount (%)</label><label class="text-danger">*</label>
                        <input type="number" name="discount" id="discount" class="form-control" min="0" max="90" value="0">
                    </div>

                    <div class="col-md-3">
                        <label>Grand Total</label><label class="text-danger">*</label>
                        <input readonly type="number" step="any" name="total_amount" id="total_amount" class="form-control" value="0">
                    </div>

                    <div class="col-md-3">
                        <label>Payment Method</label><label class="text-danger">*</label>
                        <select name="payment_method" class="form-control" required>
                            <option value="">-- Select Payment Method --</option>
                            <option value="Cash">Cash</option>
                            <option value="Card">Card</option>
                            <option value="Bank Transfer">Bank Transfer</option>
                            <option value="N/A">N/A</option>
                        </select>
                    </div>
                </div>

                <div class="row mt-3">

                    <div class="col-md-3">
                        <label>Order Priority</label><label class="text-danger">*</label>
                        <select name="order_priority" id="order_priority" class="form-control" required>
                            <option value="">-- Select Order Priority --</option>
                            <option value="Low">Low</option>
                            <option value="Moderate">Moderate</option>
                            <option value="High">High</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label>Paid Amount</label><label class="text-danger">*</label>
                        <input type="number" step="any" name="paid_amount" id="paid_amount" class="form-control" value="0" required>
                    </div>

                    <div class="col-md-3">
                        <label>Due Amount</label><label class="text-danger">*</label>
                        <input readonly type="number" step="any" name="due_amount" id="due_amount" class="form-control" value="0">
                    </div>

                    <div class="col-md-3">
                        <label>Balance</label><label class="text-danger">*</label>
                        <input readonly type="number" step="any" name="balance" id="balance" class="form-control" value="0">
                    </div>
                </div>

                <div class="row mt-3">

                    <div class="col-md-3">
                        <label>Order Type</label><label class="text-danger">*</label>
                        <select name="order_type" id="order_type" class="form-control" required>
                            <option value="">-- Select Order Type --</option>
                            <option value="Dine-In">Dine-In</option>
                            <option value="Take-Away">Take-Away</option>
                            <option value="Delivery">Delivery</option>
                        </select>
                    </div>

                    <div class="col-md-3" id="table_select_wrapper" style="display: none;">
                        <label>Select Table</label><label class="text-danger">*</label>
                        <select name="table_id" id="table_id" class="form-control" disabled>
                            <option value="">-- Select Table --</option>
                        </select>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12 align-self-end">
                        <br>
                        <button style="margin-top: 3px; width: 100%;" type="submit" class="btn btn-primary">Submit & Print</button>
                    </div>
                </div>
                <br>
            </form>
        </div>

        <script src="../js/jquery-3.7.1.js"></script>
        <script src="../js/uservalidation.js"></script>
        <script>
            function displayImage(input) {
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = e => {
                        if (!document.getElementById('img_prev')) {
                            const img = document.createElement('img');
                            img.id = 'img_prev';
                            input.parentNode.appendChild(img);
                        }
                        document.getElementById('img_prev').src = e.target.result;
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>

        <script>
            let availableQty = 0;
            let cartIndex = 0; // Unique ID for each row if needed

            $(document).ready(function() {

                $('#order_type').on('change', function() {
    const orderType = $(this).val();

    if (orderType === 'Dine-In') {
        $('#table_select_wrapper').show();
        $('#table_id').prop('disabled', false).attr('required', true);

        const customerId = $('#customer_id').val();
        if (!customerId) {
            alert("Please select a customer first.");
            $('#order_type').val('');
            $('#table_select_wrapper').hide();
            $('#table_id').val('').prop('disabled', true).removeAttr('required');
            return;
        }

        $.ajax({
            url: '../ajax/get_table_by_order_type.php',
            method: 'GET',
            data: { customer_id: customerId },
            dataType: 'json',
            success: function(response) {
                $('#table_id').html('<option value="">-- Select Table --</option>');
                if (response.length > 0) {
                    response.forEach(function(table) {
                        $('#table_id').append('<option value="' + table.table_id + '">' + table.table_name + '</option>');
                    });
                } else {
                    $('#table_id').html('<option value="">No tables available</option>');
                }
            },
            error: function(xhr) {
                alert("Failed to check reservations.");
                console.log(xhr.responseText);
            }
        });

    } else {
        $('#table_id').prop('disabled', true).removeAttr('required');
        $('#table_select_wrapper').hide();
        $('#table_id').val('');
    }
});


                function toggleNoItemsRow() {
                    const hasItems = $('#cart_table tbody tr').not('.no-items-row').length > 0;
                    if (hasItems) {
                        $('#cart_table .no-items-row').remove();
                    } else {
                        $('#cart_table tbody').html(`
                    <tr class="no-items-row">
                        <td colspan="7" class="text-center">No items in the cart.</td>
                    </tr>
                `);
                    }
                }

                toggleNoItemsRow(); // Initial call

                // Fetch items when category changes
                $('#category_id').on('change', function() {
                    $('#item_id').html('<option value="">-- Select Item --</option>');
                    let categoryId = $(this).val();

                    if (categoryId !== "") {
                        $.ajax({
                            url: '../ajax/get_items_by_category.php',
                            method: 'GET',
                            data: {
                                category_id: categoryId
                            },
                            dataType: 'json',
                            success: function(response) {
                                if (response.length > 0) {
                                    response.forEach(function(item) {
                                        $('#item_id').append('<option value="' + item.item_id + '">' + item.item_name + '</option>');
                                    });
                                } else {
                                    $('#item_id').html('<option value="">No items found</option>');
                                }
                            }
                        });
                    }
                });

                // Fetch item details on item select
                $('#item_id').on('change', function() {
                    let itemId = $(this).val();

                    if (itemId !== "") {
                        $.ajax({
                            url: '../ajax/get_item_details.php',
                            method: 'GET',
                            data: {
                                item_id: itemId
                            },
                            dataType: 'json',
                            success: function(data) {
                                if (data.length > 0) {
                                    availableQty = parseInt(data[0].item_qty);
                                    $('#item_qty').val(availableQty);
                                    $('#item_qty').data('item-details', data[0]); // store full object
                                } else {
                                    availableQty = 0;
                                    $('#item_qty').val('');
                                }
                            }
                        });
                    } else {
                        availableQty = 0;
                        $('#item_qty').val('');
                    }
                });

                // Validate Qty
                $('#item_qty').on('input', function() {
                    const enteredQty = parseInt($(this).val());
                    if (enteredQty > availableQty) {
                        alert("Not enough stock. Available Qty: " + availableQty);
                        $(this).val('');
                    }
                });

                // Add to cart
                $('#add_to_cart').on('click', function() {
                    const customer = $('#customer_id').val();
                    const category = $('#category_id').val();
                    const itemId = $('#item_id').val();
                    const qty = parseInt($('#item_qty').val());

                    if (!customer) {
                        alert("Please select the customer.");
                        return;
                    }
                    if (!category) {
                        alert("Please select the category.");
                        return;
                    }
                    if (!itemId) {
                        alert("Please select the item.");
                        return;
                    }
                    if (!qty || qty <= 0) {
                        alert("Please enter a valid quantity.");
                        return;
                    }
                    if (qty > availableQty) {
                        alert("Not enough stock. Available Qty: " + availableQty);
                        return;
                    }

                    const itemData = $('#item_qty').data('item-details');
                    const itemCode = itemData.item_code;

                    // Check for duplicate item by item_code
                    let isDuplicate = false;
                    $('#cart_table tbody tr').each(function() {
                        const code = $(this).find('td:first').text().trim();
                        if (code === itemCode) {
                            isDuplicate = true;
                            return false; // break loop
                        }
                    });

                    if (isDuplicate) {
                        alert("Duplicate item! This item is already in the cart.");
                        return;
                    }

                    const totalPrice = (parseFloat(itemData.item_price) * qty).toFixed(2);
                    const imagePath = '../images/item_images/' + itemData.item_image;

                    const newRow = `
                        <tr data-index="${cartIndex}">
                            <td class="text-start">${itemCode}<input type="hidden" name="item_code[]" value="${itemCode}"></td>
                            <td><img src="${imagePath}" class="rounded-circle" width="50" height="50" alt="Item"></td>
                            <td class="text-start">${itemData.item_name}<input type="hidden" name="item_name[]" value="${itemData.item_name}"></td>
                            <td>${parseFloat(itemData.item_price).toFixed(2)}<input type="hidden" name="item_price[]" value="${itemData.item_price}"></td>
                            <td>${qty}<input type="hidden" name="item_qty[]" value="${qty}"></td>
                            <td>${totalPrice}<input type="hidden" name="total_price[]" value="${totalPrice}"></td>
                            <td>
                                <button class="btn btn-sm btn-danger remove-cart-item">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                    $('#cart_table tbody').append(newRow);
                    cartIndex++;

                    toggleNoItemsRow(); // hide "no item" message
                    calculateTotals();
                });


                // Remove item from cart
                $(document).on('click', '.remove-cart-item', function() {
                    $(this).closest('tr').remove();
                    toggleNoItemsRow();
                    calculateTotals();
                });


            });
        </script>

        <script>
            function calculateTotals() {
                let subtotal = 0;
                $('#cart_table tbody tr').not('.no-items-row').each(function() {
                    let rowTotal = parseFloat($(this).find('td:nth-child(6)').text());
                    if (!isNaN(rowTotal)) subtotal += rowTotal;
                });
                $('#sub_total_amount').val(subtotal.toFixed(2));

                let discount = parseFloat($('#discount').val()) || 0;
                let total = subtotal - (subtotal * (discount / 100));
                $('#total_amount').val(total.toFixed(2));

                let paid = parseFloat($('#paid_amount').val()) || 0;
                let balance = 0,
                    due = 0;

                if (paid >= total) {
                    balance = paid - total;
                    due = 0;
                } else {
                    balance = 0;
                    due = total - paid;
                }

                $('#balance').val(balance.toFixed(2));
                $('#due_amount').val(due.toFixed(2));
            }

            $(document).ready(function() {
                $('#discount').on('input', function() {
                    $('#paid_amount').val('0');
                    calculateTotals();
                });

                $('#paid_amount').on('input', function() {
                    calculateTotals();
                });
            });
        </script>



</body>

</html>