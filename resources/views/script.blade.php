<!-- Liên kết Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
    document.getElementById('addPublishedPaper').addEventListener('hidden.bs.modal', function () {
        clearModal();
    });

    let isLoadingNextPage = true;
    let nextPageToLoad = null;

    let selectedPapers = [];

    // Lắng nghe sự kiện nhấn phím Enter trong ô tìm kiếm
    document.getElementById('search-query').addEventListener('keypress', function (event) {
        if (event.key === 'Enter') {
            event.preventDefault();  // Ngừng hành động mặc định của Enter (không gửi form)
            document.getElementById('search-btn').click();  // Gọi sự kiện click khi nhấn Enter
        }
    });

    // Lắng nghe sự kiện click của nút tìm kiếm
    document.getElementById('search-btn').addEventListener('click', function (e) {
        e.preventDefault(); // Ngăn hành vi mặc định của form

        const query = document.getElementById('search-query').value;
        const paginationDiv = document.getElementById('pagination');

        if (query) {
            selectedPapers = [];
            sessionStorage.removeItem('selectedPapers');
            const page = isDoiOrURL(query) ? null : 1;
            // Gửi AJAX request đến controller
            loadPage(query, page);
        }
    });


    function isDoiOrURL(query) {
        const doiRegex = /^10\.\d{4,9}\/\S+$/;

        const urlRegex = /^(http:\/\/|https:\/\/).+/;

        return doiRegex.test(query) || urlRegex.test(query);
    }

    function loadPage(query, page) {
        const paginationDiv = document.getElementById('pagination');
        const resultsDiv = document.getElementById('search-results');

        const isURL = isDoiOrURL(query);

        if (!isURL) {
            // Using cache before call API
            const cacheKey = `search-${query}-page-${page}`;
            const cacheData = sessionStorage.getItem(cacheKey);

            if (cacheData && isLoadingNextPage) {
                const data = JSON.parse(cacheData);
                const startIndex = data.startIndex;
                displayResults(data.papers, startIndex);
                setupPagination(paginationDiv, query, data.totalPages, page);

                restoreSelectedPapers(data.papers);

                loadNextPage(query, page + 1);

            }
            else {
                const url = new URL('{{ route('publishedpaper.search_title') }}'); // URL của route
                url.searchParams.append('query', query);
                url.searchParams.append('page', page);

                fetch(url, {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        resultsDiv.innerHTML = ''; // Clear previous results

                        // Kiểm tra nếu có lỗi
                        if (data.error) {
                            resultsDiv.innerHTML = `<p class="text-danger">${data.error}</p>`;
                            return;
                        }

                        if (data.papers.length > 0) {
                            const startIndex = (page - 1) * data.perPage;
                            displayResults(data.papers, startIndex);

                            // Cache data
                            data.startIndex = startIndex;
                            sessionStorage.setItem(cacheKey, JSON.stringify(data));

                            // Pagination
                            if (paginationDiv && data.total && data.perPage) {
                                const totalPages = Math.ceil(data.total / data.perPage);
                                setupPagination(paginationDiv, query, totalPages, page);
                            }

                            document.getElementById('add-papers-btn').disabled = false;

                            if (page < Math.ceil(data.total / data.perPage)) {
                                loadNextPage(query, page + 1);
                            }
                        } else {
                            resultsDiv.innerHTML = '<p>No results found.</p>';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }
        }
        else {
            fetch('{{route('publishedpaper.search_url')}}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    query: query
                })
            })
                .then(response => response.json())
                .then(data => {
                    resultsDiv.innerHTML = '';

                    if (data.error) {
                        resultsDiv.innerHTML = `<p class="text-danger">${data.error}</p>`;
                        return;
                    }

                    if (data.papers.length > 0) {
                        displayResults(data.papers, 0);
                    }
                    else {
                        resultsDiv.innerHTML = '<p>No results found.</p>';
                    }

                    if (paginationDiv) {
                        paginationDiv.innerHTML = '';
                    }
                })
                .catch(error => {
                    console.error('Error: ', error);
                })
        }
    }

    function displayResults(papers, startIndex) {

        const resultsDiv = document.getElementById('search-results');

        resultsDiv.innerHTML = '';

        papers.forEach((paper, index) => {
            const paperValue = JSON.stringify(paper);
            const paperIndex = startIndex + index;

            const resultItem = document.createElement('div');
            resultItem.classList.add('result-item', 'mb-3');

            resultsDiv.innerHTML += `
                                <div class="row">
                                    <div class="col-sm-1 align-content-center d-flex justify-content-center">
                                        <input type="checkbox" id="paper-${startIndex + index}" name="add_papers[]" value='${paperValue}' 
                                        onchange="selectingPaper(this)">
                                    </div>
                                    <div class="col">
                                        <label for="paper-${startIndex + index}">
                                            <a href="https://doi.org/${paper.doi}" target="_blank">
                                                <strong class="text-primary">${paper.title}</strong>
                                            </a>
                                        </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-1 align-content-center d-flex justify-content-center">
                                    </div>
                                    <div class="col">
                                        ${paper.authors} - ${paper.publisher}, ${paper.published_date ? paper.published_date : 'No publication date'} 
                                    </div>
                                </div>
                                `;
            resultsDiv.appendChild(resultItem);
        });
    }

    function loadNextPage(query, nextPage) {
        const cacheKey = `search-${query}-page-${nextPage}`;

        if (!sessionStorage.getItem(cacheKey)) {

            if (isLoadingNextPage) {

                isLoadingNextPage = false;

                const url = new URL('{{ route('publishedpaper.search_title') }}'); // URL của route
                url.searchParams.append('query', query);
                url.searchParams.append('page', nextPage);

                fetch(url, {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.papers.length > 0) {
                            data.startIndex = (nextPage - 1) * data.perPage;
                            sessionStorage.setItem(cacheKey, JSON.stringify(data));
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching next page data: ', error);
                    })
                    .finally(() => {
                        isLoadingNextPage = true;
                        if (nextPageToLoad) {
                            loadPage(query, nextPageToLoad);
                            nextPageToLoad = null;
                        }
                    });
            }
        }
    }

    function setupPagination(paginationDiv, query, totalPages, currentPage = 1) {
        paginationDiv.innerHTML = '';

        // Previous Page Button
        const prevPageBtn = document.createElement('button');
        prevPageBtn.innerHTML = '<i class="bi bi-caret-left-fill"></i>';
        prevPageBtn.classList.add('btn', 'btn-outline-primary', 'mx-1');
        prevPageBtn.disabled = currentPage === 1;
        prevPageBtn.addEventListener('click', () => loadPage(query, currentPage - 1));
        paginationDiv.appendChild(prevPageBtn);

        // Current Page
        const currentPageSpan = document.createElement('span');
        currentPageSpan.textContent = `Trang ${currentPage}`;
        currentPageSpan.classList.add('mx-3', 'fw-bold', 'align-text-center');
        paginationDiv.appendChild(currentPageSpan);

        // Next Page Button
        const nextPageBtn = document.createElement('button');
        nextPageBtn.innerHTML = '<i class="bi bi-caret-right-fill"></i>';
        nextPageBtn.classList.add('btn', 'btn-outline-primary', 'mx-1');
        nextPageBtn.disabled = currentPage === totalPages;
        nextPageBtn.addEventListener('click', () => {
            if (isLoadingNextPage) {
                loadPage(query, currentPage + 1)
            }
            else {
                nextPageToLoad = currentPage + 1;
            }
        });
        paginationDiv.appendChild(nextPageBtn);
    }



    // Hàm xử lý khi checkbox thay đổi trạng thái
    function selectingPaper(checkbox) {
        const paperValue = JSON.parse(checkbox.value); // Giải mã giá trị JSON từ checkbox
        const paperExists = selectedPapers.some(paper => paper.doi === paperValue.doi); // Kiểm tra xem bài báo đã có trong danh sách chưa

        if (checkbox.checked) {
            if (!paperExists) {
                selectedPapers.push(paperValue); // Thêm bài báo vào danh sách nếu chưa có
            }
        } else {
            selectedPapers = selectedPapers.filter(paper => paper.doi !== paperValue.doi); // Loại bỏ bài báo khi bỏ chọn
        }

        // Lưu danh sách bài báo đã chọn vào sessionStorage
        sessionStorage.setItem('selectedPapers', JSON.stringify(selectedPapers));

        // In ra danh sách bài báo đã chọn trong console
        // console.log('Danh sách bài báo đã chọn:', selectedPapers);
    }

    // Hàm khôi phục trạng thái checkbox khi tải lại trang
    function restoreSelectedPapers(papersOnCurrentPage) {
        // Lấy danh sách bài báo đã chọn từ sessionStorage
        const savedPapers = sessionStorage.getItem('selectedPapers');
        if (savedPapers) {
            const selectedPapers = JSON.parse(savedPapers); // Giải mã dữ liệu đã lưu

            // Duyệt qua tất cả các checkbox trên trang và khôi phục trạng thái chọn
            $('input[name="add_papers[]"]').each(function () {
                const checkbox = this;
                const paperValue = JSON.parse(checkbox.value); // Giải mã giá trị JSON của checkbox

                // Kiểm tra xem bài báo này có tồn tại trong papersOnCurrentPage và đã được chọn chưa
                const isPaperOnCurrentPage = papersOnCurrentPage.some(paper => paper.doi === paperValue.doi);
                const isSelected = selectedPapers.some(paper => paper.doi === paperValue.doi);

                // Nếu bài báo có trong danh sách hiện tại trên trang và đã được chọn
                if (isPaperOnCurrentPage && isSelected) {
                    checkbox.checked = true; // Đánh dấu checkbox đã được chọn
                } else {
                    checkbox.checked = false; // Bỏ chọn checkbox nếu không có trong danh sách
                }
            });
        }
    }

    // Dữ liệu bài báo trên trang hiện tại
    const papersOnCurrentPage = @json($publishedPapers);

    // Khi trang được tải lại, gọi hàm restoreSelectedPapers và truyền vào dữ liệu bài báo hiện tại
    $(document).ready(function () {
        restoreSelectedPapers(papersOnCurrentPage);
    });

    function submitSelectedPapers() {
        // Lấy danh sách bài báo đã chọn từ sessionStorage
        const selectedPapers = JSON.parse(sessionStorage.getItem('selectedPapers') || '[]'); // Lấy từ sessionStorage hoặc dùng mảng rỗng nếu không có

        // Kiểm tra nếu có ít nhất một bài báo được chọn
        if (selectedPapers.length > 0) {
            // Gửi AJAX request để lưu các bài báo đã chọn
            fetch('{{ route('publishedpaper.save') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ papers: selectedPapers }) // Gửi danh sách bài báo đã chọn
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        // Đóng modal sau khi lưu thành công
                        clearModal();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Có lỗi xảy ra khi lưu bài báo.');
                });
        } else {
            alert('Vui lòng chọn ít nhất một bài báo.');
        }
    }

    // Hàm để xóa dữ liệu trong modal (nếu cần)
    function clearModal() {

        // 1. Reset hộp thoại tìm kiếm về trạng thái ban đầu
        $('#search-query').val(''); // Xóa nội dung trong ô tìm kiếm
        $('#search-results').empty(); // Xóa danh sách kết quả tìm kiếm


        // Đặt lại trạng thái checkbox
        $('input[name="add_papers[]"]').each(function () {
            const checkbox = $(this);
            checkbox.checked = false;
        });
        selectedPapers = [];
        sessionStorage.removeItem('selectedPapers');
        // Xóa hash khỏi URL sau khi modal bị đóng
        history.pushState('', document.title, window.location.pathname);

        // Xóa nội dung phân trang
        const paginationDiv = document.getElementById('pagination');
        if (paginationDiv) {
            paginationDiv.innerHTML = ''; // Xóa tất cả các phần tử con trong phân trang
        }

        // 2. Đóng modal sau khi thêm thành công
        $('#addPublishedPaper').modal('hide'); // Đóng modal bằng Bootstrap

        // 3. Cập nhật bảng dữ liệu trang web
        refreshMainTable(); // Gọi hàm cập nhật bảng dữ liệu chính
    }

    function refreshMainTable() {
        $.ajax({
            url: '{{ route('scientist.home') }}',
            type: 'GET',
            success: function (response) {
                $('#publishedPapersTable').html(response.html);
            },
            error: function (xhr) {
                console.error('Error refreshing table:', xhr.responseText);
            }
        });
    }
