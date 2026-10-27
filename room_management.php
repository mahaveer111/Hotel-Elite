<?php
session_start();
include('db.php');

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['add_room'])) {
    $rno = mysqli_real_escape_string($conn, $_POST['room_no']);
    $floor = mysqli_real_escape_string($conn, $_POST['floor']);
    $rtype = mysqli_real_escape_string($conn, $_POST['room_type']);
    $rstatus = mysqli_real_escape_string($conn, $_POST['room_status']);
    $price = (float)$_POST['price'];

    $conn->query("INSERT INTO rooms (room_no, floor, room_type, room_status, price) VALUES ('$rno', '$floor', '$rtype', '$rstatus', $price)");
    header("Location: room_management.php");
    exit();
}

if (isset($_POST['update_room'])) {
    $id = (int)$_POST['room_id'];
    $rno = mysqli_real_escape_string($conn, $_POST['room_no']);
    $floor = mysqli_real_escape_string($conn, $_POST['floor']);
    $rtype = mysqli_real_escape_string($conn, $_POST['room_type']);
    $rstatus = mysqli_real_escape_string($conn, $_POST['room_status']);
    $price = (float)$_POST['price'];

    $conn->query("UPDATE rooms SET room_no='$rno', floor='$floor', room_type='$rtype', room_status='$rstatus', price=$price WHERE id=$id");
    header("Location: room_management.php");
    exit();
}

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM rooms WHERE id = $id");
    header("Location: room_management.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Room Management - Hotel Elite Admin</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body { 
            background: #f4f7f6; 
            color: #333;
            padding: 30px; 
        }

        .container { 
            max-width: 1100px; 
            margin: 0 auto; 
            background: #fff; 
            padding: 30px; 
            border-radius: 8px; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.05); 
        }

        .header-flex { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 25px; 
        }

        h2 { 
            color: #0d1b2a; 
            font-size: 1.8rem;
        }

        .back-link { 
            display: inline-block; 
            margin-bottom: 20px; 
            color: #6c757d; 
            text-decoration: none; 
            font-weight: bold; 
            font-size: 0.9rem; 
            transition: color 0.2s;
        }

        .back-link:hover {
            color: #0d1b2a;
        }

        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 15px; 
            text-align: center; 
        }

        th, td { 
            padding: 12px 10px; 
            border: 1px solid #e9ecef; 
            font-size: 0.9rem; 
        }

        th { 
            background: #007bff; 
            color: white; 
            font-weight: 600;
        }

        tr:nth-child(even) { 
            background: #fdfdfe; 
        }

        tr:hover {
            background: #f1f4f8;
        }

        .btn { 
            padding: 6px 12px; 
            border: none; 
            border-radius: 4px; 
            font-weight: bold; 
            cursor: pointer; 
            color: white; 
            text-decoration: none; 
            font-size: 0.8rem; 
            display: inline-block; 
            transition: background 0.2s;
        }

        .btn-success { background: #28a745; }
        .btn-success:hover { background: #218838; }

        .btn-warning { background: #ffc107; color: #212529; }
        .btn-warning:hover { background: #e0a800; }

        .btn-danger { background: #dc3545; }
        .btn-danger:hover { background: #c82333; }

        #addRoomForm { 
            display: none; 
            background: #f8f9fa; 
            padding: 25px; 
            border: 1px solid #e9ecef; 
            border-radius: 8px; 
            margin-bottom: 25px; 
            box-shadow: 0 4px 10px rgba(0,0,0,0.03);
        }

        #addRoomForm h3 {
            color: #0d1b2a;
            margin-bottom: 15px;
        }

        .form-group { 
            margin-bottom: 15px; 
            text-align: left; 
        }

        label { 
            display: block; 
            margin-bottom: 6px; 
            font-weight: 600; 
            font-size: 0.85rem; 
            color: #495057;
        }

        input, select { 
            width: 100%; 
            padding: 10px; 
            border: 1px solid #ced4da; 
            border-radius: 5px; 
            font-size: 0.95rem; 
        }

        input:focus, select:focus {
            border-color: #007bff;
            outline: none;
        }

        .modal { 
            display: none; 
            position: fixed; 
            z-index: 99; 
            left: 0; 
            top: 0; 
            width: 100%; 
            height: 100%; 
            background: rgba(0,0,0,0.5); 
            justify-content: center; 
            align-items: center; 
        }

        .modal-content { 
            background: #fff; 
            padding: 30px; 
            border-radius: 8px; 
            width: 100%;
            max-width: 420px; 
            position: relative; 
            box-shadow: 0 4px 25px rgba(0,0,0,0.2);
        }

        .modal-content h3 {
            color: #0d1b2a;
            margin-bottom: 20px;
        }

        .close-modal { 
            position: absolute; 
            right: 20px; 
            top: 15px; 
            font-size: 22px; 
            cursor: pointer; 
            font-weight: bold; 
            color: #6c757d;
        }

        .close-modal:hover {
            color: #333;
        }
    </style>
</head>
<body>

<div class="container">
    <a href="dashboard.php" class="back-link">&larr; Back to Dashboard</a>

    <div class="header-flex">
        <h2>Room Management</h2>
        <button class="btn btn-success" onclick="toggleRoomForm()" style="padding: 10px 18px; font-size: 0.9rem;">+ Add New Room</button>
    </div>

    <div id="addRoomForm">
        <h3>Add New Room</h3>
        <form method="POST" autocomplete="off" style="margin-top: 10px;">
            <div class="form-group">
                <label>Room Number</label>
                <input type="text" name="room_no" placeholder="e.g. 101" required>
            </div>
            <div class="form-group">
                <label>Floor</label>
                <input type="text" name="floor" placeholder="e.g. 1st Floor" required>
            </div>
            <div class="form-group">
                <label>Room Type</label>
                <input type="text" name="room_type" placeholder="e.g. Deluxe Room" required>
            </div>
            <div class="form-group">
                <label>Room Status</label>
                <select name="room_status">
                    <option value="Active">Active</option>
                    <option value="Clean & Ready">Clean & Ready</option>
                    <option value="Maintenance">Maintenance</option>
                </select>
            </div>
            <div class="form-group">
                <label>Price per Night (₹)</label>
                <input type="number" step="0.01" name="price" placeholder="1800.00" required>
            </div>
            <button type="submit" name="add_room" class="btn btn-success" style="width:100%; padding:12px; font-size:0.95rem;">Save Room</button>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Room No</th>
                <th>Floor</th>
                <th>Type</th>
                <th>Status</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $rooms = $conn->query("SELECT * FROM rooms ORDER BY id DESC");
            if ($rooms && $rooms->num_rows > 0) {
                while ($row = $rooms->fetch_assoc()) {
                    $status = isset($row['room_status']) ? $row['room_status'] : 'Active';
                    $floor = isset($row['floor']) ? $row['floor'] : '-';
                    $rtype = isset($row['room_type']) ? $row['room_type'] : '-';
                    $price = isset($row['price']) ? $row['price'] : '0.00';

                    echo "<tr>
                            <td><b>#{$row['id']}</b></td>
                            <td><b>{$row['room_no']}</b></td>
                            <td>{$floor}</td>
                            <td>{$rtype}</td>
                            <td>{$status}</td>
                            <td><b>₹{$price}</b></td>
                            <td>
                                <button class='btn btn-warning' onclick='openEditModal({$row['id']}, \"{$row['room_no']}\", \"{$floor}\", \"{$rtype}\", \"{$status}\", \"{$price}\")'>Edit</button>
                                <a href='room_management.php?delete={$row['id']}' class='btn btn-danger' onclick='return confirm(\"Delete this room?\")'>Delete</a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No rooms found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close-modal" onclick="closeModal()">&times;</span>
        <h3>Edit Room Details</h3>
        <form method="POST" style="margin-top: 15px;">
            <input type="hidden" name="room_id" id="edit_id">
            <div class="form-group">
                <label>Room Number</label>
                <input type="text" name="room_no" id="edit_room_no" required>
            </div>
            <div class="form-group">
                <label>Floor</label>
                <input type="text" name="floor" id="edit_floor" required>
            </div>
            <div class="form-group">
                <label>Room Type</label>
                <input type="text" name="room_type" id="edit_room_type" required>
            </div>
            <div class="form-group">
                <label>Room Status</label>
                <select name="room_status" id="edit_room_status">
                    <option value="Active">Active</option>
                    <option value="Clean & Ready">Clean & Ready</option>
                    <option value="Maintenance">Maintenance</option>
                </select>
            </div>
            <div class="form-group">
                <label>Price per Night (₹)</label>
                <input type="number" step="0.01" name="price" id="edit_price" required>
            </div>
            <button type="submit" name="update_room" class="btn btn-success" style="width:100%; padding:12px; font-size:0.95rem;">Update Room</button>
        </form>
    </div>
</div>

<script>
    function toggleRoomForm() {
        var f = document.getElementById('addRoomForm');
        f.style.display = (f.style.display === 'none' || f.style.display === '') ? 'block' : 'none';
    }

    function openEditModal(id, rno, floor, rtype, status, price) {
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_room_no').value = rno;
        document.getElementById('edit_floor').value = floor;
        document.getElementById('edit_room_type').value = rtype;
        document.getElementById('edit_room_status').value = status;
        document.getElementById('edit_price').value = price;
        document.getElementById('editModal').style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('editModal').style.display = 'none';
    }
</script>

</body>
</html>