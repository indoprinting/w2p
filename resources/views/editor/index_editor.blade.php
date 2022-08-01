<!DOCTYPE HTML>
<html>

<head>

    {{ header('Access-Control-Allow-Origin: http://admin.w2p.test/') }}
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IDP | {{ $title ?? 'Cetak Expres, Harga Ngepres, Kualitas The Best' }}</title>
    <meta content="indoprinting" name="description">
    <meta content="indoprinting" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('assets/images/logo/favicon.png') }}" rel="icon">
    <!-- Style sheets -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/editor-online/css/main.css') }}">

    <!-- The CSS for the plugin itself - required -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/editor-online/css/FancyProductDesigner-all.css') }}" />

    <!-- Include required jQuery files -->
    <script src="{{ asset('assets/editor-online/js/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/editor-online/js/jquery-ui.min.js') }}" type="text/javascript"></script>

    <!-- HTML5 canvas library - required -->
    <script src="{{ asset('assets/editor-online/js/fabric.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/editor-online/js/jquery-confirm.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/editor-online/js/jquery-confirm.min.css') }}" type="text/javascript"></script>
    <!-- The plugin itself - required -->
    <script src="{{ asset('assets/editor-online/js/FancyProductDesigner-all.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            var $yourDesigner = $('#' + '<?= $product_id ?>'),

                pluginOpts = {
                    productsJSON: '/w2p_admin/public/assets/editor-online/products/json_fe/' + '<?= $ukuran ?>' + '.json', //see JSON folder for products sorted in categories
                    designsJSON: '/w2p_admin/public/assets/editor-online/clipart/clipart.json', //see JSON folder for designs sorted in categories
                    editorMode: false,
                    smartGuides: true,
                    uiTheme: 'doyle',
                    fonts: [{
                            name: 'Helvetica'
                        },
                        {
                            name: 'Times New Roman'
                        },
                        {
                            name: 'Arial'
                        },
                        {
                            name: 'Lobster',
                            url: 'google'
                        }
                    ],
                    customTextParameters: {
                        colors: true,
                        removable: true,
                        resizable: true,
                        draggable: true,
                        rotatable: true,
                        autoCenter: true,
                        boundingBox: "Base",
                        curvable: true
                    },
                    customImageParameters: {
                        draggable: true,
                        removable: true,
                        resizable: true,
                        rotatable: true,
                        scaleX: 0.1,
                        scaleY: 0.1,
                        autoCenter: true,
                        boundingBox: "Base"
                    },
                    actions: {
                        'top': ['undo', 'redo'],
                        'left': ['manage-layers', 'load']
                    }
                },

                yourDesigner = new FancyProductDesigner($yourDesigner, pluginOpts);

            $('#save-image-php').click(function() {
                yourDesigner.getProductDataURL(function(dataURL) {
                    var a = $.post("/set-design-online", {
                            base64_image: dataURL,
                            cart_id: '<?= $cart_id ?>'
                        },
                        function(status) {
                            if (status == 1) {
                                window.location.href = "/keranjang";
                            }
                        });
                });
            });
        });
    </script>

</head>

<body>
    <div id="main-container">
        <div id="{{ $product_id }}" class="fpd-shadow-2 fpd-topbar fpd-tabs fpd-tabs-side fpd-top-actions-centered fpd-bottom-actions-centered fpd-views-inside-left"> </div>
        <br />

        <p class="fpd-container">
            <span class="fpd-btn" id="save-image-php">Add to cart</span>
        </p>

    </div>
</body>

</html>
