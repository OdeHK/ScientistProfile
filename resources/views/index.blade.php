<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scientist Profile</title>
    @include('style')
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Thanh điều hướng dọc -->
            <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar position-fixed vh-100">
                <div class="d-flex flex-column p-3">
                    <div>
                        <a class="text-dark text-center text-decoration-none" href="/home">
                            <h3>Hồ sơ cá nhân</h3>
                        </a>
                    </div>

                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="#general">Thông tin cơ bản</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="#education">Quá trình đào tạo</a>
                            <!-- <a class="nav-link text-dark" href="#education" data-bs-toggle="collapse"
                                data-bs-target="#educationSubmenu" aria-expanded="false"
                                aria-controls="educationSubmenu">
                                Quá trình đào tạo
                                <span class="ms-2"><i class="bi bi-chevron-down"></i></span>
                            </a> -->

                            <!-- <ul class="collapse list-unstyled ps-4" id="educationSubmenu">
                                <li class="nav-item">
                                    <a class="nav-link text-dark" href="#undergraduate">Đại học</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-dark" href="#postgraduate">Sau đại học</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-dark" href="#language">Ngoại ngữ</a>
                                </li>
                            </ul> -->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="#work_exp">Quá trình công tác</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="#additional">Thông tin bổ sung</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="#participate">Đề tài tham gia</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="#publishedPaper">Công bố khoa học</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="#award">Giải thưởng</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark"
                                href="{{route('scientist.export', ['id' => $scientist->id])}}">Export your CV</a>
                        </li>
                        <hr>
                        <li>
                            <a class="nav-link text-dark" href="{{route('user.logout')}}">Logout</a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Nội dung chính -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 offset-md-3 offset-lg-2">
                <section class="full-screen-section">
                    <div class="container">
                        <h1>Welcome, {{$scientist->name}}</h1>
                    </div>
                    <hr class="fixed-hr">
                </section>

                <section id="general" class="full-screen-section">
                    <div class="container">
                        <h1>Thông tin cơ bản</h1>
                        <div class="form-group mt-3">
                            <div class="row mb-3">
                                <div class="col">
                                    <div class="input-group">
                                        <span class="input-group-text">Họ và tên:</span>
                                        <input type="text" name="person_name" class="form-control"
                                            value="{{$scientist->name}}" placeholder="Name">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="input-group">
                                        <span class="input-group-text">Giới tính:</span>
                                        <input type="text" name="person_gender" class="form-control"
                                            value="{{$scientist->gender == 0 ? 'Nam' : 'Nữ'}}" placeholder="Gender">
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col">
                                    <div class="input-group">
                                        <span class="input-group-text">Ngày, tháng, năm sinh:</span>
                                        <input type="text" name="person_dob" class="form-control"
                                            value="{{$scientist->date_of_birth}}" placeholder="Date of birth">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="input-group">
                                        <span class="input-group-text">Nơi sinh:</span>
                                        <input type="text" name="person_pob" class="form-control"
                                            value="{{$scientist->place_of_birth}}" placeholder="Place of birth">
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col">
                                    <div class="input-group">
                                        <span class="input-group-text">Quê quán:</span>
                                        <input type="text" name="person_hometown" class="form-control"
                                            value="{{$scientist->hometown}}" placeholder="Hometown">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="input-group">
                                        <span class="input-group-text">Dân tộc:</span>
                                        <input type="text" name="person_ethnicity" class="form-control"
                                            value="{{$scientist->ethnicity}}" placeholder="Ethnicity">
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col">
                                    <div class="input-group">
                                        <span class="input-group-text">Học vị cao nhất:</span>
                                        <input type="text" name="person_degree" class="form-control"
                                            value="{{$scientist->highest_degree}}"
                                            placeholder="Highest academic degree">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="input-group">
                                        <span class="input-group-text">Năm, nước nhận học vị:</span>
                                        <input type="text" name="person_degree_award" class="form-control"
                                            value="{{$scientist->year_awarded_degree}}, {{$scientist->country_awarded_degree}}"
                                            placeholder="Year and Country of degree award">
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col">
                                    <div class="input-group">
                                        <span class="input-group-text">Chức danh khoa học cao nhất:</span>
                                        <input type="text" name="person_sci_title" class="form-control"
                                            value="{{$scientist->scientific_title}}"
                                            placeholder="Highest scientific title">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="input-group">
                                        <span class="input-group-text">Năm bổ nhiệm:</span>
                                        <input type="text" name="person_year_appointment" class="form-control"
                                            value="{{$scientist->year_title_appointment}}"
                                            placeholder="Year of appointment">
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="input-group">
                                    <span class="input-group-text">Chức vụ (Hiện tại hoặc trước khi nghỉ hưu):</span>
                                    <input type="text" name="person_position" class="form-control"
                                        value="{{$scientist->position}}"
                                        placeholder="Position (current or before retirement)">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="input-group">
                                    <span class="input-group-text">Đơn vị công tác (Hiện tại hoặc trước khi nghỉ
                                        hưu):</span>
                                    <input type="text" name="person_work_unit" class="form-control"
                                        value="{{$scientist->workplace}}"
                                        placeholder="Work unit (current or before retirement)">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="input-group">
                                    <span class="input-group-text">Chỗ ở riêng hoặc địa chỉ liên lạc:</span>
                                    <input type="text" name="person_address" class="form-control"
                                        value="{{$scientist->address}}" placeholder="Address">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="input-group">
                                    <span class="input-group-text">Điện thoại liên hệ:</span>
                                    <span class="input-group-text">CQ:</span>
                                    <input type="text" name="person_office_phone" class="form-control"
                                        value="{{$scientist->phone_office}}" placeholder="Office Phone">
                                    <span class="input-group-text">NR:</span>
                                    <input type="text" name="person_home_phone" class="form-control"
                                        value="{{$scientist->phone_home}}" placeholder="Home Phone">
                                    <span class="input-group-text">DĐ:</span>
                                    <input type="text" name="person_mobile_phone" class="form-control"
                                        value="{{$scientist->phone_mobile}}" placeholder="Mobile Phone">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col">
                                    <div class="input-group">
                                        <span class="input-group-text">Fax:</span>
                                        <input type="text" name="person_fax" class="form-control"
                                            value="{{$scientist->fax}}" placeholder="Fax">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="input-group">
                                        <span class="input-group-text">Email:</span>
                                        <input type="text" name="person_email" class="form-control"
                                            value="{{$user->email}}" placeholder="Email">
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="input-group">
                                    <span class="input-group-text">CCCD:</span>
                                    <input type="text" name="person_citizen_id" class="form-control"
                                        value="{{$scientist->citizen_id}}" placeholder="Citizen ID number">
                                    <span class="input-group-text">Ngày cấp:</span>
                                    <input type="text" name="person_date_issue" class="form-control"
                                        value="{{$scientist->date_issue}}" placeholder="Date of issue">
                                    <span class="input-group-text">Nơi cấp:</span>
                                    <input type="text" name="person_place_issue" class="form-control"
                                        value="{{$scientist->place_issue}}" placeholder="Place of issue">
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="fixed-hr">
                </section>

                <section id="education" class="full-screen-section">
                    <div class="container">
                        <div class="content-header">
                            <div class="row align-text-center">
                                <div class="col-sm-8">
                                    <h1>Quá trình đào tạo</h1>
                                </div>
                                <div class="col-sm-4 justify-content-center d-flex align-items-center">
                                    <a href="#add_Education">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#addEducation">
                                            <i class="bi bi-plus-circle"></i> Add
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="content-body">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Bậc học</th>
                                        <th>Nơi đào tạo</th>
                                        <th>Ngành/Chuyên ngành</th>
                                        <th>Chi tiết</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($educations))
                                        @foreach ($educations as $education)
                                            <tr>
                                                <td>{{ $education->type == 'undergraduate' ? 'Đại học' : 'Sau đại học' }}</td>
                                                <td>{{ $education->institution }}</td>
                                                <td>{{ $education->field_of_study }}</td>
                                                <td>
                                                    @if ($education->type === 'undergraduate')
                                                        Hệ đào tạo: {{ $education->undergraduate->first()->training_system }} <br>
                                                        Nước: {{ $education->undergraduate->first()->training_country }} <br>
                                                        Năm tốt nghiệp: {{$education->undergraduate->first()->graduation_year}}
                                                    @else
                                                        Level: {{ ucfirst($education->postgraduate->first()->level) }} <br>
                                                        Graduation Year: {{$education->postgraduate->first()->graduation_year}} <br>
                                                        Thesis: {{ $education->postgraduate->first()->thesis_title }}
                                                    @endif
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            <div class="d-flex align-items-end">
                                {!! $educations->appends(request()->query())->fragment('educations')->links() !!}
                            </div>
                        </div>
                    </div>
                    <hr class="fixed-hr">
                </section>

                <section id="work_exp" class="full-screen-section">
                    <div class="container">
                        <div class="content-header">
                            <div class="row align-text-center">
                                <div class="col-sm-8">
                                    <h1>Quá trình công tác</h1>
                                </div>
                                <div class="col-sm-4 justify-content-center d-flex align-items-center">
                                    <a href="#add_WorkExp">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#addWorkExp">
                                            <i class="bi bi-plus-circle"></i> Add
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="content-body">
                            <table class="table table-hover">
                                <thead class="text-center align-middle">
                                    <tr>
                                        <th>Từ</th>
                                        <th>Đến</th>
                                        <th>Đơn vị công tác</th>
                                        <th>Công việc đảm nhiệm</th>
                                    </tr>
                                </thead>
                                <tbody class="align-middle">
                                    @if (isset($workExps))
                                        @foreach ($workExps as $exp)
                                            <tr class="text-center">
                                                <td>{{\Carbon\Carbon::parse($exp['start_date'])->format('d/m/Y')}}</td>
                                                <td>{{$exp['end_date'] ? \Carbon\Carbon::parse($exp['end_date'])->format('d/m/Y') : 'Now'}}
                                                </td>
                                                <td>{{$exp['institution']}}</td>
                                                <td>{{$exp['position']}}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr class="fixed-hr">
                </section>

                <section id="additional" class="full-screen-section">
                    <div class="container">
                        <h1>Thông tin bổ sung</h1>
                        <div class="form-group mt-3">
                            <div class="row mb-3">
                                <div class="input-group">
                                    <span class="input-group-text">Mã số thuế:</span>
                                    <input type="text" name="tax_id" class="form-control" value=""
                                        placeholder="Tax indentification number">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="input-group">
                                    <span class="input-group-text">Số tài khoản ngân hàng:</span>
                                    <input type="text" name="bank_account" class="form-control" value=""
                                        placeholder="Bank account number">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="input-group">
                                    <span class="input-group-text">Ngân hàng:</span>
                                    <input type="text" name="bank_name" class="form-control" value=""
                                        placeholder="Bank">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="input-group">
                                    <span class="input-group-text">Chi nhánh:</span>
                                    <input type="text" name="bank_branch" class="form-control" value=""
                                        placeholder="Bank branch">
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="fixed-hr">
                </section>

                <section id="participate" class="full-screen-section">
                    <div class="container">
                        <div class="content-header">
                            <div class="row align-text-center">
                                <div class="col-sm-8">
                                    <h1>Đề tài tham gia</h1>
                                </div>
                                <div class="col-sm-4 justify-content-center d-flex align-items-center">
                                    <a href="#add_project">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#addProject">
                                            <i class="bi bi-plus-circle"></i> Add
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <table class="table table-hover">
                            <thead class="align-middle">
                                <tr class="text-center">
                                    <th>TT</th>
                                    <th>Tên đề tài nghiên cứu</th>
                                    <th>Năm bắt đầu</th>
                                    <th>Năm nghiệm thu</th>
                                    <th>Đề tài cấp (NN, Bộ, ngành, trường)</th>
                                    <th>Chức vụ</th>
                                </tr>
                            </thead>
                            <tbody class="align-middle">
                                @if(isset($projects))
                                    @foreach($projects as $index => $project)
                                        <tr class="text-center">
                                            <td>{{$index + 1}}</td>
                                            <td>{{$project->title}}</td>
                                            <td>{{$project->start_year}}</td>
                                            <td>{{$project->end_year}}</td>
                                            <td>{{$project->level}}</td>
                                            <td>{{$project->position}}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <hr class="fixed-hr">
                </section>

                <section id="publishedPaper" class="full-screen-section">
                    <div class="container">
                        <div class="content-header">
                            <div class="row align-text-center">
                                <div class="col-sm-8">
                                    <h1>Công bố khoa học</h1>
                                </div>
                                <div class="col-sm-4 justify-content-center d-flex align-items-center">
                                    <a href="#add_publishedPaper">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#addPublishedPaper">
                                            <i class="bi bi-plus-circle"></i> Add
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="content-body" id="publishedPapersTable">
                            <table class="table table-hover">
                                <thead class="text-center align-middle">
                                    <tr>
                                        <th>TT</th>
                                        <th>Tên công trình</th>
                                        <th>Tác giả</th>
                                        <th>Năm công bố</th>
                                        <th>ISSN</th>
                                        <th>Tên tạp chí</th>
                                    </tr>
                                </thead>
                                <tbody class="align-middle">
                                    @if (isset($publishedPapers))
                                        @foreach ($publishedPapers as $index => $paper)
                                            <tr>
                                                <td class="text-center">{{$index + 1}}</td>
                                                <td>
                                                    @if(isset($paper['doi']))
                                                        <a href="https://doi.org/{{$paper['doi']}}" target="_blank">
                                                            {{$paper['title']}}
                                                        </a>
                                                    @else
                                                        <a href="{{$paper['url']}}" target="_blank">
                                                            {{$paper['title']}}
                                                        </a>
                                                    @endif
                                                </td>
                                                <td>{{$paper['authors']}}</td>
                                                <td class="text-center">{{$paper['publication_date']}}</td>
                                                <td class="text-center">{{$paper['issn']}}</td>
                                                <td>{{$paper['publisher']}}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            <div class="d-flex align-items-end">
                                {!! $publishedPapers->appends(request()->query())->fragment('publishedPaper')->links() !!}
                            </div>
                        </div>
                    </div>
                    <hr class="fixed-hr">
                </section>

                <section id="award" class="full-screen-section">
                    <div class="container">
                        <h1>Giải thưởng</h1>


                    </div>
                    <hr class="fixed-hr">
                </section>
            </main>

            <!-- Bootstrap Modal: Add Published Paper Modal -->
            <div class="modal fade" id="addPublishedPaper" tabindex="-1" aria-labelledby="addPublishedPaper"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content fixed-modal">
                        <div class="modal-header">
                            <div class="container-fluid">

                                <div class="row">
                                    <div class="col-2 d-flex justify-content-start align-items-center">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="col-8 text-center">
                                        <h5 class="modal-title" id="addArticleModalLabel">Thêm công bố khoa học</h5>
                                    </div>
                                    <div class="col-2 d-flex justify-content-end align-items-center">
                                        <button class="btn btn-primary" id="add-papers-btn"
                                            onclick="submitSelectedPapers()">Add</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal-body">
                            <form class="d-flex">
                                @csrf
                                <div class="input-group mb-3">
                                    <input class="form-control" type="text" aria-label="Search" name="query"
                                        id="search-query" placeholder="Enter DOI or Link website">
                                    <button class="btn btn-outline-success" type="button" id="search-btn">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </form>
                            <div id="search-results" class="mt-4">
                            </div>

                        </div>
                        <div class="modal-footer">
                            <div id="pagination"></div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Bootstrap Modal: Add Work Exp Modal -->
            <div class="modal fade" id="addWorkExp" tabindex="-1" aria-labelledby="addWorkExp" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content fixed-modal">
                        <div class="modal-header">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-2 d-flex justify-content-start align-items-center">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="col-8 text-center">
                                        <h5 class="modal-title" id="addArticleModalLabel">Thêm quá trình công tác</h5>
                                    </div>
                                    <div class="col-2 d-flex justify-content-end align-items-center">
                                        <button class="btn btn-primary" id="add_workExp_btn" onclick="">Add</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal-body">
                            <form class="form-group" id="addWorkExpForm">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col">
                                        <div class="input-group">
                                            <span class="input-group-text">Từ:</span>
                                            <input type="date" name="workExp_start_date" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="input-group">
                                            <span class="input-group-text">Đến:</span>

                                            <!-- Select option -->
                                            <select name="workExp_end_date" class="form-control" id="end_date_select"
                                                onchange="toggleEndDate()">
                                                <option value="null">Hiện tại</option>
                                                <option value="">Ngày khác</option>
                                            </select>

                                            <!-- Input date, sẽ chỉ hiển thị nếu chọn "Ngày khác" -->
                                            <input type="date" name="workExp_end_date_selected" class="form-control"
                                                id="specific_date" style="display: none;">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <div class="input-group">
                                            <span class="input-group-text">Nơi công tác:</span>
                                            <input type="text" name="workExp_institution" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <div class="input-group">
                                            <span class="input-group-text">Chức danh:</span>
                                            <input type="text" name="workExp_position" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bootstrap Modal: Add Education Modal -->
            <div class="modal fade" id="addEducation" tabindex="-1" aria-labelledby="addEducation" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content fixed-modal">
                        <div class="modal-header">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-2 d-flex justify-content-start align-items-center">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="col-8 text-center">
                                        <h5 class="modal-title" id="addArticleModalLabel">Thêm quá trình đào tạo</h5>
                                    </div>
                                    <div class="col-2 d-flex justify-content-end align-items-center">
                                        <button class="btn btn-primary" id="add_education_btn" onclick="">Add</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal-body">
                            <form class="form-group" id="addEducationForm">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col">
                                        <div class="input-group">
                                            <span class="input-group-text">Bậc học vấn</span>
                                            <select name="education_type" id="education_type" class="form-select">
                                                <option value="undergraduate">Đại học</option>
                                                <option value="postgraduate">Sau đại học</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col">
                                        <div class="input-group">
                                            <span class="input-group-text">Ngành/Chuyên ngành:</span>
                                            <input type="text" name="education_field_of_study" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col">
                                        <div class="input-group">
                                            <span class="input-group-text">Nơi đào tạo:</span>
                                            <input type="text" name="education_institution" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <!-- Fields for Undergraduate -->
                                <div id="undergraduateFields" class="education-fields" style="display: show;">
                                    <div class="row mb-3">
                                        <div class="col">
                                            <div class="input-group">
                                                <span class="input-group-text">Hệ đào tạo:</span>
                                                <input type="text" name="undergraduate_system" id="undergraduate_system"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col">
                                            <div class="input-group">
                                                <span class="input-group-text">Nước đào tạo:</span>
                                                <input type="text" name="undergraduate_country"
                                                    id="undergraduate_country" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="input-group">
                                                <span class="input-group-text">Năm tốt nghiệp:</span>
                                                <input type="number" name="undergraduate_graduation_year"
                                                    id="undergraduate_graduation_year" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Fields for Postgraduate -->
                                <div id="postgraduateFields" class="education-fields" style="display: none;">
                                    <div class=" row mb-3">
                                        <div class="col">
                                            <div class="input-group">
                                                <span class="input-group-text">Bậc học:</span>
                                                <select name="postgraduate_level" id="postgraduate_level"
                                                    class="form-select">
                                                    <option value="master">Thạc sĩ</option>
                                                    <option value="phd">Tiến sĩ</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row mb-3">
                                        <div class="col">
                                            <div class="input-group">
                                                <span class="input-group-text">Tên luận văn:</span>
                                                <input type="text" name="postgraduate_thesis" id="postgraduate_thesis"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="input-group">
                                                <span class="input-group-text">Năm tốt nghiệp:</span>
                                                <input type="number" name="postgraduate_graduation_year"
                                                    id="postgraduate_graduation_year" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bootstrap Modal: Add Project Modal -->
            <div class="modal fade" id="addProject" tabindex="-1" aria-labelledby="addProject" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content fixed-modal">
                        <div class="modal-header">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-2 d-flex justify-content-start align-items-center">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="col-8 text-center">
                                        <h5 class="modal-title" id="addArticleModalLabel">Thêm dự án đang tham gia</h5>
                                    </div>
                                    <div class="col-2 d-flex justify-content-end align-items-center">
                                        <button class="btn btn-primary" id="add_project_btn" onclick="">Add</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal-body">
                            <form class="form-group" id="addProjectForm">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col">
                                        <div class="input-group">
                                            <span class="input-group-text">Tên đề tài:</span>
                                            <input type="string" name="project_title" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <div class="input-group">
                                            <span class="input-group-text">Từ:</span>
                                            <input type="string" name="project_start_year" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="input-group">
                                            <span class="input-group-text">Đến:</span>
                                            <input type="string" name="project_end_year" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <div class="input-group">
                                            <span class="input-group-text">Đề tài cấp:</span>
                                            <input type="text" name="project_level" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="input-group">
                                            <span class="input-group-text">Chức vụ:</span>
                                            <input type="text" name="project_position" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('script')
</body>

</html>