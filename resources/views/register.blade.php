@extends('layouts.guest')
{{-- capitalize $role + login --}}
@section('title')
    Student Register
@endsection

@section('content')
    <main class="container flex items-center justify-center min-h-screen mx-auto">
        <div class="flex flex-col items-center justify-center max-w-xl px-6 py-12 mx-auto bg-white shadow-md rounded-lg">
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
                <!--To be removed-->
                <hr class="md:col-span-2">
                <x-text-input name="guardian_name" label="Guardian Name" type="text" required />
                <x-text-input name="guardian_contact" label="Guardian Contact" type="text" required />
                <hr class="md:col-span-2">
                <!-- Campus select field -->
                <select name="campus" id="campus"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300">
                    <option value="">Select Campus</option>
                    <option value="Abucay">Abucay</option>
                    <option value="Balanga">Balanga</option>
                    <option value="Bagac">Bagac</option>
                    <option value="Dinalupihan">Dinalupihan</option>
                    <option value="Main">Main</option>
                    <option value="Orani">Orani</option>
                </select>

                <!-- College select field (will be populated dynamically) -->
                <select name="college" id="college"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300">
                    <option value="">Select College</option>
                </select>

                <!-- Program select field (will be populated dynamically) -->
                <select name="program" id="program"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300">
                    <option value="">Select Program</option>
                </select>

                <!-- Major select field (will be populated dynamically) -->
                <select name="major" id="major"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300">
                    <option value="">Select Major</option>
                </select>

                <x-primary-button class="w-full md:col-span-2" type="submit">Sign-Up</x-primary-button>
                <div class="mt-4 md:col-span-2">
                    Have an account? <a href="{{ route('student.login') }}" class="font-bold">Login</a>
                </div>
            </form>

            <script>
                // Hardcoded campus data for demonstration purposes
                const campusData = {

                        //Abucay
                        "Abucay": {
                            "colleges": ["College of Agriculture and Fisheries ", "College of Education",
                                "Institute Of Agricultural And Biosystems Engineering"
                            ],

                            "programs": {
                                "College of Agriculture and Fisheries": ["Bachelor of Science in Agriculture"],
                                "College of Education": ["Bachelor of Technical-Vocational Teacher Education"],
                                "Institute Of Agricultural And Biosystems Engineering": [
                                    "Bachelor of Science in Agricultural and Biosystems Engineering"
                                ]
                            },

                            "majors": {
                                "Bachelor of Science in Agriculture": ["Animal Science", "Crop Science"],
                                "Bachelor of Technical-Vocational Teacher Education": ["Agricultural Crops Production",
                                    "Animal Production"
                                ],
                                "Bachelor of Science in Agricultural and Biosystems Engineering": ["Not Applicable"]
                            }
                        },

                        //Balanga
                        "Balanga": {
                            "colleges": ["College of Business and Accountancy", "College of Education",
                                "College of Social and Behavioral Sciences", "Institute of Public Administration and Governance"
                            ],

                            "programs": {
                                "College of Business and Accountancy": ["Bachelor of Science in Accountancy",
                                    "Bachelor of Science in Business Administration"
                                ],
                                "College of Education": ["Bachelor of Secondary Education"],
                                "College of Social and Behavioral Sciences": ["Bachelor of Arts in Psychology",
                                    "Bachelor of Science in Psychology"
                                ],
                                "Institute of Public Administration and Governance": ["Bachelor of Public Administration"]
                            },

                            "majors": {
                                "Bachelor of Science in Accountancy": ["Not Applicable"],
                                "Bachelor of Science in Business Administration": ["Human Resource Management",
                                    "Marketing Management", "Operations Management"
                                ],
                                "Bachelor of Secondary Education": ["English", "Filipino", "Social Studies"],
                                "Bachelor of Arts in Psychology": ["Not Applicable"],
                                "Bachelor of Science in Psychology": ["Not Applicable"],
                                "Bachelor of Public Administration": ["Not Applicable"]
                            }
                        },

                        "Bagac": {
                            "colleges": ["College of Health Sciences", "College of Nursing"],

                            "programs": {
                                "College of Health Sciences": ["Bachelor of Science in Nursing",
                                    "Bachelor of Science in Health Sciences"
                                ],
                                "College of Nursing": ["Bachelor of Science in Nursing", "Bachelor of Science in Health Sciences"]
                            },

                            "majors": {
                                "Bachelor of Science in Nursing": ["Nursing", "Health Sciences"],
                                "Bachelor of Science in Health Sciences": ["Health Sciences", "Health Administration"],
                                "Bachelor of Science in Nursing": ["Nursing", "Health Sciences"],
                                "Bachelor of Science in Health Sciences": ["Health Sciences", "Health Administration"]
                            }
                        },

                        "Dinalupihan": {
                            "colleges": ["College of Arts and Sciences", "College of Business and Entrepreneurship"],

                            "programs": {
                                "College of Arts and Sciences": ["Bachelor of Arts in Communication",
                                    "Bachelor of Arts in English"
                                ],
                                "College of Business and Entrepreneurship": ["Bachelor of Science in Business Administration",
                                    "Bachelor of Science in Entrepreneurship"
                                ]
                            }
                        }
                    },

                    "majors": {
                        "Bachelor of Arts in Communication": ["Broadcasting", "Journalism"],
                        "Bachelor of Arts in English": ["Creative Writing", "Literature"],
                        "Bachelor of Science in Business Administration": ["Management", "Marketing"],
                        "Bachelor of Science in Entrepreneurship": ["Entrepreneurship", "Small Business Management"]
                    },

                    "Main": {
                        "colleges": ["College of Arts and Sciences", "College of Business and Entrepreneurship"],

                        "programs": {
                            "College of Arts and Sciences": ["Bachelor of Arts in Communication",
                                "Bachelor of Arts in English"
                            ],
                            "College of Business and Entrepreneurship": [
                                "Bachelor of Science in Business Administration",
                                "Bachelor of Science in Entrepreneurship"
                            ]
                        },

                        "majors": {
                            "Bachelor of Arts in Communication": ["Broadcasting", "Journalism"],
                            "Bachelor of Arts in English": ["Creative Writing", "Literature"],
                            "Bachelor of Science in Business Administration": ["Management", "Marketing"],
                            "Bachelor of Science in Entrepreneurship": ["Entrepreneurship", "Small Business Management"]
                        },

                        "Orani": {
                            "colleges": ["College of Arts and Sciences", "College of Business and Entrepreneurship"],

                            "programs": {
                                "College of Arts and Sciences": ["Bachelor of Arts in Communication",
                                    "Bachelor of Arts in English"
                                ],
                                "College of Business and Entrepreneurship": [
                                    "Bachelor of Science in Business Administration",
                                    "Bachelor of Science in Entrepreneurship"
                                ]
                            },

                            "majors": {
                                "Bachelor of Arts in Communication": ["Broadcasting", "Journalism"],
                                "Bachelor of Arts in English": ["Creative Writing", "Literature"],
                                "Bachelor of Science in Business Administration": ["Management", "Marketing"],
                                "Bachelor of Science in Entrepreneurship": ["Entrepreneurship",
                                    "Small Business Management"
                                ]
                            }
                        }
                    }
                };

                // Function to populate college field based on selected campus
                function populateCollege(campus) {
                    const collegeSelect = document.getElementById("college");
                    collegeSelect.innerHTML = "";
                    collegeSelect.innerHTML += "<option value=''>Select College</option>";
                    if (campusData[campus]) {
                        campusData[campus].colleges.forEach(college => {
                            collegeSelect.innerHTML += `<option value='${college}'>${college}</option>`;
                        });
                    }
                }

                // Function to populate program field based on selected college
                function populateProgram(campus, college) {
                    const programSelect = document.getElementById("program");
                    programSelect.innerHTML = "";
                    programSelect.innerHTML += "<option value=''>Select Program</option>";
                    if (campusData[campus] && campusData[campus].programs[college]) {
                        campusData[campus].programs[college].forEach(program => {
                            programSelect.innerHTML += `<option value='${program}'>${program}</option>`;
                        });
                    }
                }

                // Function to populate major field based on selected program
                function populateMajor(campus, program) {
                    const majorSelect = document.getElementById("major");
                    majorSelect.innerHTML = "";
                    majorSelect.innerHTML += "<option value=''>Select Major</option>";
                    if (campusData[campus] && campusData[campus].majors[program]) {
                        campusData[campus].majors[program].forEach(major => {
                            majorSelect.innerHTML += `<option value='${major}'>${major}</option>`;
                        })
                    }
                }

                // Event listeners for campus, college, program, and major fields
                const campusSelect = document.getElementById("campus");
                const collegeSelect = document.getElementById("college");
                const programSelect = document.getElementById("program");
                const majorSelect = document.getElementById("major");

                campusSelect.addEventListener("change", () => {
                    const selectedCampus = campusSelect.value;
                    populateCollege(selectedCampus);
                });

                collegeSelect.addEventListener("change", () => {
                    const selectedCampus = campusSelect.value;
                    const selectedCollege = collegeSelect.value;
                    populateProgram(selectedCampus, selectedCollege);
                });

                programSelect.addEventListener("change", () => {
                    const selectedCampus = campusSelect.value;
                    const selectedProgram = programSelect.value;
                    populateMajor(selectedCampus, selectedProgram);
                });

                // Initial population of fields
                populateCollege(campusSelect.value);
                populateProgram(campusSelect.value, collegeSelect.value);
                populateMajor(campusSelect.value, programSelect.value);
            </script>
        </div>
    </main>
@endsection
