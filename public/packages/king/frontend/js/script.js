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

function selectorStatus(element, status) {
    
    if ($.isArray(element)) {
        $.each(element, function(k, v){
            selectorStatus(v, status);
        });
    } else {
        if (typeof status === 'undefined' || status === null) { 
            status = 'disable'; 
        }

        if (status === 'enable') {
            element.attr('disabled', false).parent('.selecter').css({opacity: '1'});
            element.attr('disabled', false).parent('.selecter').css({opacity: '1'});
        } else {
            element.attr('disabled', true).parent('.selecter').css({opacity: '0.5'});
            element.attr('disabled', true).parent('.selecter').css({opacity: '0.5'});
        }
    }
}

// Enable or disable employment history end day
$('#current-company').on('change', function(){
    var form     = $(this).closest('form'),
        endMonth = form.find('[name="end_month"]'),
        endYear  = form.find('[name="end_year"]'),
        requires = form.data('requires').split('|');
        
    if ($(this).is(':checked')) {
        requires = jQuery.grep(requires, function(value){
            return value !== 'end_month' && value !== 'end_year';
        }); 
        
        form.attr('data-requires', requires.join('|'));
        form.data('requires', requires.join('|'));
        endMonth.parent('.selecter').removeClass('error');
        endYear.parent('.selecter').removeClass('error');
        selectorStatus([endMonth, endYear]);
    } else {
        form.attr('data-requires', requires.join('|') + '|end_month|end_year');
        form.data('requires', requires.join('|') + '|end_month|end_year');
        selectorStatus([endMonth, endYear], 'enable');
    }
});

/**
 * append skill suggestion on add skill input field
 */
