<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Certification;
use App\Models\Page;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\Variant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Seeds the Nubic Product Catalogue 2023 (NES-0001 to NES-0191).
 *
 * Product:  [name, firstCodeNumber, rows]
 * Row:      [rating, spec/execution, packing, M.R.P., M.R.P. with enclosure, hasCode(default true)]
 */
class CatalogueSeeder extends Seeder
{
    public function run(): void
    {
        $this->settings();
        $this->content();

        foreach ($this->catalogue() as $i => [$catName, $catDesc, $products]) {
            $category = Category::updateOrCreate(
                ['slug' => Str::slug($catName)],
                ['name' => $catName, 'description' => $catDesc, 'sort_order' => $i, 'is_active' => true]
            );

            foreach ($products as $j => [$name, $start, $rows]) {
                $product = Product::updateOrCreate(
                    ['slug' => Str::slug($name)],
                    ['category_id' => $category->id, 'name' => $name, 'sort_order' => $j, 'is_active' => true, 'is_featured' => $j === 0]
                );
                $product->variants()->delete();

                $n = $start;
                foreach ($rows as $k => $r) {
                    $hasCode = $r[5] ?? true;
                    Variant::create([
                        'product_id' => $product->id,
                        'code' => $hasCode ? sprintf('NES-%04d', $n++) : null,
                        'rating' => $r[0],
                        'spec' => $r[1] ?? null,
                        'packing' => $r[2] ?? null,
                        'mrp' => $r[3] ?? null,
                        'mrp_enclosure' => $r[4] ?? null,
                        'sort_order' => $k,
                    ]);
                }
            }
        }
    }

    private function settings(): void
    {
        $defaults = [
            'site_name' => 'Nubic India Pvt. Ltd.',
            'tagline' => 'Global Energy',
            'site_slogan' => 'Changing The Way You Imagine Technology',
            'website' => 'www.nubicindia.com',
            'phone' => '',
            'email' => '',
            'whatsapp' => '',
            'address' => '',
            'facebook' => '',
            'instagram' => '',
            'linkedin' => '',
            'youtube' => '',
            'footer_text' => 'Nubic is one of the leading electrical equipment manufacturers in India. Make in India.',
            'meta_title' => 'Nubic India - MCB, Switchgear & Electrical Products Manufacturer',
            'meta_description' => 'Nubic Global Energy - manufacturer of MCB, RCCB, isolators, distribution boards, changeover switches and energy meters.',
        ];
        foreach ($defaults as $k => $v) {
            Setting::firstOrCreate(['key' => $k], ['value' => $v]);
        }
    }

