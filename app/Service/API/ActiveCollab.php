<?php

namespace App\Service\API;

use Exception;

use Illuminate\Support\Facades\Http;

class ActiveCollab
{
    const BASE_URL = "https://app.activecollab.com/119734/api/v7/";
    const HEADER = "X-Angie-AuthApiToken";

    /**
     * Returns the ActiveCollab API key. If the key is not set in the env,
     * an exception with an error message is thrown.
     * 
     * @return string
     * @throws Exception
     */
    private function getToken()
    {
        $token = env("ACTIVECOLLAB_API_KEY");

        if (is_null($token))
            throw new Exception("No Ahrefs API key has been set in the env file");

        return $token;
    }

    /**
     * Returns the required Header contents for a successful ActiveCollab
     * API request.
     * 
     * @return array
     * @throws Exception
     */
    private function getHeader()
    {
        return [
            "X-Angie-AuthApiToken" => $this->getToken()
        ];
    }

    /**
     * Performs a HTTP request to fetch data from the ActiveCollab API.
     */
    public function fetch($endpoint)
    {
        $response = Http::withHeaders(
            $this->getHeader()
        )->get(self::BASE_URL . $endpoint);

        if ($response->successful())
            return $response->json();
        else
            return null;
    }
}