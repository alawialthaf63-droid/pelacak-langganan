<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pelacak Langganan</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: system-ui, sans-serif; background: #0b0f14; color: #e6edf3; }
        .wrap { max-width: 860px; margin: 0 auto; padding: 32px 20px; }
        h1 { margin: 0 0 24px; font-size: 26px; }
        .card { background: #131a22; border: 1px solid #222d3a; border-radius: 10px; padding: 20px; margin-bottom: 20px; }
        .total { font-size: 32px; font-weight: 700; color: #4dd0e1; }
        .muted { color: #8b98a5; font-size: 14px; }
        .alert { border-color: #b7791f; background: #2a2110; }
        form.add { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; }
        input, select { width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #2c3a49; background: #0b0f14; color: #e6edf3; }
        button { padding: 10px 16px; border: 0; border-radius: 6px; background: #4dd0e1; color: #06222a; font-weight: 700; cursor: pointer; }
        button.del { background: transparent; color: #f87171; padding: 4px 8px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { text-align: left; padding: 10px 8px; border-bottom: 1px solid #222d3a; }
        .error { color: #f87171; font-size: 13px; }
        @media (max-width: 600px) { form.add { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
<div class="wrap">
    <h1>Pelacak Langganan</h1>

    <div class="card">
        <div class="muted">Total pengeluaran per bulan</div>
        <div class="total">Rp {{ number_format($totalMonthly, 0, ',', '.') }}</div>
    </div>

    @if ($dueSoon->isNotEmpty())
        <div class="card alert">
            <strong>Segera jatuh tempo (7 hari ke depan)</strong>
            @foreach ($dueSoon as $s)
                <div class="muted">
                    {{ $s->name }}: {{ $s->next_billing_date->format('d M Y') }}
                    ({{ (int) today()->diffInDays($s->next_billing_date) === 0 ? 'hari ini' : (int) today()->diffInDays($s->next_billing_date) . ' hari lagi' }})
                </div>
            @endforeach
        </div>
    @endif

    <div class="card">
        <strong>Tambah langganan</strong>
        <form class="add" method="POST" action="{{ route('subscriptions.store') }}" style="margin-top:12px;">
            @csrf
            <input name="name" placeholder="Nama (mis. Netflix)" value="{{ old('name') }}" required>
            <input name="price" type="number" min="0" placeholder="Harga (Rp)" value="{{ old('price') }}" required>
            <select name="billing_cycle">
                <option value="monthly">Bulanan</option>
                <option value="yearly">Tahunan</option>
            </select>
            <input name="next_billing_date" type="date" value="{{ old('next_billing_date') }}" required>
            <input name="category" placeholder="Kategori (opsional)" value="{{ old('category') }}">
            <button type="submit">Simpan</button>
        </form>
        @foreach ($errors->all() as $error)
            <div class="error">{{ $error }}</div>
        @endforeach
    </div>

    <div class="card">
        <strong>Daftar langganan</strong>
        @if ($subscriptions->isEmpty())
            <p class="muted">Belum ada langganan. Tambahkan yang pertama di atas.</p>
        @else
            <table>
                <thead>
                    <tr><th>Nama</th><th>Harga</th><th>Siklus</th><th>Tagihan berikut</th><th></th></tr>
                </thead>
                <tbody>
                @foreach ($subscriptions as $s)
                    <tr>
                        <td>{{ $s->name }}<br><span class="muted">{{ $s->category }}</span></td>
                        <td>Rp {{ number_format($s->price, 0, ',', '.') }}</td>
                        <td>{{ $s->billing_cycle === 'yearly' ? 'Tahunan' : 'Bulanan' }}</td>
                        <td>{{ $s->next_billing_date->format('d M Y') }}</td>
                        <td>
                            <form method="POST" action="{{ route('subscriptions.destroy', $s) }}">
                                @csrf
                                @method('DELETE')
                                <button class="del" type="submit">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
</body>
</html>