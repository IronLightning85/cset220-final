<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approved Users</title>
</head>
<body>
    <h2>Approved Users</h2>

    <!-- Display status message -->
    @if (session('status'))
        <p>{{ session('status') }}</p>
    @elseif (session('error'))
        <p>{{ session('error') }}</p>
    @endif

    <!-- Table of approved users -->
    <table border="1">
        <tr>
            <th>User ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Current Role</th>
            <th>Actions</th>
        </tr>
        @foreach ($approvedUsers as $user)
            <tr>
                <td>{{ $user->user_id }}</td>
                <td>{{ $user->first_name }}</td>
                <td>{{ $user->last_name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role_name }}</td> <!-- Display the actual role name -->
                <td>
                    <!-- Form to update role for each user -->
                    <form action="{{ route('update-role', $user->user_id) }}" method="POST">
                        @csrf
                        <label for="role_id">New Role:</label>
                        <select id="roleSelect-{{ $user->user_id }}" name="role_id" required>
                            <option value="">Select a role</option>
                        </select>
                        <button type="submit">Update Role</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

    <!-- JavaScript to populate role dropdowns -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Fetch available roles and populate each dropdown, excluding Admin (role_id = 1)
            fetch('/available-roles')
            .then(response => response.json())
            .then(data => {
                @foreach ($approvedUsers as $user)
                    let select_{{ $user->user_id }} = document.getElementById("roleSelect-{{ $user->user_id }}");
                    data.forEach(role => {
                        if (role.role_id !== 1) { // Exclude Admin role
                            let option = document.createElement("option");
                            option.value = role.role_id;
                            option.textContent = role.role_name;
                            select_{{ $user->user_id }}.appendChild(option);
                        }
                    });
                @endforeach
            })
            .catch(error => console.error('Error fetching roles:', error));
        });
    </script>
</body>
</html>