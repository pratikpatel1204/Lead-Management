<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use App\Models\ContactSetting;
use App\Models\Inquery;
use App\Models\LeadFieldOrder;
use App\Models\Meeting;
use App\Models\TemplateData;
use App\Models\TemplateMaster;
use App\Models\User;
use App\Models\WhyChooseUs;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $baseQuery = Meeting::query()
            ->where('label', 'Comments')
            ->whereNotNull('value')
            ->empScope();

        // Today
        $todayCommentCount = (clone $baseQuery)
            ->whereBetween('created_at', [
                Carbon::today()->startOfDay(),
                Carbon::today()->endOfDay(),
            ])
            ->count();

        $now = Carbon::now();

        // Month start
        $monthStart = $now->copy()->startOfMonth();

        // If today is in the first partial week of the month
        if ($now->weekOfMonth === 1) {

            $weekStart = $monthStart; // e.g. 01-01-2026 (Thursday)
            $weekEnd   = $monthStart->copy()->endOfWeek(Carbon::SUNDAY);
        } else {

            $weekStart = $now->copy()->startOfWeek(Carbon::MONDAY);
            $weekEnd   = $now->copy()->endOfWeek(Carbon::SUNDAY);
        }
        $weeklyCommentCount = (clone $baseQuery)
            ->whereBetween('created_at', [
                $weekStart->startOfDay(),
                $weekEnd->endOfDay(),
            ])
            ->count();


        // This Month
        $monthlyCommentCount = (clone $baseQuery)
            ->whereBetween('created_at', [
                Carbon::now()->startOfMonth(),
                Carbon::now()->endOfMonth(),
            ])
            ->count();

        $areas = TemplateData::query()
            ->from('template_data as area')
            ->empScope('area') // ✅ FIX
            ->selectRaw('
                direction.field_value as direction,
                area.field_value as area,
                COUNT(DISTINCT area.form_group_id) as total
            ')
            ->join('template_data as direction', function ($join) {
                $join->on('area.form_group_id', '=', 'direction.form_group_id')
                    ->where('direction.field_name', 'Direction');
            })
            ->where('area.field_name', 'Area')
            ->groupBy('direction.field_value', 'area.field_value')
            ->orderBy('direction.field_value')
            ->orderByDesc('total')
            ->get()
            ->groupBy('direction');

        $directionTotals = TemplateData::query()
            ->from('template_data as direction')
            ->empScope('direction') // ✅ FIX
            ->selectRaw('
                direction.field_value as direction,
                COUNT(DISTINCT direction.form_group_id) as total
            ')
            ->where('direction.field_name', 'Direction')
            ->groupBy('direction.field_value')
            ->pluck('total', 'direction');

        $dateExpression = "
            CASE
                WHEN value LIKE '%/%/%' THEN STR_TO_DATE(value, '%m/%d/%Y')
                WHEN value LIKE '%/%/%' THEN STR_TO_DATE(value, '%d/%m/%Y')
                WHEN value LIKE '%-%-%' THEN STR_TO_DATE(value, '%Y/%m/%d')
                WHEN value LIKE '%/%/%' THEN STR_TO_DATE(value, '%m-%d-%Y')
                WHEN value LIKE '%/%/%' THEN STR_TO_DATE(value, '%d-%m-%Y')
                WHEN value LIKE '%-%-%' THEN STR_TO_DATE(value, '%Y-%m-%d')
                ELSE NULL
            END
        ";

        $baseMeetingQuery = Meeting::query()
            ->where('label', 'Next Meeting Date')
            ->whereNotNull('value')
            ->where('value', '!=', '0000-00-00')
            ->empScope();

        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();
        $startOfWeek = Carbon::now()->startOfWeek(); // Monday
        $endOfWeek   = Carbon::now()->endOfWeek();
        $currentMonth = $today->month;
        $currentYear  = $today->year;

        $baseMeetingQuerys = Meeting::query()
            ->where('label', 'Next Meeting Date')
            ->whereNotNull('value')
            ->where('value', '!=', '0000-00-00')
            ->empScope();

        // 🔹 Latest meeting per form_group
        $latestMeetingsSub = $baseMeetingQuerys
            ->select('form_group_id', DB::raw('MAX(created_at) as latest_created_at'))
            ->groupBy('form_group_id');

        // Helper: get form_group_ids for a date range or date
        $getMeetingGroups = function ($from = null, $to = null) use ($latestMeetingsSub, $dateExpression) {
            $query = DB::table('meetings as m')
                ->joinSub($latestMeetingsSub, 'lm', function ($join) {
                    $join->on('m.form_group_id', '=', 'lm.form_group_id')
                        ->on('m.created_at', '=', 'lm.latest_created_at');
                })
                ->where('m.label', 'Next Meeting Date')
                ->whereNotNull('m.value')
                ->where('m.value', '!=', '0000-00-00');

            if ($from && $to) {
                $query->whereBetween(DB::raw($dateExpression), [$from, $to]);
            } elseif ($from) {
                $query->whereDate(DB::raw($dateExpression), $from);
            }

            return $query->pluck('m.meeting_group');
        };

        // 🔹 TODAY count
        $todayGroups = $getMeetingGroups($today);

        // 🔹 TOMORROW count
        $tomorrowGroups = $getMeetingGroups($tomorrow);

        // 🔹 NEXT WEEK count
        $nextWeekGroups = $getMeetingGroups($startOfWeek, $endOfWeek);

        // 🔹 CURRENT MONTH count
        $currentMonthGroups = $getMeetingGroups(Carbon::create($currentYear, $currentMonth, 1), Carbon::create($currentYear, $currentMonth, $today->daysInMonth));

        // 🔹 MISSED = TODAY meetings without comment
        $commentedTodayGroups = Meeting::query()
            ->where('label', 'Comments')
            ->whereNotNull('value')
            ->where('value', '!=', '')
            ->whereDate('created_at', $today)
            ->empScope()
            ->pluck('meeting_group');

        $missedGroups = $todayGroups->diff($commentedTodayGroups);

        // 🔹 Label counts
        $mostUrgentCount = TemplateData::query()->where('field_name', 'Labels')->where('field_value', 'Most Urgent')->empScope()->distinct('form_group_id')->count('form_group_id');
        $urgentCount     = TemplateData::query()->where('field_name', 'Labels')->where('field_value', 'Urgent')->empScope()->distinct('form_group_id')->count('form_group_id');
        $mustCount       = TemplateData::query()->where('field_name', 'Labels')->where('field_value', 'Must')->empScope()->distinct('form_group_id')->count('form_group_id');

        $meetingCounts = [
            'today'         => $todayGroups->count(),
            'tomorrow'      => $tomorrowGroups->count(),
            'next_week'     => $nextWeekGroups->count(),
            'current_month' => $currentMonthGroups->count(),
            'missed'        => $missedGroups->count(),
            'most_urgent'   => $mostUrgentCount,
            'urgent'        => $urgentCount,
            'must'          => $mustCount,
        ];


        $employeeLeads = TemplateData::query()
            ->select('template_data.emp_id', DB::raw('COUNT(DISTINCT template_data.form_group_id) as total'), 'users.name as employee_name')
            ->where('template_name', 'Lead Master')
            ->empScope()
            ->join('users', 'template_data.emp_id', '=', 'users.id')
            ->groupBy('template_data.emp_id', 'users.name')
            ->get();

        $employeeLeads = $employeeLeads->filter(fn($item) => $item->employee_name !== null);
        $employeeTotalLeads = $employeeLeads->sum('total');

        $labellead = TemplateData::query()
            ->select('field_value as label', DB::raw('COUNT(DISTINCT form_group_id) as total'))
            ->where('template_name', 'Lead Master')
            ->where('field_name', 'Labels')
            ->whereNotNull('field_value') 
            ->where('field_value', '!=', '#N/A')
            ->empScope()
            ->groupBy('field_value')
            ->get();

        $labelleadTotal = $labellead->sum('total');

        $focusProductLeads = TemplateData::query()
            ->select('field_value as focus_product', DB::raw('COUNT(DISTINCT form_group_id) as total'))
            ->where('template_name', 'Lead Master')
            ->where('field_name', 'SP Focused Product')
            ->whereNotNull('field_value')         
            ->where('field_value', '!=', '#N/A')   
            ->where('field_value', '!=', 'NULL')   
            ->empScope()                         
            ->groupBy('field_value')
            ->get();

        $focusProductTotal = $focusProductLeads->sum('total');

        $leadSourceLeads = TemplateData::query()
            ->select('field_value as source', DB::raw('COUNT(DISTINCT form_group_id) as total'))
            ->where('template_name', 'Lead Master')
            ->where('field_name', 'Lead Source')
            ->whereNotNull('field_value')
            ->where('field_value', '!=', 'NULL')
            ->where('field_value', '!=', '#N/A')
            ->empScope()
            ->groupBy('field_value')
            ->get();

        $leadSourceTotal = $leadSourceLeads->sum('total');

        $siteStageLeads = TemplateData::query()
            ->select('field_value as stage', DB::raw('COUNT(DISTINCT form_group_id) as total'))
            ->where('template_name', 'Lead Master')
            ->where('field_name', 'Site Stage')
            ->whereNotNull('field_value')
            ->where('field_value', '!=', '')
            ->where('field_value', '!=', '#N/A')
            ->empScope()
            ->groupBy('field_value')
            ->orderByDesc('total')
            ->get();

        $siteStageTotal = $siteStageLeads->sum('total');

        $projectTypeLeads = TemplateData::query()
            ->select('field_value as project_type', DB::raw('COUNT(DISTINCT form_group_id) as total'))
            ->where('template_name', 'Lead Master')
            ->where('field_name', 'Project Type')
            ->whereNotNull('field_value')
            ->where('field_value', '!=', '')
            ->where('field_value', '!=', '#N/A')
            ->empScope()
            ->groupBy('field_value')
            ->orderByDesc('total')
            ->get();

        $projectTypeTotal = $projectTypeLeads->sum('total');

        $meetingTypes = [
            'today'    => ["Today's Meetings", 'primary'],
            'tomorrow' => ["Tomorrow's Meetings", 'info'],
            'missed'   => ["Missed Meetings", 'danger'],
        ];

        // Chart labels
        $chartLabels = collect($meetingTypes)->pluck(0)->values();

        // Chart series (counts)
        $chartSeries = collect(['today', 'tomorrow', 'missed'])
            ->map(fn($key) => $meetingCounts[$key] ?? 0)
            ->values();

        $months = collect(range(1, 12))->map(fn($m) => Carbon::create(null, $m, 1)->format('M'))->toArray();

        $monthlyMeetings = collect(range(1, 12))->map(function ($month) use ($baseMeetingQuery, $dateExpression) {
            return (clone $baseMeetingQuery)
                ->whereYear(DB::raw($dateExpression), Carbon::now()->year)
                ->whereMonth(DB::raw($dateExpression), $month)
                ->distinct('meeting_group')
                ->count('meeting_group');
        });

        $weekStart = Carbon::now()->startOfWeek(Carbon::MONDAY);
        $weekEnd   = Carbon::now()->endOfWeek(Carbon::SUNDAY);

        $weeklyLabels = [];
        $weeklyCounts = [];

        for ($i = 0; $i < 7; $i++) {
            $day = $weekStart->copy()->addDays($i);
            $count = (clone $baseMeetingQuery)
                ->whereDate(DB::raw($dateExpression), $day)
                ->distinct('meeting_group')
                ->count('meeting_group');

            $weeklyLabels[] = $day->format('D, d M'); // e.g., Mon, 04 Jan
            $weeklyCounts[] = $count;
        }
        $baseCommentQuery = Meeting::query()
            ->where('label', 'Comments')
            ->whereNotNull('value')
            ->where('value', '!=', '')
            ->empScope();

        // Current week (Monday → Sunday)
        $weekStart = Carbon::now()->startOfWeek(Carbon::MONDAY);
        $weekEnd   = Carbon::now()->endOfWeek(Carbon::SUNDAY);

        $weeklyLabelsComments = [];
        $weeklyCountsComments = [];

        for ($i = 0; $i < 7; $i++) {
            $day = $weekStart->copy()->addDays($i);
            $count = (clone $baseCommentQuery)
                ->whereDate('created_at', $day)
                ->count();

            $weeklyLabelsComments[] = $day->format('D, d M'); // e.g., Mon, 04 Jan
            $weeklyCountsComments[] = $count;
        }

        $currentYear = Carbon::now()->year;
        $monthlyLeads = TemplateData::query()
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(DISTINCT form_group_id) as total')
            )
            ->where('template_name', 'Lead Master')
            ->whereYear('created_at', $currentYear)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->pluck('total', 'month'); // [1 => 50, 2 => 40, ...]

        // Prepare full months array
        $yearsmonths = [];
        $yearsleadsData = [];
        for ($m = 1; $m <= 12; $m++) {
            $yearsmonths[] = Carbon::create($currentYear, $m, 1)->format('M'); // Jan, Feb, ...
            $yearsleadsData[] = $monthlyLeads[$m] ?? 0; // default 0 if no leads
        }
        
        $users = User::where('role', '!=', 'super admin')->get();

        //Create Lead Meetings Meeting
        $leadmeetings = TemplateMaster::with(['field', 'field.templateData'])
            ->where('name', 'Lead Meetings')
            ->orderBy('order_no', 'asc')
            ->get();
        return view('admin.dashboard', compact(
            'todayCommentCount',
            'weeklyCommentCount',
            'monthlyCommentCount',
            'areas',
            'meetingCounts',
            'employeeLeads',
            'employeeTotalLeads',
            'labellead',
            'labelleadTotal',
            'focusProductLeads',
            'focusProductTotal',
            'leadSourceLeads',
            'leadSourceTotal',
            'siteStageLeads',
            'siteStageTotal',
            'projectTypeLeads',
            'projectTypeTotal',
            'meetingTypes',
            'chartLabels',
            'chartSeries',
            'months',     
            'monthlyMeetings',
            'weeklyLabels',
            'weeklyCounts',
            'weeklyLabelsComments',
            'weeklyCountsComments',
            'yearsmonths',
            'yearsleadsData',          
            'users',
            'leadmeetings'
        ));
    }
    public function dashboard_leads_filter(Request $request)
    {
        $type  = $request->type;
        $today = Carbon::today();

        $dateExpression = "
            CASE
                WHEN value LIKE '%/%/%' THEN STR_TO_DATE(value, '%m/%d/%Y')
                WHEN value LIKE '%-%-%' THEN STR_TO_DATE(value, '%Y-%m-%d')
                WHEN value LIKE '%/%/%' THEN STR_TO_DATE(value, '%d/%m/%Y')
                WHEN value LIKE '%-%-%' THEN STR_TO_DATE(value, '%d-%m-%Y')
                ELSE NULL
            END
        ";

        if (in_array($type, ['most_urgent', 'urgent', 'must'])) {

            $labelMap = [
                'most_urgent' => 'Most Urgent',
                'urgent'      => 'Urgent',
                'must'        => 'Must',
            ];

            $formGroupIds = TemplateData::query()
                ->where('field_name', 'Labels')
                ->where('field_value', $labelMap[$type])
                ->empScope()
                ->distinct()
                ->pluck('form_group_id');

            return $this->buildLeadResponse($formGroupIds);
        }

        if ($type === 'missed') {
            $today = Carbon::today()->toDateString();

            // 1️⃣ Latest meeting per form_group
            $latestMeetingsSub = Meeting::query()
                ->empScope()
                ->select('form_group_id', DB::raw('MAX(created_at) as latest_created_at'))
                ->groupBy('form_group_id');

            // 2️⃣ Latest meetings whose Next Meeting Date = TODAY
            $todayLatestMeetings = DB::table('meetings as m')
                ->joinSub($latestMeetingsSub, 'lm', function ($join) {
                    $join->on('m.form_group_id', '=', 'lm.form_group_id')
                        ->on('m.created_at', '=', 'lm.latest_created_at');
                })
                ->where('m.label', 'Next Meeting Date')
                ->whereNotNull('m.value')
                ->where('m.value', '!=', '0000-00-00')
                ->whereDate(DB::raw($dateExpression), $today)                
                ->select('m.meeting_group', 'm.form_group_id')
                ->get();

            if ($todayLatestMeetings->isEmpty()) {
                return $this->buildLeadResponse(collect());
            }

            $todayMeetingGroups = $todayLatestMeetings->pluck('meeting_group');

            // 3️⃣ Meetings which HAVE a valid comment today
            $commentedTodayGroups = Meeting::query()
                ->where('label', 'Comments')
                ->whereNotNull('value')
                ->where('value', '!=', '')
                ->where('value', '!=', 'NULL')
                ->whereDate('created_at', $today) // ✅ correct column
                ->whereIn('meeting_group', $todayMeetingGroups)
                ->empScope()
                ->pluck('meeting_group');

            // 4️⃣ MISSED = Today meetings WITHOUT comment
            $missedMeetingGroups = $todayMeetingGroups->diff($commentedTodayGroups);

            if ($missedMeetingGroups->isEmpty()) {
                return $this->buildLeadResponse(collect());
            }

            // 5️⃣ Final form_group_ids
            $formGroupIds = Meeting::query()
                ->whereIn('meeting_group', $missedMeetingGroups)
                ->distinct()
                ->pluck('form_group_id');

            return $this->buildLeadResponse($formGroupIds);
        }
        $today = Carbon::today();

        // 1️⃣ Subquery: latest meeting per form_group_id
        $latestMeetingsSub = Meeting::query()
            ->empScope()
            ->select('form_group_id', DB::raw('MAX(created_at) as latest_created_at'))
            ->groupBy('form_group_id');

        // 2️⃣ Base query: ONLY latest meeting per form_group
        $latestMeetingQuery = DB::table('meetings as m')
            ->joinSub($latestMeetingsSub, 'lm', function ($join) {
                $join->on('m.form_group_id', '=', 'lm.form_group_id')
                    ->on('m.created_at', '=', 'lm.latest_created_at');
            })
            ->where('m.label', 'Next Meeting Date')
            ->whereNotNull('m.value')
            ->where('m.value', '!=', '0000-00-00')
            ->select('m.form_group_id', 'm.meeting_group');

        // 3️⃣ Apply date filter on LATEST meeting only
        switch ($type) {

            case 'today':
                $latestMeetingQuery->whereDate(
                    DB::raw($dateExpression),
                    $today->toDateString()
                );
                break;

            case 'tomorrow':
                $latestMeetingQuery->whereDate(
                    DB::raw($dateExpression),
                    $today->copy()->addDay()->toDateString()
                );
                break;

            case 'next_week':
                $latestMeetingQuery->whereBetween(
                    DB::raw($dateExpression),
                    [
                        $today->copy()->addDay()->toDateString(),
                        $today->copy()->addWeek()->toDateString()
                    ]
                );
                break;

            case 'current_month':
                $latestMeetingQuery
                    ->whereMonth(DB::raw($dateExpression), $today->month)
                    ->whereYear(DB::raw($dateExpression), $today->year);
                break;
        }

        // 4️⃣ Get ACTIVE meeting groups (latest only)
        $activeMeetingGroups = $latestMeetingQuery
            ->distinct()
            ->pluck('meeting_group');

        // 5️⃣ Final form_group_ids
        $formGroupIds = Meeting::query()
            ->whereIn('meeting_group', $activeMeetingGroups)
            ->distinct()
            ->pluck('form_group_id');

        return $this->buildLeadResponse($formGroupIds);

    }
    private function buildLeadResponse($formGroupIds)
    {
        if ($formGroupIds->isEmpty()) {
            return response()->json([
                'success' => true,
                'html' => view('admin.partials.lead_list', [
                    'leads' => collect(),
                    'fieldsorder' => [],
                    'tablefield' => []
                ])->render()
            ]);
        }

        $leaddata = TemplateData::with('field')
            ->where('template_name', 'Lead Master')
            ->empScope()
            ->whereIn('form_group_id', $formGroupIds)
            ->get()
            ->groupBy('form_group_id');

        $latestMeetings = Meeting::query()
            ->empScope()
            ->whereIn('form_group_id', $formGroupIds)
            ->get()
            ->groupBy('form_group_id');

        $meetingCounts = Meeting::query()
            ->empScope()
            ->whereIn('form_group_id', $formGroupIds)
            ->select('form_group_id')
            ->selectRaw('COUNT(DISTINCT meeting_group) as total_meetings')
            ->groupBy('form_group_id')
            ->pluck('total_meetings', 'form_group_id');

        $leads = $formGroupIds->map(function ($groupId) use ($leaddata, $latestMeetings, $meetingCounts) {
            return [
                'form_group_id' => $groupId,
                'lead'          => $leaddata[$groupId] ?? collect(),
                'meeting'       => $latestMeetings[$groupId] ?? collect(),
                'meeting_count' => $meetingCounts[$groupId] ?? 0,
            ];
        });

        $fieldsorder = LeadFieldOrder::where('emp_id', auth()->id())
            ->where('template_name', 'lead_master')
            ->orderBy('order_number')
            ->pluck('field_name')
            ->toArray();

        $tablefield = TemplateMaster::with(['field', 'field.templateData'])
            ->whereIn('name', ['Lead Master', 'Lead Meetings'])
            ->orderBy('order_no', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'html' => view(
                'admin.partials.lead_list',
                compact('leads', 'fieldsorder', 'tablefield')
            )->render()
        ]);
    }

    public function about_us_edit()
    {
        $about = AboutUs::first();
        return view('admin.aboutus', compact('about'));
    }
    public function about_us_update(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'main_image'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024',
            'second_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024',
        ]);
        $about = AboutUs::first() ?? new AboutUs;
        if ($request->hasFile('main_image')) {
            $file = $request->file('main_image');
            $filename = 'main_' . time() . '.' . $file->getClientOriginalExtension();
            $path = 'about/';
            $file->move(public_path($path), $filename);
            if (!empty($about->main_image) && file_exists(public_path($about->main_image))) {
                unlink(public_path($about->main_image));
            }
            $data['main_image'] = $path . $filename;
        }
        if ($request->hasFile('second_image')) {
            $file = $request->file('second_image');
            $filename = 'second_' . time() . '.' . $file->getClientOriginalExtension();
            $path = 'about/';
            $file->move(public_path($path), $filename);
            if (!empty($about->second_image) && file_exists(public_path($about->second_image))) {
                unlink(public_path($about->second_image));
            }
            $data['second_image'] = $path . $filename;
        }

        $data['title'] = $request->title;
        $data['description'] = $request->description;
        $about->updateOrCreate(['id' => $about->id], $data);
        return response()->json([
            'status' => true,
            'message' => 'About Us updated successfully'
        ]);
    }
    public function contact_settings()
    {
        $contact = ContactSetting::first();
        return view('admin.contact_settings', compact('contact'));
    }
    public function contact_settings_update(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'phone' => 'required',
        ]);

        $contact = ContactSetting::first() ?? new ContactSetting();

        $contact->updateOrCreate(
            ['id' => $contact->id ?? null],
            $request->only([
                'email',
                'phone',
                'address',
                'map_link',
                'facebook',
                'twitter',
                'linkedin',
                'instagram'
            ])
        );

        return response()->json(['status' => true, 'message' => 'Contact settings saved successfully']);
    }
    public function inquery_list()
    {
        $inquiries = Inquery::latest()->get();
        return view('admin.inquiries', compact('inquiries'));
    }
    public function inquiry_delete($id)
    {
        $inquiry = Inquery::find($id);

        if (!$inquiry) {
            return response()->json(['success' => false, 'message' => 'Inquiry not found']);
        }

        $inquiry->delete();

        return response()->json(['success' => true, 'message' => 'Inquiry deleted successfully']);
    }
    public function why_choose_us()
    {
        $choose_us = WhyChooseUs::first();
        return view('admin.why_choose_us', compact('choose_us'));
    }
    public function update_why_choose_us(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string',
            'list_one' => 'nullable|string',
            'list_two' => 'nullable|string',
            'list_three' => 'nullable|string',
            'list_four' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Collect form fields except image
        $data = $request->only([
            'title',
            'short_description',
            'list_one',
            'list_two',
            'list_three',
            'list_four'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = 'uploads/why_choose_us/';
            $file->move(public_path($path), $filename);
            $data['image'] = $path . $filename;
        }

        // Update or create record (always ID = 1)
        WhyChooseUs::updateOrCreate(['id' => 1], $data);

        return response()->json([
            'success' => true,
            'message' => 'Why Choose Us updated successfully.'
        ]);
    }
}
