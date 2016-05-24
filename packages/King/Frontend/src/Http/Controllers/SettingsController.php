<?php
/**
 * Setting Controller
 */

namespace King\Frontend\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserProfile;
use Validator;
use Intervention\Image\Facades\Image as ImageIntervention;

class SettingsController extends FrontController {
    
    /**
     * Display settings page
     * 
     * @return Response
     */
    public function index() {
        $userProfile       = is_null(user()->userProfile) ? new UserProfile() : user()->userProfile;
        $avatarMediumSize  = (int) config('frontend.avatarMedium');
        $coverMediumSize   = (int) config('frontend.coverMediumW');
        $avatar            = unserialize($userProfile->avatar_image);
        $cover             = unserialize($userProfile->cover_image);
        $avatarStoragePath = config('frontend.avatarsFolder');
        $coverStoragePath  = config('frontend.coversFolder');
        $avatarMedium      = isset($avatar[$avatarMediumSize]) ? $avatarStoragePath . '/' . $avatar[$avatarMediumSize] : '';
        $coverMedium       = isset($cover[$coverMediumSize])   ? $coverStoragePath . '/' . $cover[$coverMediumSize]    : '';
        
        return view('frontend::settings.index', [
            'userProfile'  => $userProfile,
            'avatarMedium' => $avatarMedium,
            'coverMedium'  => $coverMedium,
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
                    $userProfile               = new UserProfile();
                    $userProfile->user_id      = user()->id;
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
            
            return file_pong(['messages' => _t('opps')], _error(), 403);
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
                $avatar       = $request->file('__file');
                $storagePath  = config('frontend.coversFolder');
                $mediumSizeW  = (int) config('frontend.coverMediumW');
                $mediumSizeH  = (int) config('frontend.coverMediumH');
                $mediumName   = generate_filename($storagePath, $avatar->getClientOriginalExtension(), [
                    'prefix' => 'avatar_', 
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
                    $userProfile           = new UserProfile();
                    $userProfile->user_id  = user()->id;
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
            
            return file_pong(['messages' => _t('opps')], _error(), 403);
        }
    }
    
    public function saveInfo(Request $request) {
        if ($request->ajax() && $request->isMethod('POST')) {
            $type     = $request->get('save_info_type');
            $password = $request->get('password');
            $email    = $request->get('email');
            var_dump('<pre>', $password, $email, $type);
            die('^^!');
        }
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