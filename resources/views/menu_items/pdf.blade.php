<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Menu Items Report</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1 { color: #333; text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .price { text-align: right; }
    </style>
</head>
<body>
    <h1>Menu Items Report</h1>
    <p>Generated on: {{ now()->format('Y-m-d H:i:s') }}</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Item Name</th>
                <th>Price</th>
                <th>Description</th>
                <th>Category</th>
            </tr>
        </thead>
        <tbody>
            @foreach($menuItems as $index => $menuItem)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $menuItem->name }}</td>
                    <td class="price">₱{{ number_format($menuItem->price, 2) }}</td>
                    <td>{{ $menuItem->description ?? 'N/A' }}</td>
                    <td>{{ $menuItem->category->name ?? 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
