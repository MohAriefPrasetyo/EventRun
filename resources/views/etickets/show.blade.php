<!DOCTYPE html>
<html>
<head>
    <title>E-Ticket EventRun</title>
    <style>
        body { font-family: sans-serif; }
        .ticket { border: 2px solid #333; padding: 20px; margin: 20px; text-align: center; }
        .header { background: #2c3e50; color: white; padding: 10px; }
        .details { margin: 20px 0; text-align: left; }
    </style>
</head>
<body>
    <div class="ticket">
        <div class="header">
            <h1>E-TICKET EVENTRUN</h1>
        </div>
        <div class="details">
            <p><strong>No. Registrasi:</strong> {{ $registration->getRegistrationNumber() }}</p>
            <p><strong>Nama Peserta:</strong> {{ $user->name }}</p>
            <p><strong>Event:</strong> {{ $event->name }}</p>
            <p><strong>Kategori:</strong> {{ $category->category_name }}</p>
            <p><strong>Tanggal Event:</strong> {{ $event->date }}</p>
            <p><strong>Lokasi:</strong> {{ $event->location }}</p>
        </div>
        <div class="footer">
            <p>QR Code: {{ $registration->id }}</p>
            <p>Terima kasih telah mendaftar. Tunjukkan tiket ini di lokasi acara.</p>
        </div>
    </div>
</body>
</html>