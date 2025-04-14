<form action="{{ route('review.store', ['id' => $product->ProductID]) }}" method="POST" style="max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; background-color: #f9f9f9;">
    @csrf
    <input type="hidden" name="product_id" value="{{ $product->ProductID }}">

    <h3 style="margin-bottom: 15px;">Đánh giá sản phẩm</h3>

    <!-- Rating -->
    <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px;">Đánh giá sao:</label>
        <div style="direction: rtl; unicode-bidi: bidi-override; font-size: 24px;">
            @for ($i = 5; $i >= 1; $i--)
                <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}" style="display: none;" {{ old('rating') == $i ? 'checked' : '' }}>
                <label for="star{{ $i }}" style="cursor: pointer; color: #ccc;" onmouseover="highlightStars({{ $i }})" onmouseout="resetStars()">
                    ★
                </label>
            @endfor
        </div>
    </div>

    <!-- Comment -->
    <div style="margin-bottom: 15px;">
        <label for="comment" style="display: block; margin-bottom: 5px;">Nhận xét của bạn:</label>
        <textarea name="comment" id="comment" rows="4" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"></textarea>
    </div>

    <!-- Submit -->
    <button type="submit" style="background-color: #FFD73B; color: #000 ; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">
        <b>Gửi đánh giá</b>
        
    </button>
</form>

<!-- Optional JavaScript to highlight stars -->
<script>
    const labels = document.querySelectorAll('label[for^="star"]');
    const radios = document.querySelectorAll('input[name="rating"]');

    function highlightStars(star) {
        labels.forEach((label, index) => {
            if (5 - index <= star) {
                label.style.color = '#f5c518';
            } else {
                label.style.color = '#ccc';
            }
        });
    }

    function resetStars() {
        const checked = [...radios].find(r => r.checked);
        const rating = checked ? parseInt(checked.value) : 0;
        highlightStars(rating);
    }

    // Initialize highlight on page load
    document.addEventListener('DOMContentLoaded', resetStars);
</script>
