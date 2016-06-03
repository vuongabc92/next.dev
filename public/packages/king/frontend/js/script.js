$.ajaxSetup({
    headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
});

/**
 * AJAX upload file
 */
AIM = {
    frame: function(c) {
        var n = 'f' + Math.floor(Math.random() * 99999);
        var d = document.createElement('DIV');
        d.innerHTML = '<iframe style="display:none" '
                + 'src="about:blank" id="' + n + '" '
                + 'name="' + n + '"'
                + 'onload="AIM.loaded(\'' + n + '\')"></iframe>';
        document.body.appendChild(d);

        var i = document.getElementById(n);
        if (c && typeof (c.onComplete) == 'function') {
            i.onComplete = c.onComplete;
        }
        return n;
    },
    form: function(f, name) {
        f.setAttribute('target', name);
    },
    submit: function(f, c) {
        AIM.form(f, AIM.frame(c));
        if (c && typeof (c.onStart) == 'function') {
            return c.onStart();
        } else {
            return true;
        }
    },
    loaded: function(id) {
        var i = document.getElementById(id);
        //alert(i.parentNode.innerHTML);
        if (i.contentDocument) {
            var d = i.contentDocument;
        } else if (i.contentWindow) {
            var d = i.contentWindow.document;
        } else {
            var d = window.frames[id].document;
        }
        //alert(d.location.href);
        if (d.location.href == "about:blank")
            return;
        if (typeof (i.onComplete) == 'function') {
            i.onComplete(d.body.innerHTML);
        }
    }
}

/* Publish profile switcher */
$("[name='publish_profile']").bootstrapSwitch({
    size: 'mini',
    handleWidth: 3,
    labelWidth: 3,
    onText: '',
    offText: '',
    inverse: true,
    onSwitchChange: function (event, state) {
        
        var form = $(this).closest('form');
        
        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: {publish_state: state},
            success: function() {
                $('.inline-notification.success').addClass('show-animation');
                setTimeout(function(){
                    $('.inline-notification.success').removeClass('show-animation');
                }, 2000);
            },
            error: function(){
                $('.inline-notification.error').addClass('show-animation');
                setTimeout(function(){
                    $('.inline-notification.error').removeClass('show-animation');
                }, 2000);
            }
        });
    }
});

function showMessage(message, error) {

    var msgBlock = $('.setting-messages'),
        msgText  = $('#message');
    
    if (error === 'success') {
        msgBlock.removeClass('error').addClass('success');
    } else {
        msgBlock.removeClass('success').addClass('error');
    }
    
    msgText.html(message);
    msgBlock.show();
    
    var showErrorMsg = setTimeout(function(){
        msgBlock.hide();
    }, 4000);

    msgBlock.on('click', function(){
       $(this).hide();
       clearTimeout(showErrorMsg);
    });
    
    return showErrorMsg;
}

/**
 *  @name Required
 *  @description
 *  @version 1.0
 *  @options
 *    option
 *  @events
 *    event
 *  @methods
 *    init
 *    publicMethod
 *    destroy
 */
;
(function($, window, undefined) {
    var pluginName = 'required';

    function Plugin(element, options) {
        this.element = $(element);
        this.options = $.extend({}, $.fn[pluginName].defaults, options);
        this.init();
    }

    Plugin.prototype = {
        init: function() {
            var current    = this.element,
                fields     = current.data('required'),
                fieldArray = fields.split('|'),
                empty      = false;

            current.on('submit', function() {
                $.each(fieldArray, function(k, v) {
                    if ($('#' + v).val().trim() === '') {
                        $('#' + v).focus();
                        empty = true;

                        return false;
                    }
                });

                if (empty) {
                    return false;
                }
            });
        },
        destroy: function() {
            $.removeData(this.element[0], pluginName);
        }
    };

    $.fn[pluginName] = function(options, params) {
        return this.each(function() {
            var instance = $.data(this, pluginName);
            if (!instance) {
                $.data(this, pluginName, new Plugin(this, options));
            } else if (instance[options]) {
                instance[options](params);
            } else {
                window.console && console.log(options ? options + ' method is not exists in ' + pluginName : pluginName + ' plugin has been initialized');
            }
        });
    };

    $.fn[pluginName].defaults = {
        option: 'value'
    };

    $(function() {
        $('[data-' + pluginName + ']')[pluginName]();
    });

}(jQuery, window));

/**
 *  @name Trigger event
 *  @description
 *  @version 1.0
 *  @options
 *    option
 *  @events
 *    event
 *  @methods
 *    init
 *    publicMethod
 *    destroy
 */
