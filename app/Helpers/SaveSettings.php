<?php
namespace App\Helpers;

use Illuminate\Http\Request;
use Hash;
use App\Models\EmploymentHistory;

trait SaveSettings {
    
    /**
     * User validate rules
     * @var array 
     */
    protected $userValidateRules;
    
    /**
     * User validate messages
     *
     * @var array 
     */
    protected $userValidateMessages;
    
    public function __construct() {
        $this->userValidateRules    = user()->getRegisterRules();
        $this->userValidateMessages = user()->getRegisterMessages();
    }

    /**
     * Save settings email.
     * 
     * @param Request $request
     * 
     * @return boolean|JSON
     */
    public function saveEmail(Request $request) {
        
        $validator = validator($request->all(), $this->_saveEmailValidateRules(), $this->userValidateMessages);
        $validator->after(function($validator) use($request) {
            if ( ! Hash::check($request->get('password'), user()->password)) {
                $validator->errors()->add('password', _t('auth.login.pass_wrong'));
            }
        });
        
        if ($validator->fails()) {
            return $validator;
        }
        
        user()->email = $request->get('email');
        user()->save();
        
        return true;
    }
    
    /**
     * Save settings slug.
     * 
     * @param Request $request
     * 
     * @return boolean|JSON
     */
    public function saveSlug(Request $request) {
        
        $validator = validator($request->all(), $this->_saveSlugValidateRules(),$this->_saveSlugValidateMessages());
        if ($validator->fails()) {
            return $validator;
        }
        
        user()->userProfile->slug = $request->get('slug');
        user()->userProfile->save();
        
        return true;
    }
    
    /**
     * Save settings password.
     * 
     * @param Request $request
     * 
     * @return boolean|JSON
     */
    public function savePassword(Request $request) {
        
        $validator = validator($request->all(), $this->_savePasswordValidateRules(), $this->_savePasswordValidateMessages());
        $validator->after(function($validator) use($request) {
            if ( ! Hash::check($request->get('old_password'), user()->password)) {
                $validator->errors()->add('old_password', _t('auth.login.pass_wrong'));
            }
        });
        
        if ($validator->fails()) {
            return $validator;
        }
        
        user()->password = bcrypt($request->get('new_password'));
        user()->save();
        
        return true;
    }
    
    /**
     * Save settings personal info.
     * 
     * @param Request $request
     * 
     * @return boolean|JSON
     */
    public function savePersonalInfo(Request $request) {
        
        $validator = validator($request->all(), $this->_savePersonalInfoRules(), $this->_savePersonalInfoMessages());
        if ($validator->fails()) {
            return $validator;
        }
        
        $d                         = (int) $request->get('date');
        $m                         = (int) $request->get('month');
        $y                         = (int) $request->get('year');
        $gender                    = (int) $request->get('gender');
        
        $userProfile               = user()->userProfile;
        $userProfile->day_of_birth = ($d && $m && $y) ? new \DateTime("{$m}/{$d}/{$y}") : null;
        $userProfile->gender_id    = ($gender) ? $gender : null;
        $userProfile->first_name   = $request->get('first_name');
        $userProfile->last_name    = $request->get('last_name');
        $userProfile->save();
        
        return true;
    }
    
    /**
     * Save settings contact.
     * 
     * @param Request $request
     * 
     * @return boolean|JSON
     */
    public function saveContactInfo(Request $request) {
        
        $validateRules = $this->_saveContactRules();
        
        if (empty($request->get('city'))) {
            $validateRules['city'] = 'required_with:country';
        }
        
        if (empty($request->get('district'))) {
            $validateRules['district'] = 'required_with:city';
        }
        
        if (empty($request->get('ward'))) {
            $validateRules['ward'] = 'required_with:district';
        }
        
        $validator = validator($request->all(), $validateRules, $this->_saveContactMessages());
        if ($validator->fails()) {
            return $validator;
        }
        
        $userProfile                 = user()->userProfile;
        $userProfile->street_name    = $request->get('street_name');
        $userProfile->country_id     = (empty($request->get('country')))      ? null : $request->get('country');
        $userProfile->city_id        = (empty($request->get('city')))         ? null : $request->get('city');
        $userProfile->district_id    = (empty($request->get('district')))     ? null : $request->get('district');
        $userProfile->ward_id        = (empty($request->get('ward')))         ? null : $request->get('ward');
        $userProfile->phone_number   = (empty($request->get('phone_number'))) ? null : $request->get('phone_number');
        $userProfile->social_network = $this->_generateSocialLinks($request->get('social_network'));
        $userProfile->save();
        
        return true;
    }
    
