<?php
/**
 * Setting Controller
 */

namespace King\Frontend\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserProfile;
use App\Models\Gender;
use App\Models\Country;
use App\Models\EmploymentHistory;
use App\Models\Education;
use App\Models\Skill;
use DB;
use Validator;
use Intervention\Image\Facades\Image as ImageIntervention;
use App\Helpers\SaveSettings;

class SettingsController extends FrontController {
    
    use SaveSettings;
    
    /**
     * Display settings page
     * 
     * @return Response
     */
    public function index() {
        $userProfile         = is_null(user()->userProfile) ? new UserProfile() : user()->userProfile;
        $avatarMediumSize    = (int) config('frontend.avatarMedium');
        $coverMediumSize     = (int) config('frontend.coverMediumW');
        $avatar              = unserialize($userProfile->avatar_image);
        $cover               = unserialize($userProfile->cover_image);
        $avatarStoragePath   = config('frontend.avatarsFolder');
        $coverStoragePath    = config('frontend.coversFolder');
        $avatarMedium        = isset($avatar[$avatarMediumSize]) ? $avatarStoragePath . '/' . $avatar[$avatarMediumSize] : '';
        $coverMedium         = isset($cover[$coverMediumSize])   ? $coverStoragePath . '/' . $cover[$coverMediumSize]    : '';
        $genders             = ['' => _t('setting.profile.sextell')];
        $genderName          = Gender::find($userProfile->gender_id);
        $countries           = Country::where('id', 237)->pluck('country_name', 'id')->toArray();
        $cities              = $this->_getCityByCountryId(((is_null($userProfile->country_id)) ? 0 : $userProfile->country_id), 'array');
        $districts           = $this->_getDistrictByCityId(((is_null($userProfile->city_id)) ? 0 : $userProfile->city_id), 'array');
        $wards               = $this->_getWardByDistrictId(((is_null($userProfile->district_id)) ? 0 : $userProfile->district_id), 'array');
        $employmentHistories = EmploymentHistory::orderBy('is_current', 'DESC')->orderBy('start_date', 'DESC')->get();
        $educations          = Education::orderBy('start_date', 'DESC')->get();
        
        if (Gender::all()) {
            foreach (Gender::all() as $gender) {
                $genders[$gender->id] = $gender->gender_name;
            }
        }
        
        return view('frontend::settings.index', [
            'userProfile'         => $userProfile,
            'avatarMedium'        => $avatarMedium,
            'coverMedium'         => $coverMedium,
            'genders'             => $genders,
            'gender'              => ( ! is_null($genderName)) ? $genderName->gender_name : null,
            'countries'           => ['' => _t('setting.profile.country')] + ((count($countries)) ? $countries : []),
            'cities'              => $cities,
            'districts'           => $districts,
            'wards'               => $wards,
            'employmentHistories' => $employmentHistories,
            'educations'          => $educations
        ]);
    }
    
    /**
     * Change the profile's status: publish or unpublish
     * 
     * @param Request $request
     * 
     * @return AJAX 
     */
    public function publishProfile(Request $request) {
        if ($request->ajax() && $request->isMethod('POST')) {
            
            $userProfile     = user()->userProfile;
            $publish_request = ($request->get('publish_state') === 'true') ? true : false;
            
            if (is_null($userProfile)) {
                $userProfile          = new UserProfile();
                $userProfile->user_id = user()->id;
            }
            
            $userProfile->publish = $publish_request;
            $userProfile->save();
            
            return pong(['publish' => $userProfile->publish]);
        }
    }
    
