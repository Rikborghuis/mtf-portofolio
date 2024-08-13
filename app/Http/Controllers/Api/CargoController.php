<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

use App\Models\CarInfo;
use App\Models\Condition;
use App\Models\Documentation;
use App\Models\ExteriorInterior;
use App\Models\TechInfo;
use App\Models\Post;
use App\Models\Image;

use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class CargoController extends Controller
{


    public function handleCar(Request $request)
    {

        // Retrieve the raw XML data from the request
        $xmlContent = $request->getContent();

        // Parse the XML data
        $xml = simplexml_load_string($xmlContent, null, LIBXML_NOENT | LIBXML_DTDLOAD);


        if ($xml === false) {
            // Handle XML parsing error
            return response('0', 400); // Respond with '0' in case of error
        }

        // Optionally convert to JSON or an associative array
        $json = json_encode($xml);
        $data = json_decode($json, true);

        //handle arrays

        if (isset($data['accessoires']['accessoire'])) {
            $accessoires = $data['accessoires']['accessoire'];
            if (is_array($accessoires)) {
                $accessoires = array_map(function ($item) {
                    return $item['naam'];
                }, $accessoires);
                $accessoires = implode(', ', $accessoires);
            }
        } else {
            $accessoires = null;
        }






        if (isset($data['verkoopprijs_particulier']['prijs'])) {
            $verkoopprijs_particulier = $data['verkoopprijs_particulier']['prijs']['bedrag'];
        } else {
            $verkoopprijs_particulier = null;
        }

        if ($request->filled('actieprijs')) {
            $actieprijs = $data['actieprijs'];
        } else {
            $actieprijs = null;
        }
        // $highlights = implode(',', $data['highlights']);

        if (isset($data['motorrijtuigen_belasting']['kwartaal_max']['prijs'])) {
            $belasting = $data['motorrijtuigen_belasting']['kwartaal_max']['prijs']['bedrag'];
        } else {
            $belasting = null;
        }




        //seperate split 1 value into 2 

        if (isset($xml->apk)) {
            $apktot = (string) $xml->apk['tot'] ?? null;
            $apkBijAflevering = (string) $xml->apk['bij_aflevering'] ?? null;
        }
        //change bool format from j or n to 1 or 0
        if ($data['nap_weblabel'] === 'j') {
            $napweblabel = 1;
        } else {
            $napweblabel = 0;
        };

        //handle booleans

        if (
            $data['nap_weblabel'] === 'j'
        ) {
            $napweblabel = true;
        } else {
            $napweblabel = false;
        };


        if ($apkBijAflevering === 'j') {
            $apkBijAfleveringBool = true;
        } else {
            $apkBijAfleveringBool = false;
        }

        if ($data['nieuw_voertuig'] === 'j') {
            $nieuweauto = true;
        } else {
            $nieuweauto = false;
        };


        // change date format
        $formattedApk = null;
        if (!empty($apktot)) {
            $parseDate = Carbon::createFromFormat('d-m-Y', $apktot);
            $formattedApk = $parseDate->format('Y-m-d');
        }

        if ($data['btw_marge'] === 'B') {
            $btwMarge = 'BTW-voertuig';
        } else {
            $btwMarge = 'Marge-regeling';
        }


        // switch cases 
        switch ($data['brandstof']) {
            case 'B':
                $brandstof = 'Benzine';
                break;
            case 'D':
                $brandstof = 'Diesel';
                break;
            case 'G':
                $brandstof = 'LPG';
                break;
            case '3':
                $brandstof = 'LPG G3';
                break;
            case 'E':
                $brandstof = 'Elektrisch';
                break;
            case 'B,E':
                $brandstof = 'Benzine / Elektrisch';
                break;
            case 'D,E':
                $brandstof = 'Diesel / Elektrisch';
                break;
            case 'H':
                $brandstof = 'Hybride';
                break;
            case 'C':
                $brandstof = 'Aardgas';
                break;
            case 'A':
                $brandstof = 'Alcohol';
                break;
            case 'I':
                $brandstof = 'Biodiesel';
                break;
            case '8':
                $brandstof = 'E85';
                break;
            case 'N':
                $brandstof = 'HCNG';
                break;
            case 'O':
                $brandstof = 'Overig';
                break;
            default:
                $brandstof = 'Onbekend'; // In case of an unknown fuel type
        }

        switch ($data['transmissie']) {
            case 'H';
                $transmissie = "Handgeschakeld";
                break;
            case 'A';
                $transmissie = "Automaat";
                break;
            case 'C';
                $transmissie = "CVT";
                break;
            case 'S';
                $transmissie = "Semi-Automaat";
        }

        switch ($data['emissieklasse']) {
            case '0':
                $emissieklasse = "Emissieklasse 0";
                break;
            case '1':
                $emissieklasse = "Emissieklasse 1";
                break;
            case '2':
                $emissieklasse = "Emissieklasse 2";
                break;
            case '3':
                $emissieklasse = "Emissieklasse 3";
                break;
            case '4':
                $emissieklasse = "Emissieklasse 4";
                break;
            case '5':
                $emissieklasse = "Emissieklasse 5";
                break;
            case '6':
                $emissieklasse = "Emissieklasse 6";
                break;
            case '6b':
                $emissieklasse = "Emissieklasse 6b";
                break;
            case '6c':
                $emissieklasse = "Emissieklasse 6c";
                break;
            case '6d-TEMP':
                $emissieklasse = "Emissieklasse 6d-TEMP";
                break;
            case '6d':
                $emissieklasse = "Emissieklasse 6d";
                break;
            default:
                $emissieklasse = "Unknown Emissieklasse";
                break;
        }




        // Save the data to the existing table
        $carInfo = CarInfo::create([
            'voertuignr_hexon' => $data['voertuignr_hexon'] ?? null,
            'merk' => $data['merk'] ?? null,
            'model' => $data['model'] ?? null,
            'type' => $data['type'] ?? null,
            'carrosserie' => $data['carrosserie'] ?? null,
            'aantal_zitplaatsen' => $data['aantal_zitplaatsen'] ?? null,
            'aantal_deuren' => $data['aantal_deuren'] ?? null,
            'aandrijving' => $data['aandrijving'] ?? null,
            'massa' => $data['massa'] ?? null,
            'accessoires' => $accessoires,
            'updated_at' => now(),
            'created_at' => now(),

        ]);

        $condition = Condition::create([
            'tellerstand' => $data['tellerstand'] ?? null,
            'bouwjaar' => $data['bouwjaar'] ?? null,
            'staat_algemeen' => $data['staat_algemeen'] ?? null,
            'nieuw_voertuig' => $nieuweauto ?? null,
            'updated_at' => now(),
            'created_at' => now(),

        ]);
        $documentation = Documentation::create([
            'apk_tot' => $formattedApk ?? null,
            'apk_bij_aflevering' => $apkBijAfleveringBool ?? null,
            'kenteken' => $data['kenteken'] ?? null,
            'btw_marge' => $btwMarge ?? null,
            'belasting' => $belasting ?? null,
            'fabrieksgarantie_tot' => !empty($data['fabrieksgarantie_tot']) ? $data['fabrieksgarantie_tot'] : null,
            'nap_weblabel' => $napweblabel ?? null,
            'updated_at' => now(),
            'created_at' => now(),

        ]);
        $exteriorInterior = ExteriorInterior::create([
            'basiskleur' => $data['basiskleur'] ?? null,
            'laksoort' => $data['laksoort'] ?? null,
            'interieurkleur' => $data['interieurkleur'] ?? null,
            'bekleding' => $data['bekleding'] ?? null,
            'updated_at' => now(),
            'created_at' => now(),
        ]);


        $techInfo = TechInfo::create([
            'brandstof' => $brandstof ?? null,
            'gemiddeld_verbruik' => $data['gemiddeld_verbruik'] ?? null,
            'verbruik_stad' => $data['verbruik_stad'] ?? null,
            'verbruik_snelweg' => $data['verbruik_snelweg'] ?? null,
            'co2_uitstoot' => $data['co2_uitstoot'] ?? null,
            'emissieklasse' => $emissieklasse ?? null,
            'transmissie' => $transmissie ?? null,
            'aantal_versnellingen' => $data['aantal_versnellingen'] ?? null,
            'cilinder_inhoud' => $data['cilinder_inhoud'] ?? null,
            'cilinder_aantal' => $data['cilinder_aantal'] ?? null,
            'vermogen_motor_kw' => $data['vermogen_motor_kw'] ?? null,
            'topsnelheid' => $data['topsnelheid'] ?? null,
            'acceleratie' => $data['acceleratie'] ?? null,
            'updated_at' => now(),
            'created_at' => now(),
        ]);

        /* $image = Image::create([
            'url' => $url,
            'nr' => $nr,
            'bestandsnaam' => $bestandsnaam,
            'updated_at' => now(),
            'created_at' => now(),
        ]);
*/
        $post = Post::create([
            'documentation_id' => $documentation->id,
            'tech_info_id' => $techInfo->id,
            'condition_id' => $condition->id,
            'car_info_id' => $carInfo->id,
            'exterior_interior_id' => $exteriorInterior->id,
            'verkoopprijs_particulier' => $verkoopprijs_particulier ?? null,
            'opmerkingen' => $data['opmerkingen'] ?? null,
            'highlights' => $data['highlights'] ?? null,
            'lease_maandbedrag' => $data['lease_maandbedrag'] ?? null,
            'actieprijs' => $actieprijs ?? null,
            'updated_at' => now(),
            'created_at' => now(),
        ]);



        // Handle images and collect their IDs
        if (isset($xml->afbeeldingen)) {
            foreach ($xml->afbeeldingen->afbeelding as $afbeelding) {
                $nr = (int) $afbeelding['nr'] ?? null;
                $url = (string) $afbeelding->url;
                if ($url && $nr) {
                    $this->downloadAndStoreImage($url);
                    $bestandsnaam = basename($url);
                    $image = Image::create([
                        'nr' => $nr,
                        'post_id' => $post->id,
                        'bestandsnaam' => $bestandsnaam,
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]);
                }
            }
        }





        // Respond with '1' to indicate success
        return response('1', 200);
    }

    protected function downloadAndStoreImage($url)
    {
        $filename = basename($url);

        // Download the image
        $response = Http::get($url);

        // Check if the request was successful
        if ($response->successful()) {
            // Save the image to the public storage
            Storage::disk('public')->put("images/{$filename}", $response->body());
        } else {
            // Handle the error
            echo 'unlucky geen image voor jouw';
        }
    }
}