</script>

<script>
    $(document).ready(function () {
        $('#add_workExp_btn').on('click', function (e) {
            e.preventDefault();

            // Lấy dữ liệu từ form
            const formData = $('#addWorkExpForm').serialize();

            // Gửi dữ liệu qua AJAX
            $.ajax({
                url: '{{ route("workExp.create") }}', // Route tới controller lưu workExp
                type: 'POST',
                data: formData,
                success: function (response) {
                    // Xử lý khi lưu thành công
                    alert('Thêm quá trình công tác thành công!');
                    $('#addWorkExpForm')[0].reset(); // Xóa dữ liệu form
                    $('#addArticleModalLabel').modal('hide'); // Đóng modal
                    location.reload(); // Tải lại trang để hiển thị dữ liệu mới
                },
                error: function (xhr) {
                    // Xử lý khi có lỗi
                    console.error(xhr.responseText);
                    alert('Đã xảy ra lỗi, vui lòng kiểm tra lại!');
                }
            });
        });
    });

    function toggleEndDate() {
        var endDateSelect = document.getElementById('end_date_select');
        var specificDateInput = document.getElementById('specific_date');

        // Kiểm tra nếu người dùng chọn "Hiện tại" hay "Ngày khác"
        if (endDateSelect.value === 'null') {
            // Nếu chọn "Hiện tại", ẩn input ngày và giá trị sẽ là null
            specificDateInput.style.display = 'none';
            document.querySelector('input[name="workExp_end_date_selected"]').value = ''; // Gán giá trị trống cho ngày cụ thể
        } else {
            // Nếu chọn "Ngày khác", hiển thị input ngày
            specificDateInput.style.display = 'inline';
        }
    }
