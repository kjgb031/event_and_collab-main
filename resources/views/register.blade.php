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

                    //Bagac
                    "Bagac": {
                        "colleges": ["College of Education", "College of Technology"],

                        "programs": {
                            "College of Education": ["Bachelor of Elementary Education"],
                            "College of Technology": ["Bachelor of Science in Industrial Technology"]
                        },

                        "majors": {
                            "Bachelor of Elementary Education": ["Not Applicable"],
                            "Bachelor of Science in Industrial Technology": ["Electrical Technology",
                                "Welding and Fabrication Technology"
                            ]

                        }
                    },

                    "Dinalupihan": {
                        "colleges": ["College of Education"],

                        "programs": {
                            "College of Education": ["Bachelor of Early Childhood Education",
                                "Bachelor of Elementary Education", "Bachelor of Secondary Education"
                            ]

                        },

                        "majors": {
                            "Bachelor of Early Childhood Education": ["Not Applicable"],
                            "Bachelor of Elementary Education": ["Not Applicable"],
                            "Bachelor of Secondary Education": ["Mathematics", "Science"]
                        },
                    },

                    //Main
                    "Main": {
                        "colleges": ["College of Allied Health Sciences", "College of Computer Studies",
                            "College of Arts and Sciences", "College of Business and Accountancy",
                            "College of Engineering and Architecture", "College of Technology"
                        ],

                        "programs": {
                            "College of Allied Health Sciences": ["Bachelor of Science in Nursing",
                                "Bachelor of Science in Midwifery",
                                "Bachelor of Public Health"
                            ],
                            "College of Computer Studies": ["Bachelor of Computer Science",
                                "Bachelor of Science in Entertainment and Multimedia Computing",
                                "Bachelor of Science in Information Technology", "Bachelor of Science in Data Science"
                            ],
                            "College of Arts and Sciences": ["Bachelor of Arts in Communication"],
                            "College of Business and Accountancy": ["Bachelor of Science in Hospitality Management",
                                "Bachelor of Science in Tourism Management"
                            ],
                            "College of Engineering and Architecture": ["Bachelor of Science in Electrical Engineering",
                                "Bachelor of Science in Electronics Engineering",
                                "Bachelor of Science in Industrial Engineering",
                                "Bachelor of Science in Mechanical Engineering", "Bachelor of Science in Architecture",
                                "Bachelor of Science in Civil Engineering"

                            ],
                            "College of Technology": ["Bachelor of Technical Vocational Teacher Education",
                                "Bachelor of Science in Industrial Technology"
                            ]
                        },

                        "majors": {
                            "Bachelor of Science in Nursing": [],
                            "Bachelor of Science in Midwifery": [],
                            "Bachelor of Public Health": [],
                            "Bachelor of Computer Science": ["Network and Data Communication", "Software Development"],
                            "Bachelor of Science in Entertainment and Multimedia Computing": ["Digital Animation Technology",
                                "Game Development"
                            ],
                            "Bachelor of Science in Information Technology": ["Network and Web Application"],
                            "Bachelor of Science in Data Science": [],
                            "Bachelor of Arts in Communication": ["Creative and Performing Arts", "New Media Track"],
                            "Bachelor of Science in Hospitality Management": [],
                            "Bachelor of Science in Tourism Management": [],
                            "Bachelor of Science in Electrical Engineering": [],
                            "Bachelor of Science in Electronics Engineering": [],
                            "Bachelor of Science in Industrial Engineering": [],
                            "Bachelor of Science in Mechanical Engineering": [],
                            "Bachelor of Science in Architecture": [],
                            "Bachelor of Science in Civil Engineering": ["Construction Engineering and Management",
                                "Structural Engineering"
                            ],
                            "Bachelor of Technical Vocational Teacher Education": ["Animation", "Automotive Technology",
                                "Civil and Construction Technology", "Drafting Technology", "Electrical Technology",
                                "Food and Service Management", "Garments, Fashion and Design",
                                "Hotel and Restaurant Services", "Mechanical Technology",
                                "Welding and Fabrication Technology"
                            ],
                            "Bachelor of Science in Industrial Technology": ["Automotive Technology", "Drafting Technology",
                                "Electrical Technology", "Electronics Technology", "Food and Service Technology",
                                "Garments, Fashion and Design", "Heating, Ventilating and Air Conditioning Technology",
                                "Mechanical Technology", "Welding and Fabrication Technology"
                            ]
                        },
                    }

                    "Orani": {
                        "colleges": ["College of Agriculture and Fisheries", "College of Education"],

                        "programs": {
                            "College of Agriculture and Fisheries": ["Bachelor of Science in Fisheries"],
                            "College of Education": ["Bachelor of Physical Education",
                                "Bachelor of Science in Exercise and Sports Sciences",
                                "Bachelor of Technology and Livelihood Education"
                            ]
                        },

                        "majors": {
                            "Bachelor of Science in Fisheries": ["Not Applicable"],
                            "Bachelor of Physical Education": ["Not Applicable"],
                            "Bachelor of Science in Exercise and Sports Sciences": ["Fitness and Sports Coaching",
                                "Fitness and Sports Management"
                            ],
                            "Bachelor of Technology and Livelihood Education": ["Industrial Arts"]

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
