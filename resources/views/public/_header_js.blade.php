
<script type="text/javascript" charset="utf-8">
    $(document).ready(function(){
        $("a[rel^='prettyPhoto']").prettyPhoto({
            social_tools: false
        });
    });
</script>

<script>
    $(document).ready(function(){
        $("ul.sf-menu li a").mouseover(function(){
            $(this).parent().css( "background-color", "white" );
        });
        $("ul.sf-menu li a").mouseout(function(){
            $(this).parent().css( "background-color", "unset" );
        });
        $("ul.podmeni li a").mouseover(function(){
            $(this).parent().css( "background-color", "white" );
        });
        $("ul.podmeni li a").mouseout(function(){
            $(this).parent().css( "background-color", "unset" );
        });
    });
</script>
{{--<script src="{{url('public_design/js/bootstrap.min.js')}}"></script>--}}
{{--<script src="{{url('public_design/js/bootstrap-transition.js')}}"></script>--}}
{{--<script src="{{url('public_design/js/jquery.ticker.js')}}"></script>--}}
{{--<script src="{{url('public_design/js/jquery.uisearch.min.js')}}"></script>--}}
{{--<script src="{{url('public_design/js/jquery.classie.min.js')}}"></script>--}}
{{--<script src="{{url('public_design/js/hoverIntent.js')}}"></script>--}}
{{--<script src="{{url('public_design/js/superfish.js')}}"></script>--}}
{{--<script src="{{url('public_design/js/main.js')}}"></script>--}}
{{--<script src="{{url('public_design/js/jquery.sliderPro.min.js')}}"></script>--}}
{{--<script src="{{url('public_design/js/jquery.prettyPhoto.js')}}"></script>--}}
{{--<script src="{{url('public_design/js/jquery.navgoco.min.js')}}"></script>--}}
{{--<script src="{{url('public_design/js/customjs.js')}}"></script>--}}

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