;
(function($, window, undefined) {
    var pluginName = 'event-trigger';

    function Plugin(element, options) {
        this.element = $(element);
        this.options = $.extend({}, $.fn[pluginName].defaults, options);
        this.init();
    }

    Plugin.prototype = {
        init: function() {
            var current    = this.element,
                target     = $(current.data('event-trigger')),
                events     = current.data('event'),
                eventArray = events.split('|'),
                firstEvent = eventArray[0],
                lastEvent  = eventArray[1];

            current.on(firstEvent, function(){
                switch(lastEvent) {
                    case 'click':
                        target.click();
                        break;
                    case 'submit':
                        target.submit();
                        break;
                }
            });
        },
        destroy: function() {
            $.removeData(this.element[0], pluginName);
        }
    };

    $.fn[pluginName] = function(options, params) {
        return this.each(function() {
            var instance = $.data(this, pluginName);
            if (!instance) {
                $.data(this, pluginName, new Plugin(this, options));
            } else if (instance[options]) {
                instance[options](params);
            } else {
                window.console && console.log(options ? options + ' method is not exists in ' + pluginName : pluginName + ' plugin has been initialized');
            }
        });
    };

    $.fn[pluginName].defaults = {
        option: 'value'
    };

    $(function() {
        $('[data-' + pluginName + ']')[pluginName]();
    });

}(jQuery, window));

/**
 *  @name Upload Avatar
 *  @description
 *  @version 1.0
 *  @options
 *    option
 *  @events
 *    event
 *  @methods
 *    init
 *    publicMethod
 *    destroy
 */
;
(function($, window, undefined) {
    var pluginName = 'upload-avatar';

    function Plugin(element, options) {
        this.element = $(element);
        this.options = $.extend({}, $.fn[pluginName].defaults, options);
        this.init();
    }

    Plugin.prototype = {
        init: function() {
            var current   = this.element,
                avatar    = current.parent('.avatar'),
                editBtn   = avatar.children('.edit-btn'),
                fileInput = current.children('#avatar_file_input'),
                msgBlock  = $('.setting-messages');
            
            current.on('submit', function(){
                return AIM.submit(this, {
                    onStart: function() {
                        editBtn.addClass('show-edit-btn');
                        editBtn.children('i').hide();
                        editBtn.children('img').show();
                    },
                    onComplete: function(response){
                        response = $.parseJSON(response);
                        
                        if (response.status === SETTINGS.AJAX_OK) {
                            avatar.children('.avatar-img').attr('src', response.avatar_medium);
                        } else {
                            msgBlock.show();
                            $('#message').html(response.messages);
                            
                            setTimeout(function(){
                                msgBlock.hide();
                            }, 4000);
                        }
                        
                        editBtn.removeClass('show-edit-btn');
                        editBtn.children('i').show();
                        editBtn.children('img').hide();
                        fileInput.val('');
                    }
                });
            });
        },
        destroy: function() {
            $.removeData(this.element[0], pluginName);
        }
    };

    $.fn[pluginName] = function(options, params) {
        return this.each(function() {
            var instance = $.data(this, pluginName);
            if (!instance) {
                $.data(this, pluginName, new Plugin(this, options));
            } else if (instance[options]) {
                instance[options](params);
            } else {
                window.console && console.log(options ? options + ' method is not exists in ' + pluginName : pluginName + ' plugin has been initialized');
            }
        });
    };

    $.fn[pluginName].defaults = {
        option: 'value'
    };

    $(function() {
        $('[data-' + pluginName + ']')[pluginName]();
    });

}(jQuery, window));

/**
 *  @name Upload Cover
 *  @description
 *  @version 1.0
 *  @options
 *    option
 *  @events
 *    event
 *  @methods
 *    init
 *    publicMethod
 *    destroy
 */
