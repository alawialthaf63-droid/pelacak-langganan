<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Langganan</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: system-ui, sans-serif; background: #0b0f14; color: #e6edf3; }
        .wrap { max-width: 560px; margin: 0 auto; padding: 32px 20px; }
        h1 { margin: 0 0 24px; font-size: 26px; }
        .card { background: #131a22; border: 1px solid #222d3a; border-radius: 10px; padding: 20px; }
        label { display: block; margin: 14px 0 6px; font-size: 14px; color: #8b98a5; }
        input, select { width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #2c3a49; background: #0b0f14; color: #e6edf3; }
        .actions { display: flex; gap: 12px; margin-top: 22px; align-items: center; }
        button { padding: 10px 16px; border: 0; border-radius: 6px; background: #4dd0e1; color: #06222a; font-weight: 700; cursor: pointer; }
        a.back { color: #8b98a5; text-decoration: none; }
        .error { color: #f87171; font-size: 13px; margin-top: 10px; }
    </style>
</head>
<body>
<div class="wrap">
    <h1>Edit Langganan</h1>

    <div class="card">
        <form method="POST" action="{{ route('subscriptions.update', $subscription) }}">
            @csrf
            @method('PUT')

            <label>Nama</label>
            <input name="name" value="{{ old('name', $subscription->name) }}" required>

            <label>Harga (Rp)</label>
            <input name="price" type="number" min="0" value="{{ old('price', $subscription->price) }}" required>

            <label>Siklus tagihan</label>
            <select name="billing_cycle">
                <option value="monthly" @selected(old('billing_cycle', $subscription->billing_cycle) === 'monthly')>Bulanan</option>
                <option value="yearly" @selected(old('billing_cycle', $subscription->billing_cycle) === 'yearly')>Tahunan</option>
            </select>

            <label>Tagihan berikutnya</label>
            <input name="next_billing_date" type="date" value="{{ old('next_billing_date', $subscription->next_billing_date->format('Y-m-d')) }}" required>

            <label>Kategori</label>
            <input name="category" value="{{ old('category', $subscription->category) }}">

            @foreach ($errors->all() as $error)
                <div class="error">{{ $error }}</div>
            @endforeach

            <div class="actions">
                <button type="submit">Simpan perubahan</button>
                <a class="back" href="{{ route('subscriptions.index') }}">Batal</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>