$('.skill-suggestion').on('click', 'li', function(){
    $('.skill-suggestion').parents('form').find('[name=skill]').val($(this).text());
    $('.skill-suggestion').hide();
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
                    var field = current.find('[name=' + v + ']');
                    
                    if (field.val().trim() === '') {
                        field.addClass('error');
                        field.focus();
                        
                        empty = true;
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
                        editBtn.attr('disabled', true);
                        editBtn.css("background-color", "rgba(0, 0, 0, 0.7)");
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
                        editBtn.attr('disabled', false);
                        editBtn.css("background-color", "rgba(0, 0, 0, 0.5)");
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
                        editBtn.attr('disabled', true);
                        editBtn.css("background-color", "rgba(0, 0, 0, 0.7)");
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
                        editBtn.attr('disabled', false);
                        editBtn.css("background-color", "rgba(0, 0, 0, 0.5)");
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
                    requires     = (settingsForm.data('requires').trim() !== '') ? settingsForm.data('requires').split('|') : [],
                    saveFormType = settingsForm.find('[name="type"]').val();

                if ('_PASS' !== saveFormType && '_EMPLOYMENT' !== saveFormType && '_EDUCATION' !== saveFormType) {
                    e.preventDefault();
                }

                if ('_EMPLOYMENT' === saveFormType || '_EDUCATION' === saveFormType) {
                    $.each(settingsForm.find('select'), function(k, field){
                        $(field).next('label').html($(field).find('option:first').html()).addClass('_tga').removeClass('_tg7');
                        $(field).attr('disabled', false).parent('.selecter').css({opacity: '1'});
                        settingsForm.find('[name="id"]').remove();
                    });
                }

                $('.settings section').removeClass('_disable');
                section.find('.settings-show').show();
                settingsForm.hide();

                if ($.isArray(requires) && requires.length) {
                    $.each(requires, function(k, v){
                        var field = $('[name=' + v + ']');

                        if (field.is('select')) {
                            field.parent('.selecter').removeClass('error');
                        } else if(field.is(':checkbox')) {
                            field.next('.settings-label').removeClass('error');
                        } else {
                            field.removeClass('error');
                        }
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
            var current = this.element,
                that    = this;
            
            current.on('submit', function(e){
                
                e.preventDefault();
                
                var submitBtn   = current.find(':submit'),
                    submitLabel = submitBtn.html(),
                    require     = that.require(),
                    loadSrc     = (submitBtn.hasClass('_btn-blue-navy')) ? SETTINGS.LOADING_BLUE_NAVY_24 : SETTINGS.LOADING_GRAY_24,
                    loadingImg  = '<img class="loading-inbtn" src="' + loadSrc + '" />';
                    
                if ( ! require) {
                    return false;
                }
                
                submitBtn.attr('disabled', true);
                
                $.ajax({
                    type: current.attr('method'),
                    url: current.attr('action'),
                    data: current.serialize(),
                    dataType: 'json',
                    beforeSend: function(){
                        submitBtn.html(loadingImg);
                    },
                    success: function(response){
                        var formType = current.find('[name="type"]').val();
                        
                        if (formType === '_SLUG') {
                            var currentSlug = $('.current-slug'),
                                slugSplit   = currentSlug.html().trim().split('/');
                            
                            currentSlug.html(slugSplit[0] + '/' + current.find('[name="slug"]').val());
                            
                            $('a.current-slug').attr('href', 'http://' + slugSplit[0] + '/' + current.find('[name="slug"]').val());
                        }
                        
                        if (formType === '_PERSONAL') {
                            var personalText = current.data('personalintro-text'),
                                personalYear = current.data('persioninfo-year'),
                                firstName    = current.find('[name="first_name"]').val().trim(),
                                lastName     = current.find('[name="last_name"]').val(),
                                year         = current.find('[name="year"]').val().trim(),
                                currentYear  = new Date().getFullYear();
                        
                                if (firstName !== '' && year !== '') {
                                    $('.personal-intro').html(lastName + ' ' + firstName + ', ' + (parseInt(currentYear) - parseInt(year)) + ' ' + personalYear);
                                } else {
                                    $('.personal-intro').html(personalText);
                                }
                        }
                        
                        if (formType === '_EMPLOYMENT') {
                            var employment = response.data,
                                section    = '<div class="_fwfl timeline-section" id="timeline-section-' + employment.id + '"><div class="timeline-point"></div><div class="timeline-content">',
                                name       = '<h4>' + employment.name + '</h4>',
                                position   = '<b class="position">' + employment.position + '</b>',
                                time       = '<div class="time"><b><i class="fa fa-calendar"></i></b><span>' + employment.date + '</span></div>',
                                achieve    = '<span class="achieve">' + employment.achievement + '</span>',
                                button     = '<button class="btn _btn timeline-btn timeline-edit" data-update-employment-id="' + employment.id + '"><i class="fa fa-pencil"></i></button>',
                                button     = button + '<button class="btn _btn timeline-btn timeline-remove" data-remove-employment-id="' + employment.id + '"><i class="fa fa-remove"></i></button>',
                                link       = ('' !== employment.website_text) ? '<a href="' + employment.website_href + '" target="_blank">' + employment.website_text + '</a>' : '';
                                
                                if(current.find('[name="id"]').length) {
                                    var editSection = $('.employment-timeline #timeline-section-' + employment.id);
                                    editSection.find('h4').html(employment.name);
                                    editSection.find('.position').html(employment.position);
                                    editSection.find('.achieve').html(employment.achievement);
                                    editSection.find('.time span').html(employment.date);
                                    editSection.find('a').html(employment.website_text).attr('href', employment.website_href);
                                } else {
                                    var timelineSection = section + name + position + link + achieve + time + button + '</div></div>';
                                    
                                    $(timelineSection).insertBefore('.employment-timeline .default-timeline');
                                }
                        }
                        
                        if (formType === '_EDUCATION') {
                            var education     = response.data,
                                section       = '<div class="_fwfl timeline-section" id="timeline-section-' + education.id + '"><div class="timeline-point"></div><div class="timeline-content">',
                                name          = '<h4>' + education.name + '</h4>',
                                subject       = '<span class="subject">' + education.subject + '</span>',
                                qualification = '<span class="qualification">' + education.qualification + '</span>',
                                time          = '<div class="time"><b><i class="fa fa-calendar"></i></b><span>' + education.date + '</span></div>',
                                button        = '<button class="btn _btn timeline-btn timeline-edit" data-update-education-id="' + education.id + '"><i class="fa fa-pencil"></i></button>',
                                button        = button + '<button class="btn _btn timeline-btn timeline-remove" data-remove-education-id="' + education.id + '"><i class="fa fa-remove"></i></button>';
                                
                                
                                if(current.find('[name="id"]').length) {
                                    var editSection = $('.education-timeline #timeline-section-' + education.id);
                                    editSection.find('h4').html(education.name);
                                    editSection.find('.subject').html(education.subject);
                                    editSection.find('.qualification').html(education.qualification);
                                    editSection.find('.time span').html(education.date);
                                } else {
                                    var timelineSection = section + name + subject + qualification + time + button + '</div></div>';
                                    
                                    $(timelineSection).insertBefore('.education-timeline .default-timeline');
                                }
                        }
                        
                        showMessage(response.message, 'success');
                        submitBtn.attr('disabled', false);
                        submitBtn.html('<i class="fa fa-check"></i>');
                        setTimeout(function(){
                            submitBtn.html(submitLabel);
                            if (formType !== '_EMPLOYMENT' || formType === '_EDUCATION') { 
                                current.find('button[type=reset]').click();
                            }
                        }, 1000);
                        
                        if (formType === '_EMPLOYMENT' || formType === '_EDUCATION') { 
                            current.find('button[type=reset]').click();
                        }
                    },
                    error: function(xhr, status, error) {
                        if (xhr.status === 500) {
                            submitBtn.attr('disabled', false);
                            submitBtn.html(submitLabel);
                        }
                        var response = $.parseJSON(xhr.responseText);
                        showMessage(response.message, 'error');
                        submitBtn.attr('disabled', false);
                        submitBtn.html(submitLabel);
                    }
                });
                
                return false;
            });
        },
        require: function() {
            var current      = this.element,
                requires     = (current.data('requires').trim() !== '') ? current.data('requires').split('|') : [],
                everythingOk = true;
        
            if ($.isArray(requires) && requires.length) {
                $.each(requires, function(k, v){
                    var field = current.find('[name=' + v + ']');

                    if (field.val() === '') {
                        if (field.is('select')) {
                            field.parent('.selecter').addClass('error');
                        } else if(field.is(':checkbox')) {
                            field.next('.settings-label').addClass('error');
                        } else {
                            field.addClass('error');
                        }
                        everythingOk = false;
                    } else {
                        if (field.is('select')) {
                            field.parent('.selecter').removeClass('error');
                        } else if(field.is(':checkbox')) {
                            field.next('.settings-label').removeClass('error');
                        } else {
                            field.removeClass('error');
                        }
                    }
                });
            }
            
            return everythingOk;
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
                
                if ($(this).val() !== '') {
                    label.addClass('_tg7').removeClass('_tga');
                } else {
                    label.addClass('_tga').removeClass('_tg7');
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
 *  @name Select Place
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
    var pluginName = 'select-place';

    function Plugin(element, options) {
        this.element = $(element);
        this.options = $.extend({}, $.fn[pluginName].defaults, options);
        this.init();
    }

    Plugin.prototype = {
        init: function() {
            var current = this.element;
                
            current.on('change', function(e){
                var target   = current.data('target'),
                    select   = $('.settings-field-wrapper').find('[name="' + target + '"]'),
                    selecter = select.parent('.selecter');
                                     
                $.ajax({
                    type: 'POST',
                    url: SETTINGS.AJAX_SELECT_PLACE_URL,
                    data: {find_id: current.val(), target: target},
                    dataType: 'json',
                    error: function(xhr, status, error) {
                        
                    },
                    beforeSend: function(){
                        selecter.find('img').show();
                        selecter.find('label').css({opacity: '0.3'});
                    },
                    success: function(response){
                        var citySelect     = $('.settings-field-wrapper').find('[name="city"]'),
                            districtSelect = $('.settings-field-wrapper').find('[name="district"]'),
                            wardSelect     = $('.settings-field-wrapper').find('[name="ward"]');
                            
                        if (target === 'city') {
                            var options = [[citySelect, response.options.city], [districtSelect, response.options.district], [wardSelect, response.options.ward]];
                        }
                        if (target === 'district') {
                            var options = [[districtSelect, response.options.district], [wardSelect, response.options.ward]];
                        }
                        if (target === 'ward') {
                            var options = [[wardSelect, response.options.ward]];
                        }
                        
                        $.each(options, function(k, valueArr){
                            var selectHtml = valueArr[0],
                                selectObj  = valueArr[1];
                            
                            selectHtml.find('option').remove();
                            selectHtml.parent('.selecter').find('label').html(selectObj[Object.keys(selectObj)[0]].name);
                            
                            $.map(selectObj, function(object, k) {
                                selectHtml.append($('<option>', { 
                                    value: (object.id === 0) ? '' : object.id,
                                    text : object.name 
                                }));
                            });
                        });                       
                        
                        selecter.find('img').hide();
                        selecter.find('label').css({opacity: '1'});
                    },
                    complete: function() {
                        
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
 *  @name Update employment
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
    var pluginName = 'update-employment';

    function Plugin(element, options) {
        this.element = $(element);
        this.options = $.extend({}, $.fn[pluginName].defaults, options);
        this.init();
    }

    Plugin.prototype = {
        init: function() {
            var current = this.element,
                thiz    = this;
        
            current.on('click', '.timeline-edit', function(){
                
                $.ajax({
                    type: 'GET',
                    url: SETTINGS.AJAX_GET_EMPLOYMENTBYID + '/' + $(this).attr('data-update-employment-id'),
                    dataType: 'json',
                    success: function(response){
                        var data      = response.data,
                            form      = current.find('form');
                    
                        thiz.fillData(data);
                        form.append('<input type="hidden" name="id" value="' + data.id +'" />');
                        form.prev('div.settings-show').hide();
                        form.show();
                        
                        $('html, body').animate({
                            scrollTop: current.find('.default-timeline').offset().top
                        }, 1000);
                    }
                });
            });
        },
        fillData: function(data) {
            var form     = this.element.find('form'),
                name     = form.find('[name="company_name"]'),
                position = form.find('[name="position"]'),
                achieve  = form.find('[name="achievement"]'),
                smonth   = form.find('[name="start_month"]'),
                syear    = form.find('[name="start_year"]'),
                emonth   = form.find('[name="end_month"]'),
                eyear    = form.find('[name="end_year"]'),
                web      = form.find('[name="website"]'),
                current  = form.find('[name="current_company"]');
        
            name.val(data.name);
            position.val(data.position);
            achieve.val(data.achievement);
            smonth.val(data.start_month).parent('.selecter').find('label').html(data.start_month).addClass('_tg7').removeClass('_tga');
            syear.val(data.start_year).parent('.selecter').find('label').html(data.start_year).addClass('_tg7').removeClass('_tga');
            web.val(data.website);
            
            if (data.is_current) {
                selectorStatus([emonth, eyear]);
                current.click();
            } else {
                emonth.val(data.end_month).parent('.selecter').find('label').html(data.end_month).addClass('_tg7').removeClass('_tga');
                eyear.val(data.end_year).parent('.selecter').find('label').html(data.end_year).addClass('_tg7').removeClass('_tga');
                selectorStatus([emonth, eyear], 'enable');
                current.prop('checked', false).attr('checked', false);
            }
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
 *  @name Remove employment
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
    var pluginName = 'remove-employment';

    function Plugin(element, options) {
        this.element = $(element);
        this.options = $.extend({}, $.fn[pluginName].defaults, options);
        this.init();
    }

    Plugin.prototype = {
        init: function() {
            var current = this.element;
                
            current.on('click', '.timeline-remove', function(){
                var employmentId = $(this).attr('data-remove-employment-id');
                
                if ( ! confirm($(this).attr('data-confirm-msg'))) {
                    return false;
                }
                
                $.ajax({
                    type: 'DELETE',
                    url: SETTINGS.AJAX_GET_EMPLOYMENTREMOVEBYID,
                    data: {id: employmentId},
                    dataType: 'json',
                    success: function(){
                        current.find('#timeline-section-' + employmentId).remove();
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
 *  @name Remove education
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
    var pluginName = 'remove-education';

    function Plugin(element, options) {
        this.element = $(element);
        this.options = $.extend({}, $.fn[pluginName].defaults, options);
        this.init();
    }

    Plugin.prototype = {
        init: function() {
            var current = this.element;
                
            current.on('click', '.timeline-remove', function(){
                var educationId = $(this).attr('data-remove-education-id');
                
                if ( ! confirm($(this).attr('data-confirm-msg'))) {
                    return false;
                }
                
                $.ajax({
                    type: 'DELETE',
                    url: SETTINGS.AJAX_GET_EDUCATIONREMOVEBYID,
                    data: {id: educationId},
                    dataType: 'json',
                    success: function(){
                        current.find('#timeline-section-' + educationId).remove();
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
 *  @name Update education
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
    var pluginName = 'update-education';

    function Plugin(element, options) {
        this.element = $(element);
        this.options = $.extend({}, $.fn[pluginName].defaults, options);
        this.init();
    }

    Plugin.prototype = {
        init: function() {
            var current = this.element;
                
            current.on('click', '.timeline-edit', function(){
                
                $.ajax({
                    type: 'GET',
                    url: SETTINGS.AJAX_GET_EDUCATIONBYID + '/' + $(this).attr('data-update-education-id'),
                    dataType: 'json',
                    success: function(response){
                        var data = response.data,
                            form = current.find('form');
                            
                        form.find('[name="college_name"]').val(data.name);
                        form.find('[name="subject"]').val(data.subject);
                        form.find('[name="start_month"]').val(data.start_month).parent('.selecter').find('label').html(data.start_month).addClass('_tg7').removeClass('_tga');
                        form.find('[name="start_year"]').val(data.start_year).parent('.selecter').find('label').html(data.start_year).addClass('_tg7').removeClass('_tga');
                        form.find('[name="end_month"]').val(data.end_month).parent('.selecter').find('label').html(data.end_month).addClass('_tg7').removeClass('_tga');
                        form.find('[name="end_year"]').val(data.end_year).parent('.selecter').find('label').html(data.end_year).addClass('_tg7').removeClass('_tga');
                        form.find('[name="qualification"]').val(data.qualification_id).parent('.selecter').find('label').html(data.qualification_name).addClass('_tg7').removeClass('_tga');
                        form.append('<input type="hidden" name="id" value="' + data.id +'" />');
                        form.prev('div.settings-show').hide();
                        form.show();
                        
                        $('html, body').animate({
                            scrollTop: current.find('.default-timeline').offset().top
                        }, 1000);
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
 *  @name Nav Settings
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
    var pluginName = 'nav-settings';

    function Plugin(element, options) {
        this.element = $(element);
        this.options = $.extend({}, $.fn[pluginName].defaults, options);
        this.init();
    }

    Plugin.prototype = {
        init: function() {
            var current   = this.element,
                target    = current.data('nav-settings'),
                targetObj = $('#' + target);
                
            current.on('click', function(){
                $('.settings section').removeClass('_disable');
                $('.settings-page').hide();
                if ('employment' === target || 'education' === target) {
                    $('body').css('background-color', '#ffffff');
                } else {
                    $('body').css('background-color', '#f5f8fa');
                }
                targetObj.show();
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
 *  @name Nav Settings
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
    var pluginName = 'settings-page-view';

    function Plugin(element, options) {
        this.element = $(element);
        this.options = $.extend({}, $.fn[pluginName].defaults, options);
        this.init();
    }

    Plugin.prototype = {
        init: function() {
            var settingsPages   = ['#profile', '#skills', '#employment', '#education'],
                hashPage        = (settingsPages.indexOf(window.location.hash) === -1) ? settingsPages[0] : settingsPages[settingsPages.indexOf(window.location.hash)],
                settingsPageObj = $(hashPage);
               
            $.each(settingsPages, function(k, page){
                $(page).hide();
            });
            
            if ('#employment' === hashPage || '#education' === hashPage) {
                $('body').css('background-color', '#ffffff');
            }
            settingsPageObj.show();
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
 *  @name Rating
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
    var pluginName = 'rating';

    function Plugin(element, options) {
        this.element = $(element);
        this.options = $.extend({}, $.fn[pluginName].defaults, options);
        this.maxStar = this.element.data('rating');
        this.init();
    }

    Plugin.prototype = {
        init: function() {
            this.load();
            this.select();
            this.rate();
        },
        load: function() {
            var rates = this.element.find('.rating');
            if (rates.length > 0) {
                $.each(rates, function(k, v){
                    var currentRating = parseInt($(v).find('.current-rating').val());
                    for (var i = 1; i <= currentRating; i++) {
                        $(v).find('i:nth-child(' + i + ')').addClass('fa-star').removeClass('fa-star-o');
                    }
                });
            }
        },
        rate: function() {
            var maxStar = this.maxStar;
            
            this.element.on('click', '.rating i.fa', function(){
                var rating = $(this).parents('.rating');
                
                rating.find('.current-rating').val($(this).index() + 1);
                
                for (var i = 1; i <= maxStar; i++) {
                    if (i <= ($(this).index() + 1)) {
                        rating.find('i:nth-child(' + i + ')').addClass('fa-star').removeClass('fa-star-o');
                    } else if (i > ($(this).index() + 1)) {
                        rating.find('i:nth-child(' + i + ')').addClass('fa-star-o').removeClass('fa-star');
                    }
                }
                
                if (parseInt(rating.find('.current-rating').val()) > 0) {
                    $.ajax({
                        type: 'POST',
                        url: SETTINGS.AJAX_SAVE_INFO,
                        data: {id: rating.closest('.tag').attr('id'), votes: $(this).index() + 1, type: '_SKILL'},
                        success: function(response){
                            console.log(response);
                        }
                    });
                }
            });
            
            
        },
        select: function() {
            var thiz = this;
            
            this.element.on({
                mouseenter: function () {
                    thiz.mouseIn($(this));
                },
                mouseleave: function () {
                    thiz.mouseOut($(this));
                }
            }, '.rating i.fa');
        },
        mouseIn: function(element) {
            element.addClass('fa-star').removeClass('fa-star-o');
            
            for (var i = 1; i <= element.index(); i++) {
                element.parents('.rating').find('i:nth-child(' + i + ')').addClass('fa-star').removeClass('fa-star-o');
            }
        },
        mouseOut: function(element) {
            var rateScore = parseInt(element.parents('.rating').find('.current-rating').val()),
                index     = element.index();
            
            if ((index + 1) > rateScore) { 
                element.addClass('fa-star-o').removeClass('fa-star');
                for (var i = 1; i <= index; i++) {
                    if (rateScore < i) {
                        element.parents('.rating').find('i:nth-child(' + i + ')').addClass('fa-star-o').removeClass('fa-star');
                    }
                }
            }
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
 *  @name Kill Tag
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
    var pluginName = 'kill-tag';

    function Plugin(element, options) {
        this.element = $(element);
        this.options = $.extend({}, $.fn[pluginName].defaults, options);
        this.init();
    }

    Plugin.prototype = {
        init: function() {
            var thiz = this;
            this.element.on('click', '.tag i.fa-close', function(){
                var id = parseInt($(this).closest('.tag').attr('id'));
                
                $.ajax({
                    type: 'DELETE',
                    url: SETTINGS.AJAX_KILL_TAG,
                    data: {id: id},
                    success: function(){
                        $('#' + id).remove();
                    }
                });
                console.log(thiz.element.find('.tag').length);
                if (thiz.element.find('.tag').length === 0) {
                    $('.no-skills').addClass('_dn');
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
 *  @name Add Skill
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
    var pluginName = 'add-skill';

    function Plugin(element, options) {
        this.element = $(element);
        this.options = $.extend({}, $.fn[pluginName].defaults, options);
        this.init();
    }

    Plugin.prototype = {
        init: function() {
            this.submit();
        },
        submit: function() {
            var current = this.element,
                thiz    = this;
            
            current.on('submit', function(e){
                e.preventDefault();
                
                if ($(this).find('[name=skill]').val().trim() === '') {
                    return false;
                }
                
                $.ajax({
                    type: current.attr('method'),
                    url: current.attr('action'),
                    data: current.serialize(),
                    success: function(response){
                        thiz.append(response.data);
                        current.find('[name=skill]').val('');
                    }
                });
            });
        },
        append: function(data) {
            var skills = this.element.find('.skill-tags'),
                html   =  '<div class="tag" id="' + data.id + '">' +
                            '<div class="tag-container">' +
                                '<div class="rating">' +
                                    '<i class="fa fa-star-o"></i> ' +
                                    '<i class="fa fa-star-o"></i> ' +
                                    '<i class="fa fa-star-o"></i> ' +
                                    '<i class="fa fa-star-o"></i> ' +
                                    '<i class="fa fa-star-o"></i>' +
                                    '<input type="hidden" value="0" class="current-rating"/>' +
                                '</div>' +
                                '<div class="tag-name">' + data.name + '</div>' +
                                '<i class="fa fa-close"></i>' +
                            '</div>' +
                        '</div>';
                
            skills.append(html);
            
            if ( ! $('.no-skills').hasClass('_dn')) {
                $('.no-skills').addClass('_dn')
            }
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
 *  @name Autocomplate Skill
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
    var pluginName = 'autocomplete-skill';

    function Plugin(element, options) {
        this.element = $(element);
        this.options = $.extend({}, $.fn[pluginName].defaults, options);
        this.init();
    }

    Plugin.prototype = {
        init: function() {
            var thiz = this;
            
            this.element.on('keyup', function(e){
                if(e.keyCode !== 13){
                    setTimeout(thiz.search(thiz.element.val()), 700);
                }
            });
        },
        search: function(keyword){
            var thiz = this;
            if (keyword.length >= 3) {
                $.ajax({
                    type: 'GET',
                    url: SETTINGS.AJAX_GET_SEARCHSKILL + '/' + keyword,
                    success: function(response){
                        if (response.total > 0) {
                            thiz.append(response.skills);
                        } else {
                            thiz.hide();
                        }
                    }
                });
            } else {
                thiz.hide();
            }
        },
        append: function(list){
            var html = '',
                thiz = this;
            
            if (list.length > 0) {
                html = '<ul>';
                $.each(list, function(k, v){
                    html += '<li>' + v.name + '</li>';
                });
                html += '</ul>';
            } else {
                thiz.hide();
            }
            
            if ('' !== html) {
                $('.skill-suggestion').html(html).show();
            }
        },
        hide: function(){
            $('.skill-suggestion').hide();
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
