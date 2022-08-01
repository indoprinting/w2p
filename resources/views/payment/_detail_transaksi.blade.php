<!-- Modal detail-->
<div class="modal fade" id="paymentModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="paymentModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalTitle"><strong>Detail pembayaran</strong></h5>
                <button type="button" class="close" id="close-detail" data-dismiss="modal" aria-label="Close">
                    <i class="far fa-times-square"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="payment-detail">
                    <div>Status Pembayaran<span class="float-right" id="payment-status"><?= $sale_erp->sale->payment_status ?></span></div>
                    <div>No. Invoice<span class="float-right"><?= $order['no_inv'] ?></span></div>
                    <div>Nama Pelanggan<span class="float-right"><?= $order['cust_name'] ?></span></div>
                    <hr>
                    @foreach (json_decode($order->items) as $item)
                        <div>{{ $item->name }}</div>
                        <div class="qty">Kuantitas : {{ $item->qty }}<span class="float-right">{{ rupiah($item->price) }}</span></div>
                        @foreach (json_decode($item->attributes)->jenis_atb as $id_atb => $name)
                            <p class="atb"><strong>{{ $name }}</strong> : {{ json_decode($item->attributes)->nama_atb[$id_atb] }}</p>
                        @endforeach
                    @endforeach
                    <hr>
                    <div>Sub total<span class="float-right">{{ rupiah($order->total) }}</span></div>
                    @isset($harga_kurir)
                        <div>Ongkir<span class="float-right">{{ rupiah($harga_kurir) }}</span></div>
                    @endisset
                    @isset($sale_erp->payment_validation->unique_code)
                        <div>Kode unik<span class="float-right">{{ $sale_erp->payment_validation->unique_code }}</span></div>
                    @endisset
                    <hr>
                    <div><strong>Total pembayaran</strong>
                        <span class="float-right">
                            <strong style="color:orangered;">{{ rupiah($sale_erp->payment_validation->transfer_amount ?? $sale_erp->sale->grand_total) }}</strong>
                        </span>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
{{-- <script>
    $(document).ready(function() {
        $("#close-detail").on('click', function() {
            location.reload();
        });
    });
</script> --}}
