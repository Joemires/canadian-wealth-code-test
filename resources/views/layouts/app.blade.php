<x-guest-layout>
    @if (optional($__laravel_slots)['header'])
        @if (Str::length($__laravel_slots['header']) <= 0)
            <div class="header pb-8 pt-5 pt-lg-8 d-flex align-items-center"
                style="background-image: url(../argon/img/theme/profile-cover.jpg); background-size: cover; background-position: center top;">
                <!-- Mask -->
                <span class="mask bg-gradient-default opacity-8"></span>
                <!-- Header container -->
                <div class="container-fluid d-flex align-items-center">
                    <div class="row">
                        <div class="col-md-12 {{ $__laravel_slots['header']->attributes->get('class') }}">
                            <h1 class="display-2 text-white">{{ $__laravel_slots['header']->attributes->get('title') }}
                            </h1>
                            @if ($__laravel_slots['header']->attributes->get('description'))
                                <p class="text-white mt-0 mb-5">
                                    {{ $__laravel_slots['header']->attributes->get('description') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div {{ $__laravel_slots['header']->attributes->merge(['class' => 'header pb-8 pt-5 pt-md-8']) }}>
                <div class="container-fluid">
                    <div class="header-body">
                        {{ $__laravel_slots['header'] }}
                    </div>
                </div>
            </div>
        @endif
    @endif

    <div class="container-fluid mt--7">
        <div class="row">
            {{ $slot }}
        </div>
        <footer class="footer">
            <div class="row align-items-center justify-content-xl-between">
                <div class="col-xl-6">
                    <div class="copyright text-center text-xl-left text-muted">
                        © 2020 <a href="https://www.creative-tim.com" class="font-weight-bold ml-1" target="_blank">Creative
                            Tim</a> &amp;
                        <a href="https://www.updivision.com" class="font-weight-bold ml-1" target="_blank">Updivision</a>
                    </div>
                </div>
                <div class="col-xl-6">
                    <ul class="nav nav-footer justify-content-center justify-content-xl-end">
                        <li class="nav-item">
                            <a href="https://www.creative-tim.com" class="nav-link" target="_blank">Creative Tim</a>
                        </li>
                        <li class="nav-item">
                            <a href="https://www.updivision.com" class="nav-link" target="_blank">Updivision</a>
                        </li>
                        <li class="nav-item">
                            <a href="https://www.creative-tim.com/presentation" class="nav-link" target="_blank">About
                                Us</a>
                        </li>
                        <li class="nav-item">
                            <a href="http://blog.creative-tim.com" class="nav-link" target="_blank">Blog</a>
                        </li>
                        <li class="nav-item">
                            <a href="https://github.com/creativetimofficial/argon-dashboard/blob/master/LICENSE.md"
                                class="nav-link" target="_blank">MIT License</a>
                        </li>
                    </ul>
                </div>
            </div>
        </footer>
    </div>
</x-guest-layout>
