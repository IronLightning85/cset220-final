<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shady Shoals</title>
</head>
<body>
    <div class="logo">
        <h1>Shady Shoals Retirement Home</h1>
    </div>

    <nav>
        <ul>

        @if($level === null)
        <!-- Display error if user is not logged in -->
        <h1>Error: Please log in</h1>

    @else
    <td><button onclick="location.href='{{ route('logout') }}'">Logout</button></td>

    <td><button onclick="location.href='{{ url('roster') }}'">Roster</button></td>
    @endif

                <!-- Conditional content based on user role level -->
                @if($level == 1)
                    <td><button onclick="location.href='{{ url('supervisor') }}'">Supervisor Hub</button></td>
                    <td><button onclick="location.href='{{ url('payment') }}'">Payment</button></td>
                @elseif($level == 2)
                    <td><button onclick="location.href='{{ url('supervisor') }}'">Supervisor Hub</button></td>
                @elseif($level == 3)
                    <td><button onclick="location.href='{{ url('doctor') }}'">Doctor Home</button></td>
                @elseif($level == 4)
                    <td><button onclick="location.href='{{ url('caregiver') }}'">Caregiver Home</button></td>
                @elseif($level == 5)
                    <td><button onclick="location.href='{{ url('family') }}'">Family Home</button></td>
                @elseif($level == 6)
                    <td><button onclick="location.href='{{ url('patient') }}'">Patient Home</button></td>
                @else
                    <td><button onclick="location.href='{{ url('home') }}'">Dashboard</button></td>
                @endif

        </ul>
    </nav>

    @if($level === null)
        <!-- Display error if user is not logged in -->
        <h3>Make an Account if you don't have one.</h3>
        <td><button onclick="location.href='{{ url('register') }}'">Register</button></td>

    @else
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
                    let select = document.getElementById("roleSelect-{{ $user->user_id }}");
                    data.forEach(role => {
                        if (role.role_id !== 1) { // Exclude Admin role
                            let option = document.createElement("option");
                            option.value = role.role_id;
                            option.textContent = role.role_name;
                            select.appendChild(option);
                        }
                    });
                @endforeach
            })
            .catch(error => console.error('Error fetching roles:', error));
    });
</script>
@endif
    @endif

</body>
</html>


    