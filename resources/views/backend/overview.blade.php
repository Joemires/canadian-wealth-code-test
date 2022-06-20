<x-app-layout>
    <x-slot name="header" :title="Str::of('Welcome ?')->replace('?', auth()->user()->name)" description="We are happy to give you the premium experience you deserve">
    </x-slot>

    <div class="col-md-10 ml-auto mr-auto">
        <div class="card card-upgrade">
            @hasrole('premium member')
            <div class="container">
                <div class="row justify-content-center align-items-center">
                    <div class="col-lg-5 p-5">
                        <img src="{{ asset('assets/img/svg/undraw_professor_re_mj1s.svg') }}" alt="" class="img-fluid">
                    </div>
                    <div class="col-lg-7">
                        <h2>Hurray</h2>
                        <p>We are so happy you've joined use in the bold step of becoming a premium user. Please sit tight will we work on giving you the best experience
                            <br>
                            - From our team {{ config('app.name') }}
                        </p>
                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Asperiores totam, consectetur iusto eos tempore dicta aliquam vel impedit quidem a voluptatibus aspernatur quasi, culpa minima maxime necessitatibus consequuntur exercitationem molestiae!</p>
                    </div>
                </div>
            </div>
            @else
                <div class="card-header text-center border-bottom-0">
                    <h4 class="card-title">Upgrade Membership</h4>
                    <p class="card-category">Become a member of our community, subscribe to the premium package and enjoy
                        unlimited life experience</p>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-upgrade">
                        <table class="table">
                            <thead>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <h2>Packages</h2>
                                    </td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th class="text-center">Free</th>
                                    <th class="text-center">Premium</th>
                                </tr>
                                <tr>
                                    <td>Plugins</td>
                                    <td class="text-center">4</td>
                                    <td class="text-center">16</td>
                                </tr>
                                <tr>
                                    <td>Example Pages</td>
                                    <td class="text-center">6</td>
                                    <td class="text-center">25</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td class="text-center">Free</td>
                                    <td class="text-center"><b>$149</b></td>
                                </tr>
                                <tr>
                                    <td class="text-center"></td>
                                    <td class="text-center">
                                        <a href="#" class="btn btn-round btn-default disabled">Current Version</a>
                                    </td>
                                    <td class="text-center">
                                        <a href="#" class="btn btn-round btn-primary upgrade">Upgrade to PRO</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                @push('js')
                    <script src="https://js.paystack.co/v1/inline.js"></script>
                    <script>
                        $('a.upgrade').click( (e) => {
                            e.preventDefault();
                            let handler = PaystackPop.setup({
                                key: '{{ config("paystack.publicKey") }}', // Replace with your public key
                                email: '{{ auth()->user()->email }}',
                                amount: {{ env('SUBSCRIPTION_FEE', 100)}} * 100,
                                currency: 'NGN', // Use GHS for Ghana Cedis or USD for US Dollars
                                ref: '' + Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
                                // label: "Optional string that replaces customer email"
                                metadata: {
                                    user_id: {{ auth()->user()->id }}
                                },
                                callback: function(response) {
                                    Notiflix.Loading.circle()
                                    // let message = 'Payment complete! Reference: ' + response.reference;
                                    // console.log(message);
                                    $.post("{{ route('backend.premium') }}", {reference: response.reference}, (data) => {
                                        Notiflix.Loading.remove()
                                        if(! data.error) {
                                            Notiflix.Report.success("Upgrade Successful", "🎉 Hurray, we have received your upgrade request and have acted on it ASAP. Welcome to a premium experience 😏", null, () => {
                                                window.location.reload()
                                            })
                                        } else {
                                            Notiflix.Report.failure("Error Processing Payment", "Sorry we could not complete this upgrade request, please verify you made exact payment or contact admin. Thank you")
                                        }
                                    })
                                    .failure( () => {
                                        Notiflix.Loading.remove()
                                        Notiflix.Report.failure("Oops... Our Bad", "We are sorry but our server could not process this request, It's our fault and we are working on a quick fix. Please hold on.")
                                    })
                                    // alert(message);
                                },
                                onClose: function() {
                                    Notiflix.Report.failure("Payment Not Completed", "Oops... It's seems you mistakenly closed the payment form, please complete your membership request payment to get started")
                                }
                            });
                            handler.openIframe();
                        })
                    </script>
                @endpush
            @endhasrole

        </div>
    </div>

</x-app-layout>