    /**
     * Upload avatar image.
     * 
     * @param Request $request
     * 
     * @return AJAX
     */
    function uploadAvatar(Request $request) {
        if ($request->isMethod('POST')) {
            $rules     = $this->_getAvatarRules();
            $messages  = $this->_getAvatarMessages();
            $validator = Validator::make($request->all(), $rules, $messages);
            
            if ($validator->fails()) {
                return file_pong(['messages' => $validator->errors()->first()], _error(), 403);
            }
            
            if ($request->file('__file')->isValid()) {
                $avatar      = $request->file('__file');
                $storagePath = config('frontend.avatarsFolder');
                $mediumSize  = (int) config('frontend.avatarMedium');
                $mediumName  = generate_filename($storagePath, $avatar->getClientOriginalExtension(), [
                    'prefix' => 'avatar_', 
                    'suffix' => "_{$mediumSize}x{$mediumSize}"
                ]);
                
                $avatar->move($storagePath, $mediumName);
                
                $image = ImageIntervention::make($storagePath . '/' . $mediumName)->orientate();
                $image->fit($mediumSize, $mediumSize, function ($constraint) {
                    $constraint->upsize();
                });
                
                $image->save();
                
                $userProfile = user()->userProfile;
                
                if (is_null($userProfile)) {
                    $userProfile          = new UserProfile();
                    $userProfile->user_id = user()->id;
                } else {
                    $avatarImg = unserialize($userProfile->avatar_image);
                    if (isset($avatarImg[$mediumSize])) {
                        delete_file($storagePath . '/' . $avatarImg[$mediumSize]);
                    }
                }
                
                $userProfile->avatar_image = serialize(array($mediumSize => $mediumName));
                $userProfile->save();
                
                return file_pong(['avatar_medium' => $storagePath . '/' . $mediumName]);
            }
            
            return file_pong(['messages' => _t('oops')], _error(), 403);
        }
    }
    
    /**
     * Upload cover image.
     * 
     * @param Request $request
     * 
     * @return AJAX
     */
    function uploadCover(Request $request) {
        if ($request->isMethod('POST')) {
            $rules     = $this->_getCoverRules();
            $messages  = $this->_getCoverMessages();
            $validator = Validator::make($request->all(), $rules, $messages);
            
            if ($validator->fails()) {
                return file_pong(['messages' => $validator->errors()->first()], _error(), 403);
            }
            
            if ($request->file('__file')->isValid()) {
                $avatar      = $request->file('__file');
                $storagePath = config('frontend.coversFolder');
                $mediumSizeW = (int) config('frontend.coverMediumW');
                $mediumSizeH = (int) config('frontend.coverMediumH');
                $mediumName  = generate_filename($storagePath, $avatar->getClientOriginalExtension(), [
                    'prefix' => 'cover_', 
                    'suffix' => "_{$mediumSizeW}x{$mediumSizeH}"
                ]);
                
                $avatar->move($storagePath, $mediumName);
                
                $image = ImageIntervention::make($storagePath . '/' . $mediumName)->orientate();
                $image->fit($mediumSizeW, $mediumSizeH, function ($constraint) {
                    $constraint->upsize();
                });
                
                $image->save();
                
                $userProfile = user()->userProfile;
                
                if (is_null($userProfile)) {
                    $userProfile          = new UserProfile();
                    $userProfile->user_id = user()->id;
                } else {
                    $avatarImg = unserialize($userProfile->cover_image);
                    if (isset($avatarImg[$mediumSizeW])) {
                        delete_file($storagePath . '/' . $avatarImg[$mediumSizeW]);
                    }
                }
                
                $userProfile->cover_image = serialize(array($mediumSizeW => $mediumName));
                $userProfile->save();
                
                return file_pong(['cover_medium' => $storagePath . '/' . $mediumName]);
            }
            
            return file_pong(['messages' => _t('oops')], _error(), 403);
        }
    }

