(function($) {
    $(function() {
        var qardsWPSettings = '#qards-settings';

        // Store data of all fields except checkboxes and fileuploads
        // It needs to compare initial data with data that has been changed (obj qardsWPSettingsDataToSave)
        var qardsWPSettingsInitData = {
            siteTitle: '',
            googleKey: '',
            googleGATrack: '',
            typeKitID: '',
            editingCSS: '',
            editingHead: '',
            editingHeader: '',
            editingFooter: '',
            mailchimpKey: '',
            mailchimpListUrl: '',
            mcsel: '',
            headlineCSS: '',
            heroCSS: '',
            paragraphCSS: ''
        };

        // Store data of all fields except checkboxes and fileuploads, they will save once after upload
        // It needs to save data
        var qardsWPSettingsDataToSave = {};

        /* Font list for autocomplete */
        var googleFontList = [];

        /* All loaded fonts autocomplete */
        var allFF = [];

        /* Populate Settings Init Data */
        populateSettingInitData();

        window.alert = function(message) {
            // $.msgBox({
            // title: "Something went not as we expected :(",
            // content: message,
            // type: "error",
            // showButtons: false,
            // opacity: 0.5,
            // autoClose:true
            // });
            swal({
                title: "Something went wrong :(",
                text: message,
                type: "error",
                confirmButtonText: "OK"
            });
            console.trace();
            console.log("ERROR : "+message);
        }

        window.confirm = function(message,callback) {
            swal({
                title: "Are you sure?",
                text: message,   
                type: "warning",   
                showCancelButton: true,   
                confirmButtonColor: "#DD6B55",   
                confirmButtonText: "Yes",   
                closeOnConfirm: false 
            },callback);
        }

        var _={};
        _.now = Date.now || function() {
            return new Date().getTime();
        };
        _.debounce = function(func, wait, immediate) {
            var timeout, args, context, timestamp, result;

            var later = function() {
              var last = _.now() - timestamp;

              if (last < wait && last >= 0) {
                timeout = setTimeout(later, wait - last);
              } else {
                timeout = null;
                if (!immediate) {
                  result = func.apply(context, args);
                  if (!timeout) context = args = null;
                }
              }
            };

            return function() {
              context = this;
              args = arguments;
              timestamp = _.now();
              var callNow = immediate && !timeout;
              if (!timeout) timeout = setTimeout(later, wait);
              if (callNow) {
                result = func.apply(context, args);
                context = args = null;
              }

              return result;
            };
        };

        $.fn.extend({
          loadTwigStyle: function(style) {
                //console.log(this);
                var that = this;
                $.ajaxQueue({
                    url: ajaxurl,
                    method: 'POST',
                    data: {
                        action: 'dm_api',
                        method: 'twig.defaults.get',
                        params: JSON.stringify({
                            style: style
                        })
                    },
                    dataType: 'json'
                })
                    .done(function(response) {
                        if ("error" in response)
                        {
                            alert("Error while loading twig style for "+style+" : "+response.error.message);
                            return;
                        }
                        if(style==='link') {
                            //console.log("Link data arrived: "+response.result);
                            $(that).css("background",response.result);
                            applyColor(style, response.result);
                            var clstr = $("#" + style + "CL").css("background-color");
                            var rgbs = clstr.match(/[0-9]+/g).map(function(n)
                            {
                                return +n;
                            });
                            var rgb = {r:rgbs[0],g:rgbs[1],b:rgbs[2]};
                            var hsb = rgb2hsb(rgb);
                            if(hsb.b>70 && hsb.s<50){
                                $("#" + style + "CL").css("border", "1px solid rgba(200,200,200,1)");
                            } else {
                                $("#" + style + "CL").css("border", "1px solid rgba(108,108,108,0)");
                            }
                        } else {
                            for (var x in response.result.style)
                            {
                                // console.log("Applying " + x + " : " + response.result.style[x]);
                                $(that).css(x, response.result.style[x]);
                                if(x==="color"){
                                    applyColor(style, response.result.style[x]);
                                    $("#" + style + "CL").css("background",response.result.style[x]);
                                    var clstr = $("#" + style + "CL").css("background-color");
                                    var rgbs = clstr.match(/[0-9]+/g).map(function(n)
                                    {
                                        return +n;
                                    });
                                    var rgb = {r:rgbs[0],g:rgbs[1],b:rgbs[2]};
                                    var hsb = rgb2hsb(rgb);
                                    // console.log(hsb);
                                    if(hsb.b>70 && hsb.s<50){
                                        $("#" + style + "CL").css("border", "1px solid rgba(200,200,200,1)");
                                    } else {
                                        $("#" + style + "CL").css("border", "1px solid rgba(108,108,108,0)");
                                    }
                                }
                                if(x==="font-weight"){
                                    if(response.result.style[x]!=="normal")
                                        $("#" + style + "BL").click();
                                }
                                if(x==="font-style"){
                                    if(response.result.style[x]!=="normal")
                                        $("#" + style + "IT").click();
                                }
                            }
                            for (var x in response.result.classes)
                            {
                                // console.log("Applying class", response.result.classes[x]);
                                if(response.result.classes[x].indexOf("line-height")>-1)
                                    $(that).not(".noLH").addClass(response.result.classes[x]);
                                else
                                    $(that).addClass(response.result.classes[x]);
                                if(response.result.classes[x].indexOf("font-size")>-1) {
                                    $("#" + style + "Slider1").slider("value",parseInt(response.result.classes[x].substring(10)))
                                    // $("#" + style + "Slider").children("span").html(response.result.classes[x].substring(10));
                                }
                                if(response.result.classes[x].indexOf("line-height")>-1) {
                                    $("#" + style + "Slider2").slider("value",parseInt(response.result.classes[x].substring(12)))
                                    // console.log(parseInt(response.result.classes[x].substring(12)));
                                    // $("#" + style + "Slider").children("span").html(response.result.classes[x].substring(10));
                                }
                            }
                            $("#" + style + "FF").val($(that).css('font-family'));
                            return that;
                        }
                        // var data = JSON.parse(response.result.body);
                        // // console.log(data);
                        // if ("error" in data)
                        // {
                        //     console.log("error");
                        //     alert("jsonManipulate API failure: " + data.error.errors[0].reason + "\nPlease contact developer");
                        // } else {
                        //     console.log("Success...at least, it seems.");
                        // }
                    })
                    .fail(function(jqXHR, textStatus, errorThrown) {
                        if(textStatus.toString() && errorThrown.toString())
                            alert(textStatus, errorThrown);
                        else
                        {
                            console.log("Error in ajax");
                            console.log(jqXHR);
                        }
                    });
            }

          });

        var editDefaultFonts = _.debounce(editDefaultFontsOriginal,1000,false);
        var backgroundCSSSave = _.debounce(backgroundCSSSaveOriginal,1000,false);

        /* Initial set up for preview images */
        $('.preview-img', qardsWPSettings).each(function() {
            var $this = $(this);

            if($this.data('preview-src')) {
                $this.closest('.tab-row').removeClass('no-image');
            }
        });

        /* Initial set up for TypeKitID */
        if($('#typeKitID', qardsWPSettings).val()) {
            $('#typeKitID', qardsWPSettings).closest('.tab-row').addClass('has-typekit');
        }

        /* Checkboxes */
        $('.checkbox', qardsWPSettings).each(function() {
            var $this = $(this);
            if((typeof $this.attr('name'))==="undefined") return;
            $this.on('change', function() {
                var checkboxSetting = {};

                checkboxSetting[$this.attr('name')] = $this.prop('checked');

                apiCall(checkboxSetting);
            });
        });

        /* File uploader */
        $('.fileupload', qardsWPSettings).fileupload({
            url: ajaxurl + '?action=dm_api&method=attachement.upload',
            paramName: 'file',
            dataType: 'json',
            send: function(e, data) {
                var maxFileSize = $(this).data('file-size');

                if (maxFileSize && data.total > maxFileSize) {
                    alert('Image file size has been exceeded.');
                    return false;
                }
            },
            done: function (e, data) {
                var $this = $(this),
                    parent = $this.closest('.tab-row'),
                    previewImg = parent.find('.preview-img'),
                    imageSetting = {};

                if(data.result.result && data.result.result.original) {
                    imageSetting[$this.attr('name')] = data.result.result.original;

                    apiCall(imageSetting, function() {
                        previewImg.attr('src', pluginUrlAdmin + data.result.result.original);
                        parent.removeClass('no-image');
                    });
                }
            }
        });
        $('.remove-image', qardsWPSettings).on('click', function(e) {
            e.preventDefault();

            var $this = $(this),
                imageSetting = {};

            imageSetting[$this.closest('.tab-row').find('.fileupload').attr('name')] = '';

            apiCall(imageSetting, function() {
                $this.closest('.tab-row').addClass('no-image').find('.preview-img').attr('src', '');
            });
        });

        /* Export Subscribers */
        $('#exportSubscribers', qardsWPSettings).on('click', function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            e.stopPropagation();
            return false;
        });

        /* Edit Button */
        $('.edit-button', qardsWPSettings).on('click', function(e) {
            e.preventDefault();

            var $this = $(this),
                parent = $this.closest('.tab-row'),
                codeEditor = parent.find('.code-editor'),
                editableText = parent.find('.editable-text');

            parent.addClass('changes');

            if(editableText.length) {
                editableText.focus();
            }

            if(codeEditor.length) {
                var codeEditorInstance = codeEditor.find('.CodeMirror')[0].CodeMirror;

                codeEditor.addClass('show');
                codeEditorInstance.refresh();
                codeEditorInstance.focus();
            }
        });

        /* Editable text */
        $('.editable-text', qardsWPSettings).each(function() {
            var editableText = $(this);

            editableText.flexText();
            editableText.on('keypress', function(e) {
                if (e.keyCode == 13) {
                    e.preventDefault();
                }
            });
            editableText.on('keyup', function(e) {
                var $this = $(this),
                    value = $this.val();

                dirtyCheck($this.attr('id'), value);

                if (e.keyCode == 13) {
                    if($this.attr('id') !== 'typeKitID') {
                        saveChanges($this.attr('id'));
                        if($this.attr('id')==='googleKey') setTimeout(function(){initGFonts(false);},1000);
                    } else {
                        // check if it's valid typeKitID
                        typeKitValidation(value, $this);
                    }
                }
            });
            editableText.on('focus', function() {
                var $this = $(this),
                    id = $this.attr('id'),
                    textarea = document.getElementById(id);

                $this.addClass('focus');

                moveCursorToEnd(textarea);
                setTimeout(function() {
                    moveCursorToEnd(textarea);
                }, 1);
            });
            editableText.on('blur', function() {
                var $this = $(this);

                $this.removeClass('focus');
            });
        });

        /* Remove TypeKitID */
        $('.remove-typekitId', qardsWPSettings).on('click', function(e) {
            e.preventDefault();

            removeTypeKitId($(this));
        });

        /* Init CodeMirror */
        $('.code-editor-textarea', qardsWPSettings).each(function(index) {
            initCodeMirror($(this).attr('id'), $(this).data('code-mode'));
        });

        /* Save button */
        $('.save-button', qardsWPSettings).on('click', function(e) {
            e.preventDefault();

            var $this = $(this),
                parent = $this.closest('.tab-row'),
                el = parent.find('.text-field'),
                id = el.attr('id'),
                name = el.attr('name');

            if(id !== 'typeKitID') {
                saveChanges(id);
            } else {
                // check if it's valid typeKitID
                typeKitValidation(el.val(), el);
            }
        });

        /* Cancel button */
        $('.cancel-button', qardsWPSettings).on('click', function(e) {
            e.preventDefault();

            var $this = $(this),
                parent = $this.closest('.tab-row'),
                el = parent.find('.text-field'),
                id = el.attr('id'),
                name = el.attr('name');

            parent.removeClass('changes');
            parent.find('.code-editor').removeClass('show');

            if(name in qardsWPSettingsDataToSave) {
                if(el.hasClass('editable-text')) {
                    el.val(qardsWPSettingsInitData[id]);
                    parent.find('.flex-text-wrap span').text(qardsWPSettingsInitData[id]);
                }
                if(el.hasClass('code-editor-textarea')) {
                    parent.find('.CodeMirror')[0].CodeMirror.setValue(qardsWPSettingsInitData[id]);
                }
                delete qardsWPSettingsDataToSave[name];
            }
        });

        /* Reset Settings */
        $('#resetSettings', qardsWPSettings).on('click', function(e) {
            e.preventDefault();
            confirm('Are you sure you want to reset all settings to defaults?',function() {
                editDefaultFonts(true);
                $.ajaxQueue({
                    url: ajaxurl,
                    method: 'POST',
                    data: {
                        action: 'dm_api',
                        method: 'settings.reset',
                        params: {}
                    },
                    dataType: 'json',
                    success: function(response) {
                        if ('result' in response) {
                            location.reload();
                        } else if ('error' in response) {
                            alert(response.error.code, response.error.message);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        if(textStatus.toString() && errorThrown.toString()) 
                            alert(textStatus, errorThrown);
                        else
                        {
                            console.log("Error in ajax");
                            console.log(jqXHR);
                        }

                    }
                });
            });
        });

        $('#resetStyles', qardsWPSettings).on('click', function(e) {
            e.preventDefault();
            confirm('Are you sure you want to reset all styles to defaults?',function() {
                editDefaultFonts(true);
                $.ajaxQueue({
                    url: ajaxurl,
                    method: 'POST',
                    data: {
                        action: 'dm_api',
                        method: 'font.reset',
                        params: {}
                    },
                    dataType: 'json',
                    success: function(response) {
                        if ('result' in response) {
                            setTimeout(function() {
                                location.hash = 'appearance';
                                location.reload();
                            },1000);
                        } else if ('error' in response) {
                            alert(response.error.code, response.error.message);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        if(textStatus.toString() && errorThrown.toString()) 
                            alert(textStatus, errorThrown);
                        else
                        {
                            console.log("Error in ajax");
                            console.log(jqXHR);
                        }

                    }
                });
            });
        });

        $("textarea#mailchimpKey").on('change', function(e) {
            // console.log("changed");
            $("textarea#mailchimpListUrl").val("");
            dirtyCheck("mailchimpListUrl", "");
            MailChimpHide();
            setTimeout(MailChimpLoad,1000);
        });
        $("body").on("change",'#mcsel',function() {
            $("textarea#mailchimpListUrl").val($("#mcsel option:selected").val());
            var e = jQuery.Event("keyup");
            e.which = 13;
            e.keyCode = 13;
            $("textarea#mailchimpListUrl").trigger(e);
            //console.log($("textarea#mailchimpListUrl").val());
            $(this).closest('.tab-row').addClass("changes");
            var $this = $("textarea#mailchimpListUrl"),
                value = $this.val();

            dirtyCheck($this.attr('id'), value);
        });

        // $('#maillistsbtn').on('click', function(e) {
        //     MailChimpLoad();
        // });

        function MailChimpLoad(){
            if($("textarea#mailchimpKey").val()==="")
            {
                alert("Please enter MailChimp API key");
                return;
            }
            // console.log("Before ajax");
            $.ajaxQueue({
                url: ajaxurl,
                method: 'POST',
                data: {
                    action: 'dm_api',
                    method: 'mailchimp.lists.get'
                },
                dataType: 'json'
            })
            .done(function(response) {
                // console.log("Ajax done");
                // console.log(response);
                if ('result' in response) {
                    if('error' in response.result)
                    {
                        alert(response.result.error);
                        MailChimpHide();
                        return;
                    }
                    var MC_info=JSON.parse(response.result.body);
                    if(MC_info.status==401)
                    {
                        alert("Mailchimp " + MC_info.title);
                        MailChimpHide();
                        return;
                    }
                    $("#mcsel").prop( "disabled", false );
                    $("#mcsel").empty();
                    MailChimpShow();

                    for (var i = 0; i < MC_info.lists.length; i++) {
                        $("#mcsel").append("<option style=\"display: block; color: #424242\" value=\"" + MC_info.lists[i].subscribe_url_long + "\">"+MC_info.lists[i].name+"</option>");
                    };
                    $("textarea#mailchimpListUrl").val($("#mcsel option:selected").val());
                    //console.log($("textarea#mailchimpListUrl").val());
                    $("#mcsel").closest('.tab-row').addClass("changes");
                    var $this = $("textarea#mailchimpListUrl"),
                        value = $this.val();

                    dirtyCheck($this.attr('id'), value);
                } else if ('error' in response) {
                    alert(response.error.code, response.error.message);
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                if(textStatus.toString() && errorThrown.toString()) 
                    alert(textStatus, errorThrown);
                else
                {
                    console.log("Error in ajax");
                    console.log(jqXHR);
                }

            });
        }

        (function(){
        // console.log("Start");
            if($("textarea#mailchimpKey").val()==="")
                {
                    //alert("Please enter MailChimp API key");
                    MailChimpHide();
                    return;
                }
            if(!($("textarea#mailchimpListUrl").val()==="")){
                $("#mcsel option:selected").text("Press \"Load lists\" to change");
                // console.log($("textarea#mailchimpListUrl").val());
                $.ajaxQueue({
                    url: ajaxurl,
                    method: 'POST',
                    data: {
                        action: 'dm_api',
                        method: 'mailchimp.lists.get'
                    },
                    dataType: 'json'
                })
                .done(function(response) {
                    // console.log("Ajax done");
                    if ('result' in response) {
                        // console.log(response);
                        if('error' in response.result)
                        {
                            MailChimpHide();
                            alert(response.result.error);
                            return;
                        }
                        var MC_info=JSON.parse(response.result.body);
                        if(MC_info.status==401)
                        {
                            MailChimpHide();
                            alert("Mailchimp " + MC_info.title);
                            return;
                        }
                        $("#mcsel").empty();
                        for (var i = 0; i < MC_info.lists.length; i++) {
                            // console.log(MC_info.lists[i].subscribe_url_long);
                            // console.log($("textarea#mailchimpListUrl").val());
                            var a = MC_info.lists[i].subscribe_url_long;
                            var b = $("textarea#mailchimpListUrl").val();
                            // console.log(a.substring(a.indexOf("&id=")+5));
                            if(a.substring(a.indexOf("&id=")+5)===b.substring(b.indexOf("&id=")+5)){
                                // console.log("replacing");
                                $("#mcsel").append("<option selected=\"true\" value=\"" + MC_info.lists[i].subscribe_url_long + "\">"+MC_info.lists[i].name+"</option>");
                            } else {
                                $("#mcsel").append("<option value=\"" + MC_info.lists[i].subscribe_url_long + "\">"+MC_info.lists[i].name+"</option>");
                            }
                            $("#mcsel").attr("disabled", false);
                        }
                        MailChimpShow();
                    } else if ('error' in response) {
                        MailChimpHide();
                        alert(response.error.code, response.error.message);
                    } else {
                        // console.log(response);
                    }
                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                    MailChimpHide();
                    if(textStatus.toString() && errorThrown.toString()) 
                        alert(textStatus, errorThrown);
                    else
                    {
                        console.log("Error in ajax");
                        console.log(jqXHR);
                    }


                });
            }
            // else {
            //      console.log($("textarea#mailchimpListUrl").val() + " is empty:(");
            // }
            // console.log("End");
        })();//MailChimpInit

        $("#mailchimpListUrl").closest('.flex-text-wrap').css("display","none");


        $(".rmvIcon").on("click", rmvHandler);

        function MailChimpHide() {
            $(".mc-hide").hide();
        }

        function MailChimpShow() {
            $(".mc-hide").show();
        }

        function gFontAddClick(e) {
            e.preventDefault();
            var fontName = $("#gFonts").val();
            if(fontName=="")return;
            fNamesList = googleFontList.map(function(x){return x.family;});
            //console.log(fNamesList);
            if(fNamesList.indexOf(fontName) < 0) {
                alert("Please, select a valid font from the list.");
                return;
            }
            var existing = [];
            $("#gFontsList").children().each(function(){existing.push($(this).text())});
            // console.log(existing);
            if(existing.indexOf(fontName) >= 0) {
                alert("Font already exists.");
                return;
            }
            $("head").prepend("<link href='https://fonts.googleapis.com/css?family=" + encodeURI(fontName).replace(/%20/g,'+') + ':400,700|' + ((fontName == 'Muli') ? (encodeURI(fontName).replace(/%20/g,'+') + ':400italic|') : '') + "' rel='stylesheet' type='text/css' />");
            $("#gFontsList").append(
                '<li style="font-family: ' + fontName + '">' + '<div class="rmvIcon"><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="20px" height="20px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve"><path id="x-mark-4-icon" d="M462,256c0,113.771-92.229,206-206,206S50,369.771,50,256S142.229,50,256,50S462,142.229,462,256zM422,256c0-91.755-74.258-166-166-166c-91.755,0-166,74.259-166,166c0,91.755,74.258,166,166,166C347.755,422,422,347.741,422,256zM325.329,362.49l-67.327-67.324l-67.329,67.332l-36.164-36.186l67.314-67.322l-67.321-67.317l36.185-36.164l67.31,67.301l67.3-67.309l36.193,36.17l-67.312,67.315l67.32,67.31L325.329,362.49z"></path></svg></div>' + fontName + '</li>'
            );
            $("#gFontsList").children().last().on("click", rmvHandler)
            // console.log(fNamesList.indexOf(fontName));
            // console.log(googleFontList);
            var fontCat = googleFontList[fNamesList.indexOf(fontName)].category;
            $.ajaxQueue({
                url: ajaxurl,
                method: 'POST',
                data: {
                    action: 'dm_api',
                    method: 'google.fonts.add',
                    params: JSON.stringify({
                        font: {
                            name: fontName,
                            type: fontCat
                        }
                    })
                },
                dataType: 'json'
            })
            .done(function(response) {
                getAllFonts();
                $("#gFonts").closest(".tab-row").removeClass("changes");
                $("#gFonts").val("");
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                alert("Google.fonts.add: "+ textStatus, errorThrown);
            });
        }
        
        $("#gAPIsave").on("click",function() {
            setTimeout(function(){initGFonts(false);},1000);
        });

        $(".twigsave").on("click",function() {
            editDefaultFonts(false);
        });

        $("#nav_items").children().on("click",function(e){
            e.preventDefault();
            $(this).siblings().removeClass("active");
            $(e.target).addClass("active");
            navigate($(this).text());
        });
        
        $(".returnArrow, .returnArrowTxt").on("click",function(e) {
            navigate("Appearance");
        });

        /*["headline","hero","paragraph","background"].forEach(function(x) {
            $("." + x + "Arrow" + ", " + "." + x + "ArrowTxt").on("click",function(e) {
                navigate(x[0].toUpperCase()+x.slice(1));
            });
        });*///right arrow click handler

        !location.hash && navigate("Initial");

        initGFonts(true);
        getAllFonts();
        //Style loading:
        ["headline","hero","paragraph"].forEach(function(x){$("." + x + "Preview").loadTwigStyle(x);});
        $("#linkCL").loadTwigStyle('link');
        backgroundCSSLoad();

        ["headline","hero","paragraph"].forEach(function(x){
            [1,2].forEach(function(i){
                var property="font-size";
                if(i==2) property="line-height";
                $("#" + x + "Slider" + i).slider(
                    {
                        range: "min",
                        min: 1,
                        max: $("#" + x + "Slider" + i).attr("max"),
                        slide: sliderCallback(property),
                        change: sliderCallback(property)
                    });
            });
        });//font-size and line-height handler

        $(".clpick_panel").hide();

        ["headline","hero","paragraph","link", "background"].forEach(function(x) {
            $("#" + x + "CL").on("click",function() {
                $(this).siblings(".clpick_panel").toggle();
            });            
        });//colorpicker click handler

        function biChkbx(type,style){
            var postfix, option;
            if(style=="bold")
            {
                postfix="BL";
                option="weight";
            }
            else
            {
                postfix="IT";
                option="style";
            }
            $("#" + type + postfix).on("change",function() {
                var checked = false;
                $("#" + type + postfix + ":checked").each(function() {checked=true;});
                var cssstr="normal";
                if(checked) cssstr=style;
                $("." + type + "Preview").css("font-" + option, cssstr);
                editDefaultFonts(false);
            });
        }

        ["headline","hero","paragraph"].forEach(function(x) {
            ["bold","italic"].forEach(function(y) {
                biChkbx(x,y)
            });
        });//bold, italic checkbox handler
        ["ST","TL"].forEach(function(x) {
            $("#background" + x).on("click",function() {
                backgroundCSSSave();
            });
        });//background stretch and tile checkbox handler

        $(document).mouseup(function (e)
        {
            var container = $(".clpick_panel");

            if (!container.is(e.target) // if the target of the click isn't the container...
                && container.has(e.target).length === 0 // ... nor a descendant of the container...
                && !$("#headlineCL, #heroCL, #paragraphCL").is(e.target)) // ... nor the toggler
            {
                container.hide();
            }
        });

        $(".clpick_main").closest(".tab-row").disableSelection();

        function clpickMainEvent(evtype) {
            $(".clpick_main").on(evtype,function(e) {
                var handle = $(this).closest(".clpick_panel").attr("handle");
                if(evtype==="mousemove"){
                    // console.log(e);
                    if(e.which!=1) return false;
                    if(e.buttons!==undefined && e.buttons!=1) return false;
                }
                // console.log("Starting");
                var x = keepWithin(e.pageX - $(this).offset().left,0,255);
                var y = keepWithin(e.pageY - $(this).offset().top,0,255);
                $(this).find(".clpick_pin").css("top",y);
                $(this).find(".clpick_pin").css("left",x);
                // console.log("parse");
                var val = $(this).closest(".clpick_panel").find(".clpick_data").val();
                if(!val) val="{\"h\":0,\"s\":255,\"b\":255}";
                var h = JSON.parse(val).h;
                // console.log(h);
                if(!h) h=0;
                var s = x;
                var b = 255-y;
                function hsb(h,s,b){
                    return {
                        h: h,
                        s: s,
                        b: b
                    };
                }
                // console.log([h,s,b]);
                var hex = hsb2hex(hsb(h,s*100/255,b*100/255));
                if(["link","background"].indexOf(handle)<0){
                    $("." + handle + "Preview").css("color",hex);
                }
                $("#" + handle + "CL").css("background-color", hex);
                if(b>200 && s<50){
                    $("#" + handle + "CL").css("border", "1px solid rgba(200,200,200,1)");
                } else {
                    $("#" + handle + "CL").css("border", "1px solid rgba(108,108,108,0)");
                }
                $(this).closest(".clpick_panel").find(".clpick_data").val(JSON.stringify(hsb(h,s*100/255,b*100/255)))
                if(handle !== "background")
                {
                    editDefaultFonts();
                    //if(handle === "link")
                    //    cssLinkAjax(hex);
                }
                else
                    backgroundCSSSave();
                return false;
            });    
        }

        function clpickButtonWrapperEvent(evtype) {
            $(".clpick_button_wrapper").on(evtype,function(e) {
                var handle = $(this).closest(".clpick_panel").attr("handle");
                if(evtype==="mousemove"){
                    // console.log(e);
                    if(e.which!=1) return false;
                    if(e.buttons!==undefined && e.buttons!=1) return false;
                }
                var h = keepWithin(e.pageY - $(this).offset().top - 8,0,243);
                $(this).find(".clpick_button").css("top",h);
                h=360 - h*360/255;
                var val = $(this).closest(".clpick_panel").find(".clpick_data").val();
                if(!val) val="{\"h\":0,\"s\":255,\"b\":255}";
                var hsb = JSON.parse(val);
                hsb.h=h;
                $(this).closest(".clpick_panel").find(".clpick_data").val(
                        JSON.stringify({
                            h: hsb.h,
                            s: hsb.s,
                            b: hsb.b
                        })
                    );
                function hsb1(h,s,b){
                    return {
                        h: h,
                        s: s,
                        b: b
                    };
                }
                var hex = hsb2hex(hsb);
                if(["link","background"].indexOf(handle)<0){
                    $("." + handle + "Preview").css("color",hex);
                }
                $("#" + handle + "CL").css("background-color", hex);
                if(hex2hsb(hex).b>80 && hex2hsb(hex).s<50){
                    $("#" + handle + "CL").css("border", "1px solid rgba(200,200,200,1)");
                } else {
                    $("#" + handle + "CL").css("border", "1px solid rgba(108,108,108,0)");
                }
                hex = hsb2hex(hsb1(hsb.h,100,100));
                $(this).closest(".clpick_panel").find(".clpick_main").css("background",hex);
                if(handle !== "background")
                {
                    editDefaultFonts();
                    if(handle === "link")
                        cssLinkAjax(hex);
                }
                else
                    backgroundCSSSave();
                return false;
            });    
        }

        ["click","mousemove"].forEach(clpickMainEvent);
        ["click","mousemove"].forEach(clpickButtonWrapperEvent);
        
        function sliderCallback (classPrefix) {
            return function (event, ui) {
                // console.log("changed1:"+ui.value);
                $(this).children("span").html(ui.value);
                var el = $(this).attr("id").substring(0,$(this).attr("id").length-7);
                // console.log(el);
                var that=this;
                if(classPrefix=="line-height"){
                    $("."+el+"Preview").not(".noLH").removeClass(function(argument) {
                        arr=[];
                        for(var i=1;i<$(that).slider("option","max")+1;i++) 
                            arr.push(classPrefix+"-"+i);
                        // console.log(arr);
                        return arr.join(" ");
                    });
                    $("."+el+"Preview").not(".noLH").addClass(classPrefix+"-"+ui.value);
                } else {
                    $("."+el+"Preview").removeClass(function(argument) {
                        arr=[];
                        for(var i=1;i<$(that).slider("option","max")+1;i++) 
                            arr.push(classPrefix+"-"+i);
                        // console.log(arr);
                        return arr.join(" ");
                    });
                    $("."+el+"Preview").addClass(classPrefix+"-"+ui.value);
                }
                editDefaultFonts();
            }
        }

        function cssLinkAjaxOriginal(color) {
            $.ajaxQueue({
                url: ajaxurl,
                method: 'POST',
                data: {
                    action: 'dm_api',
                    method: 'css.link.edit',
                    params: JSON.stringify({
                        color: color
                    })
                },
                dataType: 'json'
            })
            .done(function(response) {
                if(!("result" in response))
                    alert("CSS Ajax error");
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                if(textStatus && errorThrown)
                    alert(textStatus + ":" + errorThrown);
                console.log(jqXHR);
            });
        }

        var cssLinkAjax = _.debounce(cssLinkAjaxOriginal, 1000, false);

        ["headline","hero","paragraph"].forEach(function(x){
            $("#" + x + "FF").on("change", function() {
                $("." + x + "Preview").css("font-family",$(this).val());
                editDefaultFonts(false);
            });
        });//font-family text field change handler

        $("input[name=radio]").on("click",function(){
            $("#backgroundValue").html($("input[name=radio]:checked").attr("value"));
            backgroundCSSSave();
        });

        ["gFonts","headlineFF","heroFF","paragraphFF"].forEach(function(x){
            $("#"+x).on("click",function(){
                $("#"+x).autocomplete("search","");
            });
        });

        function applyColor(style, value) {
            if(value=='transparent')value='#3d3d3d';
            if(value && value.indexOf("#")<0)
            {
                var rgbs = value.match(/[0-9]+/g).map(function(n)
                {
                    return +n;
                });
                var rgb = {r:rgbs[0],g:rgbs[1],b:rgbs[2]};
                $("#" + style + "CL").css("background-color",rgb2hex(rgb));
                var hsb = rgb2hsb(rgb);
                var $pin = $("#" + style + "CL").parent().find(".clpick_pin");
                $pin.css("top",(100-hsb.b)*255/100);
                $pin.css("left",hsb.s*255/100);
                var $hue = $("#" + style + "CL").parent().find(".clpick_button");
                $hue.css("top",(360-hsb.h)*255/360);
                $("#" + style + "CL").parent().find(".clpick_data").val(JSON.stringify(hsb));
                hsb.s=100;
                hsb.b=100;
                rgb = hsb2rgb(hsb);
                $("#" + style + "CL").parent().find(".clpick_main").css("background",rgb2hex(rgb));
            } else if (value) {
                $("#" + style + "CL").css("background-color",value);
                var hsb = hex2hsb(value);
                var $pin = $("#" + style + "CL").parent().find(".clpick_pin");
                $pin.css("top",(100-hsb.b)*255/100);
                $pin.css("left",hsb.s*255/100);
                var $hue = $("#" + style + "CL").parent().find(".clpick_button");
                $hue.css("top",(360-hsb.h)*255/360);
                $("#" + style + "CL").parent().find(".clpick_data").val(JSON.stringify(hsb));
                hsb.s=100;
                hsb.b=100;
                var rgb = hsb2rgb(hsb);
                $("#" + style + "CL").parent().find(".clpick_main").css("background",rgb2hex(rgb));
            }
        }

        function removeTypeKitId($this) {
            var el = $('#typeKitID', qardsWPSettings),
                name = el.attr('name'),
                parent = $this.closest('.tab-row'),
                removeIDSetting = {};

            removeIDSetting[name] = '';

            apiCall(removeIDSetting, function() {
                qardsWPSettingsInitData['typeKitID'] = '';
                delete qardsWPSettingsDataToSave[name];
                el.val('');
                parent.removeClass('changes has-typekit');
            });
        }

        function initCodeMirror(id, mode) {
            var editor = CodeMirror.fromTextArea(document.getElementById(id), {
                lineNumbers: true,
                mode: mode,
                lineWrapping: true,
                scrollbarStyle: 'simple',
                tabSize: 2
            });
            var totalLines = editor.lineCount();
            var totalChars = editor.getTextArea().value.length;
            editor.autoFormatRange({
                line: 0,
                ch: 0
            }, {
                line:totalLines,
                ch:totalChars
            });

            editor.on('change', function(obj){
                dirtyCheck(id, obj.getValue());
            });
        }

        function saveChanges(id) {
            var el = $('#' + id, qardsWPSettings),
                name = el.attr('name'),
                parent = el.closest('.tab-row'),
                changes = {};

            el.blur();
            if(name in qardsWPSettingsDataToSave) {
                changes[name] = qardsWPSettingsDataToSave[name];

                apiCall(changes, function() {
                    qardsWPSettingsInitData[id] = changes[name];
                    delete qardsWPSettingsDataToSave[name];
                    parent.removeClass('changes');
                    parent.find('.code-editor').removeClass('show');
                });
            } else {
                parent.removeClass('changes');
                parent.find('.code-editor').removeClass('show');
            }
        }

        function revertTypeKit($this) {
            var parent = $this.closest('.tab-row');

            $this.val(qardsWPSettingsInitData['typeKitID']);
            parent.find('.flex-text-wrap span').text(qardsWPSettingsInitData['typeKitID']);

            if(qardsWPSettingsInitData['typeKitID']) {
                parent.addClass('has-typekit');
            } else {
                parent.removeClass('has-typekit');
            }

            dirtyCheck($this.attr('id'), $this.val());
            parent.removeClass('changes');
            $this.blur();
        }

        /* Check data between qardsWPSettingsInitData and new value */
        function dirtyCheck(id, value) {
            var el = $('#' + id, qardsWPSettings),
                name = el.attr('name'),
                parent = el.closest('.tab-row');

            if(qardsWPSettingsInitData[id] !== value) {
                qardsWPSettingsDataToSave[name] = value;
            } else {
                delete qardsWPSettingsDataToSave[name];
            }

            if(name in qardsWPSettingsDataToSave) {
                parent.addClass('changes');
            }
        }

        function populateSettingInitData() {
            for(var i in qardsWPSettingsInitData) {
                if($('#' + i).hasClass('code-editor-textarea')) {
                    qardsWPSettingsInitData[i] = $('#' + i).siblings('.CodeMirror')[0] ? $('#' + i).siblings('.CodeMirror')[0].CodeMirror.getValue() : $('#' + i).val();
                } else {
                    qardsWPSettingsInitData[i] = $('#' + i).val();
                }
            }
        }

        function moveCursorToEnd(el) {
            if (typeof el.selectionStart == "number") {
                el.selectionStart = el.selectionEnd = el.value.length;
            } else if (typeof el.createTextRange != "undefined") {
                el.focus();
                var range = el.createTextRange();
                range.collapse(false);
                range.select();
            }
        }

        function typeKitValidation(value, $this) {
            if($this.attr('name') in qardsWPSettingsDataToSave) {
                if(value) {
                    $.ajax({
                        url: 'https://typekit.com/api/v1/json/kits/' + value + '/published',
                        method: 'GET',
                        data: {},
                        dataType: 'jsonp'
                    })
                    .done(function(response) {
                        if ('kit' in response) {
                            saveChanges($this.attr('id'));
                            $this.closest('.tab-row').addClass('has-typekit');
                        } else if ('errors' in response) {
                            if(response.errors[0].toLowerCase() === 'not found') {
                                alert('Kit "' + value + '" not found or not published.');
                            } else {
                                alert(response.errors[0]);
                            }
                            revertTypeKit($this);
                        }
                    })
                    .fail(function(jqXHR, textStatus, errorThrown) {
                        if(textStatus.toString() && errorThrown.toString()) 
                            alert(textStatus, errorThrown);
                        else
                        {
                            console.log("Error in ajax");
                            console.log(jqXHR);
                        }

                        revertTypeKit($this);
                    });
                } else {
                    removeTypeKitId($this);
                }
            } else {
                $this.closest('.tab-row').removeClass('changes');
                $this.blur();
            }
        }

        function apiCall(data, success, failure) {
            var defaultSuccess = function(result) {
                console.log(result);
            };
            var defaultFailure = function(code, msg) {
                alert("API failed: " + code + ": " + msg);
            };
            var success = success || defaultSuccess;
            var failure = failure || defaultFailure;

            $.ajaxQueue({
                url: ajaxurl,
                method: 'POST',
                data: {
                    action: 'dm_api',
                    method: 'settings.set',
                    params: JSON.stringify({
                        settings: data
                    })
                },
                dataType: 'json'
            })
            .done(function(response) {
                if ('result' in response) {
                    success(response.result);
                } else if ('error' in response) {
                    failure(response.error.code, response.error.message);
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                if(textStatus && errorThrown)
                    failure(textStatus, errorThrown);
            });
        }


        function initGFonts(firstrun) {
            // console.log("Before gfont ajax");
            $.ajaxQueue({
                url: ajaxurl,
                method: 'POST',
                data: {
                    action: 'dm_api',
                    method: 'google.fonts.get'
                },
                dataType: 'json'
            })
            .done(function(response) {
                // console.log("gfont ajax done");
                var data = JSON.parse(response.result.body);
                // console.log(data);
                if ("error" in data)
                {
                    if (firstrun && ($("#googleKey").val()==="")) {
                        // $("#gFonts").prop( "disabled", true );
                        // $("#gFonts").prop( "placeholder",'Please add the Google API key in "general settings" tab' );
                        return;
                    }
                    console.log("error");
                    if (data.error.errors[0].reason==="keyInvalid")
                        alert("Please, enter a valid Google API key");
                    else if (data.error.errors[0].reason==="accessNotConfigured")
                        alert("Please, make sure you enabled Google Web Fonts API in your developer console.");
                    else
                        alert("Google API failure: " + data.error.errors[0].reason + "\nPlease contact developer");
                    // $("#gFonts").prop( "disabled", true );
                    // $("#gFonts").prop( "placeholder",'Please add the Google API key in "general settings" tab' );
                } else {
                    googleFontList = data.items;
                    var fontList = data.items.map(function(x) {
                        return x.family;
                    });
                    // $("#gFonts").prop( "disabled", false );
                    // $("#gFonts").prop( "placeholder",'Start typing to add a font' );
                    $("#gFonts").autocomplete({
                      source: fontList,
                      change: gFontAddClick,
                      minLength: 0
                    });
                    getAllFonts();
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                if(textStatus && errorThrown)
                    alert("initGFonts failure - "+textStatus+":"+errorThrown);
            });
        }

        function editDefaultFontsOriginal(reset) {
            var defaultData = {
                headline: "'Helvetica Neue', Helvetica, Arial, sans-serif",
                hero: "'Helvetica Neue', Helvetica, Arial, sans-serif",
                paragraph: "'Helvetica Neue', Helvetica, Arial, sans-serif",
                headlineFS: "font-size-4",
                headlineLH: "line-height-4",
                heroFS: "font-size-4",
                heroLH: "line-height-4",
                paragraphFS: "font-size-4",
                paragraphLH: "line-height-4",
                headlineCL: "rgb(255, 255, 255)",
                heroCL: "rgb(255, 255, 255)",
                paragraphCL: "rgb(255, 255, 255)",
                headlineBL: "bold",
                heroBL: "normal",
                paragraphBL: "normal",
                headlineIT: "normal",
                heroIT: "normal",
                paragraphIT: "normal",
                linkCL: "rgb(108, 108, 108)"
            };
            var getSliderValue=function(selector, prefix) {
                // console.log($(selector).slider("option", "value"));
                var val = parseInt($(selector).slider("option", "value"));
                // console.log(val);
                if(typeof val==="number" && val>0) return prefix+val;
                else return "";
            }
            var getColorValue=function(selector) {
                var val = $(selector).parent().find(".clpick_data").val();
                if (!val) return "";
                var hsb = JSON.parse(val);
                return hsb2hex(hsb);
            }
            var getBoldValue=function(selector) {
                var bold = false;
                $(selector + ":checked").each(function() {bold=true;});
                var cssstr="normal";
                if(bold)cssstr="bold";
                return cssstr;
            }
            var getItalicValue=function(selector) {
                var italic = false;
                $(selector + ":checked").each(function() {italic=true;});
                var cssstr="normal";
                if(italic)cssstr="italic";
                return cssstr;
            }
            var getLinkColorValue=function() {
                return $("#linkCL").css("background-color");
            };
            var data = {
                headline: $("#headlineFF").val(),
                hero: $("#heroFF").val(),
                paragraph: $("#paragraphFF").val(),
                headlineFS: getSliderValue("#headlineSlider1","font-size-"),
                headlineLH: getSliderValue("#headlineSlider2","line-height-"),
                heroFS: getSliderValue("#heroSlider1","font-size-"),
                heroLH: getSliderValue("#heroSlider2","line-height-"),
                paragraphFS: getSliderValue("#paragraphSlider1","font-size-"),
                paragraphLH: getSliderValue("#paragraphSlider2","line-height-"),
                headlineCL: getColorValue("#headlineCL"),
                heroCL: getColorValue("#heroCL"),
                paragraphCL: getColorValue("#paragraphCL"),
                headlineBL: getBoldValue("#headlineBL"),
                heroBL: getBoldValue("#heroBL"),
                paragraphBL: getBoldValue("#paragraphBL"),
                headlineIT: getItalicValue("#headlineIT"),
                heroIT: getItalicValue("#heroIT"),
                paragraphIT: getItalicValue("#paragraphIT"),
                linkCL: getLinkColorValue()
            }
            // console.log(data);
            $.ajaxQueue({
                url: ajaxurl,
                method: 'POST',
                data: {
                    action: 'dm_api',
                    method: 'twig.defaults.edit',
                    params: JSON.stringify({
                        changes: (reset ? defaultData : data)
                    })
                },
                dataType: 'json'
            })
            .done(function(response) {
                if("error" in response)
                    alert(response.error.message);
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                if (textStatus.toString() && errorThrown.toString()) {
                    alert(textStatus, errorThrown);
                } else {
                    console.log("Error in ajax");
                    console.log(jqXHR);
                }

            });
            cssLinkAjax((reset ? defaultData : data).linkCL);
        }

        function navigate(wh) {
            var animTime = 600;
            if(wh==="Initial") {
                $(".tab-content").children().not("#general").fadeOut(animTime);
                return;
            }
            $(".tab-content").children().fadeOut(animTime);
            switch(wh) {
                case "General" :
                    $("#general").delay(animTime).fadeIn(animTime);
                    break;
                case "Account" :
                    $("#account").delay(animTime).fadeIn(animTime);
                    break;
                case "Appearance" :
                    $("#appearance").delay(animTime).fadeIn(animTime);
                    break;
                case "Headline" :
                    $("#headline_sub").delay(animTime).fadeIn(animTime);
                    break;
                case "Hero" :
                    $("#hero_sub").delay(animTime).fadeIn(animTime);
                    break;
                case "Paragraph" :
                    $("#paragraph_sub").delay(animTime).fadeIn(animTime);
                    break;
                case "Background" :
                    $("#background_sub").delay(animTime).fadeIn(animTime);
                    break;
            } 
        }

        function getAllFonts() {
            $.ajaxQueue({
                url: ajaxurl,
                method: 'POST',
                data: {
                    action: 'dm_api',
                    method: 'font.get'
                },
                dataType: 'json'
            })
            .done(function(response) {
                // console.log("gfont ajax done");
                // console.log(response);
                var arr=[];
                for(var type in response.family) {
                    for(var font in response.family[type]) {
                        if(font.indexOf(' ')<0)
                            arr.push(font);
                        else
                            arr.push("'" + font + "'");
                    }
                }
                allFF = arr;
                ["headline","hero","paragraph"].forEach(function(x) {allFFauto("#" + x + "FF");});
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                if(textStatus.toString() && errorThrown.toString()) {
                    console.log(textStatus);
                    console.log(errorThrown);
                    alert(textStatus, errorThrown);
                } else {
                    console.log("Error in ajax");
                    console.log(jqXHR);
                }

                return;
            });
        }

        function allFFauto (selector) {
            var availableTags = allFF;
            function split( val ) {
              return val.split( /,\s*/ );
            }
            function extractLast( term ) {
              return split( term ).pop();
            }
         
            $( selector )
              // don't navigate away from the field on tab when selecting an item
              .bind( "keydown", function( event ) {
                if ( event.keyCode === $.ui.keyCode.TAB &&
                    $( this ).autocomplete( "instance" ).menu.active ) {
                  event.preventDefault();
                }
              })
              .autocomplete({
                minLength: 0,
                source: function( request, response ) {
                  // delegate back to autocomplete, but extract the last term
                  response( $.ui.autocomplete.filter(
                    availableTags, extractLast( request.term ) ) );
                },
                focus: function() {
                  // prevent value inserted on focus
                  return false;
                },
                select: function( event, ui ) {
                  var terms = split( this.value );
                  // remove the current input
                  terms.pop();
                  // add the selected item
                  terms.push( ui.item.value );
                  // add placeholder to get the comma-and-space at the end
                  // terms.push( "" );
                  this.value = terms.join( ", " );
                  return false;
                },
                change: function() {
                    var prefix = $(this).attr("id").substring(0,$(this).attr("id").length-2);
                    var that = this;
                    setTimeout(function() {$("." + prefix + "Preview").css("font-family",$(that).val());},100);
                    editDefaultFonts(false);
                }
              });
        }

        function rmvHandler(e) {
            // console.log("gFontsDelete ajax sent");
            $.ajaxQueue({
                url: ajaxurl,
                method: 'POST',
                data: {
                    action: 'dm_api',
                    method: 'google.fonts.delete',
                    params: JSON.stringify({
                        font: {
                            name: $(e.target.closest("li")).text()
                        }
                    })
                },
                dataType: 'json'
            })
            .done(function(response) {
                // console.log("gFontsDelete ajax done");
                //var data = JSON.parse(response.result.body);
                // console.log(response);
                e.target.closest("li").remove();
                getAllFonts();
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                alert("Google.fonts.add: "+ textStatus, errorThrown);
            });
        }

        function backgroundCSSLoad() {
            $.ajaxQueue({
                url: ajaxurl,
                method: 'POST',
                data: {
                    action: 'dm_api',
                    method: 'settings.get',
                    params: JSON.stringify({
                        settings: ["_QARDS_SETTING_BACKGROUND_CSS"]
                    })
                },
                dataType: 'json'
            })
            .done(function(response) {
                if ('result' in response) {
                    console.log(response.result);
                    if(response.result._QARDS_SETTING_BACKGROUND_CSS)
                        backgroundCSSProcess(response.result._QARDS_SETTING_BACKGROUND_CSS);
                    else
                        backgroundCSSProcess("#ffffff");
                } else if ('error' in response) {
                    alert(response.error.code + ":" + response.error.message);
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                alert(textStatus + ":" + errorThrown);
            });
        }

        function backgroundCSSSaveOriginal() {
            var cssstr = "";
            cssstr += "background-color:" + $("#backgroundCL").css("background-color");
            cssstr += ";";
            cssstr += "background-position:" + $("#backgroundValue").html();
            cssstr += ";";
            cssstr += "background-size:";
            cssstr += ($("#backgroundST").prop("checked") ? "contain" : "auto");
            cssstr += ";";
            cssstr += "background-repeat:";
            cssstr += ($("#backgroundTL").prop("checked") ? "repeat" : "no-repeat");
            cssstr += ";";
            $.ajaxQueue({
                url: ajaxurl,
                method: 'POST',
                data: {
                    action: 'dm_api',
                    method: 'background.css.set',
                    params: JSON.stringify({
                        css: cssstr
                    })
                },
                dataType: 'json'
            })
            .done(function(response) {
                if ('result' in response) {
                    console.log(response.result);
                } else if ('error' in response) {
                    alert(response.error.code + ":" + response.error.message);
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                alert(textStatus + ":" + errorThrown);
            });
        }

        function backgroundCSSProcess(str) {
            var arr=cssString2Obj(str);
            console.log(arr);
            applyColor("background", arr["background-color"]);
            $(".pospick").find("input").prop("checked", false);
            $(".pospick").find("input[value=\"" + arr["background-position"] + "\"]").prop("checked", true);
            $("#backgroundValue").html(arr["background-position"]);
            if(arr["background-size"]==="contain") $("#backgroundST").prop("checked", true);
            if(arr["background-repeat"]==="repeat") $("#backgroundTL").prop("checked", true);
        }

        function cssString2Obj (str) {
            return str.replace(/;\s*$/, "")
                      .split(";")
                      .map(function(x) {
                                return (function(s,a){
                                    s[a[0]]=a[1];
                                    return s;
                                })({},x.split(":"));
                            })
                      .reduce(function(prev, curr, index, arr) {
                            for(x in curr)prev[x]=curr[x];
                            return prev;
                      },{});
        }

        $(window).on('beforeunload', function() {
            if(!$.isEmptyObject(qardsWPSettingsDataToSave)) {
                return 'Please save you changes before leaving.';
            }
        });

        /* Prevent body scroll if code editor has scroll */
        (function() {
            var trapElement,
                scrollableDist,
                trapClassName = 'trapScroll-enabled',
                trapSelector = '.CodeMirror-scroll';

            var trapWheel = function(e){
                if (!$('body').hasClass(trapClassName)) {
                    return;
                } else {
                    var curScrollPos = trapElement.scrollTop(),
                        wheelEvent = e.originalEvent,
                        dY = wheelEvent.deltaY;

                    if((dY > 0 && curScrollPos >= scrollableDist) || (dY < 0 && curScrollPos <= 0)) {
                        return false;
                    }
                }
            };

            $(document)
                .on('wheel', trapWheel)
                .on('mouseleave', trapSelector, function(){
                    $('body').removeClass(trapClassName);
                })
                .on('mouseenter', trapSelector, function(){
                    trapElement = $(this);

                    var containerHeight = trapElement.outerHeight(),
                        contentHeight = trapElement[0].scrollHeight;

                    scrollableDist = contentHeight - containerHeight;

                    if(contentHeight > containerHeight) {
                        $('body').addClass(trapClassName);
                    }
                });
        })();

        /* Make qardsWPSettings visible once all JS was loaded */
        (function() {
            $(qardsWPSettings).removeClass('invisible');
            if (location.hash) {
                $('#nav_items').find('a[href="'+ location.hash + '"]').siblings().removeClass('active');
                $('#nav_items').find('a[href="'+ location.hash + '"]').addClass('active');
                $(location.hash).siblings().hide();
                $(location.hash).show();
                location.hash = '';
            }
        })();

        function hsb2rgb (hsb) {
            var rgb = { };
            var h = Math.round(hsb.h);
            var s = Math.round(hsb.s * 255 / 100);
            var v = Math.round(hsb.b * 255 / 100);
            // console.log([h,s,v]);
            if (s === 0) {
              rgb.r = rgb.g = rgb.b = v;
            } else {
              var t1 = v;
              var t2 = (255 - s) * v / 255;
              var t3 = (t1 - t2) * (h % 60) / 60;
              // console.log([t1,t2,t3]);
              if ( h === 360 ) h = 0;
              if ( h < 60 ) { rgb.r = t1; rgb.b = t2; rgb.g = t2 + t3; }
              else if ( h < 120 ) { rgb.g = t1; rgb.b = t2; rgb.r = t1 - t3; }
              else if ( h < 180 ) { rgb.g = t1; rgb.r = t2; rgb.b = t2 + t3; }
              else if ( h < 240 ) { rgb.b = t1; rgb.r = t2; rgb.g = t1 - t3; }
              else if ( h < 300 ) { rgb.b = t1; rgb.g = t2; rgb.r = t2 + t3; }
              else if ( h < 360 ) { rgb.r = t1; rgb.g = t2; rgb.b = t1 - t3; }
              else { rgb.r = 0; rgb.g = 0; rgb.b = 0; }
            }

            return {
              r: Math.round(rgb.r),
              g: Math.round(rgb.g),
              b: Math.round(rgb.b)
            };
        };

        function rgb2hex (rgb) {
            if (!rgb) {
              return '';
            }

            var hex = [
              rgb.r.toString(16),
              rgb.g.toString(16),
              rgb.b.toString(16)
            ];

            $.each(hex, function(nr, val) {
              if (val.length === 1) {
                hex[nr] = '0' + val;
              }
            });

            return '#' + hex.join('');
        }

        function hsb2hex (hsb) {
            return rgb2hex(hsb2rgb(hsb));
        }

        function hex2hsb (hex) {
            var hsb = rgb2hsb(hex2rgb(hex));
            if( hsb.s === 0 ) hsb.h = 360;
            return hsb;
        }

        function rgb2hsb(rgb) {
            var hsb = { h: 0, s: 0, b: 0 };
            var min = Math.min(rgb.r, rgb.g, rgb.b);
            var max = Math.max(rgb.r, rgb.g, rgb.b);
            var delta = max - min;
            hsb.b = max;
            hsb.s = max !== 0 ? 255 * delta / max : 0;
            if( hsb.s !== 0 ) {
              if( rgb.r === max ) {
                hsb.h = (rgb.g - rgb.b) / delta;
              } else if( rgb.g === max ) {
                hsb.h = 2 + (rgb.b - rgb.r) / delta;
              } else {
                hsb.h = 4 + (rgb.r - rgb.g) / delta;
              }
            } else {
              hsb.h = -1;
            }
            hsb.h *= 60;
            if( hsb.h < 0 ) {
              hsb.h += 360;
            }
            hsb.s *= 100/255;
            hsb.b *= 100/255;
            return hsb;
        }

        function hex2rgb (hex) {
            if (!hex) {
              return undefined;
            } else if (hex.length === 4 && hex.indexOf('#') === 0) {
              // short mode
              var r = hex[1];
              var g = hex[2];
              var b = hex[3];

              hex = '#' + r + r + g + g + b + b;
            }

            hex = parseInt(((hex.indexOf('#') > -1) ? hex.substring(1) : hex), 16);
            return {
              r: hex >> 16,
              g: (hex & 0x00FF00) >> 8,
              b: (hex & 0x0000FF)
            };
        }

        function keepWithin (value, min, max) {
            if (value < min) value = min;
            if (value > max) value = max;
            return value;
        }
        tippy('.disabled[title]',{
            placement: 'top',
            animation: 'fade',
            duration: 1000,
            arrow: true
        })
    });
})(jQuery);