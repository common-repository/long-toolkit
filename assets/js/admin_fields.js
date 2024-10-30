/*
 * Core Fields js functions  
 * 
 * @author HQL
 * @since 1.0.0
 */

jQuery(function ($) {

    'use strict';

    var $document = $(document);

    var prefix = '';

    if ($('#widgets-right').length) {
        prefix = '#widgets-right ';

    } else if ($('#menu-to-edit').length == 0) {
        /**
         * Field repeater
         */
        if (document.getElementsByClassName('long-toolkit-repeater').length) {
            $('.long-toolkit-repeater').ltfwRepeater();
        }

        /**
         * Field Map
         */
        if (document.getElementsByClassName('long-toolkit-map').length) {
            $('.long-toolkit-map').ltfwMap();
        }
    }

    /**
     * Field Image Picker
     */
    $('.long-toolkit-image_picker').ltfwImagePicker();

    /**
     * Field Link
     */
    if (document.getElementsByClassName('long-toolkit-link').length) {
        $('.long-toolkit-link').ltfwLink();
    }

    /**
     * Field Color
     */
    if ($('.long-toolkit-color:not(.child-field)').length) {
        $(prefix + '.long-toolkit-color:not(.child-field)').wpColorPicker();
    }

    /**
     * Field icon picker
     */
    if ($(prefix + '.long-toolkit-icon_picker:not(.child-field)').length) {
        $(prefix + '.long-toolkit-icon_picker:not(.child-field) select').fontIconPicker();
    }

    /**
     * Field datetime
     */
    if (document.getElementsByClassName('long-toolkit-datetime').length) {
        $(prefix + '.long-toolkit-datetime input').each(function () {
            var data = $(this).ltfwData();
            $(this).datetimepicker(data);
        });
    }

    /**
     * Field checkboxes
     */
    if (document.getElementsByClassName('long-toolkit-checkboxes')) {

        $document.on(
                'change', '.long-toolkit-checkboxes input[type="checkbox"]',
                function () {
                    var checkbox_values = $(this).closest('ul').find('input[type="checkbox"]:checked').map(
                            function () {
                                return this.value;
                            }
                    ).get().join(',');

                    $(this).closest('ul').prev('input.long_toolkit_value').val(checkbox_values).trigger('change');
                }
        );
    }

    /**
     * Field radios
     */
    if (document.getElementsByClassName('long-toolkit-radios')) {
        $document.on('change', '.long-toolkit-radios input[type="radio"]', function (e) {
            var $this = $(this);
            var $ul = $this.closest('ul');
            $ul.find('input').removeAttr('checked');
            $this.attr('checked', 'checked');
            $ul.prev('input.long_toolkit_value').val($this.val()).trigger('change');
        });
    }

    /**
     * Field select multiple
     */
    if ($(prefix + '.long-toolkit-select-multiple').length) {

        $(prefix + '.long-toolkit-select-multiple:not(.child-field)').selectize({
            plugins: ['remove_button', 'drag_drop']
        });

        $document.on('change', prefix + '.long-toolkit-select-multiple', function () {
            $(this).closest('div').find('.long_toolkit_value').val($(this).val()).trigger('change');
        });
    }

    /**
     * Field Autocomplete
     */
    if ($(prefix + '.long-toolkit-autocomplete select').length) {

        $(prefix + '.long-toolkit-autocomplete:not(.child-field) select').ltfwAutocomplete();

        $document.on('change', prefix + '.long-toolkit-autocomplete select', function () {
            $(this).closest('div').find('.long_toolkit_value').val($(this).val()).trigger('change');
        });
    }

    /**
     * Field file
     * @since 1.0.4
     */
    if (document.getElementsByClassName('long-toolkit-upload')) {
        $('.long-toolkit-upload').ltfwUpload();
    }
    
     /**
     * Field file
     * @since 1.0.9
     */
    if (document.getElementsByClassName('long-toolkit-textfield-multiple')) {
        $('.long-toolkit-textfield-multiple').ltfwTextfields();
    }

    var widget_content_init = function ($widgetRoot) {

        if (window.hasOwnProperty('google')) {
            var $map = $widgetRoot.find('.long-toolkit-map');
            if ($map.length) {
                $map.ltfwMap().addClass('map_loaded');
            }
        }

        var $color = $widgetRoot.find('.long-toolkit-color');
        if ($color.length) {
            $color.wpColorPicker();
        }


        var $icon_picker = $widgetRoot.find('.long-toolkit-icon_picker select');
        if ($icon_picker.length) {
            $icon_picker.fontIconPicker();
        }

        var $date_time = $widgetRoot.find('.long-toolkit-datetime input');
        if ($date_time.length) {
            $date_time.each(function () {
                var data = $(this).ltfwData();
           
                $(this).datetimepicker(data);
            });
        }

        //Repeater
        var $repeater = $widgetRoot.find('.long-toolkit-repeater');
        if ($repeater.length && !$repeater.hasClass('repeater_loaded')) {
            $repeater.addClass('repeater_loaded').ltfwRepeater();
        }

        //Selective
        var $selective = $widgetRoot.find('.long-toolkit-select-multiple');
        if ($selective.length) {
            $widgetRoot.find('.long-toolkit-select-multiple:not(.child-field)').selectize({
                plugins: ['remove_button', 'drag_drop']
            });
        }

        //Autocomplete
        var $autocomplete = $widgetRoot.find('.long-toolkit-autocomplete');
        if ($autocomplete.length) {
            $widgetRoot.find('.long-toolkit-autocomplete:not(.child-field) select').ltfwAutocomplete();
        }

        //Reinit dependency
        var $dependency = $widgetRoot.find("div[data-dependency]");
        if ($dependency.length) {
            $dependency.initWidgetDependency();
        }

    }

    $document.on('widget-updated', function (e, $widgetRoot) {
        widget_content_init($widgetRoot);
    });

    $document.on('widget-added', function (e, $widgetRoot) {
        widget_content_init($widgetRoot);
    });
    
    $document.on('click', '#widgets-right .widget-title', function (e) {

        var $this = $(this);

        setTimeout(function () {
            var $widget = $this.closest('.open');

            if ($widget.length) {
                //Map
                var $map = $widget.find('.long-toolkit-map');
                if ($map.length && !$map.hasClass('map_loaded')) {
                    $map.ltfwMap();
                }

                //Repeater
                var $repeater = $widget.find('.long-toolkit-repeater');
                if ($repeater.length && !$repeater.hasClass('repeater_loaded')) {
                    $repeater.addClass('repeater_loaded').ltfwRepeater();
                }
            }

        }, 300);

        e.preventDefault();
    });

    $document.on('long-toolkit-repeater-item-opened', function (e, $widget) {
        var $map = $widget.find('.long-toolkit-map');
        if ($map.length) {
            $map.ltfwMap();
        }
    });
    
    $document.on('click', '.long_toolkit_group .group_nav a', function (e) {

        var $this = $(this);
        var id = $this.attr('href');

        $this.closest('ul').find('.active').removeClass('active');
        $this.addClass('active');

        $('.long_toolkit_group .group_item.active').removeClass('active');

        var $panel = $('.long_toolkit_group ' + id);
        $panel.addClass('active');

        if ($('.long_toolkit_group ' + id + ' .map_loaded').length) {
            if (!$panel.find('.long-toolkit-map').hasClass('map_refresh')) {
                $panel.find('.long-toolkit-map').ltfwMap().addClass('map_refresh');
            }
        }

        $document.trigger('long_toolkit_group_active', [$panel]);

        e.preventDefault();
    });
    
    /**
     * On click menu iteme edit
     */
    $('#menu-to-edit .menu-item .item-edit').click(function (e) {
        var $this = $(this);

        setTimeout(function () {
            var $memuitem = $this.closest('.menu-item');

            if ($memuitem.length) {
                //Map
                var $map = $memuitem.find('.long-toolkit-map');
                if ($map.length && !$map.hasClass('map_loaded')) {
                    $map.ltfwMap();
                }
            }

        }, 300);

        e.preventDefault();
    });

    /**
     * Init dependency
     */
    if (window.hasOwnProperty('pagenow')) {

        if (pagenow === 'widgets') {
            var $dependency = $('#widgets-right').find("div[data-dependency]");
            if ($dependency.length) {
                $dependency.initWidgetDependency();
            }
        } else if (pagenow === 'nav-menus') {
            if ($("#menu-to-edit div[data-dependency]").length) {
                $("#menu-to-edit div[data-dependency]").initMenuDependency();
            }
        } else {
            $("[data-dependency]").initDependency();
        }

    } else if ($("[data-dependency]").length) {
        $("[data-dependency]").initDependency();
    }

    if ($('input.long-toolkit-manage_box').length) {

        $('input.long-toolkit-manage_box').each(function () {

            var $this = $(this);

            var checked = '';

            if ($this.val() == 1) {
                checked = 'checked';
                $this.closest('.postbox').removeClass('postbox--disabled');
            } else {
                $this.closest('.postbox').addClass('postbox--disabled');
            }

            $this.closest('.postbox').find('.hndle').before('<label class="long-toolkit-controlbox"><input type="checkbox" ' + checked + ' data-name="' + $this.attr('name') + '"/>' + $this.data('label') + '</label>');

        });

        $(document).on('change', '.long-toolkit-controlbox input', function (e) {
            var $this = $(this);

            var $postbox = $this.closest('.postbox');

            var val = 0;

            if ($this.is(':checked')) {
                $postbox.removeClass('postbox--disabled');
                val = 1;
            } else {
                $postbox.addClass('postbox--disabled');
            }

            $('input[name=' + $this.data('name') + ']').val(val).change();

            e.preventDefault();
            e.stopPropagation();
        });
    }

    if ($('.long-toolkit-manage_group').length) {

        $('input.long-toolkit-manage_group').on('change', function (e) {
            var $this = $(this);

            if ($this.is(':checked')) {
                $this.closest('.long_toolkit_form_row').removeClass('group-disabled');
            } else {
                $this.closest('.long_toolkit_form_row').addClass('group-disabled');
            }

            e.preventDefault();
        });

        $('input.long-toolkit-manage_group').change();
    }
    if ( $('.long-toolkit-textarea').length ) {
        $('.long-toolkit-textarea').each(function(){
            var id = jQuery(this).attr('id');
            wp.editor.initialize( id , {
                mediaButtons: true,
                tinymce: {
                    wpautop  : true,
                    plugins : 'charmap colorpicker compat3x directionality fullscreen hr image lists media paste tabfocus textcolor wordpress wpautoresize wpdialogs wpeditimage wpemoji wpgallery wplink wptextpattern wpview', 
                    toolbar1: 'formatselect bold italic | bullist numlist | blockquote | alignleft aligncenter alignright | link unlink | wp_more | spellchecker' 
                },
                quicktags   : jQuery(this).attr('data-quicktags'),
            } );
        });
    }

});