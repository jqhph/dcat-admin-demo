<style>
    .color-block {
        width: 100px;
        height: 20px;
        background: #5c6bc6;
        display: inline-block;
        border-radius: .1rem;
        color: white;
        font-size: 13px;
        text-align: center;
        line-height: 20px;
    }
    .block-sm {
        width: 40px;
    }
</style>
<ul class="nav navbar-nav">
    <li class="dropdown dropdown-language nav-item">
        <a class="dropdown-toggle nav-link" href="#" id="dropdown-color" data-toggle="dropdown">
            <span class="color-block" style="background: {{ $map[request()->get('_color_')] ?? \Dcat\Admin\Admin::color()->indigo() }}">
                主题
            </span>
        </a>
        <ul class="dropdown-menu" aria-labelledby="dropdown-color">
            <li class="dropdown-item" href="#" data-language="en">
                <a class="switch-color" data-value="indigo">
                    <span class="color-block" style="background: {{ \Dcat\Admin\Admin::color()->indigo() }}">indigo</span>
                    </a>
            </li>
            <li class="dropdown-item" href="#" data-language="fr">
                <a class="switch-color" data-value="blue">
                    <span class="color-block" style="background: #5686d4">blue</span>
                    </a>
            </li>
            <lia class="dropdown-item" href="#" data-language="de">
                <a class="switch-color" data-value="blue-dark">
                    <span class="color-block" style="background: #5686d4">
                         blue-dark
                    </span>
                   </a>
            </lia>
        </ul>
    </li>
</ul>
<script>
Dcat.ready(function () {
    $('.switch-color').click(function (e) {
        window.location.href = '{{ admin_url('/') }}?_color_='+$(this).data('value');
    })
});
</script>