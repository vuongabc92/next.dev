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
    
    /**
     * Find and display the match resume.
     * 
     * @param string $slug
     * 
     * @return Response
     * 
     * @throws NotFoundHttpException
     */
    public function index($slug) {
        
        $userProfile = UserProfile::where('slug', $slug)->first();
        
        if (null === $userProfile) {
            throw new NotFoundHttpException;
        }
        
        if ($userProfile->theme_id === null) {
            $themeName = config('frontend.defaultThemeName');
        } else {
            $themeName = $userProfile->theme_id;
        }
        
        $resume   = $this->generateResumeData($userProfile->user_id);
        $compiler = new ThemeCompiler(new Filesystem, $resume, $themeName);
        $contents = $compiler->compile();
        
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
        $resume->setExpectedJob($user->userProfile->expected_job);
        $resume->setHobbies($user->userProfile->hobbies);
        
        return $resume;
    }
}