<?php

namespace Database\Seeders;

use App\Models\Festival;
use App\Models\State;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FestivalSeeder extends Seeder
{
    public function run(): void
    {
        $stateIds = [];
        foreach (['Rajasthan', 'Kerala', 'Punjab', 'Tamil Nadu', 'West Bengal'] as $name) {
            $state = State::where('name', $name)->first();
            abort_unless($state, 500, "State '{$name}' not found — run DatabaseSeeder first.");
            $stateIds[$name] = $state->id;
        }

        $all = array_values($stateIds);

        foreach ($this->festivalsData($stateIds, $all) as $data) {
            $tips              = $data['tips'] ?? [];
            $rituals           = $data['rituals'] ?? [];
            $celebratingStates = $data['celebrating_states'] ?? [];
            unset($data['tips'], $data['rituals'], $data['celebrating_states']);

            $festival = Festival::create(array_merge($data, [
                'slug' => Str::slug($data['name']),
            ]));

            foreach ($tips as $tip) {
                $festival->tips()->create($tip);
            }

            foreach ($rituals as $ritual) {
                $festival->rituals()->create($ritual);
            }

            foreach ($celebratingStates as $stateId => $pivot) {
                $festival->celebratingStates()->attach($stateId, [
                    'local_name'        => $pivot['local_name'] ?? null,
                    'local_significance' => $pivot['local_significance'] ?? null,
                ]);
            }
        }
    }

    // -------------------------------------------------------------------------

    private function festivalsData(array $s, array $all): array
    {
        $raj = $s['Rajasthan'];
        $ker = $s['Kerala'];
        $pun = $s['Punjab'];
        $tn  = $s['Tamil Nadu'];
        $wb  = $s['West Bengal'];

        return [

            // ══════════════════════════════════════════════════════════════════
            // 1. DIWALI
            // ══════════════════════════════════════════════════════════════════
            [
                'name'              => 'Diwali',
                'tagline'           => 'Festival of Lights and New Beginnings',
                'state_id'          => null,
                'is_national'       => true,
                'religion'          => 'Hindu',
                'month'             => 11,
                'start_day'         => null,
                'end_day'           => null,
                'duration_days'     => 5,
                'short_description' => 'Diwali, the Festival of Lights, is India\'s most celebrated festival — a five-day spectacle of earthen lamps, fireworks, sweets, and prayers to Goddess Lakshmi marking the triumph of light over darkness.',
                'full_description'  => '<p>Diwali — derived from the Sanskrit <em>Deepavali</em> meaning "row of lights" — is the most widely observed festival across India, celebrated by Hindus, Jains, Sikhs, and some Buddhists. The festival commemorates the return of Lord Rama to Ayodhya after 14 years of exile and the defeat of the demon king Ravana.</p><p>The five-day celebration begins with <strong>Dhanteras</strong>, when people purchase gold, silver, or new utensils as a symbol of prosperity. The second day, <strong>Naraka Chaturdashi</strong> (Choti Diwali), marks the slaying of the demon Narakasura by Lord Krishna. The main day, <strong>Lakshmi Puja</strong>, sees families lighting thousands of diyas (earthen lamps) and bursting firecrackers to welcome the Goddess of Wealth. <strong>Govardhan Puja</strong> and <strong>Bhai Dooj</strong> follow, celebrating the bond between siblings and Lord Krishna\'s lifting of Govardhan hill.</p><p>For Jains, Diwali marks the attainment of moksha by Lord Mahavira. For Sikhs, it coincides with Bandi Chhor Divas, commemorating the release of Guru Hargobind from Gwalior Fort.</p>',
                'significance'      => 'Diwali symbolises the victory of light over darkness, knowledge over ignorance, and good over evil. It marks the beginning of the Hindu New Year in many parts of India and is a time for family reunions, settling of debts, and renewal of business ledgers (Chopda Puja).',
                'how_celebrated'    => 'Homes are cleaned and decorated with rangoli patterns, marigold torans, and rows of clay diyas. Families perform Lakshmi Puja at dusk, offer sweets, and exchange gifts of mithai and dry fruits. Children burst firecrackers. Markets blaze with lights and new clothes are worn. Businesses open new accounts with prayers for prosperity.',
                'is_featured'       => true,
                'is_active'         => true,
                'tips'              => [
                    ['tip_category' => 'What_to_Wear',  'tip_title' => 'Dress in New Traditional Attire', 'tip_body' => 'Wear new traditional clothes — silk sarees, kurta-pyjamas, or lehengas in jewel tones like deep red, royal blue, or gold. Buying and wearing new clothes on Diwali is considered auspicious.'],
                    ['tip_category' => 'Photography',   'tip_title' => 'Capture the Golden Hour of Diyas', 'tip_body' => 'The best shots happen just after sunset when rows of diyas flicker against the darkening sky. Use a tripod, set ISO to 400–800, and shoot in RAW. Focus on reflections in water or brass puja thalis.'],
                    ['tip_category' => 'Safety',        'tip_title' => 'Protect Yourself from Fireworks', 'tip_body' => 'Keep a bucket of water and a fire extinguisher nearby when bursting crackers. Never allow children to handle crackers unsupervised. Wear cotton clothes and keep pets indoors — the noise causes extreme distress to animals.'],
                    ['tip_category' => 'What_to_Eat',   'tip_title' => 'Savour Regional Diwali Sweets', 'tip_body' => 'Try kaju katli (cashew barfi), besan ladoo, gulab jamun, and chakli. In West Bengal, sandesh and mishti doi are traditional. In South India, chakkarai pongal and murukku are made. Do not miss freshly prepared mathri and namkeen from local halwais.'],
                ],
                'rituals'           => [
                    ['ritual_name' => 'Lakshmi Puja',   'ritual_description' => 'On the main Diwali evening, the entire family gathers before an idol or image of Goddess Lakshmi and Lord Ganesha. The priest or eldest woman of the household performs aarti with incense, flowers, and ghee diyas, chanting Lakshmi Chalisa and distributing prasad of kheel-batasha.', 'ritual_timing' => 'Main day evening, during Pradosh Kaal (dusk)'],
                    ['ritual_name' => 'Diya Lighting',  'ritual_description' => 'Rows of earthen oil lamps (diyas) are lit along window sills, doorsteps, courtyards, and rooftops. A large diya is kept burning throughout the night at the main entrance to welcome Lakshmi. In Rajasthan, diyas are set afloat on water bodies and ponds.', 'ritual_timing' => 'From sunset until midnight'],
                    ['ritual_name' => 'Bhai Dooj',      'ritual_description' => 'On the fifth day, sisters apply tilak on their brothers\' foreheads and pray for their long life. Brothers give gifts and promise to protect their sisters. In West Bengal this ritual is called Bhai Phota and involves an elaborate ceremony with sandalwood paste and paddy.', 'ritual_timing' => 'Day 5 morning'],
                ],
                'celebrating_states' => [
                    $raj => ['local_name' => 'Deepawali',  'local_significance' => 'Jaipur illuminates its palaces and bazaars; the city conducts grand Lakshmi Puja at Govind Dev Ji temple'],
                    $ker => ['local_name' => 'Deepavali',  'local_significance' => 'Celebrated by the Tulu and Kodava communities; Thrissur markets fill with traditional brass lamps'],
                    $pun => ['local_name' => 'Bandi Chhor Divas', 'local_significance' => 'Sikhs light the Golden Temple in Amritsar and celebrate the release of Guru Hargobind Sahib from Mughal captivity'],
                    $tn  => ['local_name' => 'Deepavali',  'local_significance' => 'Celebrated a day early (Naraka Chaturdashi); people rise before dawn for an oil bath and wear new clothes'],
                    $wb  => ['local_name' => 'Kali Puja',  'local_significance' => 'West Bengal worships Goddess Kali instead of Lakshmi on the main night; elaborate pandal decorations rival Durga Puja'],
                ],
            ],

            // ══════════════════════════════════════════════════════════════════
            // 2. HOLI
            // ══════════════════════════════════════════════════════════════════
            [
                'name'              => 'Holi',
                'tagline'           => 'The Riot of Colours that Heralds Spring',
                'state_id'          => null,
                'is_national'       => true,
                'religion'          => 'Hindu',
                'month'             => 3,
                'start_day'         => null,
                'end_day'           => null,
                'duration_days'     => 2,
                'short_description' => 'Holi is the exuberant Hindu spring festival of colours, celebrated with gulal powder, water guns, bonfires, and bhang-laced sweets — marking the victory of devotion over arrogance and the arrival of spring.',
                'full_description'  => '<p>Holi is one of India\'s oldest and most joyous festivals, rooted in the legend of <strong>Prahlad and Holika</strong>. Prahlad, a devoted follower of Vishnu, was ordered killed by his demonic father Hiranyakashipu. His aunt Holika, who was immune to fire, tried to burn him on her lap — but divine grace protected Prahlad while Holika was consumed by flames. The bonfire ritual (Holika Dahan) on the eve of Holi commemorates this event.</p><p>The second day, <strong>Dhulandi</strong> or Rangwali Holi, is an uninhibited explosion of colour. People throng the streets armed with pichkaris (water guns) and bags of dry gulal, drenching strangers and loved ones alike. In Mathura and Vrindavan, Holi celebrations begin weeks before — <strong>Lathmar Holi</strong> in Barsana sees women playfully beat men with bamboo sticks.</p><p>In West Bengal, the festival is called <strong>Dol Purnima</strong> or Basanta Utsav, celebrated with cultural processions, songs of Tagore, and fragrant abir powder. In Punjab, the martial <strong>Hola Mohalla</strong> at Anandpur Sahib showcases Sikh warrior traditions.</p>',
                'significance'      => 'Holi celebrates the victory of devotion (Bhakti) over arrogance and evil, represented by Holika\'s defeat. It also marks the arrival of spring, the season of fertility and new crops. The festival dissolves social hierarchies — caste, age, and status become irrelevant as everyone plays together.',
                'how_celebrated'    => 'The evening before Holi, bonfires are lit and coconuts, corn, and popcorn are offered. Next morning, people emerge with gulal, balloons filled with coloured water, and pichkaris. Bhang (cannabis) lassi and gujiya (sweet dumplings) are shared. Communities gather at temples for Holi puja, then drench each other in colour until afternoon. Evening is for cleanup, visiting family, and feasting.',
                'is_featured'       => true,
                'is_active'         => true,
                'tips'              => [
                    ['tip_category' => 'What_to_Wear',  'tip_title' => 'Wear Clothes You Can Sacrifice', 'tip_body' => 'Wear old white clothes — colours show most vividly on white and the clothes will be stained permanently. Apply coconut oil or sunscreen to your skin and hair before stepping out; this makes it much easier to wash off synthetic colours.'],
                    ['tip_category' => 'What_to_Carry', 'tip_title' => 'Protect Your Devices and Eyes', 'tip_body' => 'Leave expensive cameras and phones at home or seal them in ziplock bags. Wear wraparound sunglasses to protect your eyes from gulal, which can cause irritation. Carry a small towel and a bottle of plain water for rinsing eyes if needed.'],
                    ['tip_category' => 'Safety',        'tip_title' => 'Choose Natural Colours Only', 'tip_body' => 'Synthetic Holi colours contain industrial dyes, heavy metals, and mica that cause skin rashes, eye damage, and respiratory problems. Opt only for natural herbal gulal made from flowers like marigold, rose, and palash. Check the label before buying.'],
                    ['tip_category' => 'What_to_Eat',   'tip_title' => 'The Essential Holi Foods', 'tip_body' => 'Gujiya (flour dumplings filled with khoya and dry fruits) is the iconic Holi sweet — make or buy them fresh. Thandai (milk infused with fennel, rose, and cardamom) is the traditional drink, sometimes laced with bhang. Also try dahi vada, puran poli, and malpua.'],
                ],
                'rituals'           => [
                    ['ritual_name' => 'Holika Dahan', 'ritual_description' => 'On the evening before Holi, a communal bonfire is lit in every neighbourhood. Villagers carry wood and dried dung cakes and arrange them around a central Holika effigy. The eldest man or priest lights the fire with a burning torch after circling it with folded hands. People roast grains, coconut, and popcorn in the fire as prasad.', 'ritual_timing' => 'Eve of Holi, at sunset after moonrise'],
                    ['ritual_name' => 'Rangwali Holi', 'ritual_description' => 'From morning to early afternoon, revellers flood the streets, terraces, and open grounds. Dry gulal is smeared on faces and thrown in the air, while water-filled pichkaris and balloons drench everyone. The chaos is deliberate and equalising — no one is spared. Music, drum beats, and shouts of "Bura na mano, Holi hai!" fill the air.', 'ritual_timing' => 'Morning until early afternoon on Holi day'],
                    ['ritual_name' => 'Gujiya Sharing', 'ritual_description' => 'After washing off the colours, families and neighbours gather to share a feast. The centrepiece is gujiya, prepared days in advance and deep-fried to a golden crisp. Elders distribute sweets first to children, then to guests. Thandai is poured in brass tumblers and everyone settles into conversations and laughter, completing the social harmony Holi symbolises.', 'ritual_timing' => 'Late afternoon and evening after colours are washed off'],
                ],
                'celebrating_states' => [
                    $raj => ['local_name' => 'Holi',       'local_significance' => 'Jaipur hosts the famous Elephant Holi festival; Pushkar celebrates with flower petals at the Brahma temple ghats'],
                    $ker => ['local_name' => 'Ukuli',      'local_significance' => 'Celebrated primarily in coastal Tulu-speaking regions of North Kerala as Ukuli, with folk songs and mild colour play'],
                    $pun => ['local_name' => 'Hola Mohalla', 'local_significance' => 'Sikhs at Anandpur Sahib celebrate Hola Mohalla with martial arts displays, gatka, and cavalry charges — a tradition started by Guru Gobind Singh'],
                    $tn  => ['local_name' => 'Holi',       'local_significance' => 'Celebrated modestly by North Indian communities; Madurai and Chennai see colour play in residential neighbourhoods'],
                    $wb  => ['local_name' => 'Dol Purnima', 'local_significance' => 'Radha and Krishna idols are placed on decorated palanquins and taken through the streets; abir (red powder) is offered first to the deities and then to elders'],
                ],
            ],

            // ══════════════════════════════════════════════════════════════════
            // 3. EID UL-FITR
            // ══════════════════════════════════════════════════════════════════
            [
                'name'              => 'Eid ul-Fitr',
                'tagline'           => 'Breaking the Fast with Joy and Gratitude',
                'state_id'          => null,
                'is_national'       => true,
                'religion'          => 'Muslim',
                'month'             => 4,
                'start_day'         => null,
                'end_day'           => null,
                'duration_days'     => 3,
                'short_description' => 'Eid ul-Fitr is the joyous Islamic festival marking the end of Ramadan — a month of fasting, prayer, and reflection — celebrated with communal prayers, charitable giving, and feasts of biryani, sheer khurma, and sevaiyan.',
                'full_description'  => '<p>Eid ul-Fitr — meaning "Festival of Breaking the Fast" — is one of Islam\'s two major celebrations, observed by Muslims worldwide on the first day of Shawwal (the tenth month of the Islamic lunar calendar). In India, home to over 200 million Muslims, Eid is a national public holiday that transcends religious boundaries, with neighbours of all faiths joining in the celebrations.</p><p>The festival begins with the sighting of the crescent moon (Hilal) the night before, triggering joyous declarations of "Eid Mubarak!" across neighbourhoods. The next morning, Muslims rise before dawn for a ritual bath (ghusl), don their finest clothes, and make their way to mosques or open-air idgahs for the special <strong>Eid Namaz</strong> (prayer).</p><p>Before the prayer, every adult Muslim is obligated to pay <strong>Zakat al-Fitr</strong> — a fixed charitable donation to ensure even the poorest members of the community can celebrate. After prayers, families visit each other, exchange gifts, and feast on elaborate spreads. In India, the meal is defined by fragrant biryani, creamy <em>sheer khurma</em> (vermicelli in sweetened milk), and mutton dishes slow-cooked since the night before.</p>',
                'significance'      => 'Eid ul-Fitr celebrates the completion of Ramadan — 30 days of fasting from dawn to dusk, prayer, and self-discipline. It is a day of gratitude to Allah, of communal solidarity expressed through Zakat (charity), and of shared joy after spiritual renewal. In India, it is also a powerful symbol of interfaith harmony, with non-Muslim neighbours often invited to partake in the feast.',
                'how_celebrated'    => 'New clothes (Eid clothes) are purchased weeks in advance. Homes are cleaned and decorated. After Eid Namaz, men embrace each other three times in greeting. Families visit graves of loved ones to offer prayers. Feasts are spread with biryani, haleem, korma, sewai, and sheer khurma. Mehndi (henna) is applied by women and girls. Elders give Eidi (cash gifts) to children. Evenings see community gatherings and music.',
                'is_featured'       => true,
                'is_active'         => true,
                'tips'              => [
                    ['tip_category' => 'What_to_Wear',  'tip_title' => 'Dress Modestly and Festively', 'tip_body' => 'Wear modest, full-sleeved clothing when visiting mosques or Muslim neighbourhoods. Men typically wear kurta-pyjama or sherwanis in white or pastel tones. Women wear salwar kameez or abayas with dupattas. Shoes are removed before entering mosques — wear easy slip-ons.'],
                    ['tip_category' => 'What_to_Eat',   'tip_title' => 'Must-Try Eid Delicacies', 'tip_body' => 'Sheer khurma — vermicelli cooked in sweetened milk with dates, cardamom, and dry fruits — is the quintessential Eid dish. Follow it with biryani (Hyderabadi dum biryani is legendary), mutton nihari, and seviyan. For dessert, try phirni set in earthen pots or double ka meetha from Hyderabad.'],
                    ['tip_category' => 'Etiquette',     'tip_title' => 'Visiting Homes on Eid', 'tip_body' => 'When invited to an Eid feast, arrive after the morning prayer (late morning). Say "Eid Mubarak" upon entering. Accept food when offered — declining repeatedly can be considered impolite. Bring sweets or dry fruits as a small gift for the host. Remove shoes at the door and greet elders first.'],
                    ['tip_category' => 'Transport',     'tip_title' => 'Navigate Eid Crowds Wisely', 'tip_body' => 'Roads near mosques and idgahs are heavily congested from 6 AM to 9 AM on Eid morning. Plan travel before 5:30 AM or after 10 AM. Old city areas of Delhi, Lucknow, and Hyderabad see the largest gatherings. Metro services run at full capacity — use them over taxis.'],
                ],
                'rituals'           => [
                    ['ritual_name' => 'Eid Namaz', 'ritual_description' => 'The two-rakat (unit) Eid prayer is performed in congregation at the mosque or open idgah ground. The imam delivers a khutba (sermon) emphasising gratitude, charity, and communal bonds. Men stand in long rows on prayer mats, and the prayer concludes with three embraces of greeting between worshippers.', 'ritual_timing' => 'Early morning, after sunrise, on Eid day'],
                    ['ritual_name' => 'Zakat al-Fitr', 'ritual_description' => 'Before the Eid prayer, every Muslim who possesses the minimum threshold of wealth (nisab) pays Zakat al-Fitr — a small fixed charitable donation — on behalf of themselves and each family member. This is distributed to the poor so that everyone can celebrate Eid with a full stomach. In India, mosques collect and redistribute this charity locally.', 'ritual_timing' => 'Before the Eid prayer, on the morning of Eid'],
                    ['ritual_name' => 'Sheer Khurma Sharing', 'ritual_description' => 'After prayers, the family gathers around the matriarch who ladles out steaming bowls of sheer khurma — a slow-cooked preparation of vermicelli, full-cream milk, dates, saffron, and dry fruits that has simmered on the stove since the previous night. The eldest member is served first. No Eid breakfast in India is complete without this dish.', 'ritual_timing' => 'Morning, immediately after returning from Eid Namaz'],
                ],
                'celebrating_states' => [
                    $raj => ['local_name' => 'Eid ul-Fitr', 'local_significance' => 'Large communities in Jaipur, Ajmer (near the Dargah of Moinuddin Chishti), and Nagaur celebrate with elaborate feasts and communal prayers at historic mosques'],
                    $ker => ['local_name' => 'Perunnal',    'local_significance' => 'Kerala\'s Malabar coast has one of India\'s oldest Muslim communities; Kozhikode and Malappuram see spectacular Eid celebrations with traditional Mappila songs and pathiri (rice bread)'],
                    $pun => ['local_name' => 'Eid ul-Fitr', 'local_significance' => 'Celebrated across Muslim communities in Ludhiana, Amritsar, and rural Punjab with emphasis on communal harmony and shared feasting with Sikh and Hindu neighbours'],
                    $tn  => ['local_name' => 'Eid ul-Fitr', 'local_significance' => 'Chennai\'s Triplicane and Vellore\'s Arcot region host large Eid congregations; local delicacies include biryani cooked in large brass handis'],
                    $wb  => ['local_name' => 'Eid ul-Fitr', 'local_significance' => 'Kolkata\'s Park Circus and Rajabazar areas transform for Eid; the city is famous for its Mughlai biryani with potato — a unique local adaptation'],
                ],
            ],

            // ══════════════════════════════════════════════════════════════════
            // 4. CHRISTMAS
            // ══════════════════════════════════════════════════════════════════
            [
                'name'              => 'Christmas',
                'tagline'           => 'Celebrating the Birth of Christ with Carols and Candlelight',
                'state_id'          => null,
                'is_national'       => true,
                'religion'          => 'Christian',
                'month'             => 12,
                'start_day'         => 25,
                'end_day'           => 25,
                'duration_days'     => 1,
                'short_description' => 'Christmas in India is a vibrant blend of solemn Midnight Mass, carol singing, paper stars (parol), and festive feasts — celebrated most grandly in Kerala, Goa, and Meghalaya but enjoyed nationwide as a public holiday.',
                'full_description'  => '<p>Christmas in India has a unique character shaped by 2000 years of Christianity\'s presence on the subcontinent. According to tradition, the Apostle Thomas brought Christianity to Kerala in 52 CE, making the Syrian Christians of Kerala among the world\'s oldest Christian communities.</p><p>The most distinctive element of Indian Christmas is the <strong>Midnight Mass</strong>, celebrated in grand churches across the country — from St. Paul\'s Cathedral in Kolkata to the Santhome Basilica in Chennai. Churches are decorated with poinsettia flowers, star-shaped lanterns made of coloured paper (called <em>parol</em> in Kerala), and nativity scenes.</p><p>In Kerala, Christmas (locally called <em>Perunnal</em>) involves elaborate home cooking — <strong>duck roast</strong>, <strong>appam with stew</strong>, <strong>plum cake</strong> soaked in rum, and <strong>Kerala beef fry</strong>. The Kolkata tradition of "Bada Din" (Big Day) sees Park Street illuminate into a magical strip of lights, attracting people of all faiths for Carol evenings and cake shops that have been preparing plum cakes since October.</p>',
                'significance'      => 'Christmas celebrates the birth of Jesus Christ, the central figure of Christianity. For Indian Christians, it is both a deep spiritual commemoration and a cultural celebration of heritage. Beyond the religious community, Christmas in India is a widely shared occasion — the lights, carols, plum cake, and gift-giving culture have become part of the mainstream Indian festive calendar.',
                'how_celebrated'    => 'Churches hold services on Christmas Eve, culminating in the Midnight Mass at 12 AM. Homes are decorated with Christmas trees, star lanterns, tinsel, and nativity cribs. Families bake or buy plum cakes and share them with neighbours. Carol singers (often school choirs) visit homes and community centres. Gift exchanges happen on Christmas morning. Public spaces in major cities hold carol evenings, Santa visits, and light displays.',
                'is_featured'       => false,
                'is_active'         => true,
                'tips'              => [
                    ['tip_category' => 'Best_Spots',   'tip_title' => 'Best Places to Experience Indian Christmas', 'tip_body' => 'Goa offers the most European-feeling Christmas with Portuguese-heritage churches and beach parties. Kerala\'s Thrissur and Kottayam hold the most traditional Midnight Mass celebrations. Kolkata\'s Park Street is magical with lights. Shillong and other Northeast cities celebrate Christmas as a near-national festival.'],
                    ['tip_category' => 'What_to_Eat',  'tip_title' => 'Christmas Foods Across India', 'tip_body' => 'In Kerala: appam and beef/chicken stew, duck curry, plum cake soaked in brandy, rose cookies, and achappam. In Goa: sorpotel (pork offal curry), bebinca (layered pudding), and sannas. In Kolkata: fruit cake from Nahoum\'s bakery (a Jewish institution!) and Wenger\'s. Try rose cookies wherever you find them.'],
                    ['tip_category' => 'Photography',  'tip_title' => 'Capturing Indian Christmas', 'tip_body' => 'The best photography happens at Midnight Mass when candlelit churches glow against the dark sky. In Kerala, photograph the intricate paper star lanterns (parol) hanging from every home. Kolkata\'s Park Street from 7 PM onwards is a spectacular scene of string lights and carol singers.'],
                    ['tip_category' => 'Transport',    'tip_title' => 'Getting Around on Christmas', 'tip_body' => 'Christmas Day is a national holiday — government offices and many shops are closed. Churches see heavy traffic from 10 PM on Christmas Eve until 2 AM. Book hotels near famous churches well in advance in Goa and Kerala (prices double in December). Local buses may run reduced services on December 25.'],
                ],
                'rituals'           => [
                    ['ritual_name' => 'Midnight Mass', 'ritual_description' => 'The central spiritual event of Christmas, the Mass begins at midnight on December 24 and commemorates the birth of Jesus. Parishioners sing carols, follow scripture readings narrating the Nativity, receive Holy Communion, and exchange the sign of peace. In Kerala\'s Syrian Christian tradition, the Mass is conducted in Syriac, an ancient liturgical language.', 'ritual_timing' => 'Midnight, December 24'],
                    ['ritual_name' => 'Nativity Crib Decoration', 'ritual_description' => 'Weeks before Christmas, families construct nativity scenes (cribs) depicting the manger of Bethlehem with clay figurines of Mary, Joseph, the baby Jesus, wise men, shepherds, and animals. In Tamil Nadu and Andhra, this tradition is called the "Bethlehem Kuthirai" and elaborate tableaux are created in church courtyards, sometimes depicting local village scenes.', 'ritual_timing' => 'December 1 onwards; unveiled on Christmas Eve'],
                    ['ritual_name' => 'Carol Singing', 'ritual_description' => 'From the first week of December, school and church choirs visit homes in their parish to sing Christmas carols in exchange for small donations or refreshments. In Kerala\'s Kottayam district, this tradition called "Kummi Paattu" has been sustained for over two centuries. In Kolkata, carol singing on Park Street draws crowds of tens of thousands.', 'ritual_timing' => 'December 1–24 evenings'],
                ],
                'celebrating_states' => [
                    $raj => ['local_name' => 'Christmas', 'local_significance' => 'Celebrated in Ajmer, Jaipur, and Mount Abu; the hill station of Mount Abu hosts a colonial-era Christmas tradition'],
                    $ker => ['local_name' => 'Perunnal',  'local_significance' => 'Kerala has one of India\'s oldest and largest Christian communities (20%); grand church celebrations with star lanterns, duck roast, and carol processions define the state\'s Christmas'],
                    $pun => ['local_name' => 'Christmas', 'local_significance' => 'Christian communities in Punjab celebrate in Amritsar, Jalandhar, and Ludhiana; churches of British-era origin hold traditional carol services'],
                    $tn  => ['local_name' => 'Christmas', 'local_significance' => 'Santhome Basilica in Chennai — built over the tomb of St. Thomas — holds a major pilgrimage on Christmas; Velankanni\'s Basilica of Our Lady of Good Health is another focal point'],
                    $wb  => ['local_name' => 'Bada Din',  'local_significance' => 'Kolkata\'s Park Street Christmas is legendary; the Jewish-owned Nahoum\'s bakery and the Colonial-era St. Paul\'s Cathedral are the centrepieces of a celebration the whole city participates in'],
                ],
            ],

            // ══════════════════════════════════════════════════════════════════
            // 5. BAISAKHI
            // ══════════════════════════════════════════════════════════════════
            [
                'name'              => 'Baisakhi',
                'tagline'           => 'Harvest, Khalsa, and the Spirit of Punjab',
                'state_id'          => $pun,
                'is_national'       => false,
                'religion'          => 'Sikh',
                'month'             => 4,
                'start_day'         => 13,
                'end_day'           => 13,
                'duration_days'     => 1,
                'short_description' => 'Baisakhi marks the Punjabi harvest festival and, for Sikhs, the historic founding of the Khalsa Panth by Guru Gobind Singh in 1699 — celebrated with Gurdwara prayers, bhangra, and golden fields of ripening wheat.',
                'full_description'  => '<p>Baisakhi (also spelled Vaisakhi) falls on April 13 or 14 each year, marking the solar New Year in the Punjabi calendar and the beginning of the Rabi (spring wheat) harvest season. For the Sikh community, Baisakhi carries a significance beyond agriculture: on this day in 1699, Guru Gobind Singh, the tenth Sikh Guru, founded the <strong>Khalsa Panth</strong> at Anandpur Sahib.</p><p>The founding ceremony was extraordinary. Guru Gobind Singh called thousands of Sikhs together and asked who among them would give their head for the faith. Five men — the <em>Panj Pyare</em> (Five Beloved Ones) — came forward one by one. Instead of beheading them, the Guru initiated them into a new order of soldiers-saints, giving them the five K\'s (Panj Kakkar) and the collective surname "Singh" (lion) for men and "Kaur" (princess) for women.</p><p>In Punjabi villages, Baisakhi is a harvest thanksgiving. Farmers who have toiled through winter gather at the gurudwara in the morning, then spend the afternoon in open fields celebrating the golden wheat harvest with bhangra drums, gidda dances, and communal langar feasts.</p>',
                'significance'      => 'For Sikhs, Baisakhi commemorates the founding of the Khalsa — the community of initiated Sikhs who embody both spiritual devotion and the readiness to defend righteousness. For Punjab\'s Hindu community, it is the solar New Year and harvest thanksgiving. The 1919 Jallianwala Bagh massacre in Amritsar happened on Baisakhi, adding a layer of historical gravity to the celebrations.',
                'how_celebrated'    => 'Gurdwaras across Punjab hold Amrit Sanchar (Khalsa initiation) ceremonies where new members join the brotherhood. Devotees take holy dips in sarovars (tanks) of gurudwaras like Harmandir Sahib. Nagar Kirtans (processions with hymn singing) wind through city streets. Bhangra and Gidda performances fill village squares. Langar is served to all. Fairs (melas) with wrestling, music, and food stalls complete the celebration.',
                'is_featured'       => true,
                'is_active'         => true,
                'tips'              => [
                    ['tip_category' => 'What_to_Wear',  'tip_title' => 'Dress for Gurudwara and Fields', 'tip_body' => 'Wear bright Punjabi attire — phulkari dupattas, kurta-pyjama, or salwar kameez in saffron, yellow, and green. Cover your head with a cloth or dupatta before entering any Gurudwara. Remove shoes at the entrance and wash your feet at the designated tap.'],
                    ['tip_category' => 'What_to_Eat',   'tip_title' => 'Baisakhi Food Traditions', 'tip_body' => 'Langar at the Gurudwara offers dal, roti, kheer, and seasonal vegetables — always free for everyone. Outside, look for kadah prasad (semolina halwa offered as prasad), makki di roti with sarson da saag, and freshly pulled sugarcane juice. Amritsari kulcha with chole from street stalls is unmissable.'],
                    ['tip_category' => 'Best_Spots',    'tip_title' => 'Where to Experience Baisakhi', 'tip_body' => 'Anandpur Sahib in Rupnagar district is the holiest site — the Hola Mohalla celebrations here are spectacular. The Golden Temple in Amritsar holds the grandest Baisakhi prayers. Village fairs in the Malwa region of Punjab offer the most authentic rural celebration with bhangra competitions and wrestling bouts.'],
                    ['tip_category' => 'Photography',   'tip_title' => 'Capturing the Golden Harvest', 'tip_body' => 'The golden wheat fields of Punjab in April offer spectacular backdrops. Shoot at sunrise when the light is golden and farmers are already in the fields. Bhangra dancers in colourful attire make vivid subjects — ask permission before photographing at Gurudwara ceremonies, especially Amrit Sanchar.'],
                ],
                'rituals'           => [
                    ['ritual_name' => 'Ardas at Gurudwara', 'ritual_description' => 'The community gathers at the Gurudwara before sunrise for Asa di Var kirtan (morning hymns). The Ardas (Sikh prayer) is recited standing, with everyone\'s hands folded. The Granth Sahib (Sikh scripture) is opened at random and the Hukamnama (divine order of the day) is read aloud to the congregation. This spiritual beginning sets the tone for the entire celebration.', 'ritual_timing' => 'Before sunrise on Baisakhi morning'],
                    ['ritual_name' => 'Bhangra and Gidda', 'ritual_description' => 'After gurudwara prayers, village communities gather in open grounds and courtyards for bhangra (men\'s vigorous drum-accompanied folk dance) and gidda (women\'s graceful lyrical dance). Dhol players beat faster and faster as dancers spin, jump, and shout "Balle Balle!" The energy peaks around noon as harvested wheat sways behind them in the breeze.', 'ritual_timing' => 'Morning to afternoon'],
                    ['ritual_name' => 'Langar', 'ritual_description' => 'The institution of Langar — free community kitchen — is central to Baisakhi. On this day, every Gurudwara in Punjab serves langar continuously from morning to night. Thousands of volunteers (sewadars) chop vegetables, roll roti, and serve food to all who arrive regardless of caste, religion, or economic status. This act of selfless service (seva) is considered equal in merit to prayer.', 'ritual_timing' => 'All day at Gurudwaras'],
                ],
                'celebrating_states' => [
                    $pun => ['local_name' => 'Baisakhi', 'local_significance' => 'The founding of the Khalsa Panth at Anandpur Sahib makes this the most sacred Sikh festival in Punjab; massive Nagar Kirtans and Amrit Sanchar ceremonies are held'],
                    $raj => ['local_name' => 'Baisakhi', 'local_significance' => 'Hindu communities in Rajasthan celebrate the solar New Year with temple visits, fairs in Pushkar and Ajmer, and traditional sweets'],
                ],
            ],

            // ══════════════════════════════════════════════════════════════════
            // 6. ONAM
            // ══════════════════════════════════════════════════════════════════
            [
                'name'              => 'Onam',
                'tagline'           => 'Kerala Welcomes Its Beloved King Mahabali Home',
                'state_id'          => $ker,
                'is_national'       => false,
                'religion'          => 'Hindu',
                'month'             => 8,
                'start_day'         => null,
                'end_day'           => null,
                'duration_days'     => 10,
                'short_description' => 'Onam is Kerala\'s grandest festival — a 10-day harvest celebration welcoming the mythical King Mahabali with elaborate flower carpets (pookalam), a 26-dish vegetarian feast (Onam Sadya), and spectacular snake boat races.',
                'full_description'  => '<p>Onam is Kerala\'s most important festival, lasting ten days from the first day of Atham to the main day of Thiruvonam in the Malayalam month of Chingam (August–September). Its central myth tells of <strong>Mahabali</strong>, a just and beloved king of ancient Kerala whose reign was a golden age of equality, prosperity, and happiness. When the god Vamana (Vishnu\'s dwarf avatar) tricked Mahabali into giving up his kingdom and pushed him into the underworld, the gods granted Mahabali one wish — to visit his people once a year. Onam celebrates this annual homecoming.</p><p>The ten days are filled with rituals: <strong>Pookalam</strong> (flower carpet) designs grow more elaborate each day; on Thiruvonam, they can be eight feet in diameter with up to 16 layers of flowers. The <strong>Onam Sadya</strong> — served on a banana leaf — consists of 26 or more dishes including rice, sambar, avial, olan, pachadi, pradhaman (payasam), and pappadam, all arriving in a precise order.</p><p>The <strong>Vallam Kali</strong> (snake boat race) at Punnamada Lake in Alappuzha draws 100+ oarsmen per boat, rowing in perfect synchrony to the beat of Vanchipattu (boat songs). The race is one of the most photographed events in India.</p>',
                'significance'      => 'Onam is Kerala\'s harvest festival and its most unifying social occasion. It transcends religion — Christians, Muslims, and Hindus of all castes celebrate together in honour of Mahabali\'s egalitarian legacy. The festival embodies the Kerala ideal of a society without discrimination, where the king served his people rather than the reverse.',
                'how_celebrated'    => 'Each of the ten days has a specific name and ritual. Households wake before sunrise to gather fresh flowers from gardens and arrange pookalam patterns. Women wear the traditional white-and-gold kasavu saree. The Onam Sadya is served on a banana leaf placed on the floor, eaten with the right hand. Tiger dance (pulikali), classical Kathakali performances, Kaikottikali (women\'s circular dance), and the roar of snake boat races fill the ten days with colour and energy.',
                'is_featured'       => true,
                'is_active'         => true,
                'tips'              => [
                    ['tip_category' => 'What_to_Eat',   'tip_title' => 'How to Eat the Onam Sadya', 'tip_body' => 'The Onam Sadya is served on a banana leaf with the tip pointing left. Dishes arrive in a set order: papad first, then the chips, pickles, and side dishes, followed by rice, sambar, and payasam. Eat with your right hand only. Pour sambar over the rice before mixing. The meal ends with a banana and buttermilk. Never fold the leaf upward at the end — that is done only at funerals.'],
                    ['tip_category' => 'Best_Spots',    'tip_title' => 'Best Places to Experience Onam', 'tip_body' => 'The Nehru Trophy Boat Race at Punnamada Lake in Alappuzha (Alleppey) is the most famous Onam event — book grandstand tickets months in advance. Thrissur\'s Athachamayam procession on the first day of Onam features elaborate cultural performances. Kerala Tourism organises cultural shows in Thiruvananthapuram, Kochi, and Thrissur throughout the ten days.'],
                    ['tip_category' => 'Photography',   'tip_title' => 'Photographing Onam', 'tip_body' => 'Pookalam competitions in residential colonies offer intimate, colourful shots — ask permission to enter homes for close-up flower carpet photography. The snake boat race requires a long telephoto lens (200mm+) or a seat on a coracle boat close to the water. Kathakali and Kaikottikali are best shot under natural morning light.'],
                    ['tip_category' => 'What_to_Wear',  'tip_title' => 'Dress Like a Keralite for Onam', 'tip_body' => 'The traditional Onam dress for women is the white kasavu saree (cream with gold border). Men wear the white mundu with a golden kasavu border. Avoid synthetic fabrics as Onam falls in the humid monsoon/post-monsoon period. Comfortable cotton is best. Gold jewellery (temple jewellery) is traditionally worn with the kasavu saree.'],
                ],
                'rituals'           => [
                    ['ritual_name' => 'Pookalam', 'ritual_description' => 'Every morning of Onam, the women of the household rise early to create a pookalam — a circular flower carpet — in the front courtyard. On Atham (day 1) it is a simple one-flower-type circle; by Thiruvonam (day 10) it is an intricate mandala of eight or more concentric rings using jasmine, marigold, chrysanthemum, wild fern, and kanakambaram. No glue or frame is used — only fresh flowers pressed flat.', 'ritual_timing' => 'Each morning of the 10 days, before sunrise'],
                    ['ritual_name' => 'Onam Sadya', 'ritual_description' => 'The grand Onam feast, served on Thiruvonam, is one of the world\'s largest vegetarian spreads. Banana leaves are laid on the floor or a low table. Servers bring 26–28 dishes in strict sequence from right to left. The sequence begins with banana chips and pickles; then comes rice, sambar, rasam, and four types of payasam. The meal is eaten in silence with the right hand, each dish mixed in proportion with rice.', 'ritual_timing' => 'Midday on Thiruvonam (the 10th day)'],
                    ['ritual_name' => 'Vallam Kali (Snake Boat Race)', 'ritual_description' => 'The serpentine snake boats (chundan vallams), each up to 40 metres long and carrying 100–150 oarsmen, compete on the backwaters in perfectly synchronised rows. The oarsmen chant Vanchipattu (boat songs) in rhythm with their oars. The boats, crowned with golden umbrellas at the stern, reach speeds of 25 km/h. The roar of the drums and the chants carry across the lake.', 'ritual_timing' => 'Second Saturday of Chingam at Punnamada Lake, Alappuzha'],
                ],
                'celebrating_states' => [
                    $ker => ['local_name' => 'Onam', 'local_significance' => 'Onam is Kerala\'s state festival — all schools, colleges, and government offices observe 10 days; the entire state participates regardless of religion'],
                ],
            ],

            // ══════════════════════════════════════════════════════════════════
            // 7. DURGA PUJA
            // ══════════════════════════════════════════════════════════════════
            [
                'name'              => 'Durga Puja',
                'tagline'           => 'Bengal Transforms into a Goddess\'s Grand Gallery',
                'state_id'          => $wb,
                'is_national'       => false,
                'religion'          => 'Hindu',
                'month'             => 10,
                'start_day'         => null,
                'end_day'           => null,
                'duration_days'     => 10,
                'short_description' => 'Durga Puja is West Bengal\'s greatest cultural festival — a 10-day spectacular of elaborate clay goddess idols, artistic pandal installations, street food, and immersion processions that transforms Kolkata into the world\'s largest open-air art exhibition.',
                'full_description'  => '<p>Durga Puja celebrates the victory of Goddess Durga over the buffalo demon Mahishasura — the triumph of feminine power (Shakti) over evil. In Bengal, the goddess is worshipped as a daughter returning to her maternal home for five days before departing for Mount Kailash with her husband Shiva.</p><p>The festival\'s scale is staggering. Kolkata alone hosts over 3,000 community pandals (temporary structures) — each a unique art installation designed by professional artists and craftspeople who begin work months in advance. Pandal themes range from replicas of world monuments to abstract social commentaries. UNESCO recognised the Durga Puja festival of Kolkata on its Intangible Cultural Heritage list in 2021.</p><p>The clay idols of Durga — depicted with ten arms, astride a lion, slaying Mahishasura — are crafted by artisans in the Kumartuli district of Kolkata. Each idol can stand 15–20 feet tall and takes months to complete using clay from the banks of the Hooghly River, bamboo frameworks, and natural dyes. The idols are elaborately dressed and bejewelled before being installed in pandals.</p>',
                'significance'      => 'Durga Puja is the supreme expression of Bengali identity, creativity, and community spirit. It is simultaneously a religious festival, a massive cultural event, a fashion spectacle, and an economic engine. For Bengalis everywhere — including large diaspora communities — the days of Durga Puja are defined by nostalgia, homecoming, and the bittersweet joy of the goddess\'s return and departure.',
                'how_celebrated'    => 'The formal five days begin with Shoshti (Day 6) and culminate in Vijayadashami (Day 10). Each day has specific rituals: Mahasaptami sees the awakening (Bodhon) of the goddess; Mahashtami brings the grand Sandhi Puja at the junction of the eighth and ninth lunar hours. Devotees do pandal-hopping all night in new clothes, eating street food (kathi rolls, jhal muri, ghugni). Married women play Sindur Khela on Dashami before bidding goodbye.',
                'is_featured'       => true,
                'is_active'         => true,
                'tips'              => [
                    ['tip_category' => 'Best_Spots',    'tip_title' => 'Pandal Hopping Strategy', 'tip_body' => 'The famous pandals to visit in Kolkata are Bagbazar, Kumartuli Park, Mohammad Ali Park, Sreebhumi, and College Square. These draw the longest queues — arrive before 8 AM or after midnight for shorter waits. Download the Durga Puja app for real-time crowd density at each pandal.'],
                    ['tip_category' => 'Photography',   'tip_title' => 'Photographing Durga Puja', 'tip_body' => 'Kumartuli (the artisan district) is best visited in September before the festival — photograph the half-finished idols and the clay-covered craftsmen. During the festival, Sandhi Puja (the transition between Ashtami and Navami) is the most dramatic ritual — a cacophony of dhak drums, conch shells, and ululation lasting exactly 48 minutes.'],
                    ['tip_category' => 'What_to_Wear',  'tip_title' => 'Bengali Fashion During Puja', 'tip_body' => 'Wear your finest traditional clothes — a new outfit for each major day is the norm in Bengal. Women typically wear handloom or Tant sarees, Dhakai jamdani, or Baluchari. Men wear dhoti-kurta on the puja days. Comfortable footwear matters as pandal hopping involves kilometres of walking on crowded streets.'],
                    ['tip_category' => 'What_to_Eat',   'tip_title' => 'Eating During Durga Puja', 'tip_body' => 'The essential Puja street foods are: kathi rolls (Kolkata\'s iconic egg roll), jhal muri (spiced puffed rice), ghugni (yellow pea curry), and phuchka (the Bengal version of pani puri filled with tamarind water). For sit-down meals, the para (neighbourhood) clubs often organise community meals. Finish with mishti doi (sweetened yoghurt) or rosogolla.'],
                ],
                'rituals'           => [
                    ['ritual_name' => 'Bodhon (Invocation)', 'ritual_description' => 'Durga Puja officially begins with Bodhon on Shoshti (the sixth lunar day). The priest awakens the goddess\'s life force by waving an oil lamp before the clay idol while chanting Sanskrit mantras from the Chandi (Devi Mahatmya scripture). The idol\'s eyes are ritually "opened" with a special painting ceremony. Family members shower the idol with flowers, and the dhak (large drum) is beaten for the first time.', 'ritual_timing' => 'Shoshti evening (Day 6)'],
                    ['ritual_name' => 'Ashtami Pushpanjali', 'ritual_description' => 'On Mahashtami morning, devotees dress in traditional clothes and gather at the pandal for the Pushpanjali — a flower offering ceremony. Holding flowers and bel leaves (bilva), they repeat Sanskrit shlokas after the priest in three separate offerings to the goddess. This is the most emotionally charged moment of the festival; women and men often weep as the priest recites the prayer for blessings on all.', 'ritual_timing' => 'Mahashtami morning, after sunrise'],
                    ['ritual_name' => 'Sindur Khela', 'ritual_description' => 'On Vijayadashami (the final day), married Hindu women smear each other\'s partings and faces with sindur (vermilion) as a blessing of longevity for their husbands and in farewell to Durga (who is also a wife). Women in white sarees with red borders crowd around the idol, laughing and weeping simultaneously. The scene — red sindur against white sarees and gold ornaments — is one of India\'s most iconic festival images.', 'ritual_timing' => 'Vijayadashami morning, before the idol is taken for immersion'],
                ],
                'celebrating_states' => [
                    $wb  => ['local_name' => 'Durga Puja', 'local_significance' => 'Kolkata is the global capital of Durga Puja; UNESCO recognised it as Intangible Cultural Heritage in 2021; over 3,000 pandals transform the city into a living gallery'],
                    $raj => ['local_name' => 'Navratri',   'local_significance' => 'Rajasthan observes Durga\'s nine forms during Navratri with Garba and Dandiya Raas as the main celebration mode'],
                ],
            ],

            // ══════════════════════════════════════════════════════════════════
            // 8. PONGAL
            // ══════════════════════════════════════════════════════════════════
            [
                'name'              => 'Pongal',
                'tagline'           => 'Tamil Nadu Thanks the Sun, Rain, and Cattle',
                'state_id'          => $tn,
                'is_national'       => false,
                'religion'          => 'Hindu',
                'month'             => 1,
                'start_day'         => 14,
                'end_day'           => 17,
                'duration_days'     => 4,
                'short_description' => 'Pongal is Tamil Nadu\'s four-day harvest festival — a joyous thanksgiving to the Sun, rain, cattle, and nature itself, celebrated by boiling the first rice harvest in milk with turmeric and jaggery until it overflows in auspicious abundance.',
                'full_description'  => '<p>Pongal — meaning "to boil over" or "to overflow" — is Tamil Nadu\'s most important festival, falling on January 14 or 15 at the start of the Tamil month of Thai. The festival is ancient, with references found in Sangam literature dating back 2000 years, making it one of the world\'s oldest continuously celebrated harvest festivals.</p><p>The four-day festival is a structured thanksgiving to the forces that sustain agriculture. <strong>Bhogi Pongal</strong> (Day 1): old and unused items are burned in bonfires, symbolising renewal. <strong>Thai Pongal</strong> (Day 2): the main day — a clay pot of newly harvested rice, milk, and jaggery is boiled in the open courtyard facing the sun until it overflows, with women crying "Pongalo Pongal!" as it does. <strong>Mattu Pongal</strong> (Day 3): cattle are honoured — their horns are painted, garlanded with flowers, and paraded; the sport of Jallikattu (bull-taming) is held in rural areas. <strong>Kaanum Pongal</strong> (Day 4): a day for family outings and picnics.</p>',
                'significance'      => 'Pongal expresses gratitude to the Sun (Surya), who provides energy for crops; to rain (Indra), without which farming is impossible; and to cattle, who plough the fields. It marks the end of the winter solstice (Dakshinayana) and the beginning of the sun\'s northward journey (Uttarayana), symbolising warmth, light, and renewal.',
                'how_celebrated'    => 'Homes are thoroughly cleaned and decorated with kolam patterns drawn with rice flour at the threshold. Women wear pavadai or Kanjeevaram sarees. The pongal dish is cooked outdoors in a new clay pot with turmeric leaves tied around it. Sugarcane stalks are placed as a decoration in every home. Jallikattu — bull-taming — is the signature Mattu Pongal event, attracting tens of thousands in Alanganallur and Palamedu.',
                'is_featured'       => false,
                'is_active'         => true,
                'tips'              => [
                    ['tip_category' => 'What_to_Eat',   'tip_title' => 'Pongal Foods to Try', 'tip_body' => 'The festival dish "sweet pongal" (chakkarai pongal) is made with raw rice, jaggery, cardamom, cashews, and raisins cooked in milk — eat it warm as prasad. Savoury ven pongal (pepper-cumin rice with lentils and ghee) is the everyday version eaten for breakfast throughout Tamil Nadu. Also try murukku, adhirasam, and vella pongal.'],
                    ['tip_category' => 'Best_Spots',    'tip_title' => 'Where to Experience Pongal', 'tip_body' => 'The Jallikattu event in Alanganallur village near Madurai is the most famous — book tickets weeks ahead as tens of thousands attend. Thanjavur\'s villages offer the most traditional Mattu Pongal celebrations with decorated bull processions. Chennai\'s Marina Beach hosts the Kaanum Pongal family gathering that draws hundreds of thousands.'],
                    ['tip_category' => 'Etiquette',     'tip_title' => 'Pongal Cultural Etiquette', 'tip_body' => 'When visiting a home on Thai Pongal, arrive in the morning and bring sugarcane sticks as a gift — it\'s the traditional offering. Accept pongal when offered (refusing is considered inauspicious). Kolam designs at thresholds are sacred — do not step on them. If invited to a cattle procession, admire the animals from a respectful distance as they can be agitated.'],
                    ['tip_category' => 'Photography',   'tip_title' => 'Photographing Pongal', 'tip_body' => 'The boiling-over moment of the pongal pot (Thai Pongal morning, around 7–9 AM) is the iconic shot. Set up your tripod early and use a fast shutter speed to capture the milk overflowing. Kolam patterns in front of homes make beautiful detail shots with early morning light. Jallikattu requires a telephoto lens and positioned viewing — the dust and speed demand fast apertures (f/2.8 or wider).'],
                ],
                'rituals'           => [
                    ['ritual_name' => 'Boiling the Pongal', 'ritual_description' => 'In the open courtyard on Thai Pongal morning, a new clay pot is filled with raw rice and fresh milk and placed on a temporary stove facing the rising sun. Turmeric leaves are tied around the pot. The fire is lit with dry wood. As the milk begins to boil and rise, the women of the household cry "Pongalo Pongal!" three times — the overflow is considered the blessing of abundance for the coming year. Jaggery, cardamom, raisins, and cashews are added after.', 'ritual_timing' => 'Thai Pongal morning, facing the rising sun'],
                    ['ritual_name' => 'Kolam Drawing', 'ritual_description' => 'From Bhogi day onwards, the women of the house rise before sunrise to scrub the front threshold and draw intricate kolam patterns in white rice flour. Pongal kolams are larger and more elaborate than daily ones — some extend 10–15 feet and incorporate geometric patterns of dots connected by flowing curves. During Pongal season, kolam competitions are held in streets and temple courtyards.', 'ritual_timing' => 'Each morning before sunrise, across all 4 days'],
                    ['ritual_name' => 'Mattu Pongal (Cattle Worship)', 'ritual_description' => 'On the third day, cattle who ploughed the fields are bathed, their horns painted in red and green, garlanded with flowers and fresh sugarcane, and adorned with tinkling bells. They are offered pongal rice as prasad and led through villages in festive procession. In villages of Madurai and Tiruchirappalli, the ancient sport of Jallikattu — where young men must subdue a running bull by clinging to its hump — is held at sundown.', 'ritual_timing' => 'Mattu Pongal (Day 3), morning procession; Jallikattu at afternoon'],
                ],
                'celebrating_states' => [
                    $tn  => ['local_name' => 'Thai Pongal', 'local_significance' => 'Pongal is Tamil Nadu\'s state harvest festival; it is a public holiday; Jallikattu in Madurai and Thanjavur attracts international media attention'],
                    $ker => ['local_name' => 'Makara Vilakku', 'local_significance' => 'Kerala celebrates Makar Sankranti (the same astronomical event as Pongal) with the lighting of the sacred Makara Jyoti star at the Sabarimala temple'],
                ],
            ],

            // ══════════════════════════════════════════════════════════════════
            // 9. PUSHKAR CAMEL FAIR
            // ══════════════════════════════════════════════════════════════════
            [
                'name'              => 'Pushkar Camel Fair',
                'tagline'           => 'The World\'s Largest Camel Fair Under Rajasthan\'s Stars',
                'state_id'          => $raj,
                'is_national'       => false,
                'religion'          => 'Secular',
                'month'             => 11,
                'start_day'         => null,
                'end_day'           => null,
                'duration_days'     => 5,
                'short_description' => 'The Pushkar Camel Fair is Rajasthan\'s legendary five-day spectacle — the world\'s largest gathering of camels and livestock, combined with cultural performances, pilgrimages to the sacred Pushkar Lake, and a riot of colour in the Thar Desert.',
                'full_description'  => '<p>The Pushkar Camel Fair (Pushkar Mela) is held every year in the Kartik month (October–November) on the banks of the sacred Pushkar Lake in Ajmer district. What began as a livestock trading fair — primarily for camels, the "ships of the desert" — has evolved into one of Rajasthan\'s most spectacular cultural events and a major draw for travellers from around the world.</p><p>At its peak, over 50,000 camels, horses, and cattle gather on the sandy grounds outside Pushkar town. Traders come from across Rajasthan, Gujarat, Haryana, and even Afghanistan to buy and sell. Camels are groomed with intricate shaved patterns on their flanks, dressed in embroidered blankets and silver jewellery, and paraded for judging competitions.</p><p>The fair coincides with Kartik Purnima — the full moon of Kartik, when Pushkar Lake is considered most sacred. Hundreds of thousands of pilgrims take a holy dip in the lake\'s 52 ghats, believing it cleanses them of all sins. The combination of the trading fair, the pilgrimage, and an organised cultural programme makes Pushkar a unique convergence of commerce, faith, and festivity.</p>',
                'significance'      => 'Pushkar is one of the five sacred dhams (pilgrimage sites) of Hinduism, home to the only Brahma temple in the world. The Kartik Purnima bath in the Pushkar Lake is believed to grant moksha (liberation). The fair is also of cultural significance as it preserves the camel trading traditions, folk music, and artisan crafts of the Thar Desert communities.',
                'how_celebrated'    => 'Days begin with pilgrims bathing at the ghats at sunrise. The camel grounds fill with traders, competing camels, and spectators. Events include camel races, longest moustache competitions, turban-tying contests, and bridal competition for "Pushkar Queen". Evenings see folk performances — Kalbeliya snake dancers, Bhopa puppeteers, and Manganiyar musicians performing under floodlit skies. Craftspeople from across Rajasthan sell textiles, jewellery, and leatherwork.',
                'is_featured'       => true,
                'is_active'         => true,
                'tips'              => [
                    ['tip_category' => 'What_to_Carry', 'tip_title' => 'What to Pack for Pushkar', 'tip_body' => 'Carry a large scarf or dupatta — it doubles as sun protection by day and warmth at night (desert temperatures drop to 10°C after dark in November). Comfortable walking shoes are essential as the fair grounds are vast sandy terrain. Bring a UV-protection face mask or bandana for the dust, a reusable water bottle (there are filling stations), and small denomination notes for purchases.'],
                    ['tip_category' => 'Photography',   'tip_title' => 'Golden Hour at the Camel Grounds', 'tip_body' => 'Sunrise and sunset at the Pushkar camel grounds are magical — dust particles in the air turn the light amber and the decorated camels are silhouetted against an orange sky. Use a telephoto lens to isolate camels with their riders. The Kartik Purnima lake bathing (the final night) is best photographed from the upper ghats with a wide-angle lens.'],
                    ['tip_category' => 'What_to_Wear',  'tip_title' => 'Dress for the Desert Fair', 'tip_body' => 'Wear light cotton during the day — temperatures reach 30°C in November sunlight. After sunset, layer up with a jacket or pashmina as it turns cold quickly. Avoid white clothing at the camel grounds (dust). Women should cover shoulders and knees near the temple and lake ghats. Dusty sandals are fine for the fair grounds; close-toed shoes for the lake area.'],
                    ['tip_category' => 'Transport',     'tip_title' => 'Getting to Pushkar', 'tip_body' => 'The nearest railway station is Ajmer (11 km), well connected to Jaipur, Delhi, and Mumbai. From Ajmer, take a shared auto or taxi through the Nag Pahar mountain pass. During the fair, the Rajasthan Tourism special train runs from Jaipur directly to Ajmer. Book accommodation in Pushkar 3–4 months ahead as everything within 20 km fills up during the fair week.'],
                ],
                'rituals'           => [
                    ['ritual_name' => 'Camel Trading', 'ritual_description' => 'The fair\'s commercial heart is the camel trading ground, where thousands of animals are led in and displayed over three days before the religious Kartik Purnima. Traders from across the region bargain loudly, slap hands, and inspect teeth, feet, and gait to determine prices. Camels are decorated with embroidered saddles, painted horns, tinkling bells, and flower garlands. A prize camel can fetch up to ₹5 lakh.', 'ritual_timing' => 'Days 1–3 of the fair, morning to sunset'],
                    ['ritual_name' => 'Kartik Purnima Dip', 'ritual_description' => 'On the full moon night of Kartik, pilgrims descend on Pushkar\'s 52 sacred ghats for a holy dip in the lake. Priests on elevated platforms chant mantras as incense smoke rises over the moonlit water. Thousands of diyas are released on the lake surface. The belief is that a dip on this night washes away the sins of a lifetime, making it one of the most sought-after ritual baths in Hinduism.', 'ritual_timing' => 'Kartik Purnima night (Day 5 of the fair)'],
                    ['ritual_name' => 'Kalbeliya Performance', 'ritual_description' => 'The Kalbeliya tribe — traditionally snake charmers — perform their mesmerising dance form each evening on the cultural stage. Women in flowing black skirts embroidered with silver thread spin at extraordinary speed, mimicking the movement of cobras, while men play the pungi (snake charmer\'s flute) and dholak. The UNESCO-recognised dance form is at its most authentic in Pushkar, performed by the communities who created it.', 'ritual_timing' => 'Every evening at the cultural stage, from 7 PM'],
                ],
                'celebrating_states' => [
                    $raj => ['local_name' => 'Pushkar Mela', 'local_significance' => 'Pushkar is one of the five sacred pilgrimage sites of Hinduism; the only Brahma temple in the world stands here; the fair is Rajasthan\'s most internationally recognized cultural event'],
                ],
            ],

            // ══════════════════════════════════════════════════════════════════
            // 10. NAVRATRI
            // ══════════════════════════════════════════════════════════════════
            [
                'name'              => 'Navratri',
                'tagline'           => 'Nine Nights of the Goddess, Garba, and Devotion',
                'state_id'          => null,
                'is_national'       => true,
                'religion'          => 'Hindu',
                'month'             => 10,
                'start_day'         => null,
                'end_day'           => null,
                'duration_days'     => 9,
                'short_description' => 'Navratri is India\'s nine-night festival honouring the nine forms of Goddess Durga — celebrated with Garba and Dandiya Raas dances in Gujarat and Rajasthan, fasting, Kanya Puja, and culminating in Vijayadashami (Dussehra).',
                'full_description'  => '<p>Navratri — meaning "nine nights" in Sanskrit — is observed four times a year in the Hindu calendar, but the Sharad Navratri (autumn Navratri) falling in September–October is the most widely celebrated. The nine nights are dedicated to the nine manifestations of Goddess Durga (collectively called Nav Durga): Shailaputri, Brahmacharini, Chandraghanta, Kushmanda, Skandamata, Katyayani, Kalaratri, Mahagauri, and Siddhidatri.</p><p>The festival\'s character varies dramatically by region. In <strong>Gujarat and Rajasthan</strong>, Navratri is synonymous with <strong>Garba</strong> — circular folk dances performed around a lit lamp or image of the goddess, accompanied by clapping and high-energy devotional songs. In later nights, <strong>Dandiya Raas</strong> (the stick dance) takes over, with paired dancers clicking painted wooden sticks in rhythmic patterns. The most elaborate Garba events in Ahmedabad draw 50,000+ participants nightly.</p><p>In <strong>West Bengal</strong>, Navratri overlaps with Durga Puja, where the goddess is worshipped in her most fierce, warrior form. In South India, the festival features <strong>Golu</strong> — a tiered display of dolls depicting deities, mythological scenes, and village life arranged on steps in the home.</p>',
                'significance'      => 'Navratri commemorates the cosmic battle between Goddess Durga and the demon Mahishasura, representing the eternal struggle between good and evil. Each of the nine nights is also associated with one form of the divine feminine energy (Shakti), allowing devotees to contemplate different aspects of spiritual power — from nurturing motherhood to fierce warrior energy.',
                'how_celebrated'    => 'Devotees fast during the nine days, eating only fruits, nuts, and specific grains (sabudana, singhara flour). Women perform Garba in nine different colours of clothing (each day has a designated colour). Temples stay open all night with continuous kirtan. On the eighth day (Ashtami), Kanya Puja is performed — nine young girls (representing the nine forms of Durga) are worshipped, their feet washed, and they are served a meal and given gifts. The festival ends with Vijayadashami/Dussehra on the tenth day.',
                'is_featured'       => true,
                'is_active'         => true,
                'tips'              => [
                    ['tip_category' => 'What_to_Wear',  'tip_title' => 'Navratri Colour Calendar', 'tip_body' => 'Each of the nine nights has a traditional colour. A common sequence: Day 1: Royal Blue, Day 2: Yellow, Day 3: Green, Day 4: Grey, Day 5: Orange, Day 6: White, Day 7: Red, Day 8: Sky Blue, Day 9: Pink. In Gujarat, elaborate chaniya choli (lehenga) in that day\'s colour is worn for Garba. Plan your wardrobe before the festival begins.'],
                    ['tip_category' => 'Best_Spots',    'tip_title' => 'Best Navratri Garba Venues', 'tip_body' => 'Vadodara\'s open Garba at Sardar Baug is the most authentic massive event. Mysore\'s Dasara is the grandest Vijayadashami celebration — the royal palace is illuminated with 100,000 bulbs. In Rajasthan, Vaishno Devi temple at Katra gets 500,000+ pilgrims during Navratri. Kolkata\'s Durga Puja pandals are at their most vibrant during this period.'],
                    ['tip_category' => 'Photography',   'tip_title' => 'Photographing Garba', 'tip_body' => 'Garba photography requires a high ISO (3200–6400) and a fast lens (f/1.8 or f/2.8) to freeze motion in low-light evening settings. The colourful lehengas spinning create natural motion blur trails at slower shutter speeds — try 1/30s for creative blur or 1/500s to freeze the dancers. Position yourself at the Garba circle\'s edge for dynamic angles.'],
                    ['tip_category' => 'Etiquette',     'tip_title' => 'Navratri Garba Etiquette', 'tip_body' => 'Many Garba events are strictly vegetarian and no-alcohol venues — respect this. Wear traditional Indian attire — Western clothing is considered disrespectful at religious Garba venues. Remove footwear before entering the Garba circle. Learning even the basic three-step Garba clap sequence before attending makes participation much more enjoyable.'],
                ],
                'rituals'           => [
                    ['ritual_name' => 'Garba', 'ritual_description' => 'Each evening of Navratri, communities gather in open grounds around a central mandap holding a lit lamp (garbo) or image of Durga. Dancers — traditionally women only, though mixed participation is now common — move in concentric circles performing the three-clap garba step to devotional songs. The pace accelerates through the night; by midnight, seasoned dancers spin with extraordinary precision. The Garba represents circumambulation of the Divine Mother.', 'ritual_timing' => 'Each evening from Day 1 to Day 9, 9 PM to 2 AM'],
                    ['ritual_name' => 'Kanya Puja', 'ritual_description' => 'On the eighth or ninth day (Ashtami/Navami), nine young girls below puberty (representing the nine forms of Durga) are invited to each home. Their feet are washed by the householder, who then kneels before them. The girls are served a ritual meal of halwa, poori, and chana. Each girl is given a gift (clothing, utensils, or money) and a tilak is applied on her forehead. The act represents the worship of the living goddess.', 'ritual_timing' => 'Ashtami or Navami morning'],
                    ['ritual_name' => 'Fasting and Prayer', 'ritual_description' => 'Devotees who observe Navratri vrat abstain from grains, meat, onion, and garlic for all nine days. Special fasting foods — sabudana khichdi, kuttu ki puri, singhara atta halwa, fruits, and sendha namak (rock salt) — are consumed. Evening prayers (aarti) are performed at home altars before the image of Durga, with incense, flowers, and sweets offered each day to a different form of the goddess.', 'ritual_timing' => 'Each morning and evening across all 9 days'],
                ],
                'celebrating_states' => [
                    $raj => ['local_name' => 'Navratri', 'local_significance' => 'Rajasthan\'s Navratri features spectacular Garba and Dandiya Raas events in Jaipur, Jodhpur, and Udaipur; temples of Shakti like Rani Sati in Jhunjhunu receive massive pilgrimages'],
                    $ker => ['local_name' => 'Navratri Golu', 'local_significance' => 'Kerala celebrates Navratri with Golu (Kolu) — elaborate tiered displays of dolls set up in homes; the final three days coincide with the Saraswati Puja for students placing their books on the altar'],
                    $pun => ['local_name' => 'Navratri', 'local_significance' => 'The Vaishno Devi shrine in Katra receives its highest footfall during Navratri; millions of pilgrims trek 14 km to the cave shrine'],
                    $tn  => ['local_name' => 'Navratri Golu', 'local_significance' => 'Tamil Navratri centres on Kolu — the nine-tiered doll display; families visit each other\'s Kolu displays and exchange betel leaves, coconut, and sundal (legume salads)'],
                    $wb  => ['local_name' => 'Durga Puja', 'local_significance' => 'In Bengal, Navratri and Durga Puja are synonymous; the entire state observes the nine nights with nonstop pandal-hopping and prayers'],
                ],
            ],

            // ══════════════════════════════════════════════════════════════════
            // 11. GANESH CHATURTHI
            // ══════════════════════════════════════════════════════════════════
            [
                'name'              => 'Ganesh Chaturthi',
                'tagline'           => 'Mumbai Celebrates the Elephant God with Unstoppable Joy',
                'state_id'          => null,
                'is_national'       => true,
                'religion'          => 'Hindu',
                'month'             => 9,
                'start_day'         => null,
                'end_day'           => null,
                'duration_days'     => 11,
                'short_description' => 'Ganesh Chaturthi is an 11-day festival honouring Lord Ganesha — the elephant-headed remover of obstacles — celebrated most exuberantly in Maharashtra with gigantic idol installations, daily aarti, and a thunderous immersion procession.',
                'full_description'  => '<p>Ganesh Chaturthi falls on the fourth day (Chaturthi) of the bright fortnight of Bhadrapada (August–September). It celebrates the birthday of Lord Ganesha, the son of Shiva and Parvati, who is revered as the god of new beginnings, wisdom, and the remover of obstacles.</p><p>The modern form of the public festival was popularised by Lokmanya Bal Gangadhar Tilak in 1893 as a means of uniting people across caste lines during the independence movement. He transformed a domestic puja into a public community event, and the tradition has grown into one of India\'s largest urban festivals.</p><p>In Mumbai, the festival peaks at <strong>Lalbaugcha Raja</strong>, an idol worshipped by over 1.5 million devotees per day. The pandals compete for the largest and most artistically designed idol — some stand 30–40 feet tall. Neighbourhood committees spend months fundraising and constructing elaborate themed mandaps.</p><p>On <strong>Anant Chaturdashi</strong> (the 11th day), the idol is carried in a procession to the nearest water body for immersion (Visarjan), accompanied by dhol-tasha drums, DJs, and millions of revellers chanting "Ganpati Bappa Morya!"</p>',
                'significance'      => 'Ganesha is the first deity invoked in any Hindu ritual — he removes obstacles and ensures auspicious beginnings. Ganesh Chaturthi marks his birthday and his return to his heavenly abode after 11 days of residence among his devotees. The festival also carries a political history — Tilak used it as a platform for nationalist gatherings during British rule.',
                'how_celebrated'    => 'Ganesha idols are installed in homes and public pandals on the first day (Pranapratishtha). Daily aarti is performed twice a day with offerings of modak (sweet dumplings — Ganesha\'s favourite). Cultural programmes, sports events, and charity drives are organised by the pandal committee. On the 5th, 7th, or 11th day (depending on the family), the idol is carried to a river, lake, or sea for immersion amid dancing and chanting.',
                'is_featured'       => true,
                'is_active'         => true,
                'tips'              => [
                    ['tip_category' => 'What_to_Eat',   'tip_title' => 'Modak and Ganesh Chaturthi Sweets', 'tip_body' => 'Modak is the sacred food of Ganesha — a steamed or fried dumpling filled with coconut and jaggery. Try authentic ukadiche modak (steamed with rice flour shell) which is softer and more delicate than the fried version. Other Ganesh Chaturthi foods include karanji (sweet deep-fried pastry), puran poli, and coconut laddoo offered as naivedya.'],
                    ['tip_category' => 'Best_Spots',    'tip_title' => 'Best Ganesh Chaturthi Experiences', 'tip_body' => 'In Mumbai, the Lalbaugcha Raja queue can be 30+ hours long — instead visit Andhericha Raja or GSB Seva Mandal (which installs a gold-adorned idol). Pune\'s Shrimant Dagdusheth Halwai Ganapati and Kasba Ganpati are the oldest and most revered. Karnataka\'s Mysore celebrations are quieter but culturally rich.'],
                    ['tip_category' => 'Photography',   'tip_title' => 'Photographing the Visarjan', 'tip_body' => 'The Visarjan procession on Anant Chaturdashi is one of India\'s most intense photographic events. Position yourself on a bridge or elevated building overlooking the immersion point (Girgaon Chowpatty in Mumbai). Use a wide-angle lens for crowd shots and a telephoto for idol close-ups. The moment an idol is submerged amid chanting and splashing is the shot — set your shutter to 1/1000s.'],
                    ['tip_category' => 'Transport',     'tip_title' => 'Getting Around During Ganesh Chaturthi', 'tip_body' => 'Mumbai\'s roads are effectively closed for 2–3 hours during the Visarjan procession on Day 11. Metro and local trains are heavily crowded. Plan travel early morning or after midnight. All roads to the sea (Marine Drive, Juhu, Girgaon) are packed from 6 PM. If staying overnight for the immersion, book accommodation near the seafront months in advance.'],
                ],
                'rituals'           => [
                    ['ritual_name' => 'Pranapratishtha (Idol Installation)', 'ritual_description' => 'On the morning of Ganesh Chaturthi, a priest performs the Pranapratishtha ceremony — the installation of divine energy into the clay idol. Vedic mantras are chanted while the priest touches the idol\'s eyes, ears, nose, mouth, and heart, symbolically awakening its senses. An unbroken coconut is cracked, and flowers, kumkum, and sandalwood paste are applied. The idol is formally invited to reside for the festival\'s duration.', 'ritual_timing' => 'Morning of Ganesh Chaturthi (Day 1)'],
                    ['ritual_name' => 'Daily Aarti', 'ritual_description' => 'Twice daily — once at sunrise and once at sunset — the full aarti ritual is performed before the Ganesha idol. The "Sukhakarta Dukhaharta" aarti composed by Saint Samarth Ramdas in Marathi is sung by devotees in unison, with camphor and incense smoke filling the mandap. Modak, coconut, and seasonal fruits are offered as naivedya. The aarti deepens in intensity each day as devotion builds toward the Visarjan.', 'ritual_timing' => 'Morning and evening across all 11 days'],
                    ['ritual_name' => 'Visarjan (Immersion)', 'ritual_description' => 'On the chosen immersion day (1st, 5th, 7th, or 11th), the Ganesha idol is placed on a decorated palanquin and carried through the streets in a procession. Devotees dance, drum, and chant "Ganpati Bappa Morya, Pudchya Varshi Lavkar Ya!" (Come back soon next year!). At the water\'s edge, the idol is lowered into the water and offered flowers before being fully submerged — symbolising Ganesha\'s return to Mount Kailash.', 'ritual_timing' => 'Day 1, 5, 7, or 11 (Anant Chaturdashi)'],
                ],
                'celebrating_states' => [
                    $raj => ['local_name' => 'Ganesh Chaturthi', 'local_significance' => 'Celebrated in cities across Rajasthan; Jaipur\'s Moti Dungri Ganesh Temple sees massive gatherings; eco-friendly clay idols are increasingly popular'],
                    $ker => ['local_name' => 'Vinayaka Chaturthi', 'local_significance' => 'Celebrated with home puja and modest community events; Thrissur and Ernakulam have growing public celebrations'],
                    $pun => ['local_name' => 'Ganesh Chaturthi', 'local_significance' => 'Celebrated by Hindu communities across Punjab with home installations and local pandals'],
                    $tn  => ['local_name' => 'Vinayaka Chaturthi', 'local_significance' => 'A major festival in Tamil Nadu; kolam patterns of Ganesha drawn at every threshold; kozhukattai (Tamil version of modak) offered as naivedya'],
                    $wb  => ['local_name' => 'Ganesh Puja', 'local_significance' => 'Relatively modest compared to Maharashtra but celebrated in Hindu homes with clay idols and morning aarti'],
                ],
            ],

            // ══════════════════════════════════════════════════════════════════
            // 12. LOHRI
            // ══════════════════════════════════════════════════════════════════
            [
                'name'              => 'Lohri',
                'tagline'           => 'The Bonfire that Ends Punjab\'s Winter',
                'state_id'          => $pun,
                'is_national'       => false,
                'religion'          => 'Sikh',
                'month'             => 1,
                'start_day'         => 13,
                'end_day'           => 13,
                'duration_days'     => 1,
                'short_description' => 'Lohri is Punjab\'s beloved mid-winter bonfire festival — a joyous gathering around a blazing fire to sing folk songs about Dulla Bhatti, eat rewdi and popcorn, dance bhangra, and celebrate the end of the winter solstice.',
                'full_description'  => '<p>Lohri falls every year on January 13, the day before Makar Sankranti, marking the end of winter and the northward shift of the sun (Uttarayana). The festival is especially significant for newly married couples and newborn babies — their first Lohri is a major household celebration.</p><p>Central to Lohri is the legend of <strong>Dulla Bhatti</strong> — a Robin Hood-like figure from the reign of Emperor Akbar who robbed the rich to help the poor and rescued Hindu girls from being sold into slavery in Arabia. His folk ballad is sung around every Lohri bonfire, with verses about Sundri and Mundri, the girls he saved. Children go door-to-door singing the Dulla Bhatti song in exchange for sweets, rewdi, and money — a tradition similar to carolling.</p><p>The bonfire (the central element of Lohri) is constructed in the village square or neighbourhood lane. Families circle it with folded hands, tossing offerings of revdi (sesame seed candy), popcorn, peanuts, and til (sesame) into the flames while calling out "Aadar aa, adar aa, dalle di maar!" — invoking abundance. Bhangra and Gidda then break out spontaneously around the fire.</p>',
                'significance'      => 'Lohri marks the end of winter and the beginning of the sun\'s transition northward, signalling longer days and the coming spring sowing season for Punjab\'s agricultural communities. For Sikh families, the first Lohri of a newborn — especially a first son — is celebrated with the same grandeur as a wedding. The festival also keeps alive the memory of Dulla Bhatti, a symbol of resistance against injustice.',
                'how_celebrated'    => 'Children go door-to-door during the day singing the Lulla Bhatti folk song. In the evening, a large bonfire is built and lit. Families circle it clockwise, tossing revdi, til, peanuts, and popcorn into the fire while singing Lohri songs. Men perform bhangra and women perform gidda around the fire. A feast of sarson da saag, makki di roti, gajar ka halwa, and khichdi follows. Newborns and brides celebrate their first Lohri with special gifts.',
                'is_featured'       => false,
                'is_active'         => true,
                'tips'              => [
                    ['tip_category' => 'What_to_Wear',  'tip_title' => 'Dress for a Winter Bonfire', 'tip_body' => 'Lohri night is cold in Punjab (5–10°C). Layer up with a warm shawl or jacket over your Punjabi suit or kurta. Women wear bright phulkari (embroidered) shawls. Men wear colourful turbans. Avoid synthetic fabrics near the bonfire — cotton and wool are safer. Wear closed shoes as the ground around the bonfire can be uneven.'],
                    ['tip_category' => 'What_to_Eat',   'tip_title' => 'Lohri Foods to Taste', 'tip_body' => 'Rewdi (crunchy sesame seed and jaggery discs) is the quintessential Lohri sweet. Til laddoo (sesame and jaggery balls) are pressed into rounds and exchanged. Gajak (sesame brittle) is another essential. For the main meal: sarson da saag with makki di roti and dollops of white butter, followed by gajar halwa. Hot milky chai with ginger is drunk throughout the cold evening.'],
                    ['tip_category' => 'Best_Spots',    'tip_title' => 'Where to Experience Lohri', 'tip_body' => 'The most vibrant Lohri celebrations happen in villages of the Malwa and Doaba regions of Punjab. Ludhiana and Jalandhar have grand community bonfire events. In Amritsar, the Bhangra Academy organises a professional Bhangra and Gidda performance near the Golden Temple complex on Lohri eve. Delhi\'s Punjabi colonies (Punjabi Bagh, Shalimar Bagh) have large public bonfire events.'],
                    ['tip_category' => 'Photography',   'tip_title' => 'Photographing Lohri', 'tip_body' => 'The bonfire is your main subject but it creates a challenging mix of dark surroundings and bright flame. Shoot in RAW, use f/4, ISO 1600, and bracket exposures. Backlit portraits of people circling the fire silhouetted against the flames are striking. Bhangra dancers jumping in front of the fire give high-energy freeze-frame shots at 1/800s shutter speed.'],
                ],
                'rituals'           => [
                    ['ritual_name' => 'Bonfire Lighting', 'ritual_description' => 'The community bonfire is built by piling wood, dried sugarcane, and cow dung cakes into a tall stack. The eldest member of the community or the father of a newborn lights the fire with a torch. As the flames rise, everyone encircles it clockwise with hands folded, symbolising reverence to the sacred fire (Agni). Offerings of rewdi, popcorn, peanuts, and sesame are tossed into the fire while invoking blessings for the coming year.', 'ritual_timing' => 'Evening, after sunset on January 13'],
                    ['ritual_name' => 'Dulla Bhatti Song', 'ritual_description' => 'Children go door-to-door from the afternoon onwards, singing the Lohri folk ballad about Dulla Bhatti. The song narrates Bhatti\'s rescue of Sundri and Mundri, with animated call-and-response sections. Householders reward the singers with rewdi, til, peanuts, and coins. If denied, the children sing a mock-curse verse ("Hor aana joota maar aana!") — traditionally a playful jab to shame stinginess.', 'ritual_timing' => 'Afternoon into evening on January 13'],
                    ['ritual_name' => 'Bhangra and Gidda', 'ritual_description' => 'After the bonfire ritual, the dhol (double-headed drum) players begin the beat and the celebrations shift to dance. Men break into exuberant bhangra — arms raised, shoulders pumping — while women form a circle for gidda, clapping rhythmically and calling out boliyan (folk couplets). The dancing continues for hours around the dying bonfire, warming the winter night with community energy.', 'ritual_timing' => 'After the bonfire ritual, 8 PM to midnight'],
                ],
                'celebrating_states' => [
                    $pun => ['local_name' => 'Lohri', 'local_significance' => 'Lohri is Punjab\'s most beloved mid-winter festival; the first Lohri of a newborn child or newly married bride is celebrated with grandeur equal to a wedding'],
                    $raj => ['local_name' => 'Lohri', 'local_significance' => 'Celebrated by Punjabi communities settled in Rajasthan\'s cities, particularly in Jaipur and Bikaner'],
                ],
            ],

            // ══════════════════════════════════════════════════════════════════
            // 13. THRISSUR POORAM
            // ══════════════════════════════════════════════════════════════════
            [
                'name'              => 'Thrissur Pooram',
                'tagline'           => 'The Mother of All Temple Festivals in Kerala',
                'state_id'          => $ker,
                'is_national'       => false,
                'religion'          => 'Hindu',
                'month'             => 4,
                'start_day'         => null,
                'end_day'           => null,
                'duration_days'     => 2,
                'short_description' => 'Thrissur Pooram is Kerala\'s most spectacular temple festival — a 36-hour extravaganza of decorated war elephants bearing jewelled parasols, thunderous percussion orchestras (chenda melam), and a massive fireworks display at the Vadakkunnathan temple.',
                'full_description'  => '<p>Thrissur Pooram is held every year during the Malayalam month of Medam (April–May) at the Vadakkunnathan temple in the heart of Thrissur city. Initiated by Sakthan Thampuran, the Raja of Cochin, in the 18th century, it was designed to be the grandest of all Kerala\'s pooram (temple festivals) — and it has never disappointed.</p><p>The festival pits two rival temple groups — the <strong>Thiruvambadi</strong> (representing Sree Krishna) and the <strong>Paramekavu</strong> (representing Bhagavathy) — in a friendly but intensely competitive display. Each side brings 15 decorated elephants into the Thekkinkad Maidan (central ground), adorned with <strong>nettipattam</strong> (golden caparison), tassels, and jewelled ornaments that together weigh hundreds of kilograms.</p><p>The <strong>Kudamattam</strong> is Thrissur Pooram\'s most mesmerising spectacle: the two elephant contingents face each other and simultaneously raise and swap different styles of coloured ceremonial parasols (kudas), each change accompanied by a roar of the crowd and a drumroll. Up to 33 rounds of parasol changes take place, each displaying increasingly elaborate combinations.</p>',
                'significance'      => 'Thrissur Pooram is both a religious event honouring the deity at Vadakkunnathan temple and a supreme expression of Kerala\'s temple art traditions — elephant pageantry, percussion ensembles (chenda melam and panchavadyam), and pyrotechnics. It is also an economic event: artisans, elephant mahouts, percussion musicians, and fireworks makers spend months preparing.',
                'how_celebrated'    => 'The festivities span two days and a night. The Ilanjithara Melam (dawn percussion) begins the morning before the main pooram. The main event sees the elephant procession enter the temple ground at noon with 30 elephants on each side, facing off in a display of colour and percussion. At dusk, the Kudamattam (parasol exchange) takes place. The night concludes with a two-hour fireworks display — arguably India\'s most spectacular traditional fireworks show, using hand-packed traditional pyrotechnics.',
                'is_featured'       => true,
                'is_active'         => true,
                'tips'              => [
                    ['tip_category' => 'Photography',   'tip_title' => 'Photographing Thrissur Pooram', 'tip_body' => 'The best photography vantage points sell out fast — book rooftop access on buildings overlooking the Thekkinkad Maidan at least a week ahead. A 70–200mm lens is ideal for elephant close-ups and parasol detail. The fireworks display starts around 3 AM and lasts 2 hours — use a tripod, 10–30 second exposures at f/8–11, ISO 100, and manually focus to infinity. The golden hour light on the caparisoned elephants is stunning.'],
                    ['tip_category' => 'What_to_Wear',  'tip_title' => 'What to Wear to Thrissur Pooram', 'tip_body' => 'The festival takes place in scorching April heat (35–38°C) — wear lightweight cotton in light colours. The mundu (dhoti) for men and Kerala saree for women is the traditional attire; locals judge you kindly for wearing it. Comfortable closed shoes matter as the ground gets packed with hundreds of thousands of people. Carry a folding umbrella for sun protection in the afternoon hours.'],
                    ['tip_category' => 'Best_Spots',    'tip_title' => 'Best Viewing Positions', 'tip_body' => 'The Swaraj Round (roundabout road) offers a full panoramic view of the elephant procession. Get there before 8 AM to secure a spot. For the fireworks, the open ground to the east of the temple gives the widest view. The percussion (Pandimelam and Panchavadyam) competitions happen on the Vadakkunnathan temple grounds the morning before the main pooram — these are free to enter and less crowded.'],
                    ['tip_category' => 'Transport',     'tip_title' => 'Getting to Thrissur Pooram', 'tip_body' => 'Thrissur railway station (5 km from temple) is well connected to Kochi, Trivandrum, and Calicut. On Pooram day, all roads within 3 km of the temple are closed to vehicles from 10 AM — arrive early or stay overnight nearby. KSRTC buses connect all Kerala districts. Shared autos run from the station. Book hotels in Thrissur 2–3 months ahead as the city fills completely during Pooram week.'],
                ],
                'rituals'           => [
                    ['ritual_name' => 'Elephant Procession', 'ritual_description' => 'Fifteen elephants from each of the two competing sides — Thiruvambadi and Paramekavu — enter the Thekkinkad Maidan with ceremonial precision. Each elephant bears a colourfully dressed mahout on its back holding a golden fan (venchamaravum) and a golden parasol. The animals are adorned with nettipattam (ornate golden face plates), ankle bells, embroidered velvet cloth, and fresh flower garlands. The procession is accompanied by chenda melam — a deafening 100-drum percussion ensemble.', 'ritual_timing' => 'Noon on Pooram day'],
                    ['ritual_name' => 'Kudamattam (Parasol Exchange)', 'ritual_description' => 'The two elephant lines face each other in the Thekkinkad Maidan. Each line\'s lead elephant holds a ceremonial parasol (kuda). At a signal from the percussion ensemble, both sides simultaneously raise a new parasol design — the crowd erupts each time. This exchange repeats up to 33 times, each round introducing more elaborate parasol colours and patterns. The visual spectacle, the drumming, and the crowd\'s collective gasp create an incomparable sensory experience.', 'ritual_timing' => 'Late afternoon, approximately 4–6 PM on Pooram day'],
                    ['ritual_name' => 'Vedikettu (Fireworks)', 'ritual_description' => 'Beginning at midnight and running until dawn, the two temple parties compete in a traditional fireworks display using hand-packed cylindrical rockets, colour bombs, and aerial shells. The fireworks are of a specific traditional Kerala style — known for their booming percussion rather than visual colour — and the sound can be heard 20 km away. The finale involves simultaneous launches from both parties that light the sky continuously for 15 minutes.', 'ritual_timing' => 'Midnight to 4 AM following the Pooram'],
                ],
                'celebrating_states' => [
                    $ker => ['local_name' => 'Thrissur Pooram', 'local_significance' => 'Called the "festival of festivals" in Kerala; Thrissur city receives 1 million+ visitors annually; it is listed as one of Asia\'s top cultural spectacles'],
                ],
            ],

            // ══════════════════════════════════════════════════════════════════
            // 14. DESERT FESTIVAL
            // ══════════════════════════════════════════════════════════════════
            [
                'name'              => 'Desert Festival',
                'tagline'           => 'Rajasthan\'s Living Culture Comes Alive on Golden Dunes',
                'state_id'          => $raj,
                'is_national'       => false,
                'religion'          => 'Secular',
                'month'             => 2,
                'start_day'         => null,
                'end_day'           => null,
                'duration_days'     => 3,
                'short_description' => 'The Jaisalmer Desert Festival is a three-day celebration of Rajasthan\'s folk arts against the backdrop of the Sam Sand Dunes — featuring turban-tying contests, longest moustache competitions, Kalbeliya dance, camel polo, and a sunset silhouette show.',
                'full_description'  => '<p>The Jaisalmer Desert Festival, organised by the Rajasthan Tourism Development Corporation, is held every year on the three days leading up to the full moon of Magh (February). Against the backdrop of the golden Sam Sand Dunes — just 42 km from Jaisalmer city — the festival showcases the folk arts, crafts, sports, and cultural traditions of the Thar Desert communities.</p><p>The festival takes place on two stages: the city stage at the Gandhi Chowk maidan in Jaisalmer, and the dune stage at Sam. Events alternate between the two. At the city stage, folk musicians perform <strong>Manganiyar and Langas</strong> music — hereditary Muslim musician castes of Rajasthan whose soulful compositions on the khartal, sarangi, and morchang represent one of India\'s most distinctive musical traditions.</p><p>At Sam, the <strong>camel parade</strong> features the most elaborately decorated camels in Rajasthan — groomed with shaved geometric patterns, embroidered saddles, tinkling bells, and silver ornaments. The <strong>turban-tying competition</strong> and <strong>longest moustache contest</strong> are crowd favourites; winners receive cash prizes and medals from the tourism minister. The festival ends with a sunset performance at Sam as the dunes glow amber and camel silhouettes punctuate the horizon.</p>',
                'significance'      => 'The Desert Festival preserves and celebrates the unique cultural heritage of the Thar Desert — its folk music, dance, craftsmanship, and equestrian traditions — which are at risk of being lost as younger generations move to cities. It also provides vital livelihood opportunities for artisan communities (Kalbeliya dancers, Manganiyar musicians, puppet makers) and supports Jaisalmer\'s tourism economy.',
                'how_celebrated'    => 'Three days of events include: camel races on open dunes, camel polo, turban-tying competitions, moustache and pagri (turban) fashion shows, folk music and dance performances on both stages, artisan markets with Rajasthani handicrafts and textiles, and cultural presentations by desert tribal communities. Each evening ends at Sam with a sunset cultural show followed by a bonfire dinner for tourists.',
                'is_featured'       => false,
                'is_active'         => true,
                'tips'              => [
                    ['tip_category' => 'What_to_Carry', 'tip_title' => 'Essential Packing for the Desert Festival', 'tip_body' => 'The Thar in February experiences cold mornings (7–12°C) and warm afternoons (25–28°C). Pack layers. A large cotton scarf is essential — it doubles as sun protection and a dusty-wind shield. Sunscreen SPF 50+, UV-protection sunglasses, and a hat are non-negotiable. Carry more cash than you think you\'ll need — ATMs in Jaisalmer are unreliable during the festival peak.'],
                    ['tip_category' => 'Photography',   'tip_title' => 'Capturing the Desert Festival', 'tip_body' => 'The golden hour at Sam Sand Dunes (6 PM in February) is extraordinary — arrive by 5 PM to hike a dune for the panoramic shot. Use a telephoto lens to isolate camel silhouettes against the sun. For Kalbeliya dancers, shoot in burst mode at 1/500s — the spinning skirts create circular motion blur at slower speeds. At night, long-exposure shots of the bonfire under the desert sky (Milky Way visible in February) are spectacular.'],
                    ['tip_category' => 'What_to_Wear',  'tip_title' => 'Dress for the Desert Aesthetic', 'tip_body' => 'Wearing Rajasthani traditional dress enhances the experience and photographs beautifully against the dunes. Women can hire Rajasthani lehenga-choli sets in Jaisalmer\'s Sadar Bazaar for ₹200–500/day. Men look great in a Rajasthani bandhgala jacket with churidar. A pagri (turban) is offered free to tie at the festival — participate in the competition for a fun experience.'],
                    ['tip_category' => 'Transport',     'tip_title' => 'Getting to Jaisalmer for the Festival', 'tip_body' => 'Jaisalmer is 6 hours by train from Jodhpur (Jaisalmer Express) and 12 hours from Jaipur. Book train tickets 2 months in advance — they sell out fast for the festival dates. Sam Sand Dunes are 42 km from Jaisalmer city; shared jeeps run from Hanuman Circle for ₹50–100, or rent a bike. The Desert Festival shuttle bus from the city maidan to Sam runs every 90 minutes during event days.'],
                ],
                'rituals'           => [
                    ['ritual_name' => 'Camel Race', 'ritual_description' => 'The camel race at Sam Sand Dunes is one of the festival\'s most anticipated events. Professional camel jockeys from the desert communities ride bareback or with minimal saddles over a 2-km marked course. Camels reach speeds of 65 km/h and the race lasts under 5 minutes — but the atmosphere of drum beats, shouting crowds, and clouds of golden dust transforms it into pure spectacle.', 'ritual_timing' => 'Morning of Day 2, at Sam Sand Dunes'],
                    ['ritual_name' => 'Turban-Tying Contest', 'ritual_description' => 'Rajasthani men demonstrate the ancient art of tying a pagri (turban) in the fastest time. Contestants are given a 9-metre length of fabric and must tie it correctly around their head — the traditional Rajasthani turban style varies by community, caste, and occasion, and knowers can identify a man\'s village by his pagri style. Winners are judged on speed, neatness, and style by a panel of elders.', 'ritual_timing' => 'Afternoon of Day 1 and Day 2 at Gandhi Chowk stage'],
                    ['ritual_name' => 'Manganiyar Music Night', 'ritual_description' => 'Each evening, the hereditary Manganiyar musician community of Rajasthan performs under the stars — a concert of folk compositions passed down through oral tradition for generations. Playing the khartal (wooden castanets), kamaycha (bowed stringed instrument), morchang (jaw harp), and dholak, the musicians sing in a wailing, ecstatic style that has influenced classical Rajasthani music for centuries. This is one of the few occasions where tourists can hear them in their element.', 'ritual_timing' => 'Evening of each day at Gandhi Chowk, 7–10 PM'],
                ],
                'celebrating_states' => [
                    $raj => ['local_name' => 'Jaisalmer Desert Festival', 'local_significance' => 'Held at the Sam Sand Dunes near Jaisalmer — a UNESCO-listed city; the festival is organised by Rajasthan Tourism and is a major international tourism event'],
                ],
            ],

            // ══════════════════════════════════════════════════════════════════
            // 15. MAKAR SANKRANTI
            // ══════════════════════════════════════════════════════════════════
            [
                'name'              => 'Makar Sankranti',
                'tagline'           => 'The Day India Looks Upward as Kites Fill the Sky',
                'state_id'          => null,
                'is_national'       => true,
                'religion'          => 'Hindu',
                'month'             => 1,
                'start_day'         => 14,
                'end_day'           => 14,
                'duration_days'     => 1,
                'short_description' => 'Makar Sankranti marks the sun\'s transition into Capricorn — India\'s only solar-calendar Hindu festival — celebrated with kite flying, sesame sweets, river dips, and regional traditions from Pongal in Tamil Nadu to Uttarayan in Gujarat.',
                'full_description'  => '<p>Makar Sankranti falls on January 14 every year (January 15 in leap years) — one of the few Hindu festivals that follows the solar calendar rather than the lunar one. It marks the moment when the Sun (Surya) transitions into the zodiac sign of Makar (Capricorn) and begins its northward journey (Uttarayana), bringing longer days and the promise of spring.</p><p>The festival is known by different names across India: <strong>Pongal</strong> in Tamil Nadu, <strong>Uttarayan</strong> in Gujarat, <strong>Magh Bihu</strong> in Assam, <strong>Poush Sankranti</strong> in West Bengal, and <strong>Makar Vilakku</strong> in Kerala. Despite regional variations, common threads unite the celebrations: sesame (til) in all its forms, jaggery, the holy Ganga (or any river), and gratitude to the Sun.</p><p>Gujarat\'s <strong>Uttarayan</strong> has made kite flying synonymous with Sankranti worldwide. On January 14, the skies above every city and village in Gujarat fill with tens of millions of kites — a display so spectacular that the International Kite Festival at Ahmedabad draws participants from over 40 countries.</p><p>At Prayagraj, the <strong>Magh Mela</strong> (precursor to the Kumbh Mela) begins on Makar Sankranti with millions taking a holy dip at the Sangam (confluence of Ganga, Yamuna, and the mythical Saraswati).</p>',
                'significance'      => 'Makar Sankranti marks the astronomical moment of the sun\'s northward turn — the end of the inauspicious Dakshinayana period and the beginning of the auspicious Uttarayana. It is believed that the soul of a person who dies during Uttarayana attains moksha (liberation) without returning to the cycle of rebirth. The Mahabharata\'s Bhishma Pitamah famously waited on his bed of arrows for the Uttarayana moment to leave his body.',
                'how_celebrated'    => 'Sesame seeds (til) and jaggery are the sacred foods — offered to the sun, made into laddoos, and exchanged between families with the saying "Til gul ghya, god god bola" (Accept sesame-jaggery, speak sweetly). Holy dips are taken in rivers at dawn. Kites are flown from rooftops all day in Rajasthan and Gujarat. In Punjab, Lohri bonfires on January 13 are considered the eve of Sankranti. New clothes are worn and charity (especially sesame, rice, and blankets) is given to the poor.',
                'is_featured'       => false,
                'is_active'         => true,
                'tips'              => [
                    ['tip_category' => 'Photography',   'tip_title' => 'Photographing Makar Sankranti Kites', 'tip_body' => 'The kite flying spectacle in Jaipur and Jodhpur on January 14 is one of India\'s most photogenic events. Shoot from a rooftop or elevated ground with a wide-angle lens for the "thousands of kites" shot. Use a telephoto for close-ups of kites in silhouette against the blue sky. The pre-sunset hour (4–5 PM) gives the best golden light on colourful kites. Avoid looking directly at the sun even through a viewfinder.'],
                    ['tip_category' => 'What_to_Eat',   'tip_title' => 'Sankranti Foods Across India', 'tip_body' => 'Til-gul laddoo (sesame-jaggery balls) are shared everywhere. In West Bengal, pithe (steamed rice cakes with coconut and jaggery) are made at home. In Tamil Nadu, Pongal (sweet and savoury rice preparations) are the centrepiece. In Kerala, chakkarai pongal and vella payasam are made. In Punjab, khichdi (rice and lentil porridge) is the traditional Sankranti food — mustard oil and sesame are donated to temples.'],
                    ['tip_category' => 'Best_Spots',    'tip_title' => 'Best Sankranti Destinations', 'tip_body' => 'Ahmedabad and Jaipur host the most spectacular kite festivals. Prayagraj\'s Magh Mela begins on Sankranti with millions bathing at Sangam — book accommodation in tent cities at the ghat months ahead. Ganga Sagar in West Bengal (where the Ganga meets the Bay of Bengal) sees one of India\'s largest Sankranti pilgrimage gatherings. Sabarimala in Kerala sees the Makara Jyoti (sacred light) phenomenon on this night.'],
                    ['tip_category' => 'What_to_Wear',  'tip_title' => 'Dress for Sankranti', 'tip_body' => 'Sankranti is a January morning festival — dress in warm layers. Traditional new clothes are worn (white in Tamil Nadu for women, colourful in Rajasthan and Gujarat). For the kite festival, avoid loose dupattas and stoles that can tangle in kite strings (manja). Wear full sleeves to protect arms from the cutting kite thread (glass-coated manja can cut skin deeply — be cautious around flying kites).'],
                ],
                'rituals'           => [
                    ['ritual_name' => 'Sunrise Dip and Sun Prayer', 'ritual_description' => 'Before sunrise on Sankranti, devout Hindus wake for a cold water bath (considered purifying on this day) and then perform Surya Namaskar (sun salutations) or Arghya (water offering) to the rising sun, pouring water in a copper vessel while chanting the Gayatri Mantra. At sacred rivers like the Ganga, Godavari, and Krishna, millions gather for a dip at the auspicious transitional moment (Sankraman Kaal).', 'ritual_timing' => 'Before and at sunrise on January 14'],
                    ['ritual_name' => 'Kite Flying', 'ritual_description' => 'From morning to sunset, rooftops across Rajasthan, Gujarat, and Madhya Pradesh fill with kite flyers of all ages. The art of kite fighting — cutting rival kite strings with glass-coated manja thread — is the competitive element. Expert players control their kites with subtle wrist movements, and a successful cut is celebrated with shouts of "Kai Po Che!" (I\'ve cut it!) in Gujarat. The sky turns multicoloured by noon and the fluttering continues until after dark.', 'ritual_timing' => 'All day on January 14'],
                    ['ritual_name' => 'Til-Gul Exchange', 'ritual_description' => 'Families prepare til-gul laddoos (sesame-jaggery balls) and sesame chikki (brittle) in the days before Sankranti. On the morning of the festival, visiting relatives and neighbours exchange these sweets with the Marathi saying "Til gul ghya, god god bola" — meaning "Accept sesame-jaggery and speak sweetly to each other." The ritual symbolises forgiveness of past grudges and renewal of relationships for the coming year.', 'ritual_timing' => 'Morning of January 14, during family visits'],
                ],
                'celebrating_states' => [
                    $raj => ['local_name' => 'Makar Sankranti', 'local_significance' => 'Jaipur and Jodhpur host spectacular kite festivals; Magh Mela at Pushkar lake draws pilgrims for ritual baths; sesame laddoos are exchanged between families'],
                    $ker => ['local_name' => 'Makara Vilakku', 'local_significance' => 'The sacred Makara Jyoti (a natural light visible at the Sabarimala peak) appears on Makar Sankranti night; millions of Ayyappa devotees gather for this annual darshan'],
                    $pun => ['local_name' => 'Makar Sankranti', 'local_significance' => 'Celebrated the morning after Lohri; families share khichdi and sesame sweets; river dips in the Beas and Ravi are traditional'],
                    $tn  => ['local_name' => 'Thai Pongal',    'local_significance' => 'The same solar event is celebrated as Pongal in Tamil Nadu — the four-day harvest festival with the boiling pongal rice ritual'],
                    $wb  => ['local_name' => 'Poush Sankranti', 'local_significance' => 'Pithe Parbona — the festival of rice-cake making — is held; families make 12 varieties of pithe (rice cakes with coconut and jaggery) and sesame narus; the day begins with a river dip'],
                ],
            ],

        ];
    }
}
