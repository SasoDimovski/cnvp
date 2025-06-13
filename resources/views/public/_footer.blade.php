<!-- start footer -->
<div class="container futer" style="background-color: #001f35">
    <footer>
        <div class="row">

            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <p><strong>СОЈУЗ НА СТОПАНСКИ КОМОРИ НА МАКЕДОНИЈА</strong></br>
                            Црвена Скопска Општина бр.10</br>
                            1000 Скопје, Р. Македонија</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <p> Е: <a href="mailto:info@chamber.mk">info@chamber.mk</a></br>
                            Т: + 389 2 3091 440</br>
                            Ф: 02 3114 619</br>
                           </p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="panel panel-default">
                    <div style="text-align:right; margin-top:40px;"> by <a href="http://www.medium3.mk" target="_blank">Medium3</a></div>
                </div>
            </div>

        </div>
    </footer>
</div>
<!-- cookie warning toast -->
<div class="toast bg-dark text-white w-100 mw-100 kolacinja" role="alert" data-autohide="false" style="display: none">
    <div class="toast-body p-4 d-flex flex-column">
        <p>{{trans('properties.public.menu.name.poraka_kolacinja')}}
            <a href="#">{{trans('properties.public.menu.name.politika_kolacinja')}}</a><button type="button" class="btn btn-light" id="btnAccept">
                {{trans('properties.public.menu.name.ok')}}
            </button></p>
    </div>
</div>

<!-- jQuery Version 1.11.0 -->
<script src="{{url('public_design/mvk/js/jquery-1.11.0.js')}}"></script>

<!-- Bootstrap Core JavaScript -->
<script src="{{url('public_design/mvk/js/bootstrap.min.js')}}"></script>
<script>
    function setCookie(name,value,days) {
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days*24*60*60*1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "")  + expires + "; path=/";
    }
    function getCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for(var i=0;i < ca.length;i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1,c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
        }
        return null;
    }

    function eraseCookie(name) {
        document.cookie = name +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
    }

    function cookieConsent() {
        if (!getCookie('allowCookies')) {
            $('.toast').show();
            //alert('nema');
        }
    }

    $('#btnDeny').click(()=>{
        eraseCookie('allowCookies')
        $('.toast').hide();
    })

    $('#btnAccept').click(()=>{
        setCookie('allowCookies','1',7)
        $('.toast').hide();
    })

    // load
    cookieConsent()

    // for demo / testing only
    $('#btnReset').click(()=>{
        // clear cookie to show toast after acceptance
        eraseCookie('allowCookies')
        $('.toast').show();
    })

</script>
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-5756323-17', 'auto');
    ga('send', 'pageview');

</script>


