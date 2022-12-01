@extends('layouts.main')
@section('main')
    <x-breadcrumb :title="$title" />
    <div class="wrapper-pl">
        <h2>Price List</h2>
        <div class="underline"></div>
        <div class="row">
            @foreach ($images as $image)
                <div class="price-list">
                    <img src="{{ adminUrl('assets/images/price-list/' . $image->filename) }}" class="w-100 rounded image">
                    <div class="text-center mt-1">
                        <a href="{{ route('download.price.list', $image->filename) }}" class="btn btn-primary w-100">
                            <i class="fas fa-download"></i> Download
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="modal-img-zoom">
            <span class="close-modal-zoom">&times;</span>
            <img class="content">
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $(".image").on("click", function() {
                let src = $(this).attr("src");
                $(".content").attr("src", src);
                $(".modal-img-zoom").css("display", "block");
            });
            $(".close-modal-zoom").on("click", function() {
                $(".modal-img-zoom").css("display", "none");
            });
        });
    </script>
@endsection