;
(function($, window, undefined) {
    var pluginName = 'upload-cover';

    function Plugin(element, options) {
        this.element = $(element);
        this.options = $.extend({}, $.fn[pluginName].defaults, options);
        this.init();
    }

    Plugin.prototype = {
        init: function() {
            var current   = this.element,
                cover     = current.parent('.cover'),
                editBtn   = cover.children('.edit-btn'),
                fileInput = current.children('#cover_file_input'),
                msgBlock  = $('.setting-messages');
            
            current.on('submit', function(){
                return AIM.submit(this, {
                    onStart: function() {
                        editBtn.addClass('show-edit-btn');
                        editBtn.children('i').hide();
                        editBtn.children('img').show();
                    },
                    onComplete: function(response){
                        response = $.parseJSON(response);
                        
                        if (response.status === SETTINGS.AJAX_OK) {
                            cover.css('background-image', 'url(' + response.cover_medium + ')');
                        } else {
                            msgBlock.show();
                            $('#message').html(response.messages);
                            
                            setTimeout(function(){
                                msgBlock.hide();
                            }, 4000);
                        }
                        
                        editBtn.removeClass('show-edit-btn');
                        editBtn.children('i').show();
                        editBtn.children('img').hide();
                        fileInput.val('');
                    }
                });
            });
        },
        destroy: function() {
            $.removeData(this.element[0], pluginName);
        }
    };

    $.fn[pluginName] = function(options, params) {
        return this.each(function() {
            var instance = $.data(this, pluginName);
            if (!instance) {
                $.data(this, pluginName, new Plugin(this, options));
            } else if (instance[options]) {
                instance[options](params);
            } else {
                window.console && console.log(options ? options + ' method is not exists in ' + pluginName : pluginName + ' plugin has been initialized');
            }
        });
    };

    $.fn[pluginName].defaults = {
        option: 'value'
    };

    $(function() {
        $('[data-' + pluginName + ']')[pluginName]();
    });

}(jQuery, window));

/**
 *  @name Show form
 *  @description Show settings form
 *  @version 1.0
 *  @options
 *    option
 *  @events
 *    event
 *  @methods
 *    init
 *    publicMethod
 *    destroy
 */
;
(function($, window, undefined) {
    var pluginName = 'show-form';

    function Plugin(element, options) {
        this.element = $(element);
        this.options = $.extend({}, $.fn[pluginName].defaults, options);
        this.init();
    }

    Plugin.prototype = {
        init: function() {
            var current = this.element;
                current.on('click', function(){
                    var section = current.closest('section');
                    
                    $('.settings section').addClass('_disable');
                    section.removeClass('_disable');
                    section.find('.settings-show').hide();
                    section.find('form').show();
                });
            
        },
        destroy: function() {
            $.removeData(this.element[0], pluginName);
        }
    };

    $.fn[pluginName] = function(options, params) {
        return this.each(function() {
            var instance = $.data(this, pluginName);
            if (!instance) {
                $.data(this, pluginName, new Plugin(this, options));
            } else if (instance[options]) {
                instance[options](params);
            } else {
                window.console && console.log(options ? options + ' method is not exists in ' + pluginName : pluginName + ' plugin has been initialized');
            }
        });
    };

    $.fn[pluginName].defaults = {
        option: 'value'
    };

    $(function() {
        $('[data-' + pluginName + ']')[pluginName]();
    });

}(jQuery, window));

/**
 *  @name Hide Form
 *  @description Hide settings form
 *  @version 1.0
 *  @options
 *    option
 *  @events
 *    event
 *  @methods
 *    init
 *    publicMethod
 *    destroy
 */
;
(function($, window, undefined) {
    var pluginName = 'hide-form';

    function Plugin(element, options) {
        this.element = $(element);
        this.options = $.extend({}, $.fn[pluginName].defaults, options);
        this.init();
    }

    Plugin.prototype = {
        init: function() {
            var current = this.element;
                
                current.on('click', function(e){
                    var section      = current.closest('section'),
                        settingsForm = section.find('form'),
                        requires     = (settingsForm.data('requires').trim() !== '') ? settingsForm.data('requires').split('|') : [];
                    
                    if (settingsForm.find('[name="type"]').val() !== '_PASS') {
                        e.preventDefault();
                    }
                    
                    $('.settings section').removeClass('_disable');
                    section.find('.settings-show').show();
                    settingsForm.hide();
                    
                    if ($.isArray(requires) && requires.length) {
                        $.each(requires, function(k, v){
                            $('[name=' + v + ']').removeClass('error');
                        });
                    }
                });
            
        },
        destroy: function() {
            $.removeData(this.element[0], pluginName);
        }
    };

    $.fn[pluginName] = function(options, params) {
        return this.each(function() {
            var instance = $.data(this, pluginName);
            if (!instance) {
                $.data(this, pluginName, new Plugin(this, options));
            } else if (instance[options]) {
                instance[options](params);
            } else {
                window.console && console.log(options ? options + ' method is not exists in ' + pluginName : pluginName + ' plugin has been initialized');
            }
        });
    };

    $.fn[pluginName].defaults = {
        option: 'value'
    };

    $(function() {
        $('[data-' + pluginName + ']')[pluginName]();
    });

}(jQuery, window));

