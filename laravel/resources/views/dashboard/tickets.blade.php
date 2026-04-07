<!DOCTYPE html>
<html>
<head>
    <title>Tickets Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body { font-family: Arial; padding: 20px; }
        input, select { margin-right: 10px; padding: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; }
        th { cursor: pointer; }
    </style>
</head>
<body>

<h2>Tickets</h2>

<div>
    <input id="email" placeholder="Email">
    <input id="phone" placeholder="Phone">

    <select id="status">
        <option value="">All statuses</option>
        <option value="new">New</option>
        <option value="in_progress">In progress</option>
        <option value="completed">Completed</option>
    </select>

    <button onclick="loadTickets()">Filter</button>
</div>

<table>
    <thead>
    <tr>
        <th onclick="sort('id')">ID</th>
        <th onclick="sort('theme')">Theme</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Status</th>
        <th onclick="sort('created_at')">Created</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody id="ticketsBody"></tbody>
</table>

<script>
    let currentSort = 'created_at';
    let currentDirection = 'desc';

    async function loadTickets() {
        const params = new URLSearchParams({
            email: document.getElementById('email').value,
            phone: document.getElementById('phone').value,
            status: document.getElementById('status').value,
            sort: currentSort,
            direction: currentDirection,
        });

        const res = await fetch(`/api/dashboard/tickets?${params}`, {
            headers: {
                'Accept': 'application/json'
            }
        });

        const data = await res.json();

        const tbody = document.getElementById('ticketsBody');
        tbody.innerHTML = '';

        data.data.forEach(ticket => {
            const customer = ticket.customer || {};

            tbody.innerHTML += `
            <tr>
                <td>${ticket.id}</td>
                <td>${ticket.theme}</td>
                <td>${customer.email ?? ''}</td>
                <td>${customer.phone ?? ''}</td>
                <td>${ticket.status?.name ?? ''}</td>
                <td>${ticket.created_at}</td>
                <td>
                    <a href="/dashboard/tickets/${ticket.id}">View</a>
                </td>
            </tr>
        `;
        });
    }

    function sort(field) {
        if (currentSort === field) {
            currentDirection = currentDirection === 'asc' ? 'desc' : 'asc';
        } else {
            currentSort = field;
            currentDirection = 'asc';
        }

        loadTickets();
    }

    loadTickets();
</script>

</body>
</html>
