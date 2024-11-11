<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <title>BPSU Events And Collaboration</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">
    <main class="container px-4 py-8 mx-auto">
        {{-- card --}}
        <div class="flex flex-col max-w-xl px-6 py-20 mx-auto mt-10 bg-white rounded shadow-lg">



            <div>
                <img src="/logo.png" alt="" class="w-full max-w-sm mx-auto mt-4">
            </div>

            <h2>

            </h2>

            {{-- navigation gid --}}
            <div class="grid grid-cols-1 gap-4 mt-8">
                {{-- selection 1 - admin --}}
                <a href="{{ route('admin.login') }}">
                    <div class="bg-[#841818] text-white p-2 rounded shadow-lg hover:bg-[#600000] transition-all duration-100">
                        <h2 class="text-xl font-semibold text-center">
                            Admin
                        </h2>
                    </div>
                </a>

                {{-- selection 2 - user --}}
                <a href="{{ route('student.login') }}">
                    <div class="bg-[#841818] text-white p-2 rounded shadow-lg hover:bg-[#600000] transition-all duration-100">
                        <h2 class="text-xl font-semibold text-center">
                            Student
                        </h2>
                    </div>
                </a>


                {{-- selection 3 - organization --}}
                <a href="{{ route('organization.login') }}">
                    <div class="bg-[#841818] text-white p-2 rounded shadow-lg hover:bg-[#600000] transition-all duration-100">

                        <h2 class="text-xl font-semibold text-center">
                            Organization
                        </h2>
                    </div>
                </a>

            </div>

        </div>


    </main>
    @vite('resources/js/app.js')
</body>

</html>
