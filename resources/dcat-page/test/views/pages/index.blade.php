@extends(\DcatPage\view_name('app'), ['title' => 'Welcome to Dcat Page'])

@section('body-class', 'home')

@section('content')

    <nav id="slide-menu" class="slide-menu" role="navigation">

        <div class="brand">
            <a href="{{ \DcatPage\url('/') }}">
                {{--                <img src="{!! \DcatPage\asset('/assets/img/laravel-logo-white.png') !!}" height="50" >--}}
            </a>
        </div>

        <ul class="slide-main-nav">
            @include(\DcatPage\view_name('partials.main-nav'))
        </ul>

    </nav>

    <style>
        .container .newline {
            height:150px
        }
        @media (max-width:780px) {
            .container .newline {
                height:0
            }
        }
    </style>

    <section class="hero">
        <div class="container" style="text-align:center">

            <div class="newline"></div>

            <div>
                <h1>Dcat Page  为PHPer打造的静态站点构建工具。</h1>
                <p>简单、高效、美观</p>
            </div>

            <div style="height:400px"></div>

            <div class="callout rule">
                <span class="text">Dcat Page可以做什么？</span>
            </div>

            <div style="text-align:left;">
                <h3 style="font-weight:300">个人站点</h3>
                <p>可用使用Dcat Page构建个人静态站点，如在线简历、个人作品展示站点等等。</p>

                <div style="height:10px"></div>

                <h3 style="font-weight:300">文档</h3>
                <p>可以把Markdown文本转化为一个简洁美观的、体验良好的web在线文档。</p>

            </div>



        </div>
    </section>


@endsection
