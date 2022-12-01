@extends('layouts.main')
@section('main')
    <x-breadcrumb :title="$title" />
    <div class="container-fluid">
        <div class="wrapper">
            <h2 class="text-center">Daftar Rekening BANK Indoprinting</h2>
            <div class="underline"></div>
            <div class="payment-bank">
                <table class="table table-bordered">
                    <tr>
                        <th style="text-align:center;" width="40%">No. Rekening</th>
                        <th>Nama Bank</th>
                        <th>Atas Nama</th>
                        <th>Minimal Transfer</th>
                    </tr>
                    <tr>
                        <td>
                            <a href="javascript:void(0);" class="fad fa-copy" onclick="copyToClipboard('#bri')"></a><span id="bri">0083 01 001092 56 5</span>
                        </td>
                        <td class="td-img"><img src="{{ asset('assets/images/logo/logo_bri.png') }}" alt="" class="img-bank"></td>
                        <td>CV. Indoprinting</td>
                        <td>Rp 10.000</td>
                    </tr>
                    <tr>
                        <td>
                            <a href="javascript:void(0);" class="fad fa-copy" onclick="copyToClipboard('#bni')"></a><span id="bni">5592 09008</span>
                        </td>
                        <td class="td-img"><img src="{{ asset('assets/images/logo/logo_bni.png') }}" alt="" class="img-bank"></td>
                        <td>CV. Indoprinting</td>
                        <td>Rp 10.000</td>
                    </tr>
                    <tr>
                        <td>
                            <a href="javascript:void(0);" class="fad fa-copy" onclick="copyToClipboard('#mandiri')"></a><span id="mandiri">1360 0005 5532 3</span>
                        </td>
                        <td class="td-img"><img src="{{ asset('assets/images/logo/logo_mandiri.png') }}" alt="" class="img-bank"></td>
                        <td>CV. Indoprinting</td>
                        <td>Rp 10.000</td>
                    </tr>
                    <tr>
                        <td>
                            <a href="javascript:void(0);" class="fad fa-copy" onclick="copyToClipboard('#bca')"></a><span id="bca">8030 200234</span>
                        </td>
                        <td class="td-img"><img src="{{ asset('assets/images/logo/logo_bca.png') }}" alt="" class="img-bank"></td>
                        <td>Anita Ratnasari</td>
                        <td>Rp 10.000</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard(element) {
            let text = $(element).text().replace(/\D/g, "");
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val(text).select();
            document.execCommand("copy");
            alert('Teks disalin');
            $temp.remove();
        }
    </script>
@endsection