/**
 *  @name Save info
 *  @description
 *  @version 1.0
 *  @options
 *    option
 *  @events
 *    event
 *  @methods
 *    init
 *    publicMethod
 *    destroy
 */
;
(function($, window, undefined) {
    var pluginName = 'save-form';

    function Plugin(element, options) {
        this.element = $(element);
        this.options = $.extend({}, $.fn[pluginName].defaults, options);
        this.init();
    }

    Plugin.prototype = {
        init: function() {
            var current     = this.element,
                requires    = (current.data('requires').trim() !== '') ? current.data('requires').split('|') : [];   
            current.on('submit', function(e){
                e.preventDefault();
                var everythingOk = true,
                    submitBtn    = current.find(':submit'),
                    submitLabel  = submitBtn.html(),
                    loadingImg   = '<img class="loading-inbtn" src="' + SETTINGS.LOADING_BLUE_NAVY_24 + '" />';
                if ($.isArray(requires) && requires.length) {
                    $.each(requires, function(k, v){
                        var field = $('[name=' + v + ']');
                        if (field.val() === '') {
                            field.addClass('error');
                            everythingOk = false;
                        } else {
                            field.removeClass('error');
                        }
                    });
                }
                
                if ( ! everythingOk) {
                    return false;
                }
                
                $.ajax({
                    type: current.attr('method'),
                    url: current.attr('action'),
                    data: current.serialize(),
                    dataType: 'json',
                    error: function(xhr, status, error) {
                        var response = $.parseJSON(xhr.responseText);
                        showMessage(response.message, 'error');
                    },
                    beforeSend: function(){
                        submitBtn.html(loadingImg);
                    },
                    success: function(response){
                        if (current.find('[name="type"]').val() === '_SLUG') {
                            var currentSlug = $('.current-slug'),
                                slugSplit   = currentSlug.html().trim().split('/');
                            
                            currentSlug.html(slugSplit[0] + '/' + current.find('[name="slug"]').val());
                            
                            $('a.current-slug').attr('href', 'http://' + slugSplit[0] + '/' + current.find('[name="slug"]').val());
                        }
                        
                        showMessage(response.message, 'success');
                        submitBtn.html('<i class="fa fa-check"></i>');
                        setTimeout(function(){
                            submitBtn.html(submitLabel);
                            current.find('button[type=reset]').click();
                        }, 1000);
                        
                    },
                    complete: function() {
                        
                    }
                });
                
                return false;
            });
        },
        destroy: function() {
            $.removeData(this.element[0], pluginName);
        }
    };

    $.fn[pluginName] = function(options, params) {
        return this.each(function() {
            var instance = $.data(this, pluginName);
            if (!instance) {
                $.data(this, pluginName, new Plugin(this, options));
            } else if (instance[options]) {
                instance[options](params);
            } else {
                window.console && console.log(options ? options + ' method is not exists in ' + pluginName : pluginName + ' plugin has been initialized');
            }
        });
    };

    $.fn[pluginName].defaults = {
        option: 'value'
    };

    $(function() {
        $('[data-' + pluginName + ']')[pluginName]();
    });

}(jQuery, window));

/**
 *  @name Selecter
 *  @description
 *  @version 1.0
 *  @options
 *    option
 *  @events
 *    event
 *  @methods
 *    init
 *    publicMethod
 *    destroy
 */
;
(function($, window, undefined) {
    var pluginName = 'selecter';

    function Plugin(element, options) {
        this.element = $(element);
        this.options = $.extend({}, $.fn[pluginName].defaults, options);
        this.init();
    }

    Plugin.prototype = {
        init: function() {
            var current = this.element,
                select  = current.find('select'),
                label   = current.find('label');
                
            select.on('change', function(e){
                label.html($(this).find('option[value="' + $(this).val() + '"]').text());
            });
        },
        destroy: function() {
            $.removeData(this.element[0], pluginName);
        }
    };

    $.fn[pluginName] = function(options, params) {
        return this.each(function() {
            var instance = $.data(this, pluginName);
            if (!instance) {
                $.data(this, pluginName, new Plugin(this, options));
            } else if (instance[options]) {
                instance[options](params);
            } else {
                window.console && console.log(options ? options + ' method is not exists in ' + pluginName : pluginName + ' plugin has been initialized');
            }
        });
    };

    $.fn[pluginName].defaults = {
        option: 'value'
    };

    $(function() {
        $('[data-' + pluginName + ']')[pluginName]();
    });

}(jQuery, window));