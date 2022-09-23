<?php

namespace App\Models;

use CodeIgniter\Model;

class Faq extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'faq';
    protected $primaryKey       = 'faq_id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['question', 'answer'];

    public function CurlRequest($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);

        // curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        //     'X-CoinAPI-Key: ' . $this->ApiKey,
        //     'Content-Type: application'
        // ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);

        $http_status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        //dd($http_status_code);
        return json_decode($output, true);
    }

    function GetFaqLatest()
    {
        $url = "http://localhost:8080/api/faq";
        return $this->CurlRequest($url);
    }
}