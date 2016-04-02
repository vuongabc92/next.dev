<?php
/**
 * Help functions.
 */

if ( ! function_exists('_t')) :

    /**
     * Translate the given message.
     *
     * @param  string  $id
     * @param  array   $parameters
     * @param  string  $domain
     * @param  string  $locale
     *
     * @return string
     */
    function _t($id = null, $parameters = [], $domain = 'messages', $locale = null) {
        return trans("frontend::frontend.{$id}", $parameters, $domain, $locale);
    }

endif; // Function _t.

if ( ! function_exists('_error') ) {
    /**
     * Get AJAX error status string
     * 
     * @return string
     */
    function _error() {
        return 'ERROR';
    }
}

if ( ! function_exists('_ok') ) {
    /**
     * Get AJAX success status string
     * 
     * @return string
     */
    function _ok() {
        return 'OK';
    }
}

if ( ! function_exists('pong')) :
    
    /**
     * Return a new simple JSON response from the application.
     *
     * @param  string|array $messages
     * @param  string       $status 0 = ERROR and 1 = OK
     * @param  int          $status_code
     * @param  array        $headers
     * @param  int          $options
     *
     * @return \Illuminate\Http\JsonResponse
     */
    function pong($messages, $status = 'OK', $status_code = 200, array $headers = [], $options = 0) {

        if (is_array($messages)) {
            $data = array_merge(['status'   => $status], $messages);
        } else {
            $data = [
                'status'   => $status,
                'messages' => $messages
            ];
        }

        return response()->json($data, $status_code, $headers, $options);
    }
    
endif; // Function pong.

if ( ! function_exists('file_pong')) :
    
    /**
     * Return a new JSON response from the application.
     *
     * @param  string|array  $data
     * @param  int           $status
     * @param  int           $options
     *
     * @return \Illuminate\Http\JsonResponse
     */
    function file_pong($messages, $status = 'OK', $status_code = 200, array $headers = ['Content-Type' => 'text/html'], $options = 0) {
        return pong($messages, $status, $status_code, $headers, $options );
    }
    
endif; // Function file_pong.

if ( ! function_exists('user')) :
    /**
     * Current authenticated user
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    function user() {
        if (auth()->check()) {
            return auth()->user();
        }

        return null;
    }
endif; // Function user.

if ( ! function_exists('str_equal')) :
    /**
     * Compares two strings using a constant-time algorithm.
     *
     * Note: This method will leak length information.
     *
     * Note: Adapted from Symfony\Component\Security\Core\Util\StringUtils.
     *
     * @param  string  $knownString
     * @param  string  $userInput
     *
     * @return bool
     */
    function str_equal($knownString, $userInput) {
        return \Illuminate\Support\Str::equals($knownString, $userInput);
    }
endif;

if ( ! function_exists('remove_rules')) :
    /**
     * Remove one or many rules in a list of rules
     *
     * @param array        $rules       List of rules will be removed out
     * @param array|string $rulesRemove Rule to be found in $rules to remove
     *
     * @return array
     */
    function remove_rules($rules, $rulesRemove) {

        //Remove list rules
        if (is_array($rulesRemove) && count($rulesRemove)) {
            foreach ($rulesRemove as $one) {
                $rules = remove_rules($rules, $one);
            }

            return $rules;
        }

        /**
         * Remove rule string
         * 1. If rule contains dot "." then remove rule after dot for rule name
         *    before the dot.
         * 2. If rule doesn't contain dot then remove the rule name present
         *
         */
        if (is_string($rulesRemove)) {

            if (str_contains($rulesRemove, '.')) {
                $ruleInField = explode('.', $rulesRemove);
                if (isset($rules[$ruleInField[0]])) {
                    $ruleSplit = explode('|', $rules[$ruleInField[0]]);
                    $ruleFlip  = array_flip($ruleSplit);

                    if (isset($ruleFlip[$ruleInField[1]])) {
                        unset($ruleSplit[$ruleFlip[$ruleInField[1]]]);
                    }

                    //Remove the rule name if it contains no rule
                    if (count($ruleSplit)) {
                        $rules[$ruleInField[0]] = implode('|', $ruleSplit);
                    } else {
                        unset($rules[$ruleInField[0]]);
                    }
                }

            } elseif (isset($rules[$rulesRemove])) {
                unset($rules[$rulesRemove]);
            }

            return $rules;
        }

        return $rules;
    }
endif;

if ( ! function_exists('generate_filename')) :
    /**
     * Generate the file name base on current user id, time
     * to get a unique file in present directory
     *
     * @param string $directory Path to the upload directory
     * @param string $extension File extension
     * @param array  $options   Prefix, suffix,...
     *
     * @return string
     */
    function generate_filename($directory, $extension, $options = []) {

        $microtime = microtime(true);
        $randStr   = str_random(10);
        
        // A specify key, default is zero.
        if (isset($options['key'])) {
            $key = $options['key'];
        } elseif(auth()->check()) {
            $key = user()->id;
        } else {
            $key = 0;
        }

        $prefix = isset($options['prefix']) ? $options['prefix']  : '';
        $suffix = isset($options['suffix']) ? $options['suffix']  : '';
        $limit  = isset($options['limit'])  ? (int) $options['limit'] : 16;
        $md5Str = md5($key . $microtime . $randStr);
        
        if ($limit) {
            $md5Str = str_limit($md5Str, $limit, '');
        }
        
        $fileName = $prefix . $md5Str . $suffix . '.' . $extension;

        while (check_file($directory . $fileName)) {
            $fileName = generate_filename($directory, $extension . $prefix);
        }

        return $fileName;
    }
endif;

if ( ! function_exists('check_file')) :
    /**
     * Check does the present file exist
     *
     * @param string $file Path to file
     *
     * @return boolean
     */
    function check_file($file) {

        if ( ! is_dir($file) && file_exists($file)) {
            return true;
        }

        return false;
    }
endif;

if ( ! function_exists('delete_file')) :
    /**
     * Delete file
     *
     * @param string|array $file
     *
     * @return boolean
     *
     * @throws \Exception
     */
    function delete_file($file) {

        //Delete list of files
        if (is_array($file) && count($file)) {
            foreach ($file as $one) {
                delete_file($one);
            }

            return true;
        }

        if (check_file($file)) {
            try {
                \Illuminate\Support\Facades\File::delete($file);
            } catch (Exception $ex) {
                throw new \Exception('Whoop!! Can not delete file. ' . $ex->getMessage());
            }
        }

        return true;
    }
endif;

if ( ! function_exists('make_random_string') ) :
    /**
     * Make a random string
     * 
     * @param string $id     A unique string
     * @param string $prefix String prefix
     * @param string $suffix String suffix
     * @param string $limit  Max length of string
     * 
     * @return string A random string
     */
    function make_random_string($id, $prefix = '', $suffix = '', $limit = 16) {
        $md5String   = md5($id . microtime(true) . str_random());
        $limitString = str_limit($md5String, $limit, '');
        
        return $prefix . $limitString . $suffix;
    }
endif;