    /**
     * Save settings
     * 
     * @param Request $request
     * 
     * @return JSON
     */
    public function saveInfo(Request $request) {
        if ($request->ajax() && $request->isMethod('POST')) {
            
            switch ($request->get('type')) {
                case '_EMAIL':
                    $save = $this->saveEmail($request);
                    break;
                    
                case '_SLUG':
                    $save = $this->saveSlug($request);
                    break;
                
                case '_PASS':
                    $save = $this->savePassword($request);
                    break;
                
                case '_PERSONAL':
                    $save = $this->savePersonalInfo($request);
                    break;
                
                case '_CONTACT':
                    $save = $this->saveContactInfo($request);
                    break;
                
                case '_EMPLOYMENT':
                    $save = $this->saveEmployment($request);
                    break;
                
                case '_EDUCATION':
                    $save = $this->saveEducation($request);
                    break;
                
                case '_SKILL':
                    $save = $this->saveSkill($request);
                    break;

                default:
                    $save = false;
                    break;
            }
            
            $result = $this->_saveInfoResult($save);
            
            if (in_array(_error(), $result)) {
                return pong(['message' => $result['message']], _error(), $result['code']);
            }
            
            return pong($result);
        }
    }
    
    public function createAddressSelectData(Request $request) {
        if ($request->ajax() && $request->isMethod('POST')) {
            
            $target   = $request->get('target');
            $findId   = (int) $request->get('find_id');
            $city     = [$this->_getDefaultAddress('city')];
            $district = [$this->_getDefaultAddress('district')];
            $ward     = [$this->_getDefaultAddress('ward')];
            
            switch ($target) {
                case 'city':
                    $city = $this->_getCityByCountryId($findId);
                    break;
                    
                case 'district':
                    $district = $this->_getDistrictByCityId($findId);
                    break;
                
                case 'ward':
                    $ward = $this->_getWardByDistrictId($findId);
                    break;
            }
            
            $options = ['city' => $city, 'district' => $district, 'ward' => $ward];
           
            return pong(['options' => $options]);
        }
    }
    
    /**
     * Get employment history by id
     * 
     * @param Request $request
     * @param int     $id
     * 
     * @return JSON
     */
    public function getEmploymentHistoryById(Request $request, $id) {
        if ($request->ajax() && $request->isMethod('GET')) {
           
            $employment = EmploymentHistory::find($id);
            if (is_null($employment)) {
                return pong(['message' => _t('oops')], 403);
            }
            
            $isCurrent = $employment->is_current;
            $startDate = new \DateTime($employment->start_date);
            $endDate   = ($isCurrent) ? false : new \DateTime($employment->end_date);
            
            return pong(['data' => [
                'id'          => $employment->id,
                'name'        => $employment->company_name,
                'position'    => $employment->position,
                'start_month' => (strlen($sm = $startDate->format('d')) === 2) ? $sm : '0' . $sm,
                'start_year'  => $startDate->format('Y'),
                'end_month'   => ($isCurrent) ? null : ((strlen($em = $endDate->format('d')) === 2) ? $em : '0' . $em),
                'end_year'    => ($isCurrent) ? null : $endDate->format('Y'),
                'website'     => $employment->company_website,
                'is_current'  => $employment->is_current
            ]]);
        }
    }
    
    /**
     * Remove employment history by id
     * 
     * @param Request $request
     * 
     * @return JSON
     */
    public function removeEmploymentHistoryById(Request $request) {
        if ($request->ajax() && $request->isMethod('DELETE')) {
           
            $employment = EmploymentHistory::find((int) $request->get('id'));
            if (is_null($employment)) {
                return pong(['message' => _t('oops')], 403);
            }
            
            $employment->delete();
            
            return pong(['message' => _t('saved')]);
        }
    }
    
    /**
     * Remove education history by id
     * 
     * @param Request $request
     * 
     * @return JSON
     */
    public function removeEducationHistoryById(Request $request) {
        if ($request->ajax() && $request->isMethod('DELETE')) {

            $education = Education::find((int) $request->get('id'));
            if (is_null($education)) {
                return pong(['message' => _t('oops')], 403);
            }
            
            $education->delete();
            
            return pong(['message' => _t('saved')]);
        }
    }
    
