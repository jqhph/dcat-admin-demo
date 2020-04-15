@extends(\DcatPage\view_name('app'), ['title' => ''])

@section('body-class', 'home')

@section('content')

    <nav id="slide-menu" class="slide-menu" role="navigation">

        <div class="brand">
            <a href="{{ \DcatPage\url('/') }}">
                Dcat Page
            </a>
        </div>

        <ul class="slide-main-nav">
            @include(\DcatPage\view_name('partials.main-nav'))
        </ul>

    </nav>

    <style>
        .container .newline {
            height:200px
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
                <h1>Dcat Page  为PHPer打造的静态站点构建工具</h1>
                <p>简单、美观、轻量</p>
            </div>

            <div style="height:500px"></div>

        </div>
    </section>

@endsection
