<div class="col-xs-12 col-sm-4 col-md-4 master-custom-right">
    <div class="well">
        <div class="panel-body">
            <h4>Пребарување</h4>
            <form class="navbar-form" role="search" name="form_search" id="form_search" method="get" action="#"
                  accept-charset="UTF-8">
                <input type="hidden" id="page" name="page" value="{{ app('request')->input('page') }}">
                <input type="hidden" id="all" name="all" value="all">
                <div class="input-group pull-left">
                    <input type="text" class="form-control" placeholder="{{trans('properties.public.index.search')}}"
                           name="search1" id="search1" value="">
                    <div class="input-group-btn">
                        <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <!-- Blog Categories Well -->
    {{--<div class="well">--}}
    {{--    <h4>Новости</h4>--}}
    {{--    <div class="row">--}}
    {{--        <div class="col-lg-12">--}}
    {{--            <ul class="list-unstyled">--}}
    {{--                <li><a href="/mk/records/10/aktivnosti">Активности</a>--}}
    {{--                </li>--}}
    {{--                <li><a href="/mk/records/9/soopstenija">Соопштенија</a>--}}
    {{--                </li>--}}
    {{--            </ul>--}}
    {{--        </div>--}}

    {{--    </div>--}}
    {{--    <!-- /.row -->--}}
    {{--</div>--}}

    <div class="well">
        <div class="panel-body">
            <h4><a href="https://admin.mvk.org.mk/" target="_blank">Портал за членови на комората</a></h4>
        </div>
    </div>
    <!-- TemplateEndEditable -->
    <div class="well">
        <div class="panel-body">
            <h4>Формулари и обрасци</h4>
            <ul class="lista">
                <li>
                    <a href="/upload/documents/obrasci/1.Пријава за упис во регистарот на доктори по ветеринарна медицина.docx">Пријава
                        за упис во регистарот на доктори по ветеринарна медицина</a></li>
                <li><a href="/upload/documents/obrasci/2.Барање за мирување на членство во Комората.doc">Барање за
                        мирување на членство во Комората</a></li>
                <li><a href="/upload/documents/obrasci/3.Барање за одобрување на приправнички стаж под менторство.docx">Барање
                        за одобрување на приправнички стаж под менторство</a></li>
                <li><a href="/upload/documents/obrasci/4.Барање за менторство.doc">Барање за менторство</a></li>
                <li><a href="/upload/documents/obrasci/5.Барање за издавање на лиценца за работа.docx">Барање за
                        издавање на лиценца за работа</a></li>
                <li><a href="/upload/documents/obrasci/6. Потврда за завршен приправнички стаж.doc">Потврда за завршен
                        приправнички стаж</a></li>
                <li>
                    <a href="/upload/records/10/20230908_204031_%D0%9A%D0%BE%D0%BD%D1%82%D1%80%D0%BE%D0%BB%D0%B5%D0%BD%20%D0%BB%D0%B8%D1%81%D1%82%20%D0%B7%D0%B0%20%D0%B5%D1%81%D0%B5%D0%BD%D1%86%D0%B8%D1%98%D0%B0%D0%BB%D0%BD%D0%B8%20%D0%BA%D0%BE%D0%BC%D0%BF%D0%B5%D1%82%D0%B5%D0%BD%D1%86%D0%B8%D0%B8%20%D0%BA%D0%BE%D0%B8%20%D1%81%D1%82%D0%B0%D0%B6%D0%B0%D0%BD%D1%82%D0%BE%D1%82%20%D1%82%D1%80%D0%B5%D0%B1%D0%B0%20%D0%B4%D0%B0%20%D0%B3%D0%B8%20%D1%81%D0%BE%D0%B2%D0%BB%D0%B0%D0%B4%D0%B0%20%D0%BF%D0%BE%D1%81%D0%BB%D0%B5%20%D0%B7%D0%B0%D0%B2%D1%80%D1%88%D1%83%D0%B2%D0%B0%D1%9A%D0%B5%20%D0%BD%D0%B0%20%D1%81%D1%82%D0%B0%D0%B6%D0%BE%D1%82.doc">Контролен
                        лист за есенцијални компетенции кои стажантот треба да ги совлада после завршување на стажот
                        издадени од ментор</a></li>
                <li><a href="/upload/documents/obrasci/7.Барање за продолжување на лиценца за работа.docx">Барање за
                        продолжување на лиценца за работа</a></li>
                <li><a href="/upload/documents/obrasci/8.Evidenciona Kartica 2023.pdf" target="_blank">Евиденциска
                        картичка</a></li>
                <li><a href="/upload/documents/obrasci/8.Барање за категоризација и вреднување 3.doc">Барање за
                        категоризација и вреднување</a></li>
                <li><a href="/upload/documents/obrasci/10.Барање за полагање на стручен испит.doc">Барање за полагање на
                        стручен испит</a></li>
                <li>
                    <a href="/upload/records/11/20230908_203650_%D0%91%D0%B0%D1%80%D0%B0%D1%9A%D0%B5%20%D0%B7%D0%B0%20%D0%B8%D0%B7%D1%80%D0%B0%D0%B1%D0%BE%D1%82%D0%BA%D0%B0%20%D0%BD%D0%B0%20%D1%84%D0%B0%D0%BA%D1%81%D0%B8%D0%BC%D0%B8%D0%BB.doc">Барање
                        за изработка на факсимил</a></li>

            </ul>
        </div>
    </div>
    <div class="well">
        <div class="panel panel-default"><a
                href="https://www.facebook.com/%D0%92%D0%B5%D1%82%D0%B5%D1%80%D0%B8%D0%BD%D0%B0%D1%80%D0%BD%D0%B0-%D0%BA%D0%BE%D0%BC%D0%BE%D1%80%D0%B0-%D0%BD%D0%B0-%D0%A0%D0%B5%D0%BF%D1%83%D0%B1%D0%BB%D0%B8%D0%BA%D0%B0-%D0%9C%D0%B0%D0%BA%D0%B5%D0%B4%D0%BE%D0%BD%D0%B8%D1%98%D0%B0-194871417547511/?fref=ts"
                target="_blank"><img src="/public_design/mvk/images/social_facebook_box_blue.png" width="30"
                                     height="30"> посетете не на Facebook</a>
        </div>
    </div>
    <div class="panel-body text-center"><a href="http://www.fva.gov.mk/" target="_blank"><img
                src="/public_design/mvk/images/agencija.gif" alt=""/></a></br>
        </br>
        <A href="http://fvm.ukim.edu.mk/" target="_blank"><img src="/public_design/mvk/images/fakultet.gif" alt=""/></A>
    </div>

</div>
