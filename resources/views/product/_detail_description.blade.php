<div style="margin-top: 50px;">
    <div class="p-2">
        <ul class="nav nav-pills">
            <li><a class="nav-item nav-link active" href="#deskripsi" data-toggle="tab" id="rincian-produk">Rincian Produk</a></li>
            <li><a class="nav-item nav-link" href="#deskripsiHarga" data-toggle="tab">Harga</a></li>
            <li><a class="nav-item nav-link" href="#sumberUpload" data-toggle="tab">Sumber Upload</a></li>
            <li><a class="nav-item nav-link" href="#ulasan" data-toggle="tab" id="ulasan-tab">Ulasan</a>
            </li>
        </ul>
    </div>
    <div class="garis"></div>
    <div class="card-body" style="min-height: 700px;">
        <div class="tab-content">

            <div class="active tab-pane desc" id="deskripsi">
                <?= $product['desc_id'] ?>
            </div>

            <div class="tab-pane" id="deskripsiHarga">
                <div class="row">
                    <div class="col-md-3" id="table-range"></div>
                </div>
                <div class="row">
                    @php
                        $count = 2 + count($attributes->name);
                    @endphp
                    @for ($i = 2; $i < $count; $i++)
                        <div class="col-md-3" style="padding:5px 10px" id="range-atb{{ $i }}">
                            &nbsp;
                        </div>
                    @endfor
                </div>
            </div>

            <div class=" tab-pane" id="sumberUpload" style="font-size: 14px;">
                <ul>
                    <li>Jenis file: TIFF, JPG, PNG, PDF, ZIP, RAR.</li>
                    <li>Ukuran File Upload maksimal 20 Mb, lebih dari 20 Mb menggunakan share link.</li>
                    <li>Mohon dicek detail: design, text, ejaan, warna, background, informasi, batas margin.</li>
                    <li>Mohon file yang anda kirim sudah Ready to print, file yang belum siap akan mempengaruhi waktu produksi.</li>
                    <li>Mohon file yang anda kirim rasio ukurannya sesuai dengan cetakan, misalnya file 1x1 di cetak menjadi 1x1 bukan 1x2</li>
                    <li>Setiap file yang dicetak akan melalui pengecekan kembali untuk memastikan hasil yang maksimal</li>
                </ul>
            </div>

            <div class="tab-pane" id="ulasan">
                @isset($product->review)
                    <div class="offer-dedicated-body-left">
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade active show" id="pills-reviews" role="tabpanel" aria-labelledby="pills-reviews-tab">
                                <div class="bg-white rounded shadow-sm p-4 mb-4 detail-review">
                                    @foreach ($product->review as $review)
                                        <div class="reviews-members pt-4 pb-4">
                                            <div class="media">
                                                <a href="#"><img alt="" src="{{ asset('assets/images/logo/cust.png') }}" class="mr-3 rounded-pill"></a>
                                                <div class="media-body">
                                                    <div class="reviews-members-header">
                                                        <h6 class="mb-1 text-black">
                                                            {{ $review?->user?->name }}
                                                        </h6>
                                                        <div class="tgl-rate">
                                                            {{ dateID($review->created_at) }}
                                                        </div>
                                                        <div class="rating-product">
                                                            <div class="Stars2" style="--rating: {{ $review->rating }};"></div>
                                                        </div>
                                                    </div>
                                                    <div class="reviews-members-body text-justify mt-2">
                                                        <p>
                                                            {!! $review->review !!}
                                                        </p>
                                                    </div>
                                                    @if ($review->respon)
                                                        <div class="reviews-members pt-2 pb-4">
                                                            <div class="media">
                                                                <a href="#"><img alt="" src="{{ asset('assets/images/logo/p.png') }}" class="mr-3 rounded-pill"></a>
                                                                <div class="media-body">
                                                                    <div class="reviews-members-header">
                                                                        <h6 class="text-black">Indoprinting</h6>
                                                                    </div>
                                                                    <div class="reviews-members-body text-justify mt-2  ">
                                                                        <p>
                                                                            {!! $review->respon !!}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endisset
            </div>

        </div>
    </div>
</div>
