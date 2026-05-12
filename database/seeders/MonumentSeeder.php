<?php

namespace Database\Seeders;

use App\Models\Monument;
use App\Models\MonumentHighlight;
use App\Models\MonumentTip;
use App\Models\State;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MonumentSeeder extends Seeder
{
    public function run(): void
    {
        // Resolve state IDs once; abort with a clear message if any are missing
        $stateIds = [];
        foreach (['Rajasthan', 'Kerala', 'Punjab', 'Tamil Nadu', 'West Bengal'] as $name) {
            $state = State::where('name', $name)->first();
            abort_unless($state, 500, "State '{$name}' not found — run DatabaseSeeder first.");
            $stateIds[$name] = $state->id;
        }

        foreach ($this->monumentsData($stateIds) as $data) {
            $monument = Monument::create([
                'state_id'           => $data['state_id'],
                'name'               => $data['name'],
                'slug'               => Str::slug($data['name']),
                'short_description'  => $data['short_description'],
                'full_description'   => $data['full_description'],
                'type'               => $data['type'],
                'category'           => $data['category'],
                'built_by'           => $data['built_by'],
                'built_in_year'      => $data['built_in_year'],
                'dynasty_or_period'  => $data['dynasty_or_period'],
                'entry_fee_indian'   => $data['entry_fee_indian'],
                'entry_fee_foreign'  => $data['entry_fee_foreign'],
                'best_time_to_visit' => $data['best_time_to_visit'],
                'visiting_hours'     => $data['visiting_hours'],
                'latitude'           => $data['latitude'],
                'longitude'          => $data['longitude'],
                'address'            => $data['address'],
                'is_featured'        => $data['is_featured'],
                'is_active'          => true,
            ]);

            foreach ($data['highlights'] as $text) {
                MonumentHighlight::create([
                    'monument_id' => $monument->id,
                    'highlight'   => $text,
                ]);
            }

            foreach ($data['tips'] as $tip) {
                MonumentTip::create([
                    'monument_id' => $monument->id,
                    'tip'         => $tip['tip'],
                    'tip_type'    => $tip['tip_type'],
                ]);
            }
        }
    }

    // ──────────────────────────────────────────────────────────────────────────
    private function monumentsData(array $s): array
    {
        return [

            // ══════════════ RAJASTHAN ══════════════════════════════════════════

            [
                'state_id'           => $s['Rajasthan'],
                'name'               => 'Amber Fort',
                'type'               => 'Fort',
                'category'           => 'ASI',
                'built_by'           => 'Raja Man Singh I',
                'built_in_year'      => 1592,
                'dynasty_or_period'  => 'Rajput — Kachwaha',
                'entry_fee_indian'   => 100.00,
                'entry_fee_foreign'  => 550.00,
                'best_time_to_visit' => 'October to March — pleasant weather and clear skies make the hill-top fort comfortable to explore; monsoon (July–September) adds lush greenery but can be muddy.',
                'visiting_hours'     => '8:00 AM – 5:30 PM daily; light and sound show at 7:30 PM (Hindi) and 8:30 PM (English)',
                'latitude'           => 26.98503,
                'longitude'          => 75.85144,
                'address'            => 'Devisingh Pura, Amer, Jaipur, Rajasthan 302001',
                'is_featured'        => true,
                'short_description'  => 'Amber Fort is a majestic hilltop fortress overlooking Maota Lake, blending Rajput and Mughal architectural traditions across four distinct courtyards and palaces.',
                'full_description'   => '<p>Amber Fort (also spelled Amer Fort) rises dramatically from the crest of a rocky hill overlooking the serene Maota Lake, 11 km from Jaipur. Begun by Raja Man Singh I in 1592 and expanded by successive Kachwaha rulers, the fort took over a century to complete and stands as the finest expression of Rajput military and palace architecture in India.</p><p>Its layout unfolds across four principal courtyards: the Jaleb Chowk (public parade ground), the Singh Pol (Lion Gate) courtyard, the renowned Sheesh Mahal complex, and the Zenana (women\'s quarters). The <strong>Sheesh Mahal</strong> — Palace of Mirrors — is Amber\'s crown jewel: its ceiling and walls are encrusted with thousands of convex mirror fragments set in plaster, so that a single candle flame transforms the room into a starlit vault. The <strong>Ganesh Pol</strong> gateway, painted with hunting scenes and portraits of deities in vibrant pigments, is considered one of the most elaborately decorated gateways in Rajasthan. A series of subterranean passages once connected the fort to the neighbouring Jaigarh Fort on the higher ridge, and the massive Jai Ban cannon — said to be Asia\'s largest wheeled cannon — still sits at Jaigarh commanding the valley. Elephant rides from the base to the Suraj Pol entrance, though controversial from an animal welfare standpoint, remain a popular tradition; jeep taxis are the recommended ethical alternative.</p>',
                'highlights'         => [
                    'The Sheesh Mahal (Palace of Mirrors) uses over 1,000 tiny mirror fragments to create a dazzling celestial effect from a single candle flame.',
                    'The fort spreads over 4 sq km across the Aravalli Hills and is connected to Jaigarh Fort by a 1 km underground passage.',
                    'Ganesh Pol gateway features seven-storeyed painted murals depicting scenes from Hindu mythology — considered the finest painted gateway in Rajasthan.',
                    'Maota Lake at the base reflects the entire fort at sunrise, creating one of the most photographed compositions in Rajasthan.',
                ],
                'tips'               => [
                    ['tip_type' => 'Timing',      'tip' => 'Arrive at opening (8 AM) to beat the tour groups and experience the Sheesh Mahal in quiet, natural light before crowds arrive.'],
                    ['tip_type' => 'Photography', 'tip' => 'The best exterior shots are taken from the far shore of Maota Lake at sunrise — walk around the lake road for 10 minutes to reach the ideal vantage point.'],
                    ['tip_type' => 'Transport',   'tip' => 'Shared jeeps run from the Amer bazaar road up to the fort gate for ₹50 per person — a faster and more ethical option than elephant rides.'],
                ],
            ],

            [
                'state_id'           => $s['Rajasthan'],
                'name'               => 'Hawa Mahal',
                'type'               => 'Palace',
                'category'           => 'ASI',
                'built_by'           => 'Maharaja Sawai Pratap Singh',
                'built_in_year'      => 1799,
                'dynasty_or_period'  => 'Rajput — Kachwaha',
                'entry_fee_indian'   => 50.00,
                'entry_fee_foreign'  => 200.00,
                'best_time_to_visit' => 'October to March — ideal weather; the sandstone facade is most photogenic in the cool golden morning light.',
                'visiting_hours'     => '9:00 AM – 4:30 PM daily',
                'latitude'           => 26.92388,
                'longitude'          => 75.82680,
                'address'            => 'Hawa Mahal Rd, Badi Choupad, Pink City, Jaipur, Rajasthan 302002',
                'is_featured'        => true,
                'short_description'  => 'The Palace of Winds is a five-storey honeycombed sandstone facade with 953 latticed jharokhas, built so royal ladies could observe street life while remaining unseen.',
                'full_description'   => '<p>Hawa Mahal — the "Palace of Winds" — is arguably Jaipur\'s most iconic silhouette: a five-storey screen of red and pink Khatri sandstone pierced by 953 small latticed windows (jharokhas) rising like the crown of Lord Krishna above the busiest street of the old city. Commissioned in 1799 by the poet-king Maharaja Sawai Pratap Singh and designed by Lal Chand Ustad, its purpose was entirely social rather than martial — royal and aristocratic women of the zenana (royal harem) could watch street processions, markets, and festivals through the screened balconies while remaining invisible to the outside world according to the purdah tradition.</p><p>The building is only one room deep in most places — essentially an elaborate facade — but inside, five storeys of sloped ramps (no staircases; ramps allowed palanquins) lead to increasingly airy halls and balconies. The latticework creates a natural cooling effect: as air passes through the perforated screens, it cools and circulates through the chambers, making the palace comfortable even in the intense Rajasthan summer. The on-site Hawa Mahal Archaeological Museum houses Rajput coins, manuscripts, and miniature paintings. The view from the top-floor balcony over Jaipur\'s Pink City roofscape is one of the best in the city.</p>',
                'highlights'         => [
                    '953 latticed jharokha windows are arranged across five storeys, designed to channel cool breeze through the palace in summer — an early form of passive air conditioning.',
                    'The facade\'s silhouette is shaped like the crown (mukut) of Lord Krishna; the Maharaja was a devoted Krishna bhakta who named the palace accordingly.',
                    'Built in Khatri limestone painted in the iconic rose-pink that gives Jaipur its "Pink City" epithet — repainted by royal decree every few years.',
                    'The entire structure has no traditional staircases; inclined ramps connect each floor, designed to allow palanquins to be carried to upper-level zenana chambers.',
                ],
                'tips'               => [
                    ['tip_type' => 'Photography', 'tip' => 'The facade is best photographed from the rooftop cafe directly opposite on Hawa Mahal Road — several cafes offer the perfect elevated angle for sunrise and golden-hour shots.'],
                    ['tip_type' => 'Timing',      'tip' => 'Visit at 9 AM when the gates open; the inside corridors and top-floor balcony become very crowded by late morning.'],
                    ['tip_type' => 'General',     'tip' => 'The small on-site museum (included in the ticket) has an interesting collection of Rajput miniatures, armour, and royal artefacts that most visitors skip.'],
                ],
            ],

            // ══════════════ KERALA ════════════════════════════════════════════

            [
                'state_id'           => $s['Kerala'],
                'name'               => 'Padmanabhapuram Palace',
                'type'               => 'Palace',
                'category'           => 'State_Protected',
                'built_by'           => 'Iravi Varman Kulasekhara (expanded by Marthanda Varma)',
                'built_in_year'      => 1601,
                'dynasty_or_period'  => 'Travancore Royal Family',
                'entry_fee_indian'   => 35.00,
                'entry_fee_foreign'  => 200.00,
                'best_time_to_visit' => 'October to February — cool and dry; avoid visiting during the South-West Monsoon (June–August) when access roads can flood.',
                'visiting_hours'     => '9:00 AM – 4:30 PM; closed Mondays and national holidays',
                'latitude'           => 8.25370,
                'longitude'          => 77.33170,
                'address'            => 'Padmanabhapuram, Thuckalay, Kanyakumari District, Tamil Nadu 629175 (administered by Kerala Government)',
                'is_featured'        => true,
                'short_description'  => 'Padmanabhapuram Palace is the largest wooden palace complex in Asia, a 400-year-old masterpiece of Kerala\'s traditional Thachu Shastra craftsmanship set at the foot of the Western Ghats.',
                'full_description'   => '<p>Padmanabhapuram Palace — literally "City of Padmanabha" after Lord Vishnu — is a sprawling complex of interlocking wooden structures set within a granite-walled compound at the foot of the Western Ghats, near Kanyakumari. Though geographically located in Tamil Nadu, it is owned and maintained by the Kerala government as the ancestral capital of the Travancore royal family, whose deity and title, Padmanabha, are enshrined here.</p><p>The palace began as a modest structure in the early 17th century under Iravi Varman Kulasekhara but reached its present extent under the great reformer-king <strong>Marthanda Varma</strong> (r. 1729–1758), who transformed Travancore into a powerful kingdom and extensively rebuilt and enlarged the palace complex. The structures exhibit the highest refinement of <em>Thachu Shastra</em> — Kerala\'s traditional science of carpentry and wooden construction. The <strong>Mother Queen\'s Bedroom</strong> (Thai Kottaram) features a ceiling composed of herbal extracts mixed into 90 different varieties of wood, historically believed to have curative properties for the elderly queen. The <strong>Performance Hall</strong> (Navarathri Mandapam) has an exquisite Belgian glass-inlay floor and a carved ceiling supported by jackwood columns. Chinese-style glazed roof tiles, brought as cargo in trading ships, cap several of the pavilions — evidence of Kerala\'s centuries-old maritime commerce. A Belgian mirror, gifted by Dutch traders, still hangs in one of the royal chambers.</p>',
                'highlights'         => [
                    'The largest wooden palace complex in Asia, built using Kerala\'s Thachu Shastra (traditional science of carpentry) without a single nail in the oldest sections.',
                    'The Thai Kottaram\'s ceiling is made of 90 different varieties of wood mixed with herbal extracts — believed to have therapeutic properties for the Mother Queen.',
                    'Chinese-glazed roof tiles and Belgian glass floor inlays reflect Travancore\'s extensive 17th-century maritime trade networks.',
                    'A 400-year-old clock in the palace\'s clock tower, gifted by Dutch traders, is still in working condition.',
                ],
                'tips'               => [
                    ['tip_type' => 'General',     'tip' => 'Shoes must be removed before entering each palace building — carry a small bag to hold them as storage spots fill up quickly.'],
                    ['tip_type' => 'Photography', 'tip' => 'Photography inside the palace rooms is strictly prohibited; focus your shots on the spectacular wooden exterior facades, lotus ponds, and courtyard views.'],
                    ['tip_type' => 'Transport',   'tip' => 'The palace is 65 km from Thiruvananthapuram; the most comfortable option is a hired taxi (2-hr journey). State buses from Nagercoil also stop at the palace gate.'],
                ],
            ],

            [
                'state_id'           => $s['Kerala'],
                'name'               => 'Bekal Fort',
                'type'               => 'Fort',
                'category'           => 'ASI',
                'built_by'           => 'Shivappa Nayaka',
                'built_in_year'      => 1650,
                'dynasty_or_period'  => 'Keladi Nayaka Kingdom',
                'entry_fee_indian'   => 25.00,
                'entry_fee_foreign'  => 300.00,
                'best_time_to_visit' => 'October to February — the Arabian Sea is calm, skies clear, and the fort\'s surrounding beach and gardens are at their most scenic.',
                'visiting_hours'     => '8:00 AM – 5:30 PM daily',
                'latitude'           => 12.39390,
                'longitude'          => 75.03880,
                'address'            => 'Bekal Fort Road, Bekal, Kasaragod, Kerala 671318',
                'is_featured'        => false,
                'short_description'  => 'Bekal is Kerala\'s largest fort, a 40-acre laterite rampart surrounded on three sides by the Arabian Sea, with a panoramic observation tower and one of the state\'s most beautiful protected beaches.',
                'full_description'   => '<p>Bekal Fort is the largest and best-preserved fort in Kerala, occupying a dramatic 40-acre promontory of land jutting into the Arabian Sea near Kasaragod — the northernmost district of Kerala. Built primarily by <strong>Shivappa Nayaka</strong> of the Keladi Nayaka kingdom in the mid-17th century, the fort later passed through the hands of Hyder Ali and Tipu Sultan of Mysore before coming under British East India Company control in 1799, who left it largely intact. Its distinctive keyhole shape, visible from aerial views, follows the natural contour of the headland.</p><p>The fort\'s most dramatic feature is its massive <strong>observation tower</strong>, rising from the north-eastern corner of the rampart to command sweeping 270° views of the Arabian Sea and the Kerala coastline — used by garrison commanders to spot approaching enemy ships. The walls are constructed from laterite blocks in the distinctive reddish-hued style of Malabar coast fortifications, without mortar in the traditional sections. Within the fort compound are water tanks, mosque ruins, and subsidiary bastions; the interior has been landscaped as a garden. Immediately south of the fort walls lies <strong>Bekal Beach</strong>, a protected stretch of golden sand that serves as one of Kerala\'s most unspoiled beaches — part of a government-designated tourism development zone. The fort featured prominently in the Bollywood film <em>Bombay</em> (1995) and draws travellers from across the country.</p>',
                'highlights'         => [
                    'Kerala\'s largest fort at 40 acres, built on a natural headland surrounded by the Arabian Sea on three sides — creating a near-impregnable coastal defensive position.',
                    'The observation tower at the northern bastion offers 270° unobstructed views over the Arabian Sea, with the Kerala coastline stretching in both directions.',
                    'The fort\'s unique keyhole shape, following the natural contour of the headland, is distinctive even from Google Earth — a feat of 17th-century military engineering.',
                    'The adjacent Bekal Beach, within the fort\'s protected zone, is one of Kerala\'s most pristine and cleanest stretches of coastline.',
                ],
                'tips'               => [
                    ['tip_type' => 'Timing',      'tip' => 'The observation tower at sunset over the Arabian Sea is one of the most spectacular viewpoints on Kerala\'s coast — plan your visit to arrive at the fort by 4:30 PM.'],
                    ['tip_type' => 'General',     'tip' => 'Combine the fort visit with an hour at Bekal Beach immediately to the south — the beach is clean, protected, and far less crowded than famous Kerala beaches further south.'],
                    ['tip_type' => 'Photography', 'tip' => 'Bring a wide-angle lens — the combination of red laterite walls, blue sea, and green coconut palms demands maximum field of view.'],
                ],
            ],

            // ══════════════ PUNJAB ════════════════════════════════════════════

            [
                'state_id'           => $s['Punjab'],
                'name'               => 'Golden Temple',
                'type'               => 'Temple',
                'category'           => 'Religious',
                'built_by'           => 'Guru Arjan Dev Ji (gold plating by Maharaja Ranjit Singh)',
                'built_in_year'      => 1604,
                'dynasty_or_period'  => 'Sikh — Khalsa (gold plating 1830)',
                'entry_fee_indian'   => 0.00,
                'entry_fee_foreign'  => 0.00,
                'best_time_to_visit' => 'October to March — cool and pleasant; the festival of Baisakhi (April) and Gurpurab (November) offer extraordinary spiritual atmosphere but with very large crowds.',
                'visiting_hours'     => 'Open 24 hours, every day of the year',
                'latitude'           => 31.62000,
                'longitude'          => 74.87650,
                'address'            => 'Golden Temple Road, Katra Ahluwalia, Amritsar, Punjab 143006',
                'is_featured'        => true,
                'short_description'  => 'Harmandir Sahib, the Golden Temple, is Sikhism\'s holiest shrine — a gold-plated sanctum afloat on the sacred Amrit Sarovar, serving 100,000 free meals daily and open to all faiths.',
                'full_description'   => '<p>Harmandir Sahib — commonly known as the Golden Temple — is the spiritual and cultural heart of Sikhism and one of the most visited religious sites on earth. Located in Amritsar, Punjab, the shrine was originally built by the fourth Sikh Guru, <strong>Guru Ram Das</strong>, who excavated the sacred pool (Amrit Sarovar — Pool of Nectar) in 1577. His successor, <strong>Guru Arjan Dev Ji</strong>, designed the two-storey marble sanctum that was completed in 1604 and installed the Adi Granth scripture for the first time. In a deliberate gesture of humility and inclusiveness, Guru Arjan Dev Ji designed the temple with entrances on all four sides — representing that it is open to people of all four directions, castes, and faiths.</p><p>The golden exterior that gives the temple its popular name was the contribution of <strong>Maharaja Ranjit Singh</strong>, the "Lion of Punjab," who donated 750 kg of pure gold to plate the upper storeys of the sanctum in 1830. The effect — golden domes and walls reflected in the still waters of the Sarovar at dawn — is one of the most transcendent sights in India. The <strong>Langar</strong>, the community kitchen housed within the complex, serves approximately 100,000 free meals every single day, operated entirely by volunteers (sevadars) and funded by donations — the largest free kitchen in the world. Across the causeway from the main sanctum stands the <strong>Akal Takht</strong>, one of Sikhism\'s five highest temporal and religious seats of authority, where historic hukamnamas (royal edicts) are issued by the Sikh community\'s governing body, the SGPC.</p>',
                'highlights'         => [
                    'The upper two storeys of the sanctum are plated with 750 kg of pure 24-carat gold donated by Maharaja Ranjit Singh in 1830 — giving the temple its iconic golden gleam.',
                    'The Langar (community kitchen) serves approximately 100,000 free meals every day of the year to visitors of any faith, religion, or background — the largest free kitchen on earth.',
                    'The Amrit Sarovar (Pool of Nectar) surrounds the sanctum on all sides; Sikhs believe bathing in its waters washes away sins and grants spiritual merit.',
                    'The Akal Takht — Sikhism\'s highest temporal seat — stands opposite the main shrine and is where the community\'s most significant religious and political edicts are proclaimed.',
                ],
                'tips'               => [
                    ['tip_type' => 'Clothing',    'tip' => 'Head covering is mandatory for all visitors regardless of faith — free cloth scarves are provided at the entrance. Shoes must be removed and feet washed in the shallow pool at the gateway.'],
                    ['tip_type' => 'Timing',      'tip' => 'Visit between 2 AM and 4 AM for a deeply meditative, near-empty experience — the golden reflection on the Sarovar at night is otherworldly and the priests\' kirtan recitation fills the silence.'],
                    ['tip_type' => 'General',     'tip' => 'Participating in the Langar (communal meal) is a deeply moving and recommended experience — simply follow the queues into the dining hall, seat yourself on the floor, and volunteers will serve you.'],
                ],
            ],

            [
                'state_id'           => $s['Punjab'],
                'name'               => 'Qila Mubarak Patiala',
                'type'               => 'Fort',
                'category'           => 'State_Protected',
                'built_by'           => 'Baba Ala Singh',
                'built_in_year'      => 1763,
                'dynasty_or_period'  => 'Phulkian Dynasty — Sikh',
                'entry_fee_indian'   => 20.00,
                'entry_fee_foreign'  => 100.00,
                'best_time_to_visit' => 'October to March — pleasant weather; Patiala\'s winter festivals coincide with this period.',
                'visiting_hours'     => '10:00 AM – 5:00 PM; closed Mondays',
                'latitude'           => 30.33950,
                'longitude'          => 76.38690,
                'address'            => 'Qila Chowk, Patiala, Punjab 147001',
                'is_featured'        => false,
                'short_description'  => 'Qila Mubarak is the magnificent ancestral fortress-palace of the Patiala royal family, housing some of the finest Sikh-era frescoes and a remarkable museum of royal artefacts in North India.',
                'full_description'   => '<p>Qila Mubarak — "the Auspicious Fort" — is the ancestral seat of the Phulkian dynasty, the royal family that ruled the princely state of Patiala from the 18th century until Indian Independence. Founded by <strong>Baba Ala Singh</strong> in 1763 CE, the fort expanded considerably under his successors, particularly the great military administrator <strong>Maharaja Karam Singh</strong> and the celebrated <strong>Maharaja Bhupinder Singh</strong> (r. 1900–1938), under whom Patiala became renowned across the British Empire for its hospitality, cricket, and extravagance. The entire complex — covering several acres in the heart of old Patiala — blends Mughal, Rajput, and Punjabi architectural traditions in a remarkable synthesis.</p><p>The fortress\'s most celebrated interior is the <strong>Darbar Hall</strong> (royal audience chamber), whose walls and ceilings are adorned with some of the finest Sikh-era frescoes in North India — vivid scenes of court life, hunting, battles, and devotional imagery executed by master painters from across the Punjab. The <strong>Sheesh Mahal</strong> within the complex contains a mirror-work salon and displays of the Patiala royal jewellery collection, including replicas of the legendary <em>Patiala Necklace</em> (the original, set with 2,930 diamonds including a 428-carat De Beers diamond, was stolen from the maharaja\'s treasury). The on-site <strong>Government Museum</strong> houses arms and armour, coins, manuscripts, textiles, and the famous collection of Punjabi historical paintings. The fort\'s Moti Bagh Palace, a short distance away, was the site of Patiala\'s legendary cricket ground — the maharajas were passionate patrons of the sport.</p>',
                'highlights'         => [
                    'The Darbar Hall contains some of the finest surviving Sikh-era frescoes in North India — vivid court and hunting scenes painted by master artists of the 18th–19th century.',
                    'The on-site museum houses the story of the legendary Patiala Necklace — a 2,930-diamond creation that vanished from the royal treasury and resurfaced decades later minus its centrepiece 428-carat De Beers diamond.',
                    'The fort complex blends Mughal arched gateways, Rajput chhatri pavilions, and Punjabi painted facades in a rare multi-tradition architectural synthesis.',
                    'Baba Ala Singh established Patiala state in 1763 CE — the fort he built went on to host British viceroys, Olympic athletes, and one of the subcontinent\'s most celebrated royal courts.',
                ],
                'tips'               => [
                    ['tip_type' => 'General',     'tip' => 'The Government Museum inside the fort is small but excellent — budget an extra 45 minutes for its collection of arms, coins, Punjabi folk paintings, and royal memorabilia.'],
                    ['tip_type' => 'Photography', 'tip' => 'The frescoed corridors of the Darbar Hall and the mirror-work ceilings of the Sheesh Mahal are the most photogenic interiors — ask the museum guard to unlock the side galleries.'],
                    ['tip_type' => 'Transport',   'tip' => 'Patiala is 70 km from Chandigarh; Volvo buses run every 30 minutes from the ISBT Chandigarh and take about 90 minutes — the most reliable option.'],
                ],
            ],

            // ══════════════ TAMIL NADU ════════════════════════════════════════

            [
                'state_id'           => $s['Tamil Nadu'],
                'name'               => 'Brihadeeswarar Temple',
                'type'               => 'Temple',
                'category'           => 'UNESCO',
                'built_by'           => 'Emperor Raja Raja Chola I',
                'built_in_year'      => 1010,
                'dynasty_or_period'  => 'Chola Dynasty',
                'entry_fee_indian'   => 0.00,
                'entry_fee_foreign'  => 0.00,
                'best_time_to_visit' => 'November to February — cool and dry; the Brihadeeswarar festival (Shivaratri) draws thousands of pilgrims in February–March.',
                'visiting_hours'     => '6:00 AM – 12:30 PM and 4:00 PM – 8:30 PM daily',
                'latitude'           => 10.78280,
                'longitude'          => 79.13180,
                'address'            => 'Membalam Road, Balaganapathy Nagar, Thanjavur, Tamil Nadu 613001',
                'is_featured'        => true,
                'short_description'  => 'The Brihadeeswarar is a 1,000-year-old Chola masterpiece — one of the tallest temple towers in India at 66 metres — and a UNESCO World Heritage Site of extraordinary architectural and spiritual significance.',
                'full_description'   => '<p>The Brihadeeswarar Temple at Thanjavur — also called the "Big Temple" or "Peruvudaiyar Kovil" in Tamil — is one of the greatest architectural achievements of medieval India and the crowning glory of the Chola imperial dynasty. Constructed by <strong>Raja Raja Chola I</strong> and consecrated in 1010 CE after 25 years of construction, it was the tallest building in India at the time of its completion and remains one of the finest examples of Dravidian temple architecture ever built. It was designated a UNESCO World Heritage Site in 1987, as part of the "Great Living Chola Temples" ensemble.</p><p>The temple\'s <strong>vimana</strong> (main tower over the sanctum) rises to 66 metres — 13 storeys of precisely diminishing tapered tiers capped by an octagonal cupola (<em>shikhara</em>) carved from a single granite block estimated to weigh 80 tonnes. Legend holds that this capstone was raised to its position using a ramp 6 km long, inclined so gently that bullocks could draw the block up without strain. One of the temple\'s most celebrated geometric enigmas is the <strong>shadow mystery</strong>: the vimana\'s shadow reportedly does not fall on the ground at solar noon, an architectural feat that has prompted much debate among historians. The <strong>Nandi bull</strong> in the main courtyard is a monolith carved from a single granite rock measuring 6 metres in length — one of the largest monolithic Nandi sculptures in India. Beneath layers of later Nayak-period paintings in the inner corridors, ASI conservation efforts have revealed exquisite original <strong>Chola frescoes</strong> — over 1,000 years old — depicting Shiva, apsaras, and royal court scenes in rich red and ochre pigments.</p>',
                'highlights'         => [
                    'The 66-metre vimana (main tower) was the tallest structure in India when consecrated in 1010 CE — built from granite without any mortar, using only interlocking stone joints.',
                    'The capstone atop the vimana is a single granite block weighing approximately 80 tonnes — raised to 66 metres using a 6 km inclined ramp, according to historical accounts.',
                    'The Nandi bull monolith in the outer courtyard is carved from a single rock 6 metres long — one of India\'s largest single-stone Nandi sculptures.',
                    'Original Chola frescoes from 1010 CE, hidden beneath Nayak-era overpainting for centuries, have been partially revealed by ASI conservation — among the oldest surviving murals in South India.',
                ],
                'tips'               => [
                    ['tip_type' => 'Clothing',    'tip' => 'Dress modestly — both men and women should cover their legs and shoulders. Traditional dhoti or sari is preferred for entry to the inner sanctum; lungis/sarongs are available to rent at the entrance.'],
                    ['tip_type' => 'Timing',      'tip' => 'Attend the 6 AM morning puja — the temple bells, incense, and oil-lamp rituals in the pre-dawn darkness create an atmosphere that a midday tourist visit cannot replicate.'],
                    ['tip_type' => 'Photography', 'tip' => 'Photography is permitted in the outer courtyards but restricted inside the mandapam and sanctum. The best full-tower shot is from the main eastern entrance aligned with the gopuram.'],
                ],
            ],

            [
                'state_id'           => $s['Tamil Nadu'],
                'name'               => 'Shore Temple Mahabalipuram',
                'type'               => 'Temple',
                'category'           => 'UNESCO',
                'built_by'           => 'Narasimhavarman II (Rajasimha)',
                'built_in_year'      => 700,
                'dynasty_or_period'  => 'Pallava Dynasty',
                'entry_fee_indian'   => 40.00,
                'entry_fee_foreign'  => 600.00,
                'best_time_to_visit' => 'November to February — calm seas, pleasant weather, and clear skies make the coastal setting most enjoyable.',
                'visiting_hours'     => '6:00 AM – 6:00 PM daily',
                'latitude'           => 12.61720,
                'longitude'          => 80.19930,
                'address'            => 'Shore Temple Road, Mahabalipuram, Tamil Nadu 603104',
                'is_featured'        => true,
                'short_description'  => 'The Shore Temple is one of South India\'s oldest structural stone temples, a 1,300-year-old Pallava masterpiece facing the Bay of Bengal, part of the UNESCO-listed Group of Monuments at Mahabalipuram.',
                'full_description'   => '<p>The Shore Temple at Mahabalipuram (also spelled Mamallapuram) stands at the edge of the Bay of Bengal as one of the oldest free-standing structural stone temples in South India — predating the great temples of Thanjavur and Madurai by centuries. Built during the reign of <strong>Narasimhavarman II</strong>, also known as Rajasimha, of the Pallava dynasty, around 700–728 CE, the temple complex consists of two Shiva shrines and one Vishnu shrine aligned along a east-west axis facing the rising sun. Unlike the earlier Pallava rock-cut monuments at Mahabalipuram (the Pancha Rathas and Arjuna\'s Penance), the Shore Temple was built entirely from cut and dressed granite blocks — representing a revolutionary shift in South Indian temple architecture from rock-cut to structural construction.</p><p>The two principal towers (each a <em>vimana</em> in the stepped Dravidian pyramidal style) frame a smaller Vishnu shrine between them. The seaward tower, shrined to <strong>Somaskanda</strong> (Shiva with Uma and Skanda), faces east and was designed specifically so that the first rays of the rising sun would illuminate the inner sanctum through its gateway. Over thirteen centuries of exposure to salt air and monsoon waves have eroded much of the surface sculpture; the ASI has constructed a sea-wall and planted casuarina trees as a windbreak to slow further weathering. Legends of <em>seven pagodas</em> submerged offshore — references found in early Pallava literature and in accounts of European sailors — were given dramatic new credence when the 2004 Indian Ocean tsunami temporarily receded the sea and revealed stone foundations, walls, and sculptures on the seabed near the Shore Temple, suggesting a much larger ancient city once stood along this coastline.</p>',
                'highlights'         => [
                    'One of the oldest free-standing structural stone temples in South India, built circa 700 CE — predating Thanjavur\'s Big Temple by over three centuries.',
                    'The main tower is oriented east so the rising sun\'s first rays illuminate the inner sanctum — a masterwork of solar alignment built 1,300 years ago.',
                    'Part of the UNESCO World Heritage Site "Group of Monuments at Mahabalipuram" (designated 1984), which includes the Pancha Rathas and Arjuna\'s Penance.',
                    'The 2004 tsunami momentarily exposed ancient submerged walls and sculptures offshore — physical evidence of the legendary "Seven Pagodas" described in Pallava literature.',
                ],
                'tips'               => [
                    ['tip_type' => 'Timing',      'tip' => 'Sunrise is the unmissable moment — arrive at 6 AM when the gates open and watch the golden light strike the eastward-facing tower directly from the sea horizon.'],
                    ['tip_type' => 'Photography', 'tip' => 'A wide-angle or ultra-wide lens captures both towers and the Bay of Bengal in one frame — shoot from the south-west corner of the compound for the best composition.'],
                    ['tip_type' => 'General',     'tip' => 'Combine with the Pancha Rathas (five monolithic chariot-shaped temples, 1 km away) and Arjuna\'s Penance (world\'s largest open-air rock relief, 500 m away) — all three sites are within the same UNESCO complex.'],
                ],
            ],

            // ══════════════ WEST BENGAL ════════════════════════════════════════

            [
                'state_id'           => $s['West Bengal'],
                'name'               => 'Victoria Memorial',
                'type'               => 'Memorial',
                'category'           => 'ASI',
                'built_by'           => 'Lord Curzon (Viceroy); designed by William Emerson',
                'built_in_year'      => 1921,
                'dynasty_or_period'  => 'British Colonial',
                'entry_fee_indian'   => 30.00,
                'entry_fee_foreign'  => 500.00,
                'best_time_to_visit' => 'October to February — Kolkata\'s cool and clear winter; the Durga Puja season (October) adds a festive atmosphere to the entire city.',
                'visiting_hours'     => '10:00 AM – 5:00 PM; closed Mondays and national holidays. Sound and light show: 7:15 PM (Bengali) and 8:15 PM (English)',
                'latitude'           => 22.54480,
                'longitude'          => 88.34260,
                'address'            => 'Victoria Memorial Hall, 1 Queens Way, Maidan, Kolkata, West Bengal 700071',
                'is_featured'        => true,
                'short_description'  => 'Victoria Memorial is Kolkata\'s most magnificent landmark — a colossal white Makrana marble hall commissioned by Lord Curzon in memory of Queen Victoria, housing 28,000 artefacts within 64 acres of Mughal-style gardens.',
                'full_description'   => '<p>Victoria Memorial Hall is Kolkata\'s grandest landmark and one of the finest examples of Indo-Saracenic architecture in India — a vast white marble building rising from 64 acres of manicured gardens at the southern end of the Maidan. Conceived and championed by <strong>Lord Curzon</strong>, Viceroy of India, as a memorial to <strong>Queen Victoria</strong> following her death in 1901, the building was designed by British architect <strong>Sir William Emerson</strong> (also responsible for the Crawford Market in Mumbai) in a style blending British Classical, Venetian, and Mughal architectural elements. Construction used white Makrana marble from Rajasthan — the same source as the Taj Mahal — and was completed and opened to the public in 1921, twenty years after the queen\'s death.</p><p>Crowning the central dome is a 16-foot bronze winged figure of <strong>Victory</strong> — mounted on a ball bearing so it rotates slowly with the wind, always facing into the breeze. The building houses a remarkable museum of <strong>28,000 artefacts</strong> across 25 galleries, spanning the entire history of the British Indian Empire: Queen Victoria\'s personal writing desk, piano, and girlhood diary; Mughal miniatures; Raj-era paintings; Company-period maps; arms and armour; and prints documenting the independence movement. The surrounding gardens — designed by Lord Redesdale and David Prain — are planted with palms, royal palms, and flowering trees around ornamental pools and bronze statues of Victoria, Curzon, and Edward VII. An evening <strong>sound and light show</strong> narrates Kolkata\'s history using the memorial\'s illuminated facade as a screen — one of the best such shows in India.</p>',
                'highlights'         => [
                    'Built entirely from Makrana white marble from Rajasthan — the same quarry that supplied stone for the Taj Mahal — 2,000 lorry-loads were transported across India.',
                    'The 16-foot bronze Victory statue atop the dome is mounted on a ball bearing and rotates freely in the wind, always pointing into the breeze.',
                    'The museum houses over 28,000 artefacts including Queen Victoria\'s personal writing desk, piano, and girlhood diary — offering an intimate portrait of the queen and the empire.',
                    'The 64-acre Mughal-style gardens are a beloved public space in Kolkata; the evening sound and light show projects Bengal\'s history onto the illuminated marble facade.',
                ],
                'tips'               => [
                    ['tip_type' => 'Timing',      'tip' => 'The evening sound and light show (7:15 PM Bengali / 8:15 PM English) is a highlight that most visitors miss — book tickets at the gate well before showtime as it frequently sells out on weekends.'],
                    ['tip_type' => 'Photography', 'tip' => 'The southern lawn at golden hour (5–6 PM) offers the best light on the white marble facade; the reflection pools in the garden foreground create a classic symmetrical composition.'],
                    ['tip_type' => 'General',     'tip' => 'Visit on a weekday — weekend crowds are enormous. The galleries on the upper floor covering Raj-era paintings and Company School miniatures are the least crowded and most historically rich sections.'],
                ],
            ],

            [
                'state_id'           => $s['West Bengal'],
                'name'               => 'Dakshineswar Kali Temple',
                'type'               => 'Temple',
                'category'           => 'Religious',
                'built_by'           => 'Rani Rashmoni',
                'built_in_year'      => 1855,
                'dynasty_or_period'  => 'Bengal Vaishnavite–Shakta tradition',
                'entry_fee_indian'   => 0.00,
                'entry_fee_foreign'  => 0.00,
                'best_time_to_visit' => 'October to March — cool weather and major festivals; Kali Puja (coinciding with Diwali) is the most extraordinary time to visit.',
                'visiting_hours'     => '6:00 AM – 12:30 PM and 3:00 PM – 8:30 PM daily',
                'latitude'           => 22.65530,
                'longitude'          => 88.35790,
                'address'            => 'Dakshineswar Kali Temple, Dakshineswar, Kolkata, West Bengal 700076',
                'is_featured'        => false,
                'short_description'  => 'Dakshineswar is one of Bengal\'s most revered Kali temples, built by the philanthropist Rani Rashmoni in 1855 on the banks of the Hooghly, and where Sri Ramakrishna Paramahamsa served as priest for 30 transformative years.',
                'full_description'   => '<p>The Dakshineswar Kali Temple is one of the most spiritually significant pilgrimage sites in Bengal — a grand complex of 13 temples set on the eastern bank of the Hooghly River, approximately 20 km north of central Kolkata. The temple was commissioned by <strong>Rani Rashmoni</strong>, a wealthy Bengali philanthropist and devout worshipper of Kali, and constructed between 1847 and 1855. Rani Rashmoni, despite facing caste discrimination (she was of the Mahishya fishing caste and initially barred from installing a Brahmin priest), secured the right to worship by dedicating the temple to the public — transforming her private devotion into an act of social philanthropy that became a model for popular Hindu temple endowment.</p><p>The main temple — a nine-spired <em>navaratna</em> structure typical of Bengali temple architecture — enshrines the goddess <strong>Bhavatarini</strong> (a form of Kali as "She who liberates the universe") in her most compassionate aspect. Twelve identical Shiva temples line the Ganges-side terrace, with a Radha-Krishna temple completing the complex. The temple\'s most profound historical significance lies in its association with <strong>Sri Ramakrishna Paramahamsa</strong> (1836–1886), the visionary mystic, who served as the temple\'s priest for 30 years — the period during which he attained spiritual realisation, conducted experiments in multiple religious paths (including Islam and Christianity), and attracted disciples who would later establish the Ramakrishna Mission. His room within the temple precincts is preserved as a museum. The Hooghly river bathing ghats directly alongside the temple are among Kolkata\'s most sacred; pilgrims descend the stone steps before entering the goddess\'s presence. Regular ferry services connect Dakshineswar across the river to <strong>Belur Math</strong>, the headquarters of the Ramakrishna Mission — making a combined visit deeply meaningful.</p>',
                'highlights'         => [
                    'Sri Ramakrishna Paramahamsa served as priest here for 30 years — it was in this temple that he attained spiritual realisation and developed his famous teaching that "all religions lead to the same God."',
                    'The navaratna (nine-spired) main temple is one of Bengal\'s finest examples of traditional terracotta-influenced Bengali temple architecture at its largest scale.',
                    'Twelve Shiva temples line the sacred Hooghly riverbank terrace — reflecting the ancient practice of building subsidiary shrines to complement a major Shakti temple.',
                    'A ferry from the temple ghat crosses the Hooghly to Belur Math (Ramakrishna Mission headquarters) in 10 minutes — one of Bengal\'s most spiritually resonant river crossings.',
                ],
                'tips'               => [
                    ['tip_type' => 'Timing',      'tip' => 'Kali Puja night (coinciding with Diwali) transforms the temple into a sea of oil lamps, flowers, and devotional chanting — one of the most extraordinary religious experiences in West Bengal.'],
                    ['tip_type' => 'General',     'tip' => 'Visit Ramakrishna\'s room inside the complex (free entry) — the small museum preserving his personal items and the room where he experienced visions is deeply moving and often overlooked by casual visitors.'],
                    ['tip_type' => 'Transport',   'tip' => 'Take the ferry from Dakshineswar ghat to Belur Math (₹7) rather than travelling by road — the 10-minute Hooghly crossing is a beautiful, atmospheric way to connect the two sites.'],
                ],
            ],

        ];
    }
}
