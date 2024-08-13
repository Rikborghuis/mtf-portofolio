<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CarInfo;
use App\Models\Condition;
use App\Models\Documentation;
use App\Models\ExteriorInterior;
use App\Models\FuelEmission;
use App\Models\TechInfo;
use App\Models\Post;


class CarSeeder extends Seeder
{
    public function run()
    {
        for ($i = 0; $i < 100; $i++) {
            $this->createCar($i);
        }
    }

    private function createCar($i)
    {
        $features = [
            '4x4',
            'Adaptive cruise control',
            'Automatische klimaatregeling',
            'Elektrische ramen',
            'Stoelverwarming',
            'Xenon verlichting',
            'ABS',
            'Airconditioning',
            'Cruise control',
            'Led Verliching',
            'Navigatie systeem',
            'Trekhaak',
            'Android auto',
            'Apple carplay',
            'Armsteun'
        ];

        $merken = [
            'BMW',
            'Audi',
            'Mercedes',
            'Tesla',
            'Lexus',
            'Renault',
        ];

        $modellen = [
            's-classe',
            'sportback',
            'panda',
            'mx-30',
            'polo',
            '5-serie'
        ];

        $carroseries = [
            'Hatchback',
            'Coupe',
            'Station',
            'Cabriolet',
            'SUV'
        ];

        $randomFeature = $features[array_rand($features)];
        $randomMerken = $merken[array_rand($merken)];
        $randomModellen = $modellen[array_rand($modellen)];
        $randomCarroseries = $carroseries[array_rand($carroseries)];


        $carInfo = CarInfo::create([
            'merk' => $randomMerken,
            'model' => $randomModellen,
            'variant' => 'Variant ' . ($i + 1),
            'carroserie' => $randomCarroseries,
            'seats' => rand(2, 7),
            'doors' => rand(2, 5),
            'features' => $randomFeature,
        ]);

        $condition = Condition::create([
            'used' => rand(0, 1),
            'damage' => rand(0, 1),
            'owners' => rand(1, 5),
            'smokers_car' => rand(0, 1),
            'general_condition' => 'Condition ' . ($i + 1),
            'mileage' => rand(10000, 200000),
            'age' => rand(1990, 2024),
        ]);

        $documentation = Documentation::create([
            'apk_date' => now()->addDays(rand(1, 365)),
            'license_plate' => 'Plate ' . ($i + 1),
            'btw_car' => rand(0, 1),
            'tax' => rand(100, 500),
            'factory_warenty' => rand(0, 1),
            'bovag_warenty' => rand(0, 1),
            'nap_check' => rand(0, 1),
        ]);

        $exteriorColors = [
            'Beige',
            'Groen',
            'Oranje',
            'Blauw',
            'Rood',
            'Goud',
            'Bruin',
            'Zwart',
            'Brons',
            'Zilver',
            'Geel',
            'Paars',
            'Grijs',
            'Wit'
        ];

        $exteriorMaterials = [
            '1K-primer',
            '1k-kunstofprimer',
            '2k-lak',
            'metallic',
        ];

        $interiorColors = [
            'Beige',
            'Rood',
            'Wit',
            'Zwart',
            'Groen',
            'Grijs',
            'Geel',
            'Bruin',
            'Oranje',
            'Blauw',
            'Andere'
        ];

        $interiorMaterials = [
            'Alcantara',
            'Leder',
            'Velours',
            'Stof',
            'Half leder',
            'Andere'
        ];

        $randomExteriorMaterial = $exteriorMaterials[array_rand($exteriorMaterials)];
        $randomExteriorColor = $exteriorColors[array_rand($exteriorColors)];

        $randomInteriorColor = $interiorColors[array_rand($interiorColors)];
        $randomInteriorMaterial = $interiorMaterials[array_rand($interiorMaterials)];

        $exteriorInterior = ExteriorInterior::create([
            'exterior_color' => $randomExteriorColor,
            'exterior_material' => $randomExteriorMaterial,
            'interior_color' => $randomInteriorColor,
            'interior_material' => $randomInteriorMaterial,
        ]);

        $fuels = [
            'Benzine',
            'Diesel',
            'Electrisch',
            'Hybride',
            'Overige',
        ];

        $randomFuels = $fuels[array_rand($fuels)];


        $transmissions = [
            'Automaat',
            'Handgeschakeld',
            'Semi Automaat',
        ];
        $drives = [
            'Voor wielen ',
            'achter wielen',
            '4 wheel drive',
        ];

        $randomTransmissions = $transmissions[array_rand($transmissions)];
        $randomDrives = $drives[array_rand($drives)];

        $techInfo = TechInfo::create([
            'transmission' => $randomTransmissions,
            'drive' => $randomDrives,
            'top_speed' => rand(150, 250),
            'acceleration' => rand(6, 12),
            'engine_power' => rand(100, 300),
            'cilinders' => rand(4, 8),
            'cilinder_volume' => rand(1, 4) . '.' . rand(0, 9),
            'gears' => rand(5, 6),
            'empty_weight' => rand(1000, 2000),
        ]);

        Post::create([
            'documentation_id' => $documentation->id,

            'tech_info_id' => $techInfo->id,
            'condition_id' => $condition->id,
            'car_info_id' => $carInfo->id,
            'exterior_interior_id' => $exteriorInterior->id,
            'name' => 'Car ' . ($i + 1),
            'disc' => 'Description for Car ' . ($i + 1),
            'img_path' => 'model.webp',
            'price' => rand(10000, 50000),
            'discounted_price' => rand(9000, 45000),
            'lease_price' => rand(200, 1000),
            'discounted_lease_price' => rand(180, 900),
            'discounted' => rand(0, 1),
            'new' => rand(0, 1),
        ]);
    }
}
