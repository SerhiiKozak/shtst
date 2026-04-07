<!DOCTYPE html>
<html>
<head>
    <title>Ticket</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body { font-family: Arial; padding: 20px; }
        select, button { padding: 5px; margin-top: 10px; }
    </style>
</head>
<body>

<h2>Ticket #{{ $id }}</h2>

<div id="ticket"></div>

<h3>Change Status</h3>

<select id="status">
    <option value="new">New</option>
    <option value="in_progress">In progress</option>
    <option value="completed">Completed</option>
</select>

<button onclick="updateStatus()">Update</button>

<script>
    const ticketId = {{ $id }};

    async function loadTicket() {
        const res = await fetch(`/api/dashboard/tickets/${ticketId}`);
        const data = await res.json();

        const t = data.data;

        document.getElementById('ticket').innerHTML = `
        <p><b>Theme:</b> ${t.theme}</p>
        <p><b>Text:</b> ${t.text}</p>
        <p><b>Status:</b> ${t.status?.name}</p>

        <h4>Customer:</h4>
        <p>${t.customer?.name ?? ''} (${t.customer?.email ?? ''}, ${t.customer?.phone ?? ''})</p>

        <h4>Files:</h4>
        ${t.attachments.map(f => `
            <p><a href="${f.url}" target="_blank">${f.name}</a></p>
        `).join('')}
    `;
    }

    async function updateStatus() {
        const status = document.getElementById('status').value;

        await fetch(`/api/dashboard/tickets/${ticketId}/status`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ status })
        });

        loadTicket();
    }

    loadTicket();
</script>

</body>
</html>
