<?php

namespace Database\Seeders;

use App\Models\State;
use App\Models\StateCulture;
use App\Models\StateFood;
use App\Models\StateTradition;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->statesData() as $data) {
            $state = State::create([
                'name'             => $data['name'],
                'slug'             => Str::slug($data['name']),
                'capital'          => $data['capital'],
                'region'           => $data['region'],
                'language'         => $data['language'],
                'description'      => $data['description'],
                'established_date' => $data['established_date'],
                'population'       => $data['population'],
                'area_sq_km'       => $data['area_sq_km'],
                'is_active'        => true,
            ]);

            StateCulture::create(array_merge(['state_id' => $state->id], $data['culture']));

            foreach ($data['foods'] as $food) {
                StateFood::create(array_merge([
                    'state_id' => $state->id,
                    'slug'     => Str::slug($food['name']),
                ], $food));
            }

            foreach ($data['traditions'] as $tradition) {
                StateTradition::create(array_merge(['state_id' => $state->id], $tradition));
            }
        }

        $this->call(MonumentSeeder::class);
        $this->call(FestivalSeeder::class);
    }

    private function statesData(): array
    {
        return [

            // ─── RAJASTHAN ────────────────────────────────────────────────
            [
                'name'             => 'Rajasthan',
                'capital'          => 'Jaipur',
                'region'           => 'West',
                'language'         => 'Hindi, Rajasthani',
                'established_date' => '1956-11-01',
                'population'       => 81032689,
                'area_sq_km'       => 342239.00,
                'description'      => 'Rajasthan, the "Land of Kings", is India\'s largest state by area, famed for its magnificent forts, palaces, and the vast Thar Desert. Once a mosaic of princely states, it is a living tapestry of chivalry, vibrant folk culture, and centuries-old artisan traditions. The state blends desert landscapes with medieval splendour, drawing millions of visitors to Jaipur\'s Pink City, Jodhpur\'s Blue City, and the golden sands of Jaisalmer.',

                'culture' => [
                    'classical_dance'         => 'Ghoomar (a graceful women\'s circle dance performed at royal courts), Kalbelia (a serpentine dance of the Kalbelia tribe, UNESCO-listed), Chari, Bhavai, and Kathputli (traditional puppet dance-theatre)',
                    'music_forms'             => 'Manganiyar and Langa folk music traditions (hereditary Muslim musician communities), Mand (classical Rajasthani raga style), Maand, Panihari, and devotional Meera bhajans',
                    'traditional_dress_male'  => 'Dhoti or churidar with an embroidered angrakha (long coat), topped with a brightly coloured safa (turban) that indicates caste, clan, and region; mojari leather slippers',
                    'traditional_dress_female' => 'Ghagra-Choli (long flared skirt with fitted blouse) in vivid colours with mirror-work, paired with a flowing odhni (veil); heavy silver jewellery including borla (maang tikka), nath, and chandrahar',
                    'art_forms'               => 'Rajput miniature painting schools (Mewar, Marwar, Kishangarh, Bundi styles), Phad scroll painting depicting folk epics, Blue Pottery of Jaipur (Persian-influenced tin-glazed earthenware), and Pichwai devotional paintings on cloth',
                    'handicrafts'             => 'Sanganeri and Bagru hand block-printing, Bandhani tie-dye textiles, Meenakari (enamel jewellery), Kundan and Thewa jewellery, leatherwork mojari, lac bangles, and Jodhpur wrought-iron work',
                    'language_script'         => 'Devanagari (Hindi); Rajasthani dialects include Marwari, Mewari, Dhundari, and Harauti',
                    'notable_personalities'   => 'Maharana Pratap (warrior king of Mewar), Mirabai (mystic poet-saint), Sawai Jai Singh II (astronomer and founder of Jaipur), Prithviraj Chauhan (last Hindu emperor of Delhi), Raskhan (devotional poet)',
                ],

                'foods' => [
                    [
                        'name'         => 'Dal Baati Churma',
                        'description'  => 'The quintessential Rajasthani platter—hard whole-wheat dough balls (baati) baked in a cowdung or wood fire, dunked in ghee and served alongside a robust five-lentil dal and crumbled sweet churma. A dish born of the battlefield and desert survival, it is now the ceremonial heart of every Rajasthani celebration.',
                        'ingredients'  => 'Whole wheat flour, ghee, jaggery, Bengal gram dal, toor dal, moong dal, masoor dal, urad dal, asafoetida, cumin, dried red chilli, coriander, garam masala, semolina, sugar',
                        'is_vegetarian' => true,
                        'meal_type'    => 'Lunch',
                        'origin_story' => 'Dal Baati dates to the Bappa Rawal era (8th century) when Rajput soldiers on long campaigns needed a meal that could survive desert heat. Baatis were buried in hot sand to bake while soldiers fought; when they returned, ghee and dal completed the feast. Churma was added later as a royal dessert variation.',
                    ],
                    [
                        'name'         => 'Laal Maas',
                        'description'  => 'A fiercely spiced mutton curry coloured a vivid red by an abundance of dried Mathania chillies—Rajasthan\'s own variety—cooked with curd and whole spices. Originally a shikar (hunting) dish of the Rajput nobility, its heat is legendary and its depth of flavour unmatched in north-Indian non-vegetarian cooking.',
                        'ingredients'  => 'Mutton (bone-in), Mathania dried red chillies, curd, ghee, onion, garlic, ginger, coriander seeds, cloves, cardamom, bay leaf, black pepper, turmeric, salt',
                        'is_vegetarian' => false,
                        'meal_type'    => 'Dinner',
                        'origin_story' => 'Laal Maas emerged from the royal kitchens of Rajput kings who demanded bold flavours after long hunting expeditions. The Mathania chilli—cultivated near Jodhpur—was chosen for both its colour and its preservative qualities in the pre-refrigeration era. Royal cooks competed to perfect the recipe; the version from the Umaid Bhawan Palace is still considered the gold standard.',
                    ],
                    [
                        'name'         => 'Ghevar',
                        'description'  => 'A disc-shaped honeycomb-textured sweet made from a batter of refined flour poured into hot ghee, soaked in sugar syrup, and topped with thickened rabri (sweetened reduced milk), saffron, and pistachios. An intricate confection associated with the monsoon and the festivals of Teej and Raksha Bandhan.',
                        'ingredients'  => 'Refined flour (maida), ghee, milk, sugar, kewra water, saffron, cardamom, pistachios, almonds, rabri (reduced whole milk), sugar syrup',
                        'is_vegetarian' => true,
                        'meal_type'    => 'Dessert',
                        'origin_story' => 'Ghevar has been prepared in Rajasthan for over five centuries and is mentioned in texts from the Mughal period. The honeycomb lattice structure requires a skilled halwai (confectioner) who pours batter in a thin stream into a deep cylindrical vessel of smoking ghee—a technique passed down within families. Jaipur\'s Ghevar remains the most celebrated in India, particularly during the Shravan month.',
                    ],
                ],

                'traditions' => [
                    [
                        'name'            => 'Teej Festival',
                        'category'        => 'Festival',
                        'description'     => 'Teej is a monsoon festival celebrated by women across Rajasthan with decorated swings, vibrant processions, and the Teej Mata idol carried through the streets of Jaipur in a grand silver palki (palanquin). Women dress in green attire symbolising nature\'s renewal, observe fasts for their husbands\' long lives, apply mehndi, and sing traditional teej songs.',
                        'significance'    => 'Teej celebrates the reunion of Goddess Parvati with Lord Shiva after her long penance, symbolising marital devotion, the fertility of the monsoon earth, and the bond between women. The Jaipur Teej procession, inaugurated by the Jaipur royal family in the 18th century, is listed among India\'s most colourful heritage festivals.',
                        'region_specific' => 'Jaipur, Jodhpur, and across eastern Rajasthan',
                    ],
                    [
                        'name'            => 'Gangaur',
                        'category'        => 'Religious',
                        'description'     => 'Gangaur is an 18-day spring festival during which women in Rajasthan worship clay idols of Gauri (Parvati) and Isar (Shiva), keeping strict fasts, singing devotional geet (songs), and adorning the idols with jewels and fresh flowers. On the final day, the idols are ceremonially immersed in a water body amid a procession of women in their finest attire.',
                        'significance'    => 'Gangaur is the most important festival in a Rajasthani woman\'s calendar, marking the onset of spring and celebrating conjugal bliss. Unmarried girls pray for a husband as devoted as Shiva; married women pray for their husbands\' prosperity and longevity. The Jaipur Gangaur procession from the City Palace is a UNESCO-recognised intangible cultural heritage event.',
                        'region_specific' => 'State-wide; most elaborate in Jaipur, Udaipur, and Jodhpur',
                    ],
                ],
            ],

            // ─── KERALA ──────────────────────────────────────────────────
            [
                'name'             => 'Kerala',
                'capital'          => 'Thiruvananthapuram',
                'region'           => 'South',
                'language'         => 'Malayalam',
                'established_date' => '1956-11-01',
                'population'       => 35699443,
                'area_sq_km'       => 38852.00,
                'description'      => 'Kerala, "God\'s Own Country", is a narrow coastal state flanked by the Western Ghats and the Arabian Sea, renowned for its backwater lagoons, lush spice plantations, pristine beaches, and a literacy rate among the highest in India. A cradle of Ayurveda, classical arts, and maritime trade since antiquity, Kerala blends natural grandeur with a deeply syncretic culture shaped by Hindu, Muslim, and Christian communities.',

                'culture' => [
                    'classical_dance'         => 'Kathakali (elaborate dance-drama with painted faces and ornate costumes depicting Mahabharata and Ramayana stories), Mohiniyattam (the "dance of the enchantress", a graceful solo feminine form), Koodiyattam (UNESCO-listed Sanskrit theatre), and Theyyam (ritualistic trance dance of north Kerala)',
                    'music_forms'             => 'Sopana Sangeetam (devotional temple music sung on the sopanam—the steps to the sanctum), Carnatic classical tradition, Panchavadyam (ensemble of five percussion instruments), Thiruvathirakali songs, and Mappilappattu (Muslim folk songs)',
                    'traditional_dress_male'  => 'Mundu (white or off-white dhoti) with a gold-bordered kasavu, paired with a shirt or jubba; on formal occasions, the mundu is worn as a double cloth (mundum neriyathum)',
                    'traditional_dress_female' => 'Kasavu saree—a cream or off-white handloom cotton saree with a distinctive golden zari (kasavu) border; for festivals a set-mundu (two-piece) in cream and gold is worn with traditional jewellery including the palakka mala (jackfruit seed necklace)',
                    'art_forms'               => 'Kerala mural painting (large-scale temple frescoes in natural pigments), Aranmula Kannadi (unique metal alloy mirror, a craft of a single village), Theyyam face painting, Kolam (rice-flour floor art), and Ottanthullal satirical performance art',
                    'handicrafts'             => 'Coir and coconut-shell products, rosewood and teak carving, Kasavu handloom weaving, bell-metal crafts, Aranmula Kannadi mirrors, bamboo and reed mat weaving, and Navara rice products (medicinal Ayurvedic variety)',
                    'language_script'         => 'Malayalam script (derived from Grantha script; one of the four classical languages of India, with literary traditions dating to the 9th century)',
                    'notable_personalities'   => 'Adi Shankaracharya (8th-century philosopher and theologian), Sree Narayana Guru (social reformer), Vallathol Narayana Menon (poet, founder of Kerala Kalamandalam), M.T. Vasudevan Nair (novelist and screenwriter), E.M.S. Namboodiripad (statesman)',
                ],

                'foods' => [
                    [
                        'name'         => 'Kerala Sadya',
                        'description'  => 'Kerala Sadya is a grand vegetarian feast of 20 to 30 dishes served on a fresh banana leaf, eaten with bare hands while seated on the floor. Steamed rice anchors the leaf, surrounded by sambar, rasam, avial, thoran, olan, kaalan, pachadi, pickles, pappadam, and the indispensable payasam. Sadya is not merely a meal—it is the ritual centrepiece of Onam and weddings.',
                        'ingredients'  => 'Parboiled Kerala rice, coconut, drumstick (moringa), raw banana, yam, ash gourd, pumpkin, taro, green beans, curry leaves, mustard, dried red chilli, turmeric, jaggery, tamarind, yoghurt, ghee, pappadam',
                        'is_vegetarian' => true,
                        'meal_type'    => 'Lunch',
                        'origin_story' => 'The sadya tradition is believed to originate in the Sangam-period royal courts of Kerala, where victorious kings hosted grand feasts for subjects. The banana leaf was chosen for its antimicrobial properties and the belief that food tastes better on natural surfaces. The precise arrangement of dishes on the leaf follows a canonical order encoded in old Sanskrit texts on Kerala cuisine (paakashastra).',
                    ],
                    [
                        'name'         => 'Meen Moilee',
                        'description'  => 'A delicate, golden fish curry cooked in a coconut milk broth fragrant with turmeric, green chilli, and ginger—light enough to let the fresh fish shine. Unlike the robust red curries of the north, Meen Moilee is a testament to Kerala\'s coastal philosophy: minimal spice, maximum freshness. It is traditionally paired with appam (lacy rice-flour crepes).',
                        'ingredients'  => 'Pearl spot fish (karimeen) or kingfish, coconut milk, green chillies, ginger, garlic, turmeric, onion, tomato, curry leaves, mustard seeds, coconut oil, lemon juice, salt',
                        'is_vegetarian' => false,
                        'meal_type'    => 'Dinner',
                        'origin_story' => 'Meen Moilee is traced to the Syrian Christian community of central Kerala (Kottayam district), who integrated Portuguese cooking techniques—specifically the use of fresh coconut milk as a braising liquid—with indigenous spices after the 16th-century arrival of the Portuguese. The name "Moilee" is thought to derive from the Portuguese "molho" (sauce). It remains a cornerstone of the Syrian Christian wedding feast.',
                    ],
                    [
                        'name'         => 'Puttu and Kadala Curry',
                        'description'  => 'Puttu is a steamed cylinder of coarsely ground rice flour layered with grated coconut, presented as a crumbly yet moist breakfast cake. It is universally paired with Kadala Curry—a robust black chickpea stew slow-cooked with freshly ground coconut masala, coriander, and chillies. The contrast of gentle, slightly sweet puttu against the earthy, spiced curry is a defining Kerala morning.',
                        'ingredients'  => 'Coarsely ground rice flour, grated coconut, black chickpeas (kadala), onion, tomato, ginger, garlic, green chilli, coriander powder, garam masala, coconut oil, curry leaves, mustard seeds, salt',
                        'is_vegetarian' => true,
                        'meal_type'    => 'Breakfast',
                        'origin_story' => 'Puttu is referenced in early medieval Malayalam literature and in the travel accounts of Arab merchants who visited Kerala\'s Malabar coast. The cylindrical steaming vessel (puttukutti), traditionally made from bamboo and later brass, is a uniquely Kerala invention. Kadala curry became the standard accompaniment because black chickpeas were abundant and affordable across the paddy-farming heartland of Palakkad and Thrissur.',
                    ],
                ],

                'traditions' => [
                    [
                        'name'            => 'Onam',
                        'category'        => 'Harvest',
                        'description'     => 'Onam is Kerala\'s most beloved ten-day harvest festival (Thiruvonam in Chingam, August–September), celebrated by all Keralites regardless of religion. Homes are decorated with elaborate floral carpets (pookalam) made fresh each day from wildflowers. The Vallamkali (snake boat race) on the Pampa river draws massive crowds, while the Sadya feast, Kaikottikali dance, Pulikali (tiger dance), and Thumbi Thullal (women\'s dance) fill the days.',
                        'significance'    => 'Onam commemorates the annual homecoming of the mythical King Mahabali, a benevolent asura king whose golden reign is remembered as a paradise of equality and abundance. When Vishnu (as Vamana) exiled him to the netherworld, Mahabali was granted one wish—to visit his people once a year. Keralites celebrate his return with flowers, food, and joy, reaffirming the values of his utopian rule.',
                        'region_specific' => 'State-wide; Vallamkali (boat race) centred on Alappuzha and Kottayam districts',
                    ],
                    [
                        'name'            => 'Theyyam',
                        'category'        => 'Religious',
                        'description'     => 'Theyyam is a ritualistic performance art of northern Kerala (Malabar region) in which a performer—typically from a scheduled caste—embodies a deity through elaborate body paint, towering head-dresses (often 10–15 feet tall), and trance-like dance. Over 400 forms of Theyyam are performed across hundreds of village shrines (kavus) between November and May. The deity is believed to possess the performer and grant blessings to devotees.',
                        'significance'    => 'Theyyam is remarkable for its radical inversion of the social order: performers from lower castes become living gods who bless Brahmin devotees, reversing everyday hierarchy for the duration of the ritual. It is simultaneously the most democratic and most ancient of Kerala\'s art forms, preserving pre-Vedic tribal worship traditions. The Kerala government has initiated steps to get it UNESCO recognition.',
                        'region_specific' => 'Kannur and Kasaragod districts (north Kerala Malabar region)',
                    ],
                ],
            ],

            // ─── PUNJAB ──────────────────────────────────────────────────
            [
                'name'             => 'Punjab',
                'capital'          => 'Chandigarh',
                'region'           => 'North',
                'language'         => 'Punjabi',
                'established_date' => '1966-11-01',
                'population'       => 27743338,
                'area_sq_km'       => 50362.00,
                'description'      => 'Punjab, the "Land of Five Rivers", is the agricultural heartland of India—a fertile plain watered by the Sutlej, Beas, and Ravi rivers, famous for producing a third of India\'s wheat. The homeland of the Sikh faith and the site of the Partition\'s most profound human tragedy, Punjab channels its complex history into an irrepressibly joyful culture of bold food, thunderous bhangra music, and a spirit of relentless hospitality encapsulated in the phrase "Sat Sri Akal".',

                'culture' => [
                    'classical_dance'         => 'Bhangra (energetic harvest folk dance of men, accompanied by the dhol drum, originally celebrating the Baisakhi harvest), Giddha (women\'s circle dance with witty boli—verbal couplets), Sammi (dance of the Sandalbar region), and Jhumar (graceful, lyrical folk form)',
                    'music_forms'             => 'Patiala Gharana classical music (one of India\'s great Hindustani vocal traditions), Tappa (romantic folk-classical form developed in Punjab), Dhol-based bhangra music, Sufiana Kalam (Punjabi Sufi poetry and music), and contemporary Punjabi pop',
                    'traditional_dress_male'  => 'Kurta-pajama with a colourful phulkari-embroidered dupatta slung over the shoulder; for Bhangra, the traditional patiala salwar, kurta, and turban (dastar or pag) with kaintha necklace and jutti',
                    'traditional_dress_female' => 'Salwar-kameez with a heavily embroidered phulkari dupatta; for special occasions the ghagra-choli (Malwa region); bridal wear includes a red phulkari odhni and elaborate gold jewellery (chura bangle set, tikka, nath)',
                    'art_forms'               => 'Phulkari embroidery (literally "flower work"—dense geometric patterns in silk floss on coarse khaddar cloth, each region having distinctive motifs), Pinjra (geometric lattice woodwork), Punjabi folk painting, and mud-relief wall art of rural homes',
                    'handicrafts'             => 'Phulkari and Bagh embroidered textiles, hand-knotted Amritsar carpets (wool pile, Persian-influenced), Punjabi jutti (hand-stitched leather footwear with curled toe), Ludhiana\'s hosiery and woollen knitwear, inlay woodwork, and papier-mâché',
                    'language_script'         => 'Gurmukhi script (standardised by Guru Angad Dev Ji in the 16th century for Sikh scripture; also written in Shahmukhi/Perso-Arabic script in Pakistani Punjab)',
                    'notable_personalities'   => 'Guru Nanak Dev Ji (founder of Sikhism), Maharaja Ranjit Singh (founder of the Sikh Empire), Bhagat Singh (revolutionary freedom fighter), Amrita Pritam (pioneering Punjabi novelist), Milkha Singh (Olympic athlete, "The Flying Sikh")',
                ],

                'foods' => [
                    [
                        'name'         => 'Makki di Roti and Sarson da Saag',
                        'description'  => 'The soul of a Punjabi winter—thick, rustic flatbreads of maize flour (makki di roti) paired with a slow-cooked pot of mustard greens (sarson da saag) richly flavoured with ginger, garlic, and a generous knob of white butter or desi ghee. Simple, sustaining, and deeply seasonal, this combination is eaten from November to February when mustard fields turn Punjab\'s landscape gold.',
                        'ingredients'  => 'Maize flour (makki), whole wheat flour, mustard greens (sarson), spinach, bathua (chenopodium), ginger, garlic, green chilli, onion, desi ghee, white butter (makhan), salt, jaggery (optional)',
                        'is_vegetarian' => true,
                        'meal_type'    => 'Lunch',
                        'origin_story' => 'This combination has fed Punjab\'s farming communities for centuries. The practice of cooking mustard greens over low heat in an iron pot (karahi) for several hours—breaking down the rough greens into a smooth, velvety saag—was developed by Jat farming families of the Majha and Malwa regions. The maize flatbread provided the caloric density needed for a day\'s agricultural labour. Its cultural status was immortalised in the 1957 Bollywood film "Mother India" and in poet Shiv Kumar Batalvi\'s verse.',
                    ],
                    [
                        'name'         => 'Amritsari Kulcha',
                        'description'  => 'A thick, leavened bread baked in a tandoor until its crust is golden and slightly charred, stuffed with a spiced filling of mashed potato and paneer or pure potato, then slathered with butter. Served with chole (spiced chickpea curry) and sliced onion, it is the signature street breakfast of Amritsar—a city whose narrow lanes are dotted with century-old kulcha shops.',
                        'ingredients'  => 'Refined flour (maida), yoghurt, baking soda, potato, paneer, onion, green chilli, pomegranate seeds (anardana), coriander, cumin, butter, chickpeas, black tea (for chole colour), bay leaf, cardamom, cloves',
                        'is_vegetarian' => true,
                        'meal_type'    => 'Breakfast',
                        'origin_story' => 'Kulcha descended from Mughal tandoor bread traditions and was adapted in Amritsar, a city that was a crossroads of trade routes. The distinctively stuffed Amritsari version was refined by halwai families near the Golden Temple, who needed to feed thousands of pilgrims efficiently. Kanha Sweets near the Hall Bazaar and Bharawan da Dhaba have been serving the same recipe for over a century.',
                    ],
                    [
                        'name'         => 'Dal Makhani',
                        'description'  => 'Whole black urad lentils and kidney beans simmered overnight on a slow flame with tomatoes, butter, and cream until they yield a luxuriously rich, smoky, mahogany-coloured dal. The overnight slow cooking is essential—it breaks down the lentil skins while retaining their shape, creating a creaminess that no shortcut can replicate. A crowning achievement of Punjabi vegetarian cooking.',
                        'ingredients'  => 'Whole black urad dal, kidney beans (rajma), butter, cream, tomato puree, onion, ginger, garlic, cumin, coriander, red chilli powder, garam masala, kasuri methi (dried fenugreek leaves), salt',
                        'is_vegetarian' => true,
                        'meal_type'    => 'Dinner',
                        'origin_story' => 'Dal Makhani was invented by Kundan Lal Gujral, founder of Moti Mahal restaurant in Peshawar (now Pakistan), in the 1930s. After Partition, he moved to Delhi and perfected the recipe at his Daryaganj restaurant, where it was adopted by Punjabi refugees who carried it across north India. His protégé Kundan Lal Jaggi (Diva Restaurant) popularised the use of heavy cream, transforming a humble dal into a luxury staple.',
                    ],
                ],

                'traditions' => [
                    [
                        'name'            => 'Lohri',
                        'category'        => 'Harvest',
                        'description'     => 'Lohri is celebrated on the 13th of January (the eve of Makar Sankranti) with a bonfire around which families and neighbourhoods gather to sing folk songs—particularly about Dulla Bhatti, a Robin Hood-like bandit of Mughal Punjab. Rewri (sesame brittle), peanuts, popcorn, and til-gur are thrown into the fire and distributed. Bhangra and Giddha dances follow. The festival is especially joyous for families who have had a birth or wedding in the preceding year.',
                        'significance'    => 'Lohri marks the end of the winter solstice and the beginning of longer days, celebrating the harvest of the rabi (winter) sugarcane crop. Agriculturally, it signals the passage of the sun into Capricorn and the gradual return of warmth to the earth. For newly married women and newborn children, the first Lohri after their arrival is a major social event involving gifts and community celebration.',
                        'region_specific' => 'Punjab, Haryana, Himachal Pradesh, Delhi NCR',
                    ],
                    [
                        'name'            => 'Vaisakhi',
                        'category'        => 'Festival',
                        'description'     => 'Vaisakhi (April 13 or 14) is simultaneously a harvest festival and the most sacred day in the Sikh calendar—the anniversary of the founding of the Khalsa Panth by Guru Gobind Singh in 1699 at Anandpur Sahib. Sikhs take a ritual dip in rivers, visit the Golden Temple in Amritsar, attend Nagar Kirtans (processions of hymn-singing), and celebrate the rabi harvest with fairs (melas) and bhangra dancing in fields.',
                        'significance'    => 'Vaisakhi 1699 CE was the moment Guru Gobind Singh baptised the first five Khalsa (Panj Pyare), establishing a new socio-spiritual order that rejected caste distinctions and created an egalitarian community of the saint-soldier. It is thus both the Sikh New Year and a political founding moment. The Jallianwala Bagh massacre of 1919 occurred on Vaisakhi, adding a dimension of remembrance to the celebration.',
                        'region_specific' => 'Punjab state-wide; most significant at Anandpur Sahib and the Golden Temple, Amritsar',
                    ],
                ],
            ],

            // ─── TAMIL NADU ──────────────────────────────────────────────
            [
                'name'             => 'Tamil Nadu',
                'capital'          => 'Chennai',
                'region'           => 'South',
                'language'         => 'Tamil',
                'established_date' => '1950-01-26',
                'population'       => 77841267,
                'area_sq_km'       => 130058.00,
                'description'      => 'Tamil Nadu, "Land of the Tamils", is one of the oldest living civilisations on earth, home to a language with an unbroken literary tradition of over 2,000 years and temples whose Dravidian gopurams (gateway towers) soar above cities and rice fields alike. From the Chola bronze-casting tradition to Carnatic music, from Bharatanatyam to the ancient philosophy of Thiruvalluvar\'s Thirukkural, Tamil Nadu is an inexhaustible repository of classical Indian culture.',

                'culture' => [
                    'classical_dance'         => 'Bharatanatyam (the oldest codified classical dance of India, originating as Sadir in the temples of Tamil Nadu, with its canonical grammar set in Natya Shastra; characterised by geometric body positions, abhinaya expression, and sculptural precision), Kolattam (stick dance), Karagattam (pot-balancing folk dance), and Therukkoothu (street theatre)',
                    'music_forms'             => 'Carnatic classical music (one of the two main traditions of Indian classical music; Thyagaraja, Muthuswami Dikshitar, and Syama Sastri—the Trinity of Carnatic music—all composed in Tamil Nadu), Isai Vellalar temple music tradition, Nadaswaram (double-reed wind instrument, essential for temple festivals), and Tavil (barrel drum)',
                    'traditional_dress_male'  => 'Veshti (white or off-white cotton dhoti) with an angavastram (shoulder cloth), often in Madurai cotton; for formal occasions, a silk veshti with gold zari border paired with a formal shirt',
                    'traditional_dress_female' => 'Madisar (9-yard Brahmin ceremonial draping style), Kanjivaram pattu saree in rich silk with contrasting zari borders; young girls wear the Pattu Pavadai (silk skirt and blouse); married women wear pottu (bindi) and thali (sacred thread necklace)',
                    'art_forms'               => 'Tanjore painting (richly textured, semi-3D paintings on wood with gesso relief, gold leaf, and semi-precious stones depicting deities), Kolam (intricate rice-flour geometric floor art drawn daily before homes), Chola bronze casting (lost-wax technique, with Nataraja considered the pinnacle), and Kalamkari-influenced textiles',
                    'handicrafts'             => 'Kanjivaram silk sarees (the finest silk sarees in India, woven in Kanchipuram with interlocked warp threads making borders inseparable from the body), bronze and panchaloha casting, Thanjavur thalayatti bommai (bobblehead dolls), Chettinad tiles, palm-leaf manuscripts, and stone carving',
                    'language_script'         => 'Tamil script (one of the world\'s oldest living scripts; Tamil is one of the 22 scheduled languages of India and holds Classical Language status; Sangam literature dates to at least 300 BCE)',
                    'notable_personalities'   => 'Thiruvalluvar (author of the Thirukkural, c. 31 BCE–5 CE), Subramania Bharati (revolutionary nationalist poet), M.S. Subbulakshmi (Carnatic vocalist, first musician to receive the Bharat Ratna), A.P.J. Abdul Kalam (scientist and President of India), C.N. Annadurai (statesman, Chief Minister)',
                ],

                'foods' => [
                    [
                        'name'         => 'Idli Sambar',
                        'description'  => 'Soft, pillowy steamed rice-and-lentil cakes (idli) accompanied by a tart, aromatic vegetable lentil broth (sambar) and a trio of chutneys—coconut, tomato, and coriander. Idli is considered among the world\'s most nutritious breakfasts: fermented for 8–12 hours, steam-cooked with no oil, and providing complete protein through its rice-lentil combination.',
                        'ingredients'  => 'Parboiled rice, urad dal (split black lentil), toor dal, tomato, shallots, drumstick (moringa), eggplant, tamarind, sambar powder, mustard seeds, curry leaves, asafoetida, turmeric, dried red chilli, grated coconut, green chilli, ginger',
                        'is_vegetarian' => true,
                        'meal_type'    => 'Breakfast',
                        'origin_story' => 'Idli\'s origins are contested between South India and Indonesia, where a similar steamed cake (kedli) existed and from where Indian traders may have adopted the fermentation technique. The earliest unambiguous mention appears in a 920 CE Kannada text. By the 12th century, Chavundaraya II\'s Kannada encyclopaedia described idli closely. The sambar accompaniment evolved in the kitchens of the Thanjavur Maratha court (c. 1640s) when tamarind was substituted for kokum.',
                    ],
                    [
                        'name'         => 'Chettinad Chicken Curry',
                        'description'  => 'The most complex and boldly spiced of all South Indian curries—a dark, aromatic gravy from the Chettinad region of Tamil Nadu built on a unique spice palette including kalpasi (stone flower), marathi mokku (dried flower pods), star anise, kalpasi, and freshly ground coconut paste. Chettinad cooking uses spices not found in any other Indian regional cuisine, a legacy of the Nattukotai Chettiars\' global trading networks.',
                        'ingredients'  => 'Country chicken, fresh coconut, shallots, tomato, ginger, garlic, kalpasi (stone flower), marathi mokku, star anise, fennel, cinnamon, cloves, cardamom, black pepper, red chilli, coriander, turmeric, sesame oil, curry leaves',
                        'is_vegetarian' => false,
                        'meal_type'    => 'Dinner',
                        'origin_story' => 'Chettinad cuisine was shaped by the Nattukotai Chettiar (Nagarathar) community, whose merchant caste controlled trade routes across South and Southeast Asia from the 17th to early 20th century. They imported rare spices from Burma, Sri Lanka, and the Spice Islands and incorporated them into their home cooking. Confined to the 74-village Chettinad region of Sivaganga district, this cuisine was only discovered by the wider world in the 1970s through food writers like Chandra Padmanabhan.',
                    ],
                    [
                        'name'         => 'Ven Pongal',
                        'description'  => 'A savoury porridge of rice and yellow moong dal simmered together until silky and thick, generously seasoned with cracked black pepper, cumin, fresh ginger, curry leaves, cashews, and ghee. Light yet filling, Ven Pongal (white pongal) is Tamil Nadu\'s definitive breakfast comfort food and the sacred offering (prasad) of the Pongal harvest festival.',
                        'ingredients'  => 'Raw rice, yellow moong dal, ghee, black pepper, cumin seeds, ginger, curry leaves, cashew nuts, asafoetida, salt',
                        'is_vegetarian' => true,
                        'meal_type'    => 'Breakfast',
                        'origin_story' => 'Pongal as a food predates the festival of the same name; it was the primordial temple prasad of Tamil Shaivite temples for over a millennium, cooked in bronze vessels and offered to Shiva before distribution. The word "pongal" means "to boil over"—a symbol of abundance. Ancient Sangam poems reference the communal cooking of rice and lentils at harvest-time gatherings. The festival Pongal formalised this practice as a harvest thanksgiving ritual.',
                    ],
                ],

                'traditions' => [
                    [
                        'name'            => 'Pongal Festival',
                        'category'        => 'Harvest',
                        'description'     => 'Pongal is Tamil Nadu\'s four-day harvest thanksgiving festival celebrated in mid-January. On the first day (Bhogi), old possessions are burned. On the second (Thai Pongal), the first harvest rice is cooked in clay pots outdoors until it boils over—a moment of joyous celebration—and offered to the Sun. The third day (Mattu Pongal) honours cattle decorated with garlands and paint. The fourth (Kaanum Pongal) is a day of family outings.',
                        'significance'    => 'Pongal is the oldest surviving harvest festival of the Tamil people, with references to the Sangam-age Thai festival appearing in poems over 2,000 years old. The boiling over of the pot symbolises prosperity overflowing in the coming year. The worship of Surya (the Sun) connects agricultural fertility with cosmic order. Unlike Diwali or Holi, Pongal is entirely a Tamil cultural festival with no pan-Indian Puranic mythology behind it—it belongs solely to the land and its farmers.',
                        'region_specific' => 'State-wide; most elaborate in rural Cauvery delta (Thanjavur, Tiruchi, Nagapattinam)',
                    ],
                    [
                        'name'            => 'Natyanjali Dance Festival',
                        'category'        => 'Art',
                        'description'     => 'Held annually in February–March at the Chidambaram Nataraja Temple—the cosmic dance hall of Lord Shiva—Natyanjali ("dance offering") is a five-day festival during which hundreds of Bharatanatyam dancers perform inside and around the thousand-year-old granite temple complex. Performances occur at dawn, noon, and dusk, with each session a devotional offering rather than a performance for an audience. Leading classical dancers from across India participate.',
                        'significance'    => 'Chidambaram is the only temple in India where Shiva is worshipped in his Nataraja (Lord of Dance) form—the Ananda Tandava pose that symbolises the cosmic cycles of creation, preservation, and destruction. The Natyanjali festival revives the ancient devadasi tradition of temple dance (arangetram) in a contemporary, democratised form, reconnecting Bharatanatyam to its sacred origins after decades in the secular concert stage. It was inaugurated in 1981 by Rukmini Devi Arundale.',
                        'region_specific' => 'Chidambaram, Cuddalore district; satellite events at Thanjavur and Kumbakonam',
                    ],
                ],
            ],

            // ─── WEST BENGAL ─────────────────────────────────────────────
            [
                'name'             => 'West Bengal',
                'capital'          => 'Kolkata',
                'region'           => 'East',
                'language'         => 'Bengali',
                'established_date' => '1947-08-15',
                'population'       => 91347736,
                'area_sq_km'       => 88752.00,
                'description'      => 'West Bengal, "the land of rivers, the poetry of the earth" as Tagore called it, is India\'s intellectual and artistic crucible—home to the Bengal Renaissance, the Nobel Prize-winning poetry of Rabindranath Tagore, the revolutionary social movements of Ramakrishna and Vivekananda, and the cinematic genius of Satyajit Ray. From the Himalayan foothills of Darjeeling to the mangrove Sundarbans, and from the jute fields of the delta to the howling ghats of Kolkata, West Bengal is a state of astonishing contrasts and enduring creative energy.',

                'culture' => [
                    'classical_dance'         => 'Rabindra Nritya (dance dramas choreographed to Rabindranath Tagore\'s songs—lyrical, expressive, and deeply literary), Chhau dance of Purulia (masked martial dance depicting scenes from the epics, UNESCO-listed under Intangible Cultural Heritage), Gaudiya Nritya (revived Vaishnavite court dance), and Baul dance (ecstatic movement accompanying Baul song)',
                    'music_forms'             => 'Rabindra Sangeet (songs composed by Rabindranath Tagore—2,232 compositions that form their own distinct musical system), Baul music (mystical folk tradition of wandering bards who merge Sufi and Vaishnava devotional traditions, UNESCO-listed), Kirtana (Vaishnava devotional singing), Shyama Sangeet (songs to goddess Kali), Thumri (semi-classical form)',
                    'traditional_dress_male'  => 'White dhoti-panjabi (kurta) for formal occasions and religious ceremonies; the dhoti is worn in a style unique to Bengal called the "dhuti" with a distinctive pleat at the front; for Durga Puja, new clothes (new clothes gifted on Puja day—pushpanjali attire) are obligatory',
                    'traditional_dress_female' => 'Bengali saree in the "Bengali style" draping—without petticoat pleats tucked in front, instead pleated over the left shoulder—in Tant cotton (Dhaniakhali, Shantipur weaves) or Baluchari and Jamdani silk; iron shankha (conch shell) and pola (red coral) bangles are mandatory for married Hindu women',
                    'art_forms'               => 'Kalighat painting (19th-century folk painting on jute, originally sold near Kalighat temple, known for bold outlines and social satire), Patachitra scroll painting (narrative painted scrolls presented by Chitrakar community to accompany songs), Dokra lost-wax metal craft, Shantiniketan leather and batik work, and the Bengal School of Art (founded by Abanindranath Tagore)',
                    'handicrafts'             => 'Baluchari silk sarees (with elaborate pallu depicting mythological narratives), Dhaniakhali and Tant cotton handloom sarees, Bishnupur Bankura horse and terracotta temple plaques, Dokra brass and bronze tribal craft, Darjeeling tea products, and Kolkata kantha stitch embroidery (running stitch quilts)',
                    'language_script'         => 'Bengali script (an eastern Brahmic script; Bengali is the 7th most spoken language in the world; the language martyrs\' movement of 1952 in East Pakistan—now Bangladesh—is commemorated globally as International Mother Language Day on 21 February)',
                    'notable_personalities'   => 'Rabindranath Tagore (Nobel Laureate in Literature, 1913), Swami Vivekananda (philosopher and spiritual leader), Subhas Chandra Bose (freedom fighter, leader of the Indian National Army), Satyajit Ray (filmmaker, Academy Award recipient), Amartya Sen (Nobel Laureate in Economics, 1998)',
                ],

                'foods' => [
                    [
                        'name'         => 'Macher Jhol',
                        'description'  => 'A light, mustard-oil-based fish curry—the everyday soul food of Bengal—made with fresh river or pond fish (typically rohu or hilsa), potatoes, tomato, and a handful of whole spices, coloured golden with turmeric. Unlike the coconut-milk richness of southern fish curries, Macher Jhol is thin-gravied, bright, and built around the freshness of the fish rather than masking it. A Bengali will judge a household by the quality of its Jhol.',
                        'ingredients'  => 'Rohu fish (or hilsa/Hilsa ilisha), mustard oil, turmeric, cumin, bay leaf, dried red chilli, onion, ginger, tomato, potato, green chilli, coriander, panch phoron (five-spice blend), salt',
                        'is_vegetarian' => false,
                        'meal_type'    => 'Lunch',
                        'origin_story' => 'Macher Jhol is ancient—referenced in medieval Bengali literature and in the culinary manuals of the Vaishnava temples of Nabadwip and Mayapur. The Bengali obsession with freshwater fish (hilsa, rohu, katla, bhetki) is rooted in the Gangetic delta geography: the rivers were the pantry. The preference for a thin, spiced broth over thick gravy reflects the climatic logic of a hot, humid delta—light food that doesn\'t burden the body. The dish gained literary immortality in Bibhutibhushan Bandyopadhyay\'s "Pather Panchali".',
                    ],
                    [
                        'name'         => 'Mishti Doi',
                        'description'  => 'Sweetened yoghurt set slowly in earthenware pots (matka) to an ambrosial, creamy, caramel-tinged consistency—the defining dessert of Bengal. Unlike plain yoghurt, Mishti Doi is prepared with reduced milk, flavoured with jaggery or caramelised sugar and sometimes a hint of cardamom, then fermented at a controlled temperature. The earthen pot is not decorative; it absorbs excess moisture and imparts a subtle mineral quality to the final product.',
                        'ingredients'  => 'Full-fat milk, jaggery or caramelised sugar, yoghurt starter culture, cardamom (optional)',
                        'is_vegetarian' => true,
                        'meal_type'    => 'Dessert',
                        'origin_story' => 'Mishti Doi is traced to the Bogra district of Bengal (now Bangladesh) and to the town of Comilla, where the tradition of setting sweetened fermented milk in terracotta pots began. The use of jaggery rather than sugar gives Mishti Doi its distinctive reddish tint and complex sweetness. Kolkata\'s famous mishti shops—K.C. Das, Girish Chandra Dey and Nakur Chandra Nandy—have kept traditional recipes since the 19th century. The earthenware matka is now a protected traditional industry.',
                    ],
                    [
                        'name'         => 'Luchi Aloor Dom',
                        'description'  => 'Luchi are small, soft puffed discs of refined flour deep-fried in ghee or oil until they balloon into golden spheres—Bengal\'s festive bread, lighter and more delicate than the north Indian puri. Aloor Dom is a rich, slow-cooked whole potato curry in a spiced onion-tomato gravy with the warmth of garam masala and the brightness of dried chilli. Together they are the ceremonial breakfast of Durga Puja mornings.',
                        'ingredients'  => 'Refined flour (maida), baby potatoes, mustard oil, onion, ginger-garlic paste, tomato, turmeric, cumin, coriander, garam masala, bay leaf, green chilli, sugar, ghee, salt',
                        'is_vegetarian' => true,
                        'meal_type'    => 'Breakfast',
                        'origin_story' => 'The Luchi is the Bengali adaptation of the ancient puri, refined over centuries in the Brahmin kitchens of Nabadwip, where it became the standard offering in the thakur\'s (deity\'s) bhog plate. Its use of refined flour (maida) rather than whole wheat marks it as a prestige bread—reserved for festivals and guests. Aloor Dom as its companion dish was standardised in Kolkata\'s zamindar (landlord) households of the 18th century, when potatoes (introduced by the Portuguese) had fully integrated into Bengali cooking.',
                    ],
                ],

                'traditions' => [
                    [
                        'name'            => 'Durga Puja',
                        'category'        => 'Religious',
                        'description'     => 'Durga Puja is a five-day festival (Shashthi to Dashami) during which Kolkata and all of West Bengal transform into the world\'s largest outdoor art exhibition. Thousands of pandals (temporary bamboo-and-cloth structures) of staggering architectural ambition house elaborately sculpted clay idols of Goddess Durga slaying the demon Mahishasura, attended by her four children. Artists spend months crafting the idol and its setting; themes range from traditional to wildly conceptual. On Dashami, the idol is carried in procession to the Ganga for immersion (visarjan).',
                        'significance'    => 'Durga Puja commemorates the Goddess\'s victory over the buffalo demon Mahishasura—a triumph of divine feminine power over evil. Culturally it is the defining annual event of Bengali identity worldwide; the Bengali diaspora recreates it in New York, London, and Sydney. UNESCO inscribed Durga Puja on its Intangible Cultural Heritage list in 2021. The festival drives an economy of Rs 50,000+ crore annually in West Bengal alone and employs tens of thousands of artisans from Kumartuli (the potters\' quarter of Kolkata).',
                        'region_specific' => 'State-wide; most spectacular in Kolkata (North Kolkata para pujas and themed pandals of South Kolkata)',
                    ],
                    [
                        'name'            => 'Poila Boishakh',
                        'category'        => 'Social',
                        'description'     => 'Poila Boishakh—the first day of the Bengali New Year (mid-April, corresponding to 1 Boishakh in the Bengali calendar)—is celebrated across West Bengal and Bangladesh with sunrise walks, the wearing of new clothes (women in white-bordered red sarees, men in white dhoti-panjabi), the playing of Rabindra Sangeet at dawn, and the ritual opening of new account books (haal khata) by traders. Sweets are exchanged, cultural programmes fill the day, and the evening belongs to adda (intellectual conversation) at tea stalls.',
                        'significance'    => 'Poila Boishakh was popularised in Bengal by Rabindranath Tagore, who instituted the Basanta Utsav (spring festival) and Nababarsha (New Year) celebrations at Shantiniketan. It is a secular festival that unites Hindus, Muslims, and Christians of Bengal in a shared cultural identity—the identity of being Bengali above all else. The Haal Khata tradition (opening new accounts on New Year) has ancient mercantile origins in the Marwari and Saha trading communities of Bengal.',
                        'region_specific' => 'State-wide; most culturally significant in Kolkata, Shantiniketan, and border districts with Bangladesh',
                    ],
                ],
            ],

        ];
    }
}
