<?php

namespace App\Http\Controllers;

use App\ContactFieldValue;
use App\ContactField;
use App\Http\Requests\ContactFieldRequest;
use App\Privacy;
use Illuminate\Http\Request;

class ContactFieldsController extends Controller
{
    /**
     * List contact information
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $contactFields = ContactField::all();
        $contactFieldValuesGrouped = auth()->user()->contactFieldValues()
            ->with(['contactField', 'defaultLabel', 'privacy'])
            ->get()
            ->groupBy('contactField.type');

        return view('settings.contactfield.index', [
            'contactFields' => $contactFields,
            'contactFieldValuesGrouped' => $contactFieldValuesGrouped,
        ]);
    }

    /**
     * Show add form
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        $contactField = ContactField::where('type', $request->get('type'))->first();
        if (!$contactField) {
            return redirect('/settings/contactfield');
        }

        $labels = $contactField->defaultLabels;
        $privacyCollect = Privacy::all();

        return view('settings.contactfield.add', [
            'contact_field_id' => $contactField->id,
            'field' => new ContactFieldValue,
            'labels' => $labels,
            'privacyCollect' => $privacyCollect,
            'type' => __('settings.' . $request->get('type') . '_type'),
        ]);
    }

    /**
     * Store information
     *
     * @param ContactFieldRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ContactFieldRequest $request)
    {
        // Store to intermediate table
        $data = $request->only([
            'contact_field_id',
            'label_id',
            'privacy_id',
            'value',
        ]);
        auth()->user()->contactFieldValues()->create($data);

        return redirect('settings/contactfield')
            ->with('status', __('settings.contact_information_saved'));
    }

    /**
     * Show edit form
     *
     * @param ContactFieldValue $field
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function edit(ContactFieldValue $field)
    {
        $labels = $field->contactField->defaultLabels;
        $privacyCollect = Privacy::all();

        return view('settings.contactfield.edit', [
            'contact_field_id' => $field->contactField->id,
            'field' => $field,
            'labels' => $labels,
            'privacyCollect' => $privacyCollect,
            'type' => __('settings.' . $field->contactField->type . '_type')
        ]);
    }

    /**
     * Update information
     *
     * @param ContactFieldRequest $request
     * @param ContactFieldValue $field
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ContactFieldRequest $request, ContactFieldValue $field)
    {
        $data = $request->only(['contact_field_id', 'label_id', 'privacy_id', 'value']);
        $field->update($data);

        return redirect('settings/contactfield')
            ->with('status', __('settings.contact_information_changed'));
    }

    /**
     * Delete information
     *
     * @param ContactFieldValue $contactFieldValue
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(ContactFieldValue $contactFieldValue)
    {
        $contactFieldValue->delete();

        return redirect('settings/contactfield')
            ->with('status', __('settings.contact_information_deleted'));
    }
}
