@extends('layouts.guest')
{{-- capitalize $role + login --}}
@section('title')
    Student Register
@endsection

@section('content')
    <main class="container flex items-center justify-center min-h-screen mx-auto">
        <div class="flex flex-col items-center justify-center max-w-xl px-6 py-12 mx-auto bg-white rounded shadow-md">
            <img src="/logo.png" alt="Student organization collaboration and events management">
            <form class="grid w-full grid-cols-1 gap-2 md:grid-cols-2" method="POST" action="{{ route('student.store') }}">
                @csrf
                @method('POST')
                @if ($errors->any())
                    <div class="w-full mb-4">
                        <ul class="text-red-600 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <x-text-input name="first_name" label="First Name" type="text" required />
                <x-text-input name="last_name" label="Last Name" type="text" required />
                <x-text-input name="email" label="Email" type="email" required />
                <x-text-input name="password" label="Password" type="password" required />
                <x-text-input name="password_confirmation" label="Confirm Password" type="password" required />
                <hr class="md:col-span-2">
                <x-text-input name="guardian_name" label="Guardian Name" type="text" required />
                <x-text-input name="guardian_contact" label="Guardian Contact" type="text" required />
                <hr class="md:col-span-2">
                <select name="campus" id="campus" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300">
                    <option value="">Select Campus</option>
                    <option value="Main">Main</option>
                    <option value="Annex">Annex</option>
                </select>
                {{-- college --}}
                <select name="college" id="college" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300">
                    <option value="">Select College</option>
                    <option value="College of Arts and Sciences">College of Arts and Sciences</option>
                    <option value="College of Business and Accountancy">College of Business and Accountancy</option>
                    <option value="College of Criminal Justice Education">College of Criminal Justice Education</option>
                    <option value="College of Education">College of Education</option>
                    <option value="College of Engineering">College of Engineering</option>
                    <option value="College of Hospitality Management">College of Hospitality Management</option>
                    <option value="College of Information Technology">College of Information Technology</option>
                    <option value="College of Nursing">College of Nursing</option>
                    <option value="College of Pharmacy">College of Pharmacy</option>
                    <option value="College of Public Administration">College of Public Administration</option>
                    <option value="College of Science">College of Science</option>
                    <option value="College of Tourism and Hospitality Management">College of Tourism and Hospitality Management</option>
                </select>
                {{-- program --}}
                <select name="program" id="program" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300">
                    <option value="">Select Program</option>
                    <option value="Bachelor of Arts in Communication">Bachelor of Arts in Communication</option>
                    <option value="Bachelor of Arts in English">Bachelor of Arts in English</option>
                    <option value="Bachelor of Arts in Political Science">Bachelor of Arts in Political Science</option>
                    <option value="Bachelor of Arts in Psychology">Bachelor of Arts in Psychology</option>
                    <option value="Bachelor of Science in Accountancy">Bachelor of Science in Accountancy</option>
                    <option value="Bachelor of Science in Business Administration">Bachelor of Science in Business Administration</option>
                    <option value="Bachelor of Science in Criminology">Bachelor of Science in Criminology</option>
                    <option value="Bachelor of Science in Hospitality Management">Bachelor of Science in Hospitality Management</option>
                    <option value="Bachelor of Science in Information Technology">Bachelor of Science in Information Technology</option>
                    <option value="Bachelor of Science in Nursing">Bachelor of Science in Nursing</option>
                    <option value="Bachelor of Science in Pharmacy">Bachelor of Science in Pharmacy</option>
                    <option value="Bachelor of Science in Public Administration">Bachelor of Science in Public Administration</option>
                    <option value="Bachelor of Science in Secondary Education">Bachelor of Science in Secondary Education</option>
                    <option value="Bachelor of Science in Tourism Management">Bachelor of Science in Tourism Management</option>
                    <option value="Bachelor of Science in Elementary Education">Bachelor of Science in Elementary Education</option>
                    <option value="Bachelor of Science in Industrial Technology">Bachelor of Science in Industrial Technology</option>
                    <option value="Bachelor of Science in Information Systems">Bachelor of Science in Information Systems</option>
                    <option value="Bachelor of Science in Office Administration">Bachelor of Science in Office Administration</option>
                    <option value="Bachelor of Science in Entrepreneurship">Bachelor of Science in Entrepreneurship</option>
                    <option value="Bachelor of Science in Real Estate Management">Bachelor of Science in Real Estate Management</option>
                    <option value="Bachelor of Science in Computer Science">Bachelor of Science in Computer Science</option>
                </select>
                {{-- major with NA option --}}
                <select name="major" id="major" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300">
                    <option value="">Select Major</option>
                    <option value="N/A">N/A</option>
                    <option value="General">General</option>
                    <option value="Advertising">Advertising</option>
                    <option value="Broadcasting">Broadcasting</option>
                    <option value="Journalism">Journalism</option>
                    <option value="Public Relations">Public Relations</option>
                    <option value="Literature">Literature</option>
                    <option value="Political Science">Political Science</option>
                    <option value="Psychology">Psychology</option>
                    <option value="Accountancy">Accountancy</option>
                    <option value="Business Administration">Business Administration</option>
                    <option value="Criminology">Criminology</option>
                    <option value="Hospitality Management">Hospitality Management</option>
                    <option value="Information Technology">Information Technology</option>
                    <option value="Nursing">Nursing</option>
                    <option value="Pharmacy">Pharmacy</option>
                    <option value="Public Administration">Public Administration</option>
                    <option value="Secondary Education">Secondary Education</option>
                    <option value="Tourism Management">Tourism Management</option>
                    <option value="Elementary Education">Elementary Education</option>
                    <option value="Industrial Technology">Industrial Technology</option>
                    <option value="Information Systems">Information Systems</option>
                    <option value="Office Administration">Office Administration</option>
                    <option value="Entrepreneurship">Entrepreneurship</option>
                    <option value="Real Estate Management">Real Estate Management</option>
                    <option value="Computer Science">Computer Science</option>
                </select>
                
                <x-primary-button class="w-full md:col-span-2" type="submit">Register</x-primary-button>
                <div class="mt-4 md:col-span-2">
                   Have an account? <a href="{{ route('student.login') }}" class="font-bold">Login</a>
                </div>
            </form>
        </div>
    </main>
@endsection