    /**
     * Get education history by id
     * 
     * @param Request $request
     * @param int     $id
     * 
     * @return JSON
     */
    public function getEducationHistoryById(Request $request, $id) {
        if ($request->ajax() && $request->isMethod('GET')) {
           
            $education = Education::find($id);
            if (is_null($education)) {
                return pong(['message' => _t('oops')], 403);
            }
            
            $startDate = new \DateTime($education->start_date);
            $endDate   = new \DateTime($education->end_date);
            
            return pong(['data' => [
                'id'                 => $education->id,
                'name'               => $education->college_name,
                'subject'            => $education->subject,
                'qualification_id'   => $education->qualification_id,
                'qualification_name' => $education->qualification->name,
                'start_month'        => (strlen($sm = $startDate->format('d')) === 2) ? $sm : '0' . $sm,
                'start_year'         => $startDate->format('Y'),
                'end_month'          => (strlen($em = $endDate->format('d')) === 2) ? $em : '0' . $em,
                'end_year'           => $endDate->format('Y')
            ]]);
        }
    }

    /**
     * Get save info result
     * 
     * @param array|object $save
     * 
     * @return array
     */
    protected function _saveInfoResult($save) {
        if ($save instanceof EmploymentHistory) {
                
            if (empty($save->company_website)) {
                $websiteText = '';
            } elseif (str_contains($save->company_website, 'https')) {
                $websiteText = str_replace('https://', '', $save->company_website);
            }else if (str_contains($save->company_website, 'http')) {
                $websiteText = str_replace('http://', '', $save->company_website);
            }

            $workedDate = ($save->is_current) ? $save->start_date->format('m/Y') . ' - ' . _t('setting.employment.current') : $save->start_date->format('m/Y') . ' - ' . $save->end_date->format('m/Y');

            return [
                'message' => _t('good_job'), 
                'data'    => [
                    'id'           => $save->id,
                    'name'         => $save->company_name,
                    'position'     => $save->position,
                    'date'         => $workedDate,
                    'website_text' => $websiteText,
                    'website_href' => $save->company_website
            ]];
        } elseif($save instanceof Education){

            return [
                'message' => _t('good_job'), 
                'data'    => [
                    'id'            => $save->id,
                    'name'          => $save->college_name,
                    'subject'       => $save->subject,
                    'date'          => $save->start_date->format('m/Y') . ' - ' . $save->end_date->format('m/Y'),
                    'qualification' => $save->qualification->name,
                    'achievements'  => $save->achievements
            ]];
        } elseif($save instanceof Skill){
            return [
                'message' => _t('good_job'), 
                'data'    => [
                    'id'    => $save->id,
                    'name'  => $save->name,
                    'votes' => $save->votes
            ]];
        }elseif (true === $save) {
            return ['message' => _t('good_job')];
        } elseif(false !== $save) {
            return ['message' => $save->errors()->first(), _error(), 'code' => 403];
        } else {
            return ['message' => _t('good_job')];
        }
    }
    
    /**
     * Convert array of object to normal array [0 => '...', 1 => '...']
     * 
     * @param array  $places   List of cities or districts or wards
     * @param string $dataType Data type include object|aray
     * 
     * @return aray
     */
    protected function _placeObjectToArray($places, $dataType = 'array') {
        if ($dataType === 'array') {
            $placesArr = [];
            foreach ($places as $place) {
                $placesArr[($place->id === 0) ? '' : $place->id] = $place->name;
            }
            
            return $placesArr;
        }
        
        return $places;
    }

