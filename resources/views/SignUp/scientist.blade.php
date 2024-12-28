<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.8">
    <title>Document</title>

    <!-- Liên kết Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/css/sign.css">
</head>

<body>
    <section class="gradient-custom">
        <div class="container py-2 h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-12 col-lg-9 col-xl-7">
                    <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                        <div class="card-body p-4 p-md-5">
                            <div class="scrollable-form">
                                <form action="{{route('scientist.register')}}" method="POST">
                                    @csrf
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <h3>Registration Form</h3>
                                            <small class="text-danger">(*) là các mục thông tin bắt buộc</small>
                                        </div>
                                        <div class="col-md-6 justify-content-end d-flex align-items-start">
                                            <input data-mdb-ripple-init class="btn btn-primary btn-lg" type="submit"
                                                value="Next" />
                                        </div>
                                    </div>
                                    @if($errors->any())
                                        <div class="alert alert-danger">
                                            {{$errors->first()}}
                                        </div>
                                    @endif
                                    <div class="row mb-3">
                                        <div class="col">
                                            <div class="form-floating">
                                                <input type="text" id="name" name="registration_name"
                                                    class="form-control" value="" placeholder="Name">
                                                <label for="name">Họ và tên
                                                    <small class="text-danger">*</small>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col">
                                            <div class="form-floating">
                                                <input type="date" id="dob" name="registration_dob" class="form-control"
                                                    value="" placeholder="Date of birth">
                                                <label for="dob">Ngày, tháng, năm sinh
                                                    <small class="text-danger">*</small>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col">
                                            <h6 class="mb-2 pb-1">Gender
                                                <small class="text-danger">*</small>
                                            </h6>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="registration_gender"
                                                    id="femaleGender" value="1" checked />
                                                <label class="form-check-label" for="femaleGender">Female</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="registration_gender"
                                                    id="maleGender" value="0" />
                                                <label class="form-check-label" for="maleGender">Male</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col">
                                            <div class="form-floating">
                                                <input type="text" id="pob" name="registration_pob" class="form-control"
                                                    value="" placeholder="Place of birth">
                                                <label for="pob">Nơi sinh
                                                    <small class="text-danger">*</small>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col">
                                            <div class="form-floating">
                                                <input type="text" id="hometown" name="registration_hometown"
                                                    class="form-control" value="" placeholder="Hometown">
                                                <label for="hometown">Quê quán
                                                    <small class="text-danger">*</small>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-floating">
                                                <input type="text" id="ethnicity" name="registration_ethnicity"
                                                    class="form-control" value="" placeholder="Ethnicity">
                                                <label for="ethnicity">Dân tộc
                                                    <small class="text-danger">*</small>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col">
                                            <div class="form-floating">
                                                <input type="text" id="degree" name="registration_highest_degree"
                                                    class="form-control" value="" placeholder="Highest academic degree">
                                                <label for="degree">Học vị cao nhất
                                                    <small class="text-danger">*</small>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-floating">
                                                <input type="text" id="year_degree_award"
                                                    name="registration_year_awarded_degree" class="form-control"
                                                    value="" placeholder="Year of degree award">
                                                <label for="year_degree_award">Năm nhận học vị
                                                    <small class="text-danger">*</small>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-floating">
                                                <input type="text" id="country_degree_award"
                                                    name="registration_country_awarded_degree" class="form-control"
                                                    value="" placeholder="Country of degree award">
                                                <label for="country_degree_award">Nước nhận học vị
                                                    <small class="text-danger">*</small>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col">
                                            <div class="form-floating">
                                                <input type="text" id="title" name="registration_scientific_title"
                                                    class="form-control" value=""
                                                    placeholder="Highest scientific title">
                                                <label for="title">Chức danh khoa học cao nhất
                                                    <small class="text-danger">*</small>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-floating">
                                                <input type="text" id="year_appointment"
                                                    name="registration_year_title_appointment" class="form-control"
                                                    value="" placeholder="Year of appointment">
                                                <label for="year_appointment">Năm bổ nhiệm
                                                    <small class="text-danger">*</small>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col">
                                            <div class="form-floating">
                                                <input type="text" id="position" name="registration_position"
                                                    class="form-control" value=""
                                                    placeholder="Position (current or before retirement)">
                                                <label for="position">Chức vụ (Hiện tại hoặc trước khi nghỉ hưu)
                                                    <small class="text-danger">*</small>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col">
                                            <div class="form-floating">
                                                <input type="text" id="workUnit" name="registration_workplace"
                                                    class="form-control" value=""
                                                    placeholder="Work unit (current or before retirement)">
                                                <label for="workUnit">Đơn vị công tác (Hiện tại hoặc trước khi nghỉ
                                                    hưu)
                                                    <small class="text-danger">*</small>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col">
                                            <div class="form-floating">
                                                <input type="text" id="address" name="registration_address"
                                                    class="form-control" value="" placeholder="Address">
                                                <label for="address">Chỗ ở riêng hoặc địa chỉ liên lạc
                                                    <small class="text-danger">*</small>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col">
                                            <div class="input-group">
                                                <label class="input-group-text">Điện thoại liên hệ</label>
                                                <div class="form-floating">
                                                    <input type="text" id="office_phone"
                                                        name="registration_phone_office" class="form-control" value=""
                                                        placeholder="Office Phone">
                                                    <label for="office_phone">CQ</label>
                                                </div>
                                                <div class="form-floating">
                                                    <input type="text" id="house_phone" name="registration_phone_home"
                                                        class="form-control" value="" placeholder="House Phone">
                                                    <label for="house_phone">NR</label>
                                                </div>
                                                <div class="form-floating">
                                                    <input type="text" id="mobile_phone"
                                                        name="registration_phone_mobile" class="form-control" value=""
                                                        placeholder="Mobile Phone">
                                                    <label for="mobile_phone">DĐ
                                                        <small class="text-danger">*</small>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col">
                                            <div class="form-floating">
                                                <input type="text" id="fax" name="registration_fax" class="form-control"
                                                    value="" placeholder="Fax">
                                                <label for="fax">Fax</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col">
                                            <div class="input-group">
                                                <label class="input-group-text">CCCD</label>
                                                <div class="form-floating">
                                                    <input type="text" id="citizen_id" name="registration_citizen_id"
                                                        class="form-control" value="" placeholder="Citizen ID number">
                                                    <label for="citizen_id">Số CCCD
                                                        <small class="text-danger">*</small>
                                                    </label>
                                                </div>
                                                <div class="form-floating">
                                                    <input type="text" id="date_issue" name="registration_date_issue"
                                                        class="form-control" value="" placeholder="Date of issue">
                                                    <label for="date_issue">Ngày cấp</label>
                                                </div>
                                                <div class="form-floating">
                                                    <input type="text" id="place_issue" name="registration_place_issue"
                                                        class="form-control" value="" placeholder="Place of issue">
                                                    <label for="place_issue">Nơi cấp</label>
                                                </div>
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
    </section>
</body>

</html>