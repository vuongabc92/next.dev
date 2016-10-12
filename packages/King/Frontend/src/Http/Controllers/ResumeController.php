<?php
/**
 * CV Controller
 */

namespace King\Frontend\Http\Controllers;

use App\Models\UserProfile;
use App\Models\User;
use App\Helpers\Theme\Resume;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;
use App\Helpers\Theme\ThemeCompiler;
use Illuminate\Filesystem\Filesystem;


class ResumeController extends FrontController {
    
    public function index($slug) {
        
        $userProfile = UserProfile::where('slug', $slug)->first();
        
        if (null === $userProfile) {
            throw new NotFoundHttpException;
        }
        
        
        
        //Read theme default.
        
        $resume    = $this->generateResumeData($userProfile->user_id);
        $themeName = 'default';
        $compiler  = new ThemeCompiler(new Filesystem, $resume, $themeName);
        $contents  = $compiler->compile();
        
        return new Response($contents);
    }
    
    /**
     * Generate resume data for show CV
     * 
     * @param int $user_id
     * 
     * @return App\Helper\Theme\Resume
     */
    protected function generateResumeData($user_id) {
        
        $resume = new Resume();
        $user   = User::find($user_id);
        
        $resume->setEmail($user->email);
        $resume->setFirstName($user->userProfile->first_name);
        $resume->setLastName($user->userProfile->last_name);
        $resume->setAvatarImages($user->userProfile->avatar_image);
        $resume->setCoverImages($user->userProfile->cover_image);
        $resume->setDob($user->userProfile->day_of_birth);
        $resume->setAboutMe($user->userProfile->about_me);
        $resume->setMaritalStatus(collect($user->userProfile->maritalStatus));
        $resume->setGender(collect($user->userProfile->gender));
        $resume->setCountry(collect($user->userProfile->country));
        $resume->setCity(collect($user->userProfile->city));
        $resume->setDistrict(collect($user->userProfile->district));
        $resume->setWard(collect($user->userProfile->ward));
        $resume->setStreetName($user->userProfile->street_name);
        $resume->setPhoneNumber($user->userProfile->phone_number);
        $resume->setWebsite($user->userProfile->website);
        $resume->setSocialNetworks($user->userProfile->social_network);
        $resume->setSkills($user->skills);
        $resume->setEmployments($user->employmentHistories);
        $resume->setEducations($user->educations);
        
        return $resume;
    }
    
//    function generateSetGetFunctions(){
//        $attributes = [
//            '1_string'  => 'avatar_images',
//            '2_string'  => 'cover_images',
//            '3_string' => 'email',
//            '4_string' => 'first_name',
//            '5_string' => 'last_name',
//            '6_string' => 'dob',
//            '7_\Illuminate\Support\Collection' => 'gender',
//            '8_\Illuminate\Support\Collection' => 'marital_status',
//            '9_string' => 'about_me',
//            '10_string' => 'street_name',
//            '11_\Illuminate\Support\Collection'  => 'country',
//            '12_\Illuminate\Support\Collection'  => 'city',
//            '13_\Illuminate\Support\Collection'  => 'district',
//            '14_\Illuminate\Support\Collection'  => 'ward',
//            '15_string' => 'phone_number',
//            '16_string' => 'website',
//            '17_string' => 'social_networks',
//            '18_\Illuminate\Support\Collection' => 'skills',
//            '19_\Illuminate\Support\Collection' => 'employments',
//            '20_\Illuminate\Support\Collection' => 'educations'
//        ];
//        
//        foreach ($attributes as $type => $attribute) {
//            
//            $attrSplit  = explode('_', $attribute);
//            $varComment = '';
//            $varName    = '';
//            $type       = explode('_', $type);
//            
//            if (count($attrSplit) > 1) {
//                foreach($attrSplit as $key => $item) {
//                    if ($key > 0) {
//                        $varName .= ucfirst($item);
//                    } else {
//                        $varName .= $item;
//                    }
//                    
//                    $varComment .= ucfirst($item) . ' ';
//                }
//            } else {
//                $varName    = $attribute;
//                $varComment = ucfirst($attribute);
//            }
//            
//            echo '/**<br>';
//            echo '&nbsp; * ' . $varComment . '<br>'; 
//            echo '&nbsp; *<br>';
//            echo '&nbsp; * @var ' . $type[1] . '<br>'; 
//            echo '&nbsp;&nbsp;*/<br>';
//            
//            echo 'protected $' . $varName . ';<br><br>';
//        }
//        
//        foreach ($attributes as $type => $attribute) {
//            
//            $attrSplit     = explode('_', $attribute);
//            $methodName    = '';
//            $methodComment = '';
//            $varName       = '';
//            $type          = explode('_', $type);
//            
//            if (count($attrSplit) > 1) {
//                foreach($attrSplit as $key => $item) {
//                    $methodName .= ucfirst($item);
//                    
//                    if ($key > 0) {
//                        $varName .= ucfirst($item);
//                    } else {
//                        $varName .= $item;
//                    }
//                    
//                    $methodComment .= $item . ' ';
//                }
//            } else {
//                $methodName = ucfirst($attribute);
//                $methodComment = $attribute;
//                $varName = $attribute;
//            }
//            
//            echo '/**<br>';
//            echo '&nbsp; * Get ' . $methodComment . '<br>'; 
//            echo '&nbsp; *<br>';
//            echo '&nbsp; * @return ' . $type[1] . '<br>'; 
//            echo '&nbsp;&nbsp;*/<br>';         
//            
//            echo 'public function get' . $methodName . '() {<br>';
//            echo '&nbsp;&nbsp;&nbsp;&nbsp;return $this->' . $varName . '; <br>';
//            echo '}<br><br>';
//            
//            echo '/**<br>';
//            echo '&nbsp; * Set ' . $methodComment . '<br>'; 
//            echo '&nbsp; *<br>';
//            echo '&nbsp; * @param ' . $type[1] . ' $' . $varName . '<br>'; 
//            echo '&nbsp;&nbsp;*/<br>';    
//            
//            echo 'public function set' . $methodName . '($' . $varName . ') {<br>';
//            echo '&nbsp;&nbsp;&nbsp;&nbsp;$this->' . $varName . ' = $' . $varName . ';<br>';
//            echo '}<br><br>';
//        }
//    }
}