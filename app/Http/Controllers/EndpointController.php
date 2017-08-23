<?php

namespace App\Http\Controllers\EndpointsAPI;

use App\Http\Controllers\Controller;
use App\Repositories\EndpointRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

class EndpointController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Endpoints Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles serving, creating, updating, and deleting endpoints
    |
    */
    protected $endpoints;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(EndpointRepository $endpoints)
    {
        $this->endpoints = $endpoints;

        $this->middleware('auth');
    }

    /**
     * Query and return a list of the endpoints
     * @return collection
     */
    public function getEndpoints()
    {
        $endpointList = $this->endpoints->all();

        return $endpointList;
    }

    /**
     * Return a particular endpoint
     * @return endpoint
     */
    public function getEndpoint($id)
    {
        $endpoint = $this->endpoints->findById($id);

        return $endpoint;
    }
















    /**
     * Create a new endpoint
     * @return null
     */
    public function createEndpoint()
    {
        $user_id = Auth::id();

        $endpoint = $this->endpoints->newEndpoint();
        $endpoint->id = 0;

    }

    /**
     * Edit a endpoint
     * @param int $id
     * @return view
     */
    public function editContact($id)
    {
        $contact = $this->contacts->findById($id);
        $email_address = $this->contacts->emailAddressFirst($id);
        $phone_number = $this->contacts->phoneNumberFirst($id);
        $address = $this->contacts->addressFirst($id);

        return view('contact.edit', ['contact' => $contact, 'email_address'=>$email_address, 'phone_number'=>$phone_number, 'address'=>$address]);
    }

    /**
     * Save a endpoint
     * @param int $id
     * @param request $request
     * @return view
     */
    public function saveContact($id, Request $request)
    {
        //get form data
        $data = Input::all();

        $this->validate($request, [
            'name' => 'required|max:255',
            'email_address' => 'email',
            'address' => 'string|max:255',
            'number' => "regex:'^[0-9+_\- \(\)]*$'",
            'number_type' => 'alpha_dash',
        ]);

        //check if the id == 0
        //if it does, then the contact is being newly created and needs to be
        if($id == 0) {
            $user_id = Auth::id();
            $contact = $this->contacts->newContact();
            $contact->user_id = $user_id;
        } else {
            $contact = $this->contacts->findById($id);
        }

        //set the contact data here and save it, so that if this was a wholly new contact
        //the othr tables will save correctly
        $contact->name = $data['name'];
        $contact->save();

        //pull the contact_id here. Again, so that creating a contact will save it correctly
        $contact_id = $contact->id;

        $email_address = $this->contacts->emailAddressFirst($contact_id);
        $phone_number = $this->contacts->phoneNumberFirst($contact_id);
        $address = $this->contacts->addressFirst($contact_id);

        $email_address->email_address = $data['email_address'];
        $phone_number->number = preg_replace("/[^0-9]/", "", $data['number']);
        $phone_number->number_type = $data['number_type'];
        $address->address = $data['address'];

        $email_address->save();
        $phone_number->save();
        $address->save();

        return Redirect::route('contact_list');
    }











    /**
     * Delete an endpoint
     * @param int $id
     */
    public function deleteEndpoint($id)
    {
        $endpoint = $this->endpoints->findById($id);

        $endpoint->delete();
    }

    /**
     * Returns a JSON representation of all endpoints
     * @return JSON
     */
    public function getEndpointsJSON()
    {
        $endpoints = $this->getEndpoints();

        return $endpoints->toJson();
    }

    /**
     * Returns a JSON representation of a specific endpoint
     * @param int $id
     * @return JSON
     */
    public function getEndpointJSON($id)
    {
        $endpoint = $this->getEndpoint($id);

        return $endpoint->toJson();
    }



}
