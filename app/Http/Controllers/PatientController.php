<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use App\Http\Requests\PatientStoreRequest;
use App\Http\Requests\PatientUpdateRequest;
use App\Http\Controllers\GlobalTrait\SessionManager;
use Dompdf\Dompdf;
use Dompdf\Options;
use Dompdf\Canvas;
use Dompdf\Adapter\CPDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PatientController extends Controller
{
    use SessionManager;
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Patient::class);

        $search = $request->get('search', '');

        $patients = Patient::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();
            

        return view('app.patients.index', compact('patients', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Patient::class);
        $last_activity = 'Create Patient'; 
        $sess_remark = 0;
        $this->crudSessions($request, $last_activity, $sess_remark);

        return view('app.patients.create');
    }

    /**
     * @param \App\Http\Requests\PatientStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PatientStoreRequest $request)
    {
        $this->authorize('create', Patient::class);

        $validated = $request->validated();

        $patient = Patient::create($validated);

        $last_activity = 'Patient Created'; 
        $sess_remark = $patient->id;
        $this->crudSessions($request, $last_activity, $sess_remark);

        // Redirect to the assessment create page with the patient ID
        return redirect()
            ->route('assessments.create', ['patient_id' => $patient->id])
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Patient $patient
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Patient $patient)
    {
        $this->authorize('view', $patient);
        $last_activity = 'View Patient'; 
        $sess_remark = $patient->id;
        $this->crudSessions($request, $last_activity, $sess_remark);

        return view('app.patients.show', compact('patient'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Patient $patient
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Patient $patient)
    {
        $this->authorize('update', $patient);
        $last_activity = 'Update Patient'; 
        $sess_remark = $patient->id;
        $this->crudSessions($request, $last_activity, $sess_remark);

        return view('app.patients.edit', compact('patient'));
    }

    /**
     * @param \App\Http\Requests\PatientUpdateRequest $request
     * @param \App\Models\Patient $patient
     * @return \Illuminate\Http\Response
     */
    public function update(PatientUpdateRequest $request, Patient $patient)
    {
        $this->authorize('update', $patient);

        $validated = $request->validated();

        $patient->update($validated);
        $last_activity = 'Patient Updated'; 
        $sess_remark = $patient->id;
        $this->crudSessions($request, $last_activity, $sess_remark);

        return redirect()
            ->route('patients.edit', $patient)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Patient $patient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Patient $patient)
    {
        $this->authorize('delete', $patient);

        $patient->delete();
        $last_activity = 'Patient Deleted'; 
        $sess_remark = $patient->id;
        $this->crudSessions($request, $last_activity, $sess_remark);

        return redirect()
            ->route('patients.index')
            ->withSuccess(__('crud.common.removed'));
    }

    public function generatePdf(Request $request, Patient $patient)
    {

        if (Gate::denies('generatePdf', $patient)) {
            // Log session activity for unauthorized attempt
            $last_activity = 'Unauthorized attempt to generate PDF'; 
            $sess_remark = $patient->id;
            $this->crudSessions($request, $last_activity, $sess_remark);
            
            abort(403, 'Unauthorized action.');
        }

        // Retrieve the authenticated user's name
        $username = Auth::user()->name;
    
        // Concatenate the username with an underscore and last 4 digits of their phone number
        $fileName = $username . 'patient->id';
    
        // Create Dompdf instance
        $dompdf = new Dompdf();
    
        // Load HTML content
        $html = view('app.patients.pdf', compact('patient'))->render();
    
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
    
        // (Optional) Set paper size and orientation
        $dompdf->setPaper('A4', 'portrait');
    
        // Render PDF (optional)
        $dompdf->render();
    
        // Add watermark to each page with the username
        $dompdf->getOptions()->set('isPhpEnabled', true); // Enable PHP script execution
    
        $dompdf->getOptions()->set('isHtml5ParserEnabled', true);

        $last_activity = 'PDF Patient Generated'; 
        $sess_remark = $patient->id;
        $this->crudSessions($request, $last_activity, $sess_remark);
    
    
        // Output PDF to browser with the custom file name
        return $dompdf->stream($fileName);
    }
}
