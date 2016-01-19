<?php
/**
 * Help functions
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

endif; // Function _t