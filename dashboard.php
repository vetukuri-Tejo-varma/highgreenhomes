<!DOCTYPE html>
<html>
<head>
    <title>Users</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ccc;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        .pagination {
            text-align: center;
            margin-top: 20px;
        }

        .pagination a {
            display: inline-block;
            margin: 0 5px;
            padding: 5px 10px;
            border: 1px solid #ccc;
            text-decoration: none;
            color: #333;
        }

        .pagination a.active {
            background-color: #f2f2f2;
        }

        .pagination a:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>User List</h1>

        <?php
        require 'api/config.php';

        // Pagination variables
        $records_per_page = 10;
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $start_from = ($page - 1) * $records_per_page;

        // Fetch data from the "highgreen_users" table
        $query = "SELECT * FROM highgreen_users LIMIT $start_from, $records_per_page";
        $result = mysqli_query($conn, $query);
    
        // Display data in a tabular format
        if (mysqli_num_rows($result) > 0) {
            echo '<table>';
            echo '<tr><th>Name</th><th>Phone</th><th>Email</th><th>Lead Generated on</th></tr>';

            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . $row['user_name'] . '</td>';
                echo '<td>' . $row['user_phone'] . '</td>';
                echo '<td>' . $row['user_email'] . '</td>';
                echo '<td>' . $row['created_on'] . '</td>';
                echo '</tr>';
            }

            echo '</table>';
        } else {
            echo 'No records found.';
        }

        // Pagination links
        $query = "SELECT COUNT(*) AS total FROM highgreen_users";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $total_records = $row['total'];
        $total_pages = ceil($total_records / $records_per_page);

        echo '<div class="pagination">';
        echo '<a href="?page=1">First</a> ';

        for ($i = max(1, $page - 2); $i <= min($page + 2, $total_pages); $i++) {
            echo '<a class="' . ($i == $page ? 'active' : '') . '" href="?page=' . $i . '">' . $i . '</a> ';
        }

        echo '<a href="?page=' . $total_pages . '">Last</a>';
        echo '</div>';

        // Close the MySQL connection
        mysqli_close($connection);
        ?>
    </div>
</body>
</html>