    /**
     * Get cities by country id.
     * 
     * @param int    $countryId Country id
     * @param string $dataType  Data type include object|array
     * 
     * @return array|\stdClass
     */
    protected function _getCityByCountryId($countryId = 0, $dataType = 'object') {
        
        $country = Country::find($countryId);
        $default = $this->_getDefaultAddress('city');
        $cities  = DB::table('cities')->select('id', 'name')
                                      ->where('country_id', $countryId)
                                      ->orderBy('type')
                                      ->orderBy('name')
                                      ->get();
        
        if ('VN' === $country->country_code) {
            $cities    = collect($cities)->splice(5);
            $bigCities = DB::table('cities')->select('id', 'name')->where('country_id', $countryId)->skip(0)->take(5)->get();
            $cities    = collect($bigCities)->merge($cities)->toArray();
        }
        
        if (count($cities)) {
            array_unshift($cities, $default);
        } else {
            $cities = [$default];
        }
        
        return $this->_placeObjectToArray($cities, $dataType);
    }
    
    /**
     * Get districts by city id.
     * 
     * @param int    $cityId   City id
     * @param string $dataType Data type include object|array
     * 
     * @return array|\stdClass
     */
    protected function _getDistrictByCityId($cityId = 0, $dataType = 'object') {
        
        $default   = $this->_getDefaultAddress('district');
        $districts = DB::table('districts')->select('id', DB::raw('CONCAT(type, " ", name) AS name'))
                                           ->where('city_id', $cityId)
                                           ->orderBy('name')
                                           ->get();
        
        if (count($districts)) {
            array_unshift($districts, $default);
        } else {
            $districts = [$default];
        }
        
        return $this->_placeObjectToArray($districts, $dataType);
    }
    
    /**
     * Get Wards by district id.
     * 
     * @param int    $districtId District id
     * @param string $dataType   Data type include object|array
     * 
     * @return array|\stdClass
     */
    protected function _getWardByDistrictId($districtId = 0, $dataType = 'object') {
        
        $default = $this->_getDefaultAddress('ward');
        $wards   = DB::table('wards')->select('id', DB::raw('CONCAT(type, " ", name) AS name'))
                                     ->where('district_id', $districtId)
                                     ->orderBy('name')
                                     ->get();
                             
        if (count($wards)) {
            array_unshift($wards, $default);
        } else {
            $wards = [$default];
        }
        
        return $this->_placeObjectToArray($wards, $dataType);
    }
    
    /**
     * Get default text for selection address.
     * 
     * @param string $type address type
     * 
     * @return \stdClass
     */
    protected function _getDefaultAddress($type) {
        $default     = new \stdClass();
        $default->id = 0;
        
        switch ($type) {
            case 'city':
                $default->name = _t('setting.profile.city');
                break;
            case 'district':
                $default->name = _t('setting.profile.district');
                break;
            case 'ward':
                $default->name = _t('setting.profile.ward');
                break;
            default:
                break;
        }
        
        return $default;
    }


    /**
     * Get avatar validation rules
     *
     * @return array
     */
    protected function _getAvatarRules() {
        return [
            '__file' => 'required|image|mimes:jpg,png,jpeg,gif|max:' . config('frontend.avatarMaxFileSize')
        ];
    }

    /**
     * Get avatar validation messages
     *
     * @return array
     */
    protected function _getAvatarMessages() {
        return [
            '__file.required' => _t('no_file'),
            '__file.image'    => _t('file_not_image'),
            '__file.mimes'    => _t('file_image_mimes'),
            '__file.max'      => _t('avatar_max', ['fileSize' => config('frontend.avatarMaxFileSizeMessage')]),
        ];
    }
    
    /**
     * Get cover validation rules
     *
     * @return array
     */
    protected function _getCoverRules() {
        return [
            '__file' => 'required|image|mimes:jpg,png,jpeg,gif|max:' . config('frontend.coverMaxFileSize')
        ];
    }

    /**
     * Get cover validation messages
     *
     * @return array
     */
    protected function _getCoverMessages() {
        return [
            '__file.required' => _t('no_file'),
            '__file.image'    => _t('file_not_image'),
            '__file.mimes'    => _t('file_image_mimes'),
            '__file.max'      => _t('avatar_max', ['fileSize' => config('frontend.coverMaxFileSizeMessage')]),
        ];
    }
}