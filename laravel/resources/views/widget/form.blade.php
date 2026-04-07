<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { font-family: Arial; padding: 10px; }
        input, textarea { width: 100%; margin-bottom: 10px; }
        button { width: 100%; padding: 10px; }
    </style>
</head>
<body>
<div id="message"></div>
<form id="ticketForm">
    <input name="name" placeholder="Name" required>
    <input name="phone" placeholder="+380..." required>
    <input name="email" placeholder="Email">

    <input name="theme" placeholder="Theme" required>
    <textarea name="text" placeholder="Message" required></textarea>

    <input type="file" name="files[]" multiple id="files">
    <div id="preview"></div>

    <button type="submit">Send</button>
</form>

<script>
    const form = document.getElementById('ticketForm');
    const submitBtn = form.querySelector('button');

    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        submitBtn.disabled = true;

        const formData = new FormData(this);

        try {
            const res = await fetch('/api/tickets', {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json'
                }
            });

            const data = await res.json();

            if (data.success) {
                showMessage(data.message, 'success');
                this.reset();
            } else {
                showMessage(data.message);
            }
        } catch (err) {
            console.error('Server error');
        } finally {
            submitBtn.disabled = false;
        }
    });

    document.getElementById('files').addEventListener('change', function(e) {
        const preview = document.getElementById('preview');
        preview.innerHTML = '';

        [...this.files].forEach(file => {
            preview.innerHTML += `<p>${file.name}</p>`;
        });
    });

    function showMessage(message, type = 'error') {
        const el = document.getElementById('message');

        el.innerHTML = `
        <div id="${type}">
            ${message}
        </div>`;
    }
</script>

<style>
    #error {
        margin-bottom: 10px;
        color: red;
        font-size: 14px;
    }
    #success {
        margin-bottom: 10px;
        color: green;
        font-size: 14px;
    }
</style>
</body>
</html>
