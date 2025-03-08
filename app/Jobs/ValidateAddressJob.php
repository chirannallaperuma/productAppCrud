<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class ValidateAddressJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $product;
    public $address;

    /**
     * Create a new job instance.
     *
     * @param  \App\Models\Product  $product
     * @param  string  $address
     * @return void
     */
    public function __construct(Product $product, string $address)
    {
        $this->product = $product;
        $this->address = $address;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $addressComponents = $this->parseAddress($this->address);

            Log::info("Parsed address: " . json_encode($addressComponents, JSON_PRETTY_PRINT));

            $validated = $this->validateAddress(
                (string) $addressComponents['street_number'],
                (string) $addressComponents['street_name'],
                (string) $addressComponents['suburb'],
                (string) $addressComponents['postcode'],
                (string) $addressComponents['state'],
                (string) $addressComponents['country']
            );

            if ($validated) {
                $this->product->status = 'Valid Address';
                $this->product->save();

                Notification::make()
                    ->title('Address Validated Successfully')
                    ->success()
                    ->send();
            } else {
                $this->product->status = 'Invalid Address';
                $this->product->save();

                Notification::make()
                    ->title('Invalid Address')
                    ->danger()
                    ->send();
            }
        } catch (\Exception $e) {
            Log::error("Error during address validation: " . $e->getMessage());
            Log::error("Stack Trace: " . $e->getTraceAsString());

            $this->product->status = 'Error in Validation';
            $this->product->save();

            Notification::make()
                ->title('Error During Address Validation')
                ->danger()
                ->send();
        }
    }

    /**
     * Parse the address to extract street, suburb, postcode, and state.
     *
     * @param string $address
     * @return array
     */
    private function parseAddress(string $address): array
    {
        Log::info("Raw address: " . $address);

        // Extract country
        preg_match('/,\s*([A-Za-z\s]+)$/i', $address, $countryMatch);
        $country = trim($countryMatch[1] ?? '');

        $address = preg_replace('/,?\s*' . preg_quote($country, '/') . '$/i', '', $address);

        Log::info("Extracted country: " . $country);
        Log::info("Address after removing country: " . $address);

        $components = array_map('trim', explode(',', $address));
        Log::info("Address components: " . json_encode($components));

        if (count($components) < 2) {
            Log::error("Invalid address format: " . json_encode($components));
            throw new \Exception("Address format is invalid.");
        }

        $street_full = $components[0] ?? '';
        $suburbState = $components[1] ?? '';

        // Extract street number and street name
        preg_match('/^(\d+)\s+(.*)$/', $street_full, $streetMatches);
        $street_number = $streetMatches[1] ?? '';
        $street_name = $streetMatches[2] ?? $street_full;

        // Extract suburb and state correctly
        $state = '';
        $suburb = '';
        $postcode = '0000';

        if (preg_match('/^(.*)\s+([A-Z]{2,3})$/', $suburbState, $matches)) {
            $suburb = trim($matches[1]);
            $state = trim($matches[2]);
        } else {
            $suburb = $suburbState;
            $state = '';
        }

        Log::info("Extracted Suburb: " . $suburb);
        Log::info("Extracted State: " . $state);

        $parsedAddress = [
            'street_number' => (string) $street_number,
            'street_name' => (string) $street_name,
            'suburb' => (string) $suburb,
            'postcode' => (string) $postcode,
            'state' => (string) $state,
            'country' => (string) $country
        ];

        Log::info("Parsed address: " . json_encode($parsedAddress, JSON_PRETTY_PRINT));

        return $parsedAddress;
    }





    /**
     * Validate the address via external API
     *
     * @param  string  $street_name
     * @param  string  $suburb
     * @param  string  $postcode
     * @param  string  $state
     * @return bool
     */
    public function validateAddress(string $street_number, string $street_name, string $suburb, string $postcode, string $state, string $country)
    {
        Log::info("Address Data: Street Number: $street_number, Street: $street_name, Suburb: $suburb, Postcode: $postcode, State: $state, Country: $country");

        $loginResponse = Http::withHeaders([
            'Accept' => 'application/json',
        ])->post('https://extranet.asmorphic.com/api/login', [
            'email' => 'project-test@projecttest.com.au',
            'password' => 'oxhyV9NzkZ^02MEB',
        ]);

        Log::info('Login API Response: ' . $loginResponse->body());

        if (!$loginResponse->successful()) {
            Log::error('Login failed! Response: ' . $loginResponse->body());
            throw new \Exception('API login failed: ' . $loginResponse->body());
        }

        $responseBody = $loginResponse->body();
        $responseArray = json_decode($responseBody, true);
        $token = $responseArray['result']['token'];


        $response = Http::withToken($token)->post('https://extranet.asmorphic.com/api/orders/findaddress', [
            'company_id' => 17,
            'street_number' => $street_number,
            'street_name' => $street_name,
            'suburb' => $suburb,
            'postcode' => $postcode,
            'state' => $state,
            'country' => $country,
        ]);

        Log::info('API Response: ' . json_encode($response->json()));

        Log::info('Request Payload:', [
            'company_id' => 17,
            'street_number' => $street_number,
            'street_name' => $street_name,
            'suburb' => $suburb,
            'postcode' => $postcode,
            'state' => $state,
            'country' => $country,
        ]);

        $data = $response->json();

        if (!is_array($data)) {
            Log::error('Invalid API Response Format: ' . $response->body());
            throw new \Exception('Invalid API response format.');
        }

        Log::info('API Response: ' . json_encode($data, JSON_PRETTY_PRINT));

        if (!isset($data['DirectoryIdentifier'])) {
            Log::error('Validation failed. Response: ' . json_encode($data));
            return false;
        }

        return true;
    }
}
