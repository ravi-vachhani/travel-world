<?php
/**
 * India geography data + render helpers for consistent, typo-free
 * Country / State / City selection across the CRM.
 *
 * - Country: a <select> (India default; a few common NRI countries included).
 * - State:   a <select> of all 28 states + 8 union territories.
 * - City:    an <input> backed by a <datalist> so the common cities for the
 *            chosen state appear as suggestions, but any city can still be typed
 *            (datalist is suggest-only). JS narrows the city list to the state.
 */

function crm_countries(): array {
    return ['India','United Arab Emirates','United States','United Kingdom','Canada',
            'Australia','Singapore','Saudi Arabia','Qatar','Kuwait','Oman','Nepal','Other'];
}

/** All Indian states & union territories. */
function crm_states(): array {
    return [
        'Andhra Pradesh','Arunachal Pradesh','Assam','Bihar','Chhattisgarh','Goa',
        'Gujarat','Haryana','Himachal Pradesh','Jharkhand','Karnataka','Kerala',
        'Madhya Pradesh','Maharashtra','Manipur','Meghalaya','Mizoram','Nagaland',
        'Odisha','Punjab','Rajasthan','Sikkim','Tamil Nadu','Telangana','Tripura',
        'Uttar Pradesh','Uttarakhand','West Bengal',
        // Union Territories
        'Andaman and Nicobar Islands','Chandigarh',
        'Dadra and Nagar Haveli and Daman and Diu','Delhi','Jammu and Kashmir',
        'Ladakh','Lakshadweep','Puducherry',
    ];
}

/** Major / common cities per state (suggestions; free text still allowed). */
function crm_cities_by_state(): array {
    return [
        'Andhra Pradesh' => ['Visakhapatnam','Vijayawada','Guntur','Nellore','Tirupati','Kurnool','Rajahmundry','Kakinada'],
        'Arunachal Pradesh' => ['Itanagar','Naharlagun','Pasighat'],
        'Assam' => ['Guwahati','Silchar','Dibrugarh','Jorhat','Nagaon','Tezpur'],
        'Bihar' => ['Patna','Gaya','Bhagalpur','Muzaffarpur','Darbhanga','Purnia'],
        'Chhattisgarh' => ['Raipur','Bhilai','Bilaspur','Korba','Durg'],
        'Goa' => ['Panaji','Margao','Vasco da Gama','Mapusa','Ponda'],
        'Gujarat' => ['Ahmedabad','Surat','Vadodara','Rajkot','Bhavnagar','Jamnagar','Gandhinagar','Junagadh','Anand','Bharuch'],
        'Haryana' => ['Faridabad','Gurugram','Panipat','Ambala','Yamunanagar','Rohtak','Hisar','Karnal'],
        'Himachal Pradesh' => ['Shimla','Dharamshala','Solan','Mandi','Manali','Kullu'],
        'Jharkhand' => ['Ranchi','Jamshedpur','Dhanbad','Bokaro','Hazaribagh','Deoghar'],
        'Karnataka' => ['Bengaluru','Mysuru','Hubli','Mangaluru','Belagavi','Davanagere','Ballari','Shivamogga'],
        'Kerala' => ['Thiruvananthapuram','Kochi','Kozhikode','Thrissur','Kollam','Kannur','Alappuzha'],
        'Madhya Pradesh' => ['Bhopal','Indore','Jabalpur','Gwalior','Ujjain','Sagar','Satna','Ratlam'],
        'Maharashtra' => ['Mumbai','Pune','Nagpur','Nashik','Thane','Aurangabad','Solapur','Kolhapur','Navi Mumbai','Amravati'],
        'Manipur' => ['Imphal','Thoubal','Bishnupur'],
        'Meghalaya' => ['Shillong','Tura','Jowai'],
        'Mizoram' => ['Aizawl','Lunglei','Champhai'],
        'Nagaland' => ['Kohima','Dimapur','Mokokchung'],
        'Odisha' => ['Bhubaneswar','Cuttack','Rourkela','Berhampur','Sambalpur','Puri'],
        'Punjab' => ['Ludhiana','Amritsar','Jalandhar','Patiala','Bathinda','Mohali','Pathankot'],
        'Rajasthan' => ['Jaipur','Jodhpur','Udaipur','Kota','Bikaner','Ajmer','Alwar','Bhilwara'],
        'Sikkim' => ['Gangtok','Namchi','Gyalshing'],
        'Tamil Nadu' => ['Chennai','Coimbatore','Madurai','Tiruchirappalli','Salem','Tirunelveli','Erode','Vellore','Thoothukudi'],
        'Telangana' => ['Hyderabad','Warangal','Nizamabad','Karimnagar','Khammam'],
        'Tripura' => ['Agartala','Udaipur','Dharmanagar'],
        'Uttar Pradesh' => ['Lucknow','Kanpur','Ghaziabad','Agra','Varanasi','Meerut','Prayagraj','Noida','Bareilly','Aligarh','Moradabad','Gorakhpur'],
        'Uttarakhand' => ['Dehradun','Haridwar','Roorkee','Haldwani','Rishikesh','Nainital'],
        'West Bengal' => ['Kolkata','Howrah','Durgapur','Asansol','Siliguri','Darjeeling'],
        'Andaman and Nicobar Islands' => ['Port Blair'],
        'Chandigarh' => ['Chandigarh'],
        'Dadra and Nagar Haveli and Daman and Diu' => ['Daman','Diu','Silvassa'],
        'Delhi' => ['New Delhi','Delhi','Dwarka','Rohini','Saket'],
        'Jammu and Kashmir' => ['Srinagar','Jammu','Anantnag','Baramulla'],
        'Ladakh' => ['Leh','Kargil'],
        'Lakshadweep' => ['Kavaratti'],
        'Puducherry' => ['Puducherry','Karaikal','Yanam','Mahe'],
    ];
}

