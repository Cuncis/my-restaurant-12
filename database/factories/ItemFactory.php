<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    use HasFactory;

    private static array $menuItems = [
        'Appetizers' => [
            ['name' => 'Lumpia Semarang', 'description' => 'Lumpia goreng khas Semarang berisi rebung, telur, dan udang, disajikan dengan saus kacang manis.'],
            ['name' => 'Siomay Bandung', 'description' => 'Siomay ikan tenggiri kukus khas Bandung, disajikan dengan saus kacang dan kecap manis.'],
            ['name' => 'Batagor', 'description' => 'Bakso tahu goreng renyah dengan bumbu kacang khas Bandung, dilengkapi perasan jeruk limau.'],
            ['name' => 'Tahu Tek', 'description' => 'Tahu goreng krispi disajikan dengan bumbu petis hitam, telur, tauge, dan lontong.'],
            ['name' => 'Krupuk Palembang', 'description' => 'Kerupuk ikan khas Palembang yang renyah dan gurih, cocok sebagai camilan pembuka.'],
            ['name' => 'Risoles Mayo', 'description' => 'Crepes tipis berisi ragout ayam dan sayuran, dibalut tepung roti lalu digoreng keemasan.'],
            ['name' => 'Perkedel Jagung', 'description' => 'Perkedel berbahan jagung manis segar dengan daun bawang, digoreng hingga kecokelatan.'],
            ['name' => 'Pempek Kapal Selam', 'description' => 'Pempek khas Palembang berisi telur ayam, disajikan dengan kuah cuka pedas manis.'],
        ],
        'Main Courses' => [
            ['name' => 'Nasi Goreng Spesial', 'description' => 'Nasi goreng wangi dengan telur ceplok, ayam suwir, udang, dan acar timun segar.'],
            ['name' => 'Ayam Bakar Taliwang', 'description' => 'Ayam kampung bakar khas Lombok dengan bumbu cabai merah pedas dan belacan.'],
            ['name' => 'Rendang Sapi', 'description' => 'Daging sapi empuk dimasak perlahan dalam santan dan bumbu rempah khas Minangkabau hingga kering kecokelatan.'],
            ['name' => 'Soto Ayam Lamongan', 'description' => 'Soto ayam bening kuning khas Lamongan dengan suwiran ayam, koya, telur, dan perasan jeruk nipis.'],
            ['name' => 'Gado-Gado', 'description' => 'Sayuran rebus, tahu, tempe, dan telur disiram bumbu kacang kental khas Betawi.'],
            ['name' => 'Mie Goreng Jawa', 'description' => 'Mie kuning goreng khas Jawa dengan ayam, telur, kol, dan kecap manis beraroma.'],
            ['name' => 'Nasi Liwet Solo', 'description' => 'Nasi gurih santan khas Solo disajikan dengan opor ayam, telur pindang, dan sambal goreng.'],
            ['name' => 'Gulai Kambing', 'description' => 'Kambing muda dimasak dalam kuah santan kuning kaya rempah, disajikan hangat dengan nasi putih.'],
            ['name' => 'Pecel Lele', 'description' => 'Lele goreng garing disajikan dengan nasi, sambal terasi, lalapan segar, dan tempe goreng.'],
            ['name' => 'Rawon Surabaya', 'description' => 'Sup daging sapi hitam khas Surabaya berbumbu kluwek, disajikan dengan tauge, telur asin, dan kerupuk.'],
        ],
        'Desserts' => [
            ['name' => 'Es Teler', 'description' => 'Campuran alpukat, kelapa muda, nangka, dan cincau hitam dengan susu kental manis dan serutan es.'],
            ['name' => 'Klepon', 'description' => 'Bola ketan hijau berisi gula merah cair, dibalut kelapa parut segar yang gurih.'],
            ['name' => 'Putu Ayu', 'description' => 'Kue kukus pandan lembut bertabur kelapa parut, dengan isian gula merah yang manis.'],
            ['name' => 'Dadar Gulung', 'description' => 'Crepes pandan hijau berisi kelapa parut bercampur gula merah karamel yang harum.'],
            ['name' => 'Kolak Pisang', 'description' => 'Pisang kepok lembut dimasak dalam kuah santan gula merah dengan aroma daun pandan.'],
            ['name' => 'Bubur Sumsum', 'description' => 'Bubur tepung beras lembut dengan kuah gula merah dan taburan sedikit garam.'],
            ['name' => 'Kue Lapis Legit', 'description' => 'Kue berlapis-lapis dengan rempah kayu manis, pala, dan kapulaga khas Betawi yang legit.'],
            ['name' => 'Onde-Onde', 'description' => 'Bola wijen goreng berisi kacang hijau manis, renyah di luar dan lembut di dalam.'],
        ],
        'Beverages' => [
            ['name' => 'Es Cendol Dawet', 'description' => 'Minuman segar cendol pandan dengan santan, gula merah kental, dan serutan es batu.'],
            ['name' => 'Wedang Jahe', 'description' => 'Minuman hangat jahe segar dengan gula merah dan serai, menyegarkan dan menghangatkan badan.'],
            ['name' => 'Es Jeruk Peras', 'description' => 'Perasan jeruk keprok segar disajikan dingin dengan sedikit gula dan es batu.'],
            ['name' => 'Jus Alpukat', 'description' => 'Alpukat Garut segar diblender dengan susu dan gula, bertekstur kental dan creamy.'],
            ['name' => 'Teh Tarik', 'description' => 'Teh susu kental manis yang ditarik-tarik hingga berbusa dan bertekstur lembut.'],
            ['name' => 'Es Kelapa Muda', 'description' => 'Air kelapa muda asli dengan daging kelapa tipis, disajikan segar dengan es batu.'],
            ['name' => 'Kopi Tubruk', 'description' => 'Kopi robusta kasar diseduh langsung dengan air panas, kental dan beraroma kuat.'],
            ['name' => 'Bajigur', 'description' => 'Minuman tradisional Sunda berbahan santan, gula aren, dan jahe, disajikan hangat.'],
        ],
    ];

    private static array $prices = [
        'Appetizers' => [8, 25],
        'Main Courses' => [15, 55],
        'Desserts' => [5, 20],
        'Beverages' => [5, 25],
    ];

    /** Shuffled pool built once per seeding run */
    private static array $pool = [];

    public function definition(): array
    {
        // Build the full shuffled pool on first call
        if (empty(self::$pool)) {
            $categories = Category::pluck('name', 'id')->toArray();
            $all = [];
            foreach (self::$menuItems as $categoryName => $items) {
                $categoryId = array_search($categoryName, $categories);
                if ($categoryId === false) {
                    continue;
                }
                foreach ($items as $item) {
                    $all[] = [
                        'name' => $item['name'],
                        'description' => $item['description'],
                        'category_id' => $categoryId,
                        'category_name' => $categoryName,
                    ];
                }
            }
            shuffle($all);
            self::$pool = $all;
        }

        $picked = array_shift(self::$pool);

        if (!$picked) {
            throw new \RuntimeException('ItemFactory pool exhausted — reduce the factory count to match the number of unique items (34).');
        }

        $range = self::$prices[$picked['category_name']] ?? [10, 50];
        $price = $this->faker->numberBetween($range[0], $range[1]) * 1000;

        return [
            'name' => $picked['name'],
            'description' => $picked['description'],
            'price' => $price,
            'category_id' => $picked['category_id'],
            'image_path' => null,
            'is_available' => $this->faker->boolean(80),
        ];
    }
}
