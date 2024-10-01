<?php
require_once "config.php"; // Include the database configuration file

header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Highgreen Homes Chat Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #4CAF50;
            color: white;
            text-align: center;
            padding: 1em 0;
        }

        main {
            padding: 20px;
        }

        .search-container {
            margin-bottom: 20px;
            text-align: center;
        }

        #searchInput {
            width: 50%;
            padding: 10px;
            font-size: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <header>
        <h1>Highgreen Homes Chat Data</h1>
    </header>
    <main>
        <div class="search-container">
            <input type="text" id="searchInput" placeholder="Search by user ID or mobile number...">
        </div>
        <table id="chatTable">
            <thead>
                <tr>
                    <th>Chat ID</th>
                    <th>User ID</th>
                    <th>Mobile Number</th>
                    <th>Message</th>
                    <th>Timestamp</th>
                    <th>Name</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <!-- Chat data will be inserted here by JavaScript -->
            </tbody>
        </table>
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const chatTableBody = document.querySelector('#chatTable tbody');

            // Fetch chat data from the server
            fetch('api/get_chat_data.php')
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        populateTable(data.chatData);
                    } else {
                        alert('Failed to fetch chat data');
                    }
                });

            // Populate the table with chat data
            function populateTable(chatData) {
                chatTableBody.innerHTML = '';
                chatData.forEach(chat => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${chat.chat_id}</td>
                        <td>${chat.user_id}</td>
                        <td>${chat.mobile_number}</td>
                        <td>${chat.message}</td>
                        <td>${chat.timestamp}</td>
                        <td>${chat.name}</td>
                        <td>${chat.email}</td>
                    `;
                    chatTableBody.appendChild(row);
                });
            }

            // Filter chat data based on search input
            searchInput.addEventListener('input', function() {
                const filter = searchInput.value.toLowerCase();
                const rows = chatTableBody.getElementsByTagName('tr');
                Array.from(rows).forEach(row => {
                    const userId = row.cells[1].textContent.toLowerCase();
                    const mobileNumber = row.cells[2].textContent.toLowerCase();
                    if (userId.includes(filter) || mobileNumber.includes(filter)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    </script>
</body>
</html>