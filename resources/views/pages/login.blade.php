@extends('layouts.layout-main')

@section('content')
    <section class="container" style="background-image: url({{ isset($settings['backgroundImage']) ? $settings['backgroundImage'] : $settings['backgroundImageDefault'] }});  background-position: center; background-size: 100% 100%; background-repeat: no-repeat;">
        <div class="row justify-center">
            <div class="col-lg-12 row justify-center mt-lg-0 mt-4">
                <div class="col-lg-12 flex justify-content-center mt-lg-5">
                    <img src="{{ isset($settings['logoImage']) ? $settings['logoImage'] : '' }}"
                        class="img my-0 py-0" style="max-height: 35vh; width: auto;" />
                </div>
                <div class="col-12">
                    <div>
                        <h2 style="color: white; margin: 27px;" class="text-center">
                            <b>Admin Panel</b>
                        </h2>
                        <input type="hidden" name="_token" placeholder="" value="{{ csrf_token() }}">
                        <div class="">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                                Email Address
                            </label>
                            <input
                                class="shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                                id="email" type="email" name="email" placeholder="Email Address" />
                        </div>
                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                                Password
                            </label>
                            <input
                                class="shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                                id="password" type="password" name="password" placeholder="******************" />
                        </div>

                        <p class="block text-white text-sm font-bold mb-2" style="display: none;" id="loading-text">
                            Loading...</p>

                        <label class="block col-12 text-center text-white text-sm font-bold mb-2"
                            id="error-message"></label>

                        <div class="flex items-center justify-between">
                            <button
                                class="col bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                                id="button-form-submit">
                                Sign In
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>

        $("#button-form-submit").on("click", function () {
            $("#loading-text").css("display", "block");
            $("#error-message").text("");
            onLogin();
        });

        function onLogin() {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            const url = '/admin/login'
            const data = {
                email: email,
                password: password
            };

            const xhr = new XMLHttpRequest();
            xhr.open('POST', url);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
            xhr.onload = function () {

                $("#loading-text").css("display", "none");

                $("#error-message").text("");

                if (xhr.status === 200) {

                    const response = JSON.parse(xhr.responseText);

                    if (response.status == true){

                        $("#error-message").html(response.message);

                        window.location.href = "/admin"

                    } else {

                        $("#error-message").html(response.message);

                    }
                } else if (xhr.status === 404) {

                    $("#error-message").text('Akun tidak ditemukan!');

                } else {

                    $("#error-message").text('Gagal! Silahkan coba kembali atau refresh halaman.');

                    console.log('Request failed. Returned status of ' + xhr.status);
                }
            };
            xhr.send(JSON.stringify(data));
        }

    </script>
@endsection
