<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Scientist;
use App\Models\WorkExp;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;
use DateTime;
use App\Models\PublishedPaper;
use App\Models\Education;
use App\Models\Project;
use App\Models\UndergraduateEducation;
use App\Models\PostGraduateEducation;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\TemplateProcessor;
use App\Models\User;

class ScientistController extends Controller
{
    public function signUp()
    {
        return view('SignUp.scientist');
    }

    public function home()
    {
        $user = Auth::user();

        $scientistID = $user->scientist->id; //session('scientist_id');

        $scientist = Scientist::find($scientistID);

        // Published Papers
        $publishedPapers = PublishedPaper::where('scientist_id', $scientistID)->paginate(5);

        // Work Exp
        $workExps = WorkExp::where('scientist_id', $scientistID)->get();

        // Education
        $educations = Education::with('undergraduate', 'postgraduate')->where('scientist_id', $scientistID)->paginate(5);

        // Project
        $projects = Project::where('scientist_id', $scientistID)->get();
        return view('index', compact('projects','educations', 'workExps', 'publishedPapers', 'scientist', 'user'));
    }

    public function register(Request $request)
    {
        $validate = $request->validate([
            'registration_name' => 'required|string|max:255',
            'registration_gender' => 'required|in:0,1',
            'registration_dob' => 'required|date|before:today',
            'registraton_pob' => 'required|string|max:255',
            'registration_hometown' => 'required|string|max:255',
            'registration_ethnicity' => 'required|string|max:255',
            'registration_highest_degree' => 'required|string|max:255',
            'registration_year_awarded_degree' => 'required|integer|min:1900|max:' . date('Y'),
            'registration_country_awarded_degree' => 'required|string|max:255',
            'registration_scientific_title' => 'required|string|max:255',
            'registration_year_title_appointment' => 'required|integer|min:1900|max:' . date('Y'),
            'registration_position' => 'required|string|max:255',
            'registration_workplace' => 'required|string|max:255',
            'registration_address' => 'required|string|max:255',
            'registration_phone_office' => 'nullable|digits_between:8,15',
            'registration_phone_home' => 'nullable|digits_between:8,15',
            'registration_phone_mobile' => 'required|digits:10',
            'registration_fax' => 'nullable|digits_between:8,15',
            'registration_citizen_id' => 'required|digits:12',
            'registration_date_issue' => 'nullable|date|before:today',
            'registration_place_issue' => 'nullable|string|max:255',
        ]);

        $user = User::create([
            'email' => session('email'),
            'password' => session('password')
        ]);

        $scientist = Scientist::create([
            'user_id' => $user->id,
            'name' => $request->registration_name,
            'gender' => $request->registration_gender,
            'date_of_birth' => $request->registration_dob,
            'place_of_birth' => $request->registration_pob,
            'hometown' => $request->registration_hometown,
            'ethnicity' => $request->registration_ethnicity,
            'highest_degree' => $request->registration_highest_degree,
            'year_awarded_degree' => $request->registration_year_awarded_degree,
            'country_awarded_degree' => $request->registration_country_awarded_degree,
            'scientific_title' => $request->registration_scientific_title,
            'year_title_appointment' => $request->registration_year_title_appointment,
            'position' => $request->registration_position,
            'workplace' => $request->registration_workplace,
            'address' => $request->registration_address,
            'phone_office' => $request->registration_phone_office,
            'phone_home' => $request->registration_phone_home,
            'phone_mobile' => $request->registration_phone_mobile,
            'fax' => $request->registration_fax,
            'citizen_id' => $request->registration_citizen_id,
            'date_issue' => $request->registration_date_issue,
            'place_issue' => $request->registration_place_issue,
        ]);

        Auth::login($user);

        session()->forget(['email', 'password']);
        return redirect()->route('scientist.home');
    }