/** Flat, de-duplicated list of all cities (for the datalist fallback). */
function crm_all_cities(): array {
    $all = [];
    foreach (crm_cities_by_state() as $cities) {
        foreach ($cities as $c) $all[$c] = true;
    }
    $list = array_keys($all);
    sort($list);
    return $list;
}

/** Render the Country <select>. */
function crm_country_select(string $name, string $selected = 'India'): string {
    $selected = $selected !== '' ? $selected : 'India';
    $opts = '';
    foreach (crm_countries() as $c) {
        $sel = ($c === $selected) ? ' selected' : '';
        $opts .= '<option value="' . htmlspecialchars($c) . '"' . $sel . '>' . htmlspecialchars($c) . '</option>';
    }
    return '<select name="' . htmlspecialchars($name) . '" data-country>' . $opts . '</select>';
}

/** Render the State <select> (data-state so JS can link it to the city list). */
function crm_state_select(string $name, string $selected = ''): string {
    $opts = '<option value="">— Select State —</option>';
    foreach (crm_states() as $s) {
        $sel = ($s === $selected) ? ' selected' : '';
        $opts .= '<option value="' . htmlspecialchars($s) . '"' . $sel . '>' . htmlspecialchars($s) . '</option>';
    }
    return '<select name="' . htmlspecialchars($name) . '" data-state>' . $opts . '</select>';
}

/** Render a City input backed by a datalist (suggest-only, free text allowed). */
function crm_city_input(string $name, string $value = ''): string {
    $list = '';
    foreach (crm_all_cities() as $c) {
        $list .= '<option value="' . htmlspecialchars($c) . '"></option>';
    }
    return '<input type="text" name="' . htmlspecialchars($name) . '" value="' . htmlspecialchars($value) . '" '
         . 'list="crmCityList" data-city autocomplete="off" placeholder="Start typing a city…">'
         . '<datalist id="crmCityList">' . $list . '</datalist>';
}

/** Emit the state→cities map as JSON for the client-side city narrowing. */
function crm_cities_json(): string {
    return json_encode(crm_cities_by_state());
}