    private function content(): void
    {
        Page::updateOrCreate(['slug' => 'about-us'], [
            'title' => 'About Us',
            'is_active' => true,
            'content' => '<p>We at Nubic introduce ourselves as one of the leading electrical equipment manufacturers in India. We are manufacturing entire range of household, industrial and commercial electrical products ranging from Switchgear, Wires &amp; Cables, Fans, Modular Switches, Motors and other Domestic Appliances.</p>'
                .'<p>Nubic is the well known name in Electrical and Electronic industry in India, manufacturing products ranging from Building Circuit Protection, Industrial &amp; Domestic Switchgears, Wire &amp; Cables, Energy Meters, Fans, Luminaries and Modular Switches.</p>'
                .'<p>Nubic Group has emerged as the preferred choice for a discerning range of individual and industrial consumers both in India and abroad. The essence of its success lies in the expertise of a fine team of professionals, the strong relationship with associates, the ability to change quickly and efficiently and the vision to think ahead.</p>',
        ]);

        if (! Slider::count()) {
            Slider::insert([
                ['title' => 'Changing The Way You Imagine Technology', 'subtitle' => 'Nubic Global Energy - MCB, RCCB, Isolators & Distribution Boards', 'button_text' => 'View Products', 'button_url' => '/products', 'sort_order' => 1, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
                ['title' => 'Protection You Can Trust', 'subtitle' => 'Built to IS/IEC 60898-1 with 10kA breaking capacity', 'button_text' => 'Contact Us', 'button_url' => '/contact', 'sort_order' => 2, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ]);
        }

        if (! Certification::count()) {
            foreach (['ISO 9001:2008 Certified', 'IEC 60669-1', 'Eco Friendly Products', 'CE European Standard'] as $i => $n) {
                Certification::create(['name' => $n, 'sort_order' => $i, 'is_active' => true]);
            }
        }
    }

    private function catalogue(): array
    {
        $three = fn (string $pack, array $m) => [['6 to 32A', null, $pack, $m[0]], ['40A', null, $pack, $m[1]], ['63A', null, $pack, $m[2]]];

        return [
            ['Miniature Circuit Breakers (MCB)', 'Electro-mechanical devices that protect an electric circuit from over current, short circuit and overload. In accordance with IS/IEC 60898-1, B & C curves, 10kA breaking capacity.', [
                ['Power Shield Mini DP MCB with Enclosure', 1, [['DP32A Mini MCB with Enclosure', null, '20', 438]]],
                ['Miniature Circuit Breaker - Single Pole', 2, $three('12', [199, 220, 259])],
                ['Miniature Circuit Breaker - S.P.N', 5, $three('06', [420, 462, 539])],
                ['Miniature Circuit Breaker - Double Pole', 8, $three('06', [420, 462, 539])],
                ['Miniature Circuit Breaker - Three Pole', 11, $three('04', [654, 717, 847])],
                ['Miniature Circuit Breaker - T.P.N.', 14, $three('03', [843, 962, 1141])],
                ['Miniature Circuit Breaker - Four Pole', 17, $three('03', [843, 962, 1141])],
                ['Mini MCB - Single Pole', 29, [['6 to 32A', 'Teny Type', '06', 154], ['6 to 32A', 'Modular Type', '06', 154]]],
                ['Mini MCB - Double Pole', 31, [['6 to 32A', 'Teny Type', '03', 343], ['6 to 32A', 'Modular Type', '03', 343]]],
                ['MCB Change Over - Double Pole', 33, [['25 to 32A', null, '06', 438], ['40A', null, '06', 438], ['63A', null, '06', 595]]],
                ['MCB Change Over - Four Pole', 36, [['25 to 32A', null, '06', 805], ['40A', null, '06', 805], ['63A', null, '06', 1155]]],
            ]],
            ['Isolators', 'Electrical isolation switches (disconnectors) with heavy duty frame, silver alloy contacts and low watt loss. Utilization category AC22A, conforming to IS/IEC 60947-3.', [
                ['Isolator - Double Pole', 20, $three('06', [350, 371, 438])],
                ['Isolator - Three Pole', 23, $three('04', [380, 401, 468])],
                ['Isolator - Four Pole', 26, $three('03', [700, 742, 875])],
            ]],
            ['RCCB / ELCB', 'Residual current operated circuit breakers (Earth Leakage protection). IS 12640 (Part-1), IEC EN-61008-1, Type-AC. Sensitivity 30mA, 100mA, 300mA.', [
                ['Residual Current Circuit Breaker - Double Pole', 39, [['25A', '30/100/300 mA', null, 1640], ['40A', '30/100/300 mA', null, 1690], ['63A', '30/100/300 mA', null, 1880]]],
                ['Residual Current Circuit Breaker - Four Pole', 42, [['25 to 32A', '30/100/300 mA', null, 1890], ['40A', '30/100/300 mA', null, 1920], ['63A', '30/100/300 mA', null, 2115]]],
            ]],
            ['MCB Distribution Boards', 'Distribution boards in poly carbonate and metal execution for single phase (S.P.N.) and three phase (T.P.N.) applications.', [
                ['MCB Distribution Board (PC / Metal)', 45, [['2 Pole (PC)', 'Poly Carbonate', '20', 77], ['4 Pole (PC)', 'Poly Carbonate', '24', 115], ['2 Pole (MS)', 'Metal', '24', 227], ['4 Pole (MS)', 'Metal', '30', 297]]],
                ['MCB Distribution Board - Single Door / Evans Series', 49, [
                    ['4 Way', 'S.P.N.', '20', 525], ['6 Way', 'S.P.N.', '20', 612], ['8 Way', 'S.P.N.', '20', 700], ['10 Way', 'S.P.N.', '20', 787],
                    ['12 Way', 'S.P.N.', '10', 875], ['16 Way', 'S.P.N.', '10', 1050], ['4 Way', 'T.P.N.', '06', 1020], ['6 Way', 'T.P.N.', '06', 1350], ['8 Way', 'T.P.N.', '06', 1650]]],
                ['MCB Distribution Board - Double Door / ACR Series', 58, [
                    ['4 Way', 'S.P.N.', '16', 925], ['6 Way', 'S.P.N.', '16', 1098], ['8 Way', 'S.P.N.', '08', 1241], ['10 Way', 'S.P.N.', '10', 1384],
                    ['12 Way', 'S.P.N.', '10', 1527], ['16 Way', 'S.P.N.', '06', 1866], ['4 Way', 'T.P.N.', '04', null]]],
                ['MCB Distribution Board - Double Door / Hilter Series', 65, [
                    ['4 Way', 'S.P.N.', '10', 1400], ['6 Way', 'S.P.N.', '10', 1575], ['8 Way', 'S.P.N.', '10', 1750], ['10 Way', 'S.P.N.', '10', 1925],
                    ['12 Way', 'S.P.N.', '08', 2100], ['16 Way', 'S.P.N.', '06', 2520], ['4 Way', 'T.P.N.', '06', 3727], ['6 Way', 'T.P.N.', '04', 4427], ['8 Way', 'T.P.N.', '04', 5127]]],
                ['MCB Distribution Board - Double Pole, Metal Box', 74, [
                    ['4 Way', 'S.P.N.', '10', 640], ['6 Way', 'S.P.N.', '10', 730], ['8 Way', 'S.P.N.', '10', 830], ['10 Way', 'S.P.N.', '10', 930],
                    ['12 Way', 'S.P.N.', '08', 1030], ['16 Way', 'S.P.N.', '06', 1230], ['4 Way', 'T.P.N.', '06', 1480], ['6 Way', 'T.P.N.', '04', 1810], ['8 Way', 'T.P.N.', '04', 2130]]],
                ['MCB Distribution Board - Double Pole, Leborn Series', 83, [
                    ['4 Way', 'S.P.N.', '10', 840], ['6 Way', 'S.P.N.', '10', 962], ['8 Way', 'S.P.N.', '10', 1085], ['10 Way', 'S.P.N.', '10', 1207],
                    ['12 Way', 'S.P.N.', '08', 1330], ['16 Way', 'S.P.N.', '06', 1575], ['4 Way', 'T.P.N.', '06', 3325], ['6 Way', 'T.P.N.', '04', 3850], ['8 Way', 'T.P.N.', '04', 4375]]],
                ['AC Box (Plug & Socket)', 92, [['2P+20A, 250V', 'Metal', '20', 682], ['3P+20A, 440V', 'Metal', '20', 1561], ['3P+30A, 440V', 'Metal', '20', 2170]]],
                ['Vertical DB (Double Door)', 95, [['4 Way', null, '06', 5898], ['6 Way', null, '04', 6545], ['8 Way', null, '04', 7892], ['12 Way', null, '03', 9642]]],
            ]],
            ['Phase Selector', 'Phase selector switches and phase selector distribution boards.', [
                ['Phase Selector Switch (S.P.)', 99, [['40Amp. 415V.', null, '2', 4900], ['63Amp. 415V.', null, '2', 5250]]],
                ['Phase Selector Distribution Board - Double Door', 101, [
                    ['4 Way', '40 Amp', '01', 7350], ['4 Way', '63 Amp', '01', 9050], ['6 Way', '40 Amp', '01', 7450],
                    ['6 Way', '63 Amp', '01', 9150], ['8 Way', '40 Amp', '01', 8450], ['8 Way', '63 Amp', '01', 9725]]],
            ]],
            ['Changeover & Fuse Switches', 'Automatic changeover, switch fuse units, on-load / off-load changeover switches, isolators, cubical fuse switches, bus bar chambers and kit kat fuse units.', [
                ['Automatic Changeover Switch (Heavy Duty)', 107, [['32 Amp. 240V', 'S.P', '10', 2450], ['32 Amp. 415V', 'T.P', '04', 4200], ['63 Amp. 240V', 'S.P', '04', 5250], ['63 Amp. 415V', 'T.P', '01', 8050], ['100 Amp. 415V', 'T.P', '01', 8750]]],
                ['Switch Fuse Unit (Double Pole / TPN)', 112, [
                    ['32 Amp. 240V', 'D.P', '10', 1505], ['63 Amp. 240V', 'D.P', '05', 3605], ['16 Amp. 415V', 'T.P.N.', '20', 1685], ['32 Amp. 415V', 'T.P.N.', '10', 3255],
                    ['63 Amp. 415V', 'T.P.N.', '03', 5530], ['100 Amp. 415V', 'T.P.N.', '02', 9205], ['200 Amp. 415V', 'T.P.N.', '01', 12530]]],
                ['Fuse Switch Unit (HRC Type T.P.N.)', 119, [['63 Amp. 415V', 'T.P.N.', '01', 3875], ['100 Amp. 415V', 'T.P.N.', '01', 6280], ['200 Amp. 415V', 'T.P.N.', '01', 8650], ['320 Amp. 415V', 'T.P.N.', '01', 10850], ['400 Amp. 415V', 'T.P.N.', '01', 12200]]],
                ['Off Load Changeover Switch (Double Pole / Four Pole)', 124, [
                    ['32 Amp. 240V', 'D.P.', '10', 1575], ['63 Amp. 240V', 'D.P.', '05', 3675], ['16 Amp. 415V', 'F.P.', '08', 2825], ['32 Amp. 415V', 'F.P.', '05', 3325],
                    ['63 Amp. 415V', 'F.P.', '03', 5600], ['100 Amp. 415V', 'F.P.', '01', 9275], ['200 Amp. 415V', 'F.P.', '01', 12600]]],
                ['Off Load Changeover Switch (Knife Type)', 131, [
                    ['63 Amp. 240V', 'D.P.', '03', 3500], ['63 Amp. 415V', 'F.P.', '02', 5425], ['100 Amp. 415V', 'F.P.', '01', 7475],
                    ['200 Amp. 415V', 'F.P.', '01', 15800], ['320 Amp. 415V', 'F.P.', '01', 21250], ['400 Amp. 415V', 'F.P.', '01', 25000]]],
                ['On Load Changeover (Four Pole)', 137, [
                    ['63 Amp. 240V', 'Size 0', null, 3570, 5050], ['63 Amp.', 'Size 1', null, 6188, 8276], ['100 Amp.', 'Size 1', null, 7225, 9828], ['200 Amp.', 'Size II', null, 10850, 13950],
                    ['320 Amp.', 'Size II', null, 11875, 15060], ['400 Amp.', 'Size III', null, 16650, 21770], ['630 Amp.', 'Size III', null, 20180, 25298]]],
                ['Isolators (Four Pole) - Heavy Duty', 144, [
                    ['125 Amp.', 'Size 1', null, 3625, 5250], ['200 Amp.', 'Size 1', null, 4875, 6500], ['250 Amp.', 'Size II', null, 6125, 8125],
                    ['320 Amp.', 'Size II', null, 6850, 8750], ['400 Amp.', 'Size III', null, 10250, 13190], ['630 Amp.', 'Size III', null, 11125, 14070]]],
                ['Cubical Fuse Switches (T.P.)', 150, [
                    ['32 Amp.', 'Size 1', null, 1892, 3094], ['63 Amp.', 'Size 1', null, 2120, 3321], ['125 Amp.', 'Size II', null, 3630, 5005], ['250 Amp.', 'Size II', null, 8180, 10055],
                    ['320 Amp.', 'Size III', null, 8745, 10647], ['400 Amp.', 'Size III', null, 10170, 12048], ['630 Amp.', 'Size IV', null, 21203, 22525], ['800 Amp.', 'Size IV', null, 23250, 27800]]],
                ['Bus Bar Chamber (Four Pole)', 159, [['32A. 415V', 'F.P.', '5', 1655], ['63 A. 415V', 'F.P.', '3', 2240], ['100 A. 415V', 'F.P.', '2', 3375], ['200 A. 415V', 'F.P.', '1', 5550], ['320 A. 415V', 'F.P.', '1', 6450], ['400A. 415V', 'F.P.', '1', 8250]]],
                ['Kit Kat Fuse Unit (S.P.)', 165, [
                    ['16/32Amp. 240V/415V', 'S.P.', '160', 54], ['32Amp. 240V', 'S.P.', '80', 122], ['32Amp. 415V', 'S.P.', '40', 177], ['63Amp. 415V', 'S.P.', '20', 395],
                    ['100Amp. 415V', 'S.P.', '10', 746], ['200Amp. 415V', 'S.P.', '08', 1060], ['320/500 Amp. 415V', 'S.P.', '04', 1740]]],
            ]],
            ['Reversing Switches', 'Compact and knife type reversing switches.', [
                ['Reversing Switch (Compact)', 172, [['16 Amp. 415V', 'R.S.', '24', 425], ['25 Amp. 415V', 'R.S.', '20', 780], ['25 Amp. 415V', 'D.P.', '20', 780], ['25 Amp. 415V', 'T.P.', '20', 780], ['25 Amp. 415V', 'F.P.', '20', 950], ['63 Amp. 415V / RF', 'T.P.', '10', 6125]]],
                ['Reversing Switch (Knife Type)', 178, [['32 Amp. 415V/CO', 'D.P.', '20', 685], ['32 Amp. 415V/CO', 'D.P.', '20', 755]]],
            ]],
            ['Energy Meters', 'Single phase and three phase electronic energy meters, electro mechanical and digital counter versions.', [
                ['Electronic Energy Meter - Electro Mech, Counter', 180, [['5-30 Amp', 'Normal Body', '60', 660], ['5-30 Amp', 'Big Body', '60', 705], ['10-40 Amp', 'Small Body', '60', 708], ['10-60 Amp', 'Small Body', '60', 804, null, false]]],
                ['Electronic Energy Meter - Digital, Counter', 183, [['5-30 Amp', null, '60', 845], ['10-40 Amp', null, '60', 895], ['10-60 Amp', null, '60', 1008]]],
                ['3 Phase Electronic Energy Meter - Electro Mech, Counter', 186, [['10-40 Amp', null, '20', 1798], ['10-60 Amp', null, '20', 2016], ['/5 (without CT)', null, '20', 2016]]],
                ['3 Phase Electronic Energy Meter - Digital, Counter', 189, [['10-40 Amp', null, '20', 2028], ['10-60 Amp', null, '20', 2256], ['/5 (without CT)', null, '20', 2256]]],
            ]],
        ];
    }
}
