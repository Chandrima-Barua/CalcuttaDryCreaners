<?php

namespace App\Http\Controllers;

use App\Legal;
use App\LegalCategory;
use App\User;
use Illuminate\Http\Request;
use Validator;

class LegalDocumentsController extends Controller
{

    public function index()
    {
        $legals = Legal::all();

        return view('legal_documents.index', compact('legals'));
    }

    public function create()
    {
        $legal_categories = LegalCategory::all();

        return view('legal_documents.create', compact('legal_categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'legal_categories_id ' => 'required|integer',
            'bike_starting' => 'date',
            'bike_ending' => 'date',
            'insurance_starting' => 'required|date',
            'insurance_ending' => 'required|date',
            'taxtoken_starting' => 'required|date',
            'taxtoken_ending' => 'required|date',
            'fitness_starting' => 'date',
            'fitness_ending' => 'date',
        ]);

        $legal = new Legal();
        $legal->legal_categories_id = $request->input('legalcategory');
        $legal->bike_starting = $request->input('bike_starting');
        $legal->bike_ending = $request->input('bike_ending');
        $legal->insurance_starting = $request->input('insurance_starting');
        $legal->insurance_ending = $request->input('insurance_ending');
        $legal->taxtoken_starting = $request->input('taxtoken_starting');
        $legal->taxtoken_ending = $request->input('taxtoken_ending');
        $legal->fitness_starting = $request->input('fitness_starting');
        $legal->fitness_ending = $request->input('fitness_ending');
        $legal->save();

        return redirect('/legal_documents')->with('success', 'Legal Document created!');
    }

    public function show($id)
    {
        $legal_document = Legal::find($id);

        return view('legal_documents.show', compact('legal_document'));
    }

    public function edit($id)
    {
        $legal_categories = LegalCategory::all();
        $legal_document = Legal::find($id);

        return view('legal_documents.edit', compact('legal_document', 'legal_categories'));
    }

    public function update(Request $request, $id)
    {
        
        $validator = Validator::make($request->all(), [
            'legal_categories_id ' => 'required|integer',
            'bike_starting' => 'date',
            'bike_ending' => 'date',
            'insurance_starting' => 'required|date',
            'insurance_ending' => 'required|date',
            'taxtoken_starting' => 'required|date',
            'taxtoken_ending' => 'required|date',
            'fitness_starting' => 'date',
            'fitness_ending' => 'date',
        ]);

        $legal = Legal::find($id);
        $legal->legal_categories_id = $request->input('legalcategory');
        $legal->bike_starting = $request->input('bike_starting');
        $legal->bike_ending = $request->input('bike_ending');
        $legal->insurance_starting = $request->input('insurance_starting');
        $legal->insurance_ending = $request->input('insurance_ending');
        $legal->taxtoken_starting = $request->input('taxtoken_starting');
        $legal->taxtoken_ending = $request->input('taxtoken_ending');
        $legal->fitness_starting = $request->input('fitness_starting');
        $legal->fitness_ending = $request->input('fitness_ending');
        $legal->save();

        return redirect('/legal_documents')->with('success', 'Legal Document created!');
    }

    public function destroy($id)
    {
        $legal = Legal::find($id);
        $legal->delete();

        return redirect('/legal_documents')->with('success', 'Legal Document deleted!');
    }

    public function send_notification(Request $request, $id)
    {
        $legal = Legal::find($id);
        $users = User::all();

        return view('legal_documents.notification')->with(['legal' => $legal, 'users' => $users]);
    }

    public function set_deadline(Request $request)
    {
        $request->validate([
            'users*' => 'required',
            'deadline_date' => 'required',
        ]);
        for ($i = 0; $i < count($request->users); ++$i) {
            $user = User::find($request->users[$i]);
            $user->deadline_date = ($request->deadline_date);
            $user->save();
        }

        return redirect('/legal_documents')->with('success', 'Notification will be sent!');
    }
}