    /**
     * Save settings contact.
     * 
     * @param Request $request
     * 
     * @return boolean|JSON
     */
    public function saveEmployment(Request $request) {
       // return true;
        $validator = validator($request->all(), $this->_saveEmploymentRules(), $this->_saveEmploymentMessages());
        if ($validator->fails()) {
            return $validator;
        }
        
        $startMonth = $request->get('start_month');
        $startYear  = $request->get('start_year');
        $endMonth   = ( ! empty($request->get('end_month'))) ? $request->get('end_month') : 0;
        $endYear    = ( ! empty($request->get('end_year')))  ? $request->get('end_year') : 0;
        $current    = ($request->has('current_company'))     ? (bool) $request->get('current_company') : false;
        $website    = $request->get('website');
        
        if ($current) {
            EmploymentHistory::all()->each(function($item, $key){
                if ($item->is_current) {
                    $item->is_current = false;
                    $item->end_date   = $item->start_date;
                }
                
                $item->save();
            });
        }
        
        if ($request->has('id') && (int) $request->get('id') > 0 && EmploymentHistory::find($request->get('id'))) {
            $employmentHistory = EmploymentHistory::find($request->get('id'));
        } else {
            $employmentHistory = new EmploymentHistory();
        }
        
        $employmentHistory->user_id         = user_id();
        $employmentHistory->company_name    = $request->get('company_name');
        $employmentHistory->position        = $request->get('position');
        $employmentHistory->start_date      = new \DateTime("{$startMonth}/{$startMonth}/{$startYear}");
        $employmentHistory->end_date        = ( ! $endMonth || ! $endYear || $current) ? $employmentHistory->start_date : new \DateTime("{$endMonth}/{$endMonth}/{$endYear}");
        $employmentHistory->is_current      = $current;
        $employmentHistory->company_website = trim((strpos($website, 'http') === false) ? 'http://' . $website : $website);
        $employmentHistory->save();
        
        return $employmentHistory;
    }
    
    protected function _generateSocialLinks($linkRaw) {
        $link    = trim($linkRaw);
        $linkArr = explode("\n", $link);
        $linkArr = array_filter($linkArr, 'trim');
        
        if (count($linkArr)) {
            foreach ($linkArr as $link) {
                
                $url = parse_url(trim((strpos($link, 'http') === false) ? 'http://' . $link : $link));
                
                if (preg_match('/(www\.)?facebook\.com/', $url['host'])) {
                    
                }
            }
        }
    }

    /**
     * Save email validate rules.
     * 
     * @return array
     */
    protected function _saveEmailValidateRules() {
        return [
            'email'    => 'required|email|max:128|unique:users,email,' . user_id() . ',id', 
            'password' => 'required'
        ];
    }
    
    /**
     * Save slug validate rules.
     * 
     * @return array
     */
    protected function _saveSlugValidateRules() {
        return ['slug' => 'required|min:2|max:128|unique:user_profile,slug,' . user_id() . ',user_id'];
    }
    
    /**
     * Save slug validate messages.
     * 
     * @return array
     */
    protected function _saveSlugValidateMessages() {
        return [
            'slug.required' => _t('setting.profile.slug_req'),
            'slug.min'      => _t('setting.profile.slug_min'),
            'slug.max'      => _t('setting.profile.slug_max'),
            'slug.unique'   => _t('setting.profile.slug_uni'),
        ];
    }
    
    /**
     * Save slug validate rules.
     * 
     * @return array
     */
    protected function _savePasswordValidateRules() {
        return [
            'old_password' => 'required',
            'new_password' => 'required|min:6|max:60|confirmed',
        ];
    }
    
