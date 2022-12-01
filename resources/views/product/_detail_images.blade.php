<img id="img" src="{{ adminUrl('assets/images/products-img/' . $product->thumbnail) }}" style="max-width:100%;">
<div class="display-thumb2">
    <div class="coloumn">
        <div class="img-thumb2">
            <img src="{{ adminUrl('assets/images/products-img/' . $product->thumbnail) }}" class="thumb2">
        </div>
        @foreach ($thumbnails as $thumb)
            <div class="img-thumb2">
                <img src="{{ adminUrl('assets/images/products-img/' . $thumb) }}" class="thumb2">
            </div>
        @endforeach
    </div>
</div>
<div class="modal-img-zoom">
    <span class="close-modal-zoom">&times;</span>
    <img class="content">
</div>
