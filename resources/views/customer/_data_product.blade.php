@foreach (json_decode($order->items) as $id_i => $item)
    <div><strong>{{ $item->name }}<span class="float-right">{{ rupiah($item->price) }}</span></strong></div>
    <div style="display: flex;">
        <p class="qty-product">Kuantitas : {{ $item->qty }} pcs</p>
        <a href="javascript:void(0);" data-toggle="modal" data-target="#desainModal{{ $id_i . $id_o }}">Lihat desain</a>
    </div>

    <!-- Modal lihat desain -->
    <div class="modal fade" id="desainModal{{ $id_i . $id_o }}" tabindex="-1" role="dialog" aria-labelledby="desainModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-100" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="desainModalTitle"><strong>Desain produk</strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="far fa-times-square"></i>
                    </button>
                </div>
                <div class="modal-body detail-desain">
                    {{-- @if ($item->design)
                        @foreach (json_decode($item->design) as $design)
                            <div class="desain">
                                <p>Desain {{ $loop->iteration }}</p>
                                <img src="{{ url('assets/images/design-upload/' . $design) }}" alt="" class="img-desain">
                            </div>
                        @endforeach
                    @elseif(isset($item->link))
                        <a href="{{ $item->link }}">{{ $item->link }}</a>
                    @endif --}}
                </div>
            </div>
        </div>
    </div>
@endforeach
@isset($order->courier_price)
    <div>
        <strong>Ongkos kirim <span class="float-right">{{ rupiah($order->courier_price) }}</span></strong>
    </div>
@endisset
