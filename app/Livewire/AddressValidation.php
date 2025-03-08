<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class AddressValidation extends Component
{
    public $street_name, $suburb, $postcode, $state;
    public $validationMessage;
    public $validAddress;
    public $loading = false;

    public function validateAddress()
    {
        $this->loading = true;

        $response = Http::post('https://extranet.asmorphic.com/api/orders/findaddress', [
            'company_id' => 17,
            'street_name' => $this->street_name,
            'suburb' => $this->suburb,
            'postcode' => $this->postcode,
            'state' => $this->state,
        ]);

        $data = $response->json();

        if (isset($data[0]['DirectoryIdentifier'])) {
            $this->validAddress = $data[0]['Address'];
            $this->validationMessage = 'Address is valid!';
        } else {
            $this->validAddress = null;
            $this->validationMessage = 'Address not valid!';
        }

        $this->loading = false;
    }

    public function render()
    {
        return view('livewire.address-validation');
    }
}
