@props(['templates'])

<div class="row">
    @foreach ($templates as $template)
        <div class="icon-box">
            <div class="box">
                <div class="frame">
                    <a href="#">
                        <div class="icon"><img src="{{ adminUrl('assets/images/design-online/template/' . $template->template_image) }}"></div>
                        <div class="text">
                            {{ $template->template_size }}
                        </div>
                        <div class="price">Start
                            <b>
                                {{ rupiah($template->template_price) }}
                            </b>
                        </div>
                        <div class="rating-sold">
                            <small>Template {{ $template->category_name }}</small>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    @endforeach
</div>

<script type="text/javascript">
    if (localStorage.getItem('url') != null){
        localStorage.removeItem('url');
    }
    $('#design-online').click(function(){
        function maketextnumber(n) {
            for (var r = ["a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n",
                    "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "A", "B", "C", "D", "E", "F",
                    "G", "H", "I",  "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W",
                    "X", "Y", "Z", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9"],
                     e = n, t = new Array, a = 0; a <= e - 1; a++) {
                t[a] = r[parseInt(Math.random() * r.length)];
                t = t;
                randomtextnumber = t.join("")
            }
        }
        localStorage.setItem('url', window.location.href);
        window.location.href = "https://indoprinting.co.id/studio?"+maketextnumber(120)+randomtextnumber;
    });
    if (localStorage.getItem('design') != null){
        localStorage.removeItem('design');
    }

</script>
