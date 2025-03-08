<div style="background-color: {{ $product->color ? $product->color->hex_code : '#ccc' }}; padding: 10px;">
    <strong>Status:</strong> {{ $product->status ?? 'No status' }}
</div>