</script>

<script>
    $('#education_type').on('change', function () {
        const selectedType = $(this).val();
        $('.education-fields').hide(); // Ẩn tất cả
        if (selectedType === 'undergraduate') {
            $('#undergraduateFields').show(); // Hiển thị trường Đại học
        } else if (selectedType === 'postgraduate') {
            $('#postgraduateFields').show(); // Hiển thị trường Sau đại học
        }
    });
    $(document).ready(function () {
        $('#add_education_btn').on('click', function (e) {
            e.preventDefault(); // Ngăn hành động gửi form mặc định

            // Thu thập dữ liệu từ form
            const formData = $('#addEducationForm').serialize(); // Serialize tất cả dữ liệu trong form

            // Gửi dữ liệu qua AJAX
            $.ajax({
                url: '{{route('education.create')}}', // Đường dẫn đến route xử lý backend
                method: 'POST',        // Phương thức POST
                data: formData,        // Dữ liệu cần gửi
                success: function (response) {
                    // Xử lý thành công
                    if (response.success) {
                        alert('Lưu thông tin học vấn thành công!');
                        // Có thể thêm code để cập nhật UI tại đây nếu cần
                        location.reload(); // Tải lại trang
                    } else {
                        alert('Đã xảy ra lỗi: ' + response.message);
                    }
                },
                error: function (xhr) {
                    // Xử lý lỗi
                    alert('Không thể lưu thông tin học vấn. Vui lòng thử lại!');
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function () {
        $('#add_project_btn').on('click', function (e) {
            e.preventDefault();

            // Lấy dữ liệu từ form
            const formData = $('#addProjectForm').serialize();

            // Gửi dữ liệu qua AJAX
            $.ajax({
                url: '{{ route("project.create") }}', // Route tới controller lưu workExp
                type: 'POST',
                data: formData,
                success: function (response) {
                    // Xử lý khi lưu thành công
                    alert('Thêm quá trình công tác thành công!');
                    $('#addProjectForm')[0].reset(); // Xóa dữ liệu form
                    $('#addArticleModalLabel').modal('hide'); // Đóng modal
                    location.reload(); // Tải lại trang để hiển thị dữ liệu mới
                },
                error: function (xhr) {
                    // Xử lý khi có lỗi
                    console.error(xhr.responseText);
                    alert('Đã xảy ra lỗi, vui lòng kiểm tra lại!');
                }
            });
        });
    });
</script>