    /**
     * Save slug validate messages.
     * 
     * @return array
     */
    protected function _savePasswordValidateMessages() {
        return [
            'old_password.required'              => _t('setting.profile.oldpass_req'),
            'old_password.min'                   => _t('setting.profile.oldpass_min'),
            'old_password.max'                   => _t('setting.profile.oldpass_max'),
            'new_password.required'              => _t('setting.profile.newpass_req'),
            'new_password.min'                   => _t('setting.profile.newpass_min'),
            'new_password.max'                   => _t('setting.profile.newpass_max'),
            'new_password.confirmed'             => _t('setting.profile.newpass_con'),
            'new_password_confirmation.required' => _t('setting.profile.renewpass_req'),
            'new_password_confirmation.min'      => _t('setting.profile.renewpass_min'),
            'new_password_confirmation.max'      => _t('setting.profile.renewpass_max'),
        ];
    }
    
    /**
     * Save personal information rules.
     * 
     * @return array
     */
    protected function _savePersonalInfoRules() {
        return [
            'first_name' => 'required_with:last_name|max:32',
            'last_name'  => 'required_with:first_name|max:32',
            'date'       => 'required_with:month,year',
            'month'      => 'required_with:date,year',
            'year'       => 'required_with:date,month',
        ];
    }
    
    /**
     * Save personal information messages.
     * 
     * @return array
     */
    protected function _savePersonalInfoMessages() {
        return [
            'first_name.required_with' => _t('setting.profile.fname_req'),
            'first_name.max'           => _t('setting.profile.fname_max'),
            'last_name.required_with'  => _t('setting.profile.lname_req'),
            'last_name.max'            => _t('setting.profile.lname_max'),
            'date.required_with'       => _t('setting.profile.date_req'),
            'month.required_with'      => _t('setting.profile.month_req'),
            'year.required_with'       => _t('setting.profile.year_req'),
        ];
    }
    
    /**
     * Save contact rules.
     * 
     * @return array
     */
    protected function _saveContactRules() {
        return [
            'street_name'  => 'max:250',
            'country'      => 'required_with:city|exists:countries,id',
            'city'         => 'required_with:district|exists:cities,id',
            'district'     => 'required_with:ward|exists:districts,id',
            'ward'         => 'exists:wards,id',
            'phone_number' => 'max:32',
        ];
    }
    
    /**
     * Save personal information messages.
     * 
     * @return array
     */
    protected function _saveContactMessages() {
        return [
            'street_name.max'        => _t('setting.profile.sname_max'),
            'country.required_with'  => _t('setting.profile.country_rwith'),
            'country.exists'         => _t('setting.profile.country_exi'),
            'city.required_with'     => _t('setting.profile.city_rwith'),
            'city.exists'            => _t('setting.profile.city_exi') ,
            'district.required_with' => _t('setting.profile.district_rwith'),
            'district.exists'        => _t('setting.profile.district_exi'),
            'ward.exists'            => _t('setting.profile.ward_exi'),
            'phone.max'              => _t('setting.profile.phone_max')
        ];
    }
    
    /**
     * Save employment information rules
     * 
     * @return array
     */
    protected function _saveEmploymentRules() {
        return [
            'company_name' => 'required|max:250',
            'position'     => 'required|max:250',
            'start_month'  => 'required',
            'start_year'   => 'required',
            'end_month'    => 'required_without:current_company',
            'end_year'     => 'required_without:current_company',
        ];
    }
    
    /**
     * Save employment information messages
     * 
     * @return array
     */
    protected function _saveEmploymentMessages() {
        return [
            'company_name.required'        => _t('setting.employment.comname_req'),
            'company_name.max'             => _t('setting.employment.comname_max'),
            'position.required'            => _t('setting.employment.position_req'),
            'position.max'                 => _t('setting.employment.position_max'),
            'start_month.required_without' => _t('setting.employment.startmonth_req'),
            'start_year.required_without'  => _t('setting.employment.startyear_req'),
            'end_month.required_without'   => _t('setting.employment.endmonth_req'),
            'end_year.required_without'    => _t('setting.employment.endyear_req'),
        ];
    }
}