    public function searchPublishedPapersByTitle(Request $request)
    {
        //\Log::info('Request Method: ' . $request->method());
        //\Log::info('Request Data: ' . json_encode($request->all()));

        $query = $request->query('query');
        $page = $request->query('page', 1);
        $perPage = 10;

        $offset = ($page - 1) * $perPage;

        $publishedPaperInfo = [];


        // The limit of the number of results returned for this API is from 2 to 12 rows of data.
        // For Example: If you found "Incorporating symbolic domain knowledge into graph neural networks" by this API
        // there are more than 2 million responses, and in each row of data store numerous information.
        // In addition, by the document of CrossRef API, they suggest that we should take 2-5 response for the most accurate results.
        // Ref: https://www.crossref.org/documentation/retrieve-metadata/rest-api/tips-for-using-the-crossref-rest-api/
        $apiUrl = "https://api.crossref.org/works?query.title=" . urlencode('"' . $query . '"') . "&rows=$perPage&offset=$offset";


        try {
            // Khởi tạo cURL
            $ch = curl_init();

            // Cấu hình cURL
            curl_setopt($ch, CURLOPT_URL, $apiUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  // Tắt kiểm tra SSL (chỉ thử trong môi trường phát triển)
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json'
            ]);

            // Gửi yêu cầu cURL và nhận phản hồi
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            // Đóng kết nối cURL
            curl_close($ch);
            //\Log::info('HTTP Code: ' . $httpCode);
            //$response->successful() condition for Http::get
            if ($httpCode >= 200 && $httpCode < 300) {

                $data = json_decode($response, true);

                if (isset($data['message']['items']) && count($data['message']['items']) > 0) {
                    foreach ($data['message']['items'] as $paper) {
                        $publishedPaperInfo[] = $this->takeSinglePaper($paper);
                    }

                    return response()->json([
                        'papers' => $publishedPaperInfo,
                        'total' => $data['message']['total-results'],
                        'perPage' => $perPage,
                        'currentPage' => $page,
                    ]);
                } else {
                    return response()->json(['error' => 'No results found for this title'], 404);
                }
            }
            return response()->json(['error' => 'Failed to fetch data from CrossRef'], 500);

        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while making the request', 'message' => $e->getMessage()], 500);
        }
    }

    public function searchPublishedPapersByURL(Request $request)
    {
        // \Log::info('Request Method: ' . $request->method());
        // \Log::info('Request Data: ' . json_encode($request->all()));

        $publishedPaperInfo = [];
        $query = $request->input('query');

        try {
            if ($this->isDOI($query)) {
                $url = "https://api.crossref.org/works/" . urlencode($query);


                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Content-Type: application/json'
                ]);

                $response = curl_exec($ch);

                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                curl_close($ch);

                if ($httpCode >= 200 && $httpCode < 300) {
                    $data = json_decode($response, true);
                    $publishedPaperInfo[] = $this->takeSinglePaper($data['message']);

                    return response()->json([
                        'papers' => $publishedPaperInfo
                    ]);
                }
            } elseif ($this->isUrl($query)) {
                $publishedPaperInfo[] = $this->CrawlingWebsite($query);
                return response()->json([
                    'papers' => $publishedPaperInfo
                ]);
            }

            return response()->json(['error' => 'Invalid DOI or URL'], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while making the request!', 'message' => $e->getMessage()], 500);
        }
    }

    public function savePublishedPapers(Request $request)
    {
        $scientistID = Auth::user()->scientist->id; //session('scientist_id');
        $scientist = Scientist::find($scientistID);

        $selectedPapers = $request->input('papers');
        //\Log::info('Selected Papers:', $selectedPapers);
        if (is_array($selectedPapers) && count($selectedPapers) > 0) {
            foreach ($selectedPapers as $paper) {
                $scientist->publishedPapers()->create([
                    'url' => $paper['url'],
                    'doi' => $paper['doi'],
                    'authors' => $paper['authors'],
                    'title' => $paper['title'],
                    'publication_date' => $paper['published_date'],
                    'issn' => $paper['issn'],
                    'publisher' => $paper['publisher'],
                ]);
            }

            return response()->json(['success' => true, 'message' => 'Successfully Saving Published Paper!']);
        } else {
            return response()->json(['success' => false, 'message' => 'There is no chosen paper!']);
        }
    }

    private function isDOI($query)
    {
        // Loại bỏ tiền tố không cần thiết, ví dụ "doi:"
        $query = trim($query);
        $query = preg_replace('/^doi:\s*/i', '', $query);

        // Kiểm tra định dạng DOI (hỗ trợ suffix phức tạp)
        return preg_match('/^10\.\d{4,9}\/[a-zA-Z0-9._;()\/:-]+$/i', $query);
    }

    private function takeSinglePaper($paper)
    {
        $title = $paper['title'][0] ?? 'No title available';
        $authors = array_map(function ($author) {
            $given = $author['given'] ?? '';
            $family = $author['family'] ?? '';
            return trim("$given $family");
        }, $paper['author'] ?? []);
        $published_date = $paper['issued']['date-parts'][0][0] ?? null;
        $publisher = $paper['publisher'] ?? null;
        $doi = $paper['DOI'] ?? null;
        $issn = isset($paper['ISSN']) ? $paper['ISSN'][0] : null;
        $url = isset($paper['resource']['primary']['URL']) ? $paper['resource']['primary']['URL'] : null;
        // create citation string
        //$citation_string = $this->createCitationString($title, $authors, $published_date, $publisher, $doi);

        $paperInfo = [
            'title' => $title,
            'authors' => implode(', ', $authors),
            'published_date' => $published_date,
            'publisher' => $publisher,
            'doi' => $doi,
            'url' => $url,
            'issn' => $issn,
        ];

        return $paperInfo;
    }

    private function isUrl($query)
    {
        return filter_var($query, FILTER_VALIDATE_URL);
    }

    private function CrawlingWebsite($url)
    {
        // Lấy nội dung của trang web
        $contextOptions = [
            "ssl" => [
                "verify_peer" => false,
                "verify_peer_name" => false,
            ],
        ];
        $html = file_get_contents($url, false, stream_context_create($contextOptions));

        if (!$html) {
            throw new \Exception("Unable to fetch HTML content from the URL.");
        }

        // Khởi tạo DomCrawler với nội dung HTML
        $crawler = new Crawler($html);

        // Lấy dữ liệu meta title
        $titles = $crawler->filter('meta[name="citation_title"]')->each(function (Crawler $node) {
            return $node->attr('content');
        });
        $title = count($titles) > 0 ? $titles[0] : 'No title available';

        // Lấy dữ liệu meta authors
        $authors = $crawler->filter('meta[name="citation_author"]')->each(function (Crawler $node) {
            return $node->attr('content');
        });

        $authors = count($authors) > 0 ? implode(', ', $authors) : 'No authors available';

        // Lấy dữ liệu meta DOI
        $dois = $crawler->filter('meta[name="citation_doi"]')->each(function (Crawler $node) {
            return $node->attr('content');
        });
        $doi = count($dois) > 0 ? $dois[0] : 'No DOI available';

        // Lấy dữ liệu meta publisher
        $publishers = $crawler->filter('meta[name="citation_publisher"]')->each(function (Crawler $node) {
            return $node->attr('content');
        });
        $journals = $crawler->filter('meta[name="citation_journal_title"]')->each(function (Crawler $node) {
            return $node->attr('content');
        });

        $publisher = count($publishers) > 0 ? $publishers[0] : $journals[0];

        // Lấy dữ liệu meta publication date
        $publicationDates = $crawler->filter('meta[name="citation_date"]')->each(function (Crawler $node) {
            return $node->attr('content');
        });
        $publishedDate = count($publicationDates) > 0 ? $publicationDates[0] : 'No publication date';

        if ($publishedDate != 'Unknown Date') {
            $dateObj = DateTime::createFromFormat('Y/m/d', $publishedDate);
            if ($dateObj) {
                $publishedDate = $dateObj->format('Y');
            }
        }

        $issn = $crawler->filter('meta[name="citation_issn"]')->each(function (Crawler $node) {
            return $node->attr('content');
        });

        $issn = count($issn) > 0 ? $issn[0] : 'No issn';

        // create citation string
        //$citation_string = $this->createCitationString($title, $authors, $publishedDate, $publisher, $doi);

        // Trả về mảng chứa thông tin bài báo
        return [
            'title' => $title,
            'authors' => $authors,
            'doi' => $doi,
            'publisher' => $publisher,
            'published_date' => $publishedDate,
            'url' => $url,
            'issn' => $issn
        ];
    }

    public function createWorkExp(Request $request)
    {
        $workExp_end_date = $request->input('workExp_end_date') === 'null' ? null : $request->input('workExp_end_date_selected');
        $validate = $request->validate([
            'workExp_start_date' => 'required|date|before_or_equal:' . ($workExp_end_date ?? Carbon::today()->toDateString()),
            'workExp_end_date_selected' => 'nullable|date|after_or_equal:workExp_start_date',
            'workExp_institution' => 'required|string|max:255',
            'workExp_position' => 'required|string|max:255',
        ]);

        $scientistID = Auth::user()->scientist->id; //session('scientist_id');
        $scientist = Scientist::find($scientistID);

        if ($scientist) {
            $scientist->workExps()->create([
                'start_date' => $request->workExp_start_date,
                'end_date' => $workExp_end_date,
                'institution' => $request->workExp_institution,
                'position' => $request->workExp_position,
            ]);

            return response()->json(['success' => true, 'message' => 'Successfully Saving Work Experience!']);
        } else {
            return response()->json(['success' => false, 'message' => 'The user is unavailable!']);
        }
    }

    public function createEducation(Request $request)
    {
        $validate = $request->validate([
            'education_type' => 'required|in:undergraduate,postgraduate',
            'education_field_of_study' => 'required|string|max:255',
            'education_institution' => 'required|string|max:255',
            'undergraduate_system' => 'nullable|required_if:education_type,undergraduate|string|max:255',
            'undergraduate_country' => 'nullable|required_if:education_type,undergraduate|string|max:255',
            'undergraduate_graduation_year' => 'nullable|required_if:education_type,undergraduate|integer|min:1900|max:' . date('Y'),
            'postgraduate_level' => 'nullable|required_if:education_type,postgraduate|in:master,phd',
            'postgraduate_thesis' => 'nullable|required_if:education_type,postgraduate|string|max:255',
            'postgraduate_graduation_year' => 'nullable|required_if:education_type,postgraduate|integer|min:1900|max:' . date('Y'),
        ]);

        $scientistID = Auth::user()->scientist->id; //session('scientist_id');
        $scientist = Scientist::find($scientistID);

        if ($scientist) {
            $education = $scientist->educations()->create([
                'institution' => $request->education_institution,
                'field_of_study' => $request->education_field_of_study,
                'type' => $request->education_type,
            ]);

            if ($education) {
                if ($education->type == "undergraduate") {
                    $education->undergraduate()->create([
                        'training_system' => $request->undergraduate_system,
                        'training_country' => $request->undergraduate_country,
                        'graduation_year' => $request->undergraduate_graduation_year,
                    ]);
                } else {
                    $education->postgraduate()->create([
                        'level' => $request->postgraduate_level,
                        'thesis_title' => $request->postgraduate_thesis,
                        'graduation_year' => $request->postgraduate_graduation_year,
                    ]);
                }
                return response()->json(['success' => true, 'message' => 'Education saved successfully!']);
            }
        }
        return response()->json(['success' => false, 'message' => 'Scientist not found.'], 404);
    }

    public function createProject(Request $request)
    {
        $validate = $request->validate([
            'project_title' => 'required|string',
            'project_start_year' => 'required|integer|min:1900|max:'.date('Y'),
            'project_end_year' => 'required|integer|after_or_equal:start_year',
            'project_level' => 'required|string|max:255',
            'project_position' => 'required|string|max:255'
        ]);

        $scientistID = Auth::user()->scientist->id;
        $scientist = Scientist::find($scientistID);
        
        if ($scientist)
        {
            $scientist->projects()->create([
                'title' => $request->project_title,
                'start_year' => $request->project_start_year,
                'end_year' => $request->project_end_year,
                'level' => $request->project_level,
                'position' => $request->project_position
            ]);

            return response()->json(['success' => true, 'message' => 'Project saved successfully!']);
        }

        return response()->json(['success' => false, 'message' => 'Scientist not found.'], 404);
    }

    public function exportCV($scientistID)
    {
        $scientist = Scientist::with(['workExps', 'publishedPapers'])->find($scientistID);

        $master = $scientist->educations()
            ->where('type', 'postgraduate')
            ->whereHas('postgraduate', function($query){
                $query->where('level', 'master');
            })
            ->with('postgraduate')
            ->first()
            ->toArray();

        $phd = $scientist->educations()
            ->where('type', 'postgraduate')
            ->whereHas('postgraduate', function($query){
                $query->where('level', 'phd');
            })
            ->with('postgraduate')
            ->first()
            ->toArray();

        $undergraduate = $scientist->educations()
            ->where('type', 'undergraduate')
            ->with('undergraduate')
            ->take(2)
            ->get()
            ->toArray();
        
        if (!$scientist) {
            return redirect()->back()->withErrors('Scientist not found!');
        }

        $templatePath = public_path('CV_template\Scientist_CV_template_new.docx');
        if (!file_exists($templatePath)) {
            return redirect()->back()->withErrors('Template file not found!');
        }

        $resume = new TemplateProcessor($templatePath);

        // Điền thông tin cá nhân của scientist
        $resume->setValue('scientist.name', $scientist->name);
        $resume->setValue('scientist.gender', $scientist->gender == 0 ? 'Nữ' : 'Nam');
        $resume->setValue('scientist.dob', date('d/m/Y', strtotime($scientist->date_of_birth)));
        $resume->setValue('scientist.pob', $scientist->place_of_birth);
        $resume->setValue('scientist.hometown', $scientist->hometown);
        $resume->setValue('scientist.ethnicity', $scientist->ethnicity);
        $resume->setValue('scientist.degree', $scientist->highest_degree);
        $resume->setValue('scientist.degree_year', $scientist->year_awarded_degree);
        $resume->setValue('scientist.degree_country', $scientist->country_awarded_degree);
        $resume->setValue('scientist.title', $scientist->scientific_title);
        $resume->setValue('scientist.title_year', $scientist->year_title_appointment);
        $resume->setValue('scientist.position', $scientist->position);
        $resume->setValue('scientist.workplace', $scientist->workplace);
        $resume->setValue('scientist.address', $scientist->address);
        $resume->setValue('scientist.office_phone', $scientist->phone_office);
        $resume->setValue('scientist.home_phone', $scientist->phone_home);
        $resume->setValue('scientist.mobile_phone', $scientist->phone_mobile);
        $resume->setValue('scientist.fax', $scientist->fax);
        $resume->setValue('scientist.email', $scientist->email);

        // Điền thông tin của quá trình đào tạo
        $resume->setValue('education.system', $undergraduate[0]['undergraduate'][0]['training_system']);
        $resume->setValue('education.institution', $undergraduate[0]['institution']);
        $resume->setValue('education.field_of_study', $undergraduate[0]['field_of_study']);
        $resume->setValue('education.country', $undergraduate[0]['undergraduate'][0]['training_country']);
        $resume->setValue('education.year', $undergraduate[0]['undergraduate'][0]['graduation_year']);

        $resume->setValue('education.degree_2', $undergraduate[1]['field_of_study']);
        $resume->setValue('education.year_degree_2', $undergraduate[1]['undergraduate'][0]['graduation_year']);

        $resume->setValue('master.major', $master['field_of_study']);
        $resume->setValue('master.year', $master['postgraduate'][0]['graduation_year']);
        $resume->setValue('master.institution',$master['institution']);
        $resume->setValue('master.thesis', $master['postgraduate'][0]['thesis_title']);

        $resume->setValue('phd.major',  $phd['field_of_study']);
        $resume->setValue('phd.year', $phd['postgraduate'][0]['graduation_year']);
        $resume->setValue('phd.institution', $phd['institution']);
        $resume->setValue('phd.thesis', $phd['postgraduate'][0]['thesis_title']);

        
        $workExps = $scientist->workExps;
        $resume->cloneRow('workExp_row.position', $workExps->count());
        foreach($workExps as $index => $exp)
        {
            $resume->setValue("workExp_row.start_date#". ($index + 1), date('d/m/Y' ,strtotime($exp->start_date)));
            $resume->setValue("workExp_row.end_date#".($index + 1), $exp->end_date == null ? 'Hiện tại' : date('d/m/Y', strtotime($exp->end_date)));
            $resume->setValue("workExp_row.institution#".($index + 1), $exp->institution);
            $resume->setValue("workExp_row.position#".($index + 1), $exp->position);
        }

        

        $publishedPapers = $scientist->publishedPapers; // Lấy danh sách công bố nghiên cứu
        $resume->cloneRow('publishedPaper_row.index', $publishedPapers->count());

        foreach ($publishedPapers as $index => $paper) {
            $resume->setValue("publishedPaper_row.index#" . ($index + 1), $index + 1);
            $resume->setValue("publishedPaper_row.title#" . ($index + 1), $paper->title);
            $resume->setValue("publishedPaper_row.publication_date#" . ($index + 1), $paper->publication_date);
            $resume->setValue("publishedPaper_row.publisher#" . ($index + 1), $paper->publisher);
        }
        // Lưu file Word
        $fileName = "Scientist_Profile_{$scientist->name}.docx";
        $outputPath = storage_path("app/public/{$fileName}");
        $resume->saveAs($outputPath);

        // Trả file về client
        return response()->download($outputPath)->deleteFileAfterSend(true);
    }

}
