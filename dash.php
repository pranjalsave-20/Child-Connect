<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    header("Location: admin-login.html");
    exit();
}

include 'db.php';

function getCount($table) {
    global $conn;
    $res = mysqli_query($conn, "SELECT COUNT(*) AS total FROM $table");
    $row = mysqli_fetch_assoc($res);
    return $row['total'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Child Connect</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('img/im2.jpg');
            background-size: cover;
            background-position: center;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .dashboard {
            max-width: 1100px;
            margin: 40px auto;
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
        }

        h1 {
            text-align: center;
            color: #ff6b6b;
            margin-bottom: 30px;
        }

        .logout-btn {
            text-align: right;
            margin-bottom: 20px;
        }

        .logout-btn button {
            background-color: #ff6b6b;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
        }

        .stats {
            display: flex;
            justify-content: space-around;
            margin-bottom: 40px;
            gap: 20px;
        }

        .card {
            flex: 1;
            background: #fff0f0;
            border: 2px solid #ff6b6b;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .card:hover {
            background: #ffe0e0;
        }

        .card h2 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .card p {
            font-size: 16px;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #ff6b6b;
            color: white;
        }

        .btn-delete {
            background: #ff4b4b;
            color: white;
            padding: 8px 14px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .btn-delete:hover {
            background: #e33c3c;
        }

        .section {
            display: none;
        }

        .section.active {
            display: block;
        }

        h2 {
            margin-top: 20px;
            color: #ff6b6b;
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <div class="logout-btn">
            <form action="logout_admin.php" method="POST">
                <button type="submit">Logout</button>
            </form>
        </div>

        <h1>Admin Dashboard</h1>

        <div class="stats">
            <div class="card" onclick="showSection('inquiries')">
                <h2><?php echo getCount('adoption_inquiries'); ?></h2>
                <p>Total Inquiries</p>
            </div>
            <div class="card" onclick="showSection('applications')">
                <h2><?php echo getCount('adoption_applications'); ?></h2>
                <p>Total Applications</p>
            </div>
            <div class="card" onclick="showSection('appointments')">
                <h2><?php echo getCount('appointments'); ?></h2>
                <p>Total Appointments</p>
            </div>
        </div>

        <!-- Inquiries Section -->
        <div id="inquiries" class="section">
            <h2>Adoption Inquiries</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Guardian Name</th>
                    <th>Email</th>
                    <th>Preferred Child</th>
                    <th>Reason</th>
                    <th>Message</th>
                    <th>Date</th>
                </tr>
                <?php
                $res = mysqli_query($conn, "SELECT * FROM adoption_inquiries");
                while ($row = mysqli_fetch_assoc($res)) {
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['guardian_name']}</td>
                        <td>{$row['guardian_email']}</td>
                        <td>{$row['preferred_child_name']} ({$row['preferred_child_age']})</td>
                        <td>{$row['reason']}</td>
                        <td>{$row['additional_message']}</td>
                        <td>{$row['created_at']}</td>
                    </tr>";
                }
                ?>
            </table>
        </div>

        <!-- Applications Section -->
        <div id="applications" class="section">
            <h2>Adoption Applications</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>DOB</th>
                    <th>Status</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Employer</th>
                    <th>Income</th>
                </tr>
                <?php
                $res = mysqli_query($conn, "SELECT * FROM adoption_applications");
                while ($row = mysqli_fetch_assoc($res)) {
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['first_name']} {$row['last_name']}</td>
                        <td>{$row['dob']}</td>
                        <td>{$row['marital_status']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['phone']}</td>
                        <td>{$row['employer']}</td>
                        <td>{$row['annual_income']}</td>
                    </tr>";
                }
                ?>
            </table>
        </div>

        <!-- Appointments Section (Children) -->
        <div id="appointments" class="section active">
            <h2>Children (Appointments)</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Child Name</th>
                    <th>Age</th>
                    <th>Guardian</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>
                <?php
                $res = mysqli_query($conn, "SELECT * FROM appointments");
                while ($row = mysqli_fetch_assoc($res)) {
                ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['child_name']; ?></td>
                        <td><?php echo $row['child_age']; ?></td>
                        <td><?php echo $row['guardian_name']; ?></td>
                        <td><?php echo $row['phone']; ?></td>
                        <td><?php echo $row['address']; ?></td>
                        <td>
                            <form action='delete_child.php' method='POST' onsubmit='return confirm("Are you sure you want to delete this child?");'>
                                <input type='hidden' name='id' value='<?php echo $row['id']; ?>'>
                                <button type='submit' class='btn-delete'>Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>

    <script>
        function showSection(id) {
            const sections = document.querySelectorAll('.section');
            sections.forEach(section => section.classList.remove('active'));
            document.getElementById(id).classList.add('active');
        }
    </script>
</body>
</html>
