var CACommon = new function () {
    this.GoLogin = function (redirectURL) {
        if (redirectURL == undefined || redirectURL.length == 0)
            redirectURL = location.pathname + location.search;
        redirectURL = encodeURIComponent(redirectURL)
        location.href = "/Auth/Login?from=" + redirectURL;
    }
    this.Logout = function (redirect) {
        redirect = redirect == undefined || redirect.length == 0 ? location.href : redirect;
        var openURL = "", alertMsg = "";
        if (window.loginType >= 0) {
            if (window.loginType != 0) {
                redirect = (redirect.indexOf(location.origin) < 0 ? location.origin + redirect : redirect)
                NgbLogin.Logout(redirect);
            }
            else
                location.href = "/Auth/Logout?from=" + encodeURIComponent(redirect);
        } else {
            location.href = redirect;
        }
    }
    this.GoMyBlock = function (gameid, servercode) {
        gameid = encodeURIComponent($.trim(gameid));
        location.href = "/MyBlock/Information/" + gameid + "/" + Number(servercode);
    }
    this.GoMain = function () {
        if (location.search.indexOf("f=mobile") > -1)
            location.href = "/Home/Index?f=mobile";
        else
            location.href = "/Home/Index";
        return false;
    }
    this.TodayChkFn = function (strCookieName) {
        CACommon.setCookie(strCookieName, "true", 1);
        CACommon.GoMain();
    }
    this.LoginInfo = function () {
        if ($("#common .log_info").length > 0) {
            $("#common .log_info").load("/auth/logininfo", {}, function (e) { loginfoFold(); });
        }
    }
    this.GameIDUrl = function (atype, redirect) {
        $.ajax({
            url: '/Auth/addGameIDURL', async: false, type: 'post', data: { type: atype },
            success: function (data) {
                if (data != undefined && data != null) {
                    if (atype == "add" && !CACommon.isJsonData(data) && $(data).find(".create_gameId").length > 0) {
                        CACommon.GameIDAddLayer(data);
                    }
                    else if (data.ReturnCode == 0 && atype != "add") {
                        //if (atype == "add") { CACommon.windowPopup(data.ReturnMsg, 680, 650, 0, 'IDGeneration'); }
                        CACommon.windowPopup(data.ReturnMsg, 680, 650, 0, 'IDJoin'); 
                    } else if (data.ReturnCode == 1) {
                        $("#layerLogin6").find(".reason").text(data.Info.RestrictReason);
                        $("#layerLogin6").find(".period").text((data.Info.period == -9 ? "영구제한" : (data.Info.period + '일 (' + data.Info.begin + ' ~ ' + data.Info.end + ')')));
                        $("#layerLogin6").show();
                    } else {
                        if (data.ReturnCode == -998) {
                            CACommon.setCookieDays('SaveLT', "e", 30);
                            redirect = redirect == undefined || redirect.length == 0 ? location.href : redirect;
                            alert("넥슨 회원 로그인 후 이용가능합니다.\n게임아이디 " + (atype == "add" ? "생성" : "통합") + "을 위해 로그아웃을 진행합니다."); CACommon.Logout('/Auth/Login?from=' + encodeURIComponent(redirect));
                        }
                        else { (alert(data.ReturnMsg == "" ? "오류가 발생하였습니다.\n잠시 후 다시 시도해주세요." : data.ReturnMsg)) }
                    }
                }
                else { alert("오류가 발생하였습니다.\n잠시 후 다시 시도해주세요."); }
            },
            error: function (error) { alert("오류가 발생하였습니다.\n잠시 후 다시 시도해주세요."); }
        });
    }
    this.GameIDCheck = function () {
        $obj = $("#layerCreateGameId");
        var gameid = $.trim($obj.find("input[name=gameid]").val());
        if (gameid.length == 0) {
            setTooltip('warning', "한글 2자리 이상 6자리 이하, 영문 12자 이하로 입력해주세요.");
        } else {
            $.ajax({
                url: '/Auth/IDGeneration/AjaxCheckID', method: 'post', dataType: 'json'
                , data: { gameid: gameid, servercode: $obj.find("input[name='server']:checked").val(), __RequestVerificationToken: $obj.find("input[name=__RequestVerificationToken]").val() }
                , success: function (data) {
                    if (CACommon.isJsonData(data)) {
                        setTooltip(data.returnCode == 0 ? 'confirm' : 'warning', data.returnMsg); $obj.find("input[name=gameid]").data("checkgameid", gameid);
                    }
                    else { alert("확인 중 오류가 발생하였습니다.\n잠시 후 다시 시도 해 주시기 바랍니다."); }
                }, error: function (err) { alert('확인 중 오류가 발생하였습니다.\n잠시 후 다시 시도 해 주시기 바랍니다.'); }
            });
        }
    }
    this.GameIDAddLayer = function (data) {
        var checkobj = "#layerCreateGameId";
        if ($.trim(data).length > 0) {
            if (CACommon.isJsonData(data)) { alert(data.ReturnMsg == "" ? "오류가 발생하였습니다.\n잠시 후 다시 시도해주세요." : data.ReturnMsg); return; }

            if (!document.querySelector(checkobj)) {
                if (document.querySelector(checkobj)) {
                    document.querySelector(checkobj).id = checkobj.replace("#","");
                } else {
                    const layerCreate = document.createElement('div');
                    layerCreate.className = 'layer_gameid';
                    layerCreate.id = checkobj.replace("#", "");
                    layerCreate.style.display = 'none';
                    document.body.appendChild(layerCreate);
                }
            }            
            document.querySelector(checkobj).innerHTML = data;
        }

        if (document.querySelector(checkobj)) {
            const layergameidadd = document.querySelector(checkobj);
            layergameidadd.querySelector("input[name=gameid]").addEventListener("keyup", function (e) {
                if (e.keyCode === 13) { e.preventDefault(); layergameidadd.querySelector("button.check_same").click(); }
                else if (layergameidadd.querySelector("input[name=gameid]").value.length == 0) { setTooltip('warning', "한글 2자리 이상 6자리 이하, 영문 12자 이하로 입력해주세요.");}
                else if (layergameidadd.querySelector("p.tooltip_txt").innerText.indexOf("게임ID 중복") < 0) { setTooltip("warning", "게임ID 중복확인을 해주세요.") }
            });
            layergameidadd.querySelectorAll("input[name=server]").forEach((item) => {
                item.addEventListener("click", function (e) {
                    if (layergameidadd.querySelector("input[name=gameid]").value.length == 0) { setTooltip('warning', "한글 2자리 이상 6자리 이하, 영문 12자 이하로 입력해주세요."); }
                    else if (layergameidadd.querySelector("p.tooltip_txt").innerText.indexOf("게임ID 중복") < 0) { setTooltip("warning", "게임ID 중복확인을 해주세요."); }
                })
            });
            openGameIdPopup('layerCreateGameId');
            if ($.trim(data).length > 0) {
                CACommon.a2sSendClickLog(null, "CA_ID_GENERATION_01", `{"button_type":"gameid_create${layergameidadd.querySelector(".create_gameId").getAttribute("data-gameidcheck")}"}`);
            } else {
                CACommon.a2sSendClickLog(null, "CA_ID_GENERATION_01", `{"button_type":"gameid_create_page_new"}`);
            }
        }
    }   
    this.GameIDProc = function () {
        $obj = $("#layerCreateGameId");
        var gameid = $.trim($obj.find("input[name=gameid]").val());
        if (gameid.length == 0) { setTooltip('warning', "한글 2자리 이상 6자리 이하, 영문 12자 이하로 입력해주세요."); return;}
        else if ($obj.find("input[name=gameid]").data("checkgameid") != gameid) {
            setTooltip("warning", "게임ID 중복확인을 해주세요.");
            return;
        }
        else if ($obj.find("p.tooltip_txt").text().indexOf("등록이 가능한") < 0) {
            setTooltip("warning", $obj.find("p.tooltip_txt").text());
            return;
        }
        $.ajax({
            url: '/Auth/IDGeneration/AjaxAddID', method: 'post' , data: { gameid: gameid, servercode: $obj.find("input[name='server']:checked").val(), __RequestVerificationToken: $obj.find("input[name=__RequestVerificationToken]").val() }
            , success: function (data) {
                if (CACommon.isJsonData(data)) { setTooltip('warning', data.returnMsg); }
                else if ($(data).find(".modal_contents").length > 0) {
                    document.querySelector('#layerCreateGameId').innerHTML = data;
                    $("#layerCreateGameId").attr("id", "layerCompleteGameId");
                    CACommon.LoginInfo();
                    var $a2scompleteobj = $(data).find(".btn_close");
                    CACommon.a2sSendClickLog(null, $a2scompleteobj.attr("data-object"), $a2scompleteobj.attr("data-option"));
                }
                else { alert("확인 중 오류가 발생하였습니다.\n잠시 후 다시 시도 해 주시기 바랍니다."); }
            }, error: function (err) { alert('확인 중 오류가 발생하였습니다.\n잠시 후 다시 시도 해 주시기 바랍니다.'); }
        });        
    }
    this.Trans = function (redirect) {
        redirect = redirect == undefined || redirect.length == 0 ? location.href : redirect;
        window.open('/Auth/Trans?redirect=' + encodeURIComponent(redirect));
        if (window.loginType >= 0) {
            alert("이메일 ID 전환 절차를 위해 nexon.com 로그아웃을 진행합니다.");
        }
    }
    this.NexonJoin = function (redirect) {
        NgbMember.GoRegisterPage(130);
        if (window.loginType >= 0) {
            alert("넥슨 회원가입을 위해 로그아웃을 진행합니다.");
            this.Logout(redirect);
        }
    }
    this.RealNameAuth = function (l, m, a) {
        if (l && m == "Email") {
            if (a == 2) { alert("본인 확인된 넥슨 계정입니다."); }
            else { NgbMember.RealNameAuth(); }
        } else { alert("이메일 ID로 로그인 후 이용 가능합니다."); }
    }
    this.GameClientStart = function () {
        if (CACommon.isMobile()) {
            alert("모바일 환경에서 게임 실행은 지원하지 않습니다. \nPC에서 게임 실행을 다시 시도해주세요.");
        } else {
            PS.game.startGame({ gameCode: 720897 });
            //PS.game.startGame({ gameCode: 65545, param: '/gamecode:720897 /fromweb'});                
            fbq('trackCustom', 'CompleteRegistration_Btn2');
            $h.a2s.sendClickLog('GAME_START', null);
            ga('send', 'event', 'gaGameStart', 'gaStart', 'startPC');
            window.dataLayer.push({ 'event': 'launcher_play' });
            try { gtag_report_conversion(); } catch (e) { }
        }
    }
    this.GameStart = function (r) {
        r = r == undefined || r == null ? false : true;

        if ($("body").attr("data-isCAGameStart") == undefined || $("body").attr("data-isCAGameStart") == "false") {
            $("body").attr("data-isCAGameStart", "true");
            $.ajax({
                url: '/Auth/GameStart', async: false, type: 'post', dataType: 'json', data: {},
                success: function (data) {
                    if (data != undefined && data != null) {
                        if (data.returnCode == 0) {
                            PS.game.startGame({ gameCode: 720897, param: data.data });
                            fbq('trackCustom', 'CompleteRegistration_Btn1');
                            $h.a2s.sendClickLog('GAME_START', null);
                            ga('send', 'event', 'gaGameStart', 'gaStart', 'startPC');
                            window.dataLayer.push({ 'event': 'game_start' });
                            try { gtag_report_conversion(); } catch (e) { }
                        } else if (data.returnCode == -801) {
                            NgbMember.RealNameAuth();
                        } else {
                            if (data.strReturn.indexOf("로그인 후") >= 0 && r) {
                                CACommon.GoLogin();
                            } else if (data.strReturn.indexOf("게임ID 생성 후") >= 0) {
                                CACommon.GameIDUrl("add");
                            } else {
                                alert(data.strReturn);
                            }                            
                        }
                    }
                    else { alert("게임 실행 중 오류가 발생하였습니다.\n잠시 후 다시 시도해주세요."); }
                    $("body").attr("data-isCAGameStart", "false");
                },
                error: function (error) { alert("게임 실행 중 오류가 발생하였습니다.\n잠시 후 다시 시도해주세요."); $("body").attr("data-isCAGameStart", "false"); }
            });
        } else { alert("게임 실행중입니다. 잠시만 기다려주세요."); }
    }
    this.SecondPassword = function () {
        $.ajax({
            url: "/Support/SecondPasswordCheck", async: false, type: 'post', dataType: 'json'
            , success: function (data) {
                if (data != undefined && data != null && data.returnCode == 0) {
                    CACommon.windowPopup('/Support/SecondPassword', 698, 880, 'secendpw')
                } else {
                    alert((data != undefined && data != null && data.returnMsg.length > 0 ? data.returnMsg.replace(/\\n/g, "\n") : "2차 비밀번호 정보 조회 도중 오류가 발생하였습니다."));
                }
            }, error: function (error) { alert("2차 비밀번호 정보 조회 도중 오류가 발생하였습니다."); }
        });
    }
    this.PlaceHolderFocus = function () {
        $('.placeholder').on('focus', function () {
            if (this.value.length < 1) { $(this).siblings('label').hide(); }
        }).on('blur', function () {
            if (this.value.length < 1) { $(this).siblings('label').show(); }
        });
    }
    this.CopyBoardShortCut = function (value) {
        if (window.clipboardData) {
            window.clipboardData.setData("Text", value);
            alert('주소가 복사되었습니다. 블로그, 카페 게시판에 html 선택 후 Ctrl+V로 붙여 넣기 하세요.');
        }
        else {
            function handler(event) {
                event.clipboardData.setData('text/plain', value);
                event.preventDefault();
                document.removeEventListener('copy', handler, true);
            }
            try {
                document.addEventListener('copy', handler, true);
                document.execCommand('copy');
                alert('주소가 복사되었습니다. 블로그, 카페 게시판에 html 선택 후 Ctrl+V로 붙여 넣기 하세요.');
            } catch (e) {
                temp = prompt("이 글의 트랙백 주소입니다. Ctrl+C를 눌러 클립보드로 복사하세요", url);
            }
        }
    }
    this.GetSNS = function (service) {
        if (!CACommon.ieBrowser()) {
            var popupWidth = 1024; var popupHeight = 800; var SNSURL = ""; var popupScroll = "yes";
            var title = "[크레이지 아케이드] " + $("meta[property='og:title']").attr("content") + (service == "twitter" ? " - " + $("meta[property='og:description']").attr("content") : "");
            var url = $("meta[property='og:url']").attr("content");
            switch (service) {
                case "facebook":
                    SNSURL = "http://www.facebook.com/sharer.php?t=" + encodeURIComponent(title) + "&u=" + encodeURIComponent(url);
                    popupWidth = 800; popupHeight = 400; break;
                case "twitter":
                    SNSURL = "https://twitter.com/intent/tweet?text=" + encodeURIComponent(title) + "&url=" + encodeURIComponent(url);
                    popupWidth = 800; popupHeight = 425; break;
            }
            window.open(SNSURL, service, 'width=' + popupWidth + ', height=' + popupHeight + ',resizable=yes,scrollbars=' + popupScroll);
        } else {
            alert((service == "facebook" ? "페이스북" : "트위터") + " 서비스가 Internet Explorer 브라우저에서 중단되었습니다.");
        }
    }
    this.CheckStrLen = function (obj) {
        var $obj = $(obj).find("textarea"), $objNum = $(obj).find("span .num");
        var msglen = $obj.val().length, maxlen = Number($obj.attr("data-maxlength")), isAlter = $obj.attr("data-alert");
        if (msglen != 0) {
            if (msglen > maxlen) {
                if (isAlter) { alert(maxlen + "자 까지 작성하실 수 있습니다."); }
                $obj.val($obj.val().substring(0, maxlen));
            }
        }
        $objNum.text($obj.val().length);
    }
    this.NumberComma = function (str) {
        return String(str).replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,');
    }
    this.NumberUnComma = function (str) {
        return String(str).replace(/[^\d]+/g, '');
    }
    this.windowPopup = function (url, w, h, s, name) {
        if (w == null) w = '100%';
        if (h == null) h = '100%';
        var l, t = '0';
        if (screen.width && screen.height) {
            l = (screen.width - w) / 2;
            t = (screen.height - h) / 2;
        }
        if (s == null) s = '0';
        if (name == null) name = '';
        window.open(url, name, 'width=' + w + ',height=' + h + ',left=' + l + ',top=' + t + ',resizable=0,menubar=0,toolbar=0,scrollbars=' + s + ',status=0');
    }
    this.windowPopup2 = function (url) {
        var options = 'scrollbars=yes, resizable=yes, ';
        var top = 0;
        var left = 0;
        var width = 0;
        var height = 500;

        var contentWidth = 1024;
        var windowWidth = screen.availWidth;
        var windowHeight = screen.availHeight;

        if (windowWidth <= contentWidth) {
            width = windowWidth;
        } else {
            width = 1024;
            left = Math.floor((windowWidth - contentWidth) / 2);

            if ($('html').hasClass('ie7') || $('html').hasClass('ie8')) {
                width = 1024 + 17;
            }
        }

        height = windowHeight - 70;

        //width = 1024;
        if (height > 1050) {
            height = 900;
        }
        else if (height > 900 && height <= 1050) {
            height = 800;
        }
        else if (height >= 720 && height <= 600) {
            height = 600;
        }
        else {
            height = 900;
        }
        options += 'top=' + top + ', left=' + left + ', width=' + width + ', height=' + height + '';

        window.open(url, 'target', options);
    }
    this.setCookie = function (name, value, expiredays) {
        var todayDate = new Date();
        todayDate.setDate(todayDate.getDate() + expiredays);
        document.cookie = name + "=" + escape(value) + "; path=/; expires=" + todayDate.toGMTString() + ";"
    }
    this.setCookieDays = function (name, value, days) {
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            var expires = "; expires=" + date.toGMTString();
        } else {
            var expires = "";
        }
        document.cookie = name + "=" + value + expires + "; path=/";
    }
    this.getCookie = function (name) {
        var nameOfCookie = name + "=";
        var x = 0;
        while (x <= document.cookie.length) {
            var y = (x + nameOfCookie.length);
            if (document.cookie.substring(x, y) == nameOfCookie) {
                if ((endOfCookie = document.cookie.indexOf(";", y)) == -1)
                    endOfCookie = document.cookie.length;
                return unescape(document.cookie.substring(y, endOfCookie));
            }
            x = document.cookie.indexOf(" ", x) + 1;
            if (x == 0)
                break;
        }
        return "";
    }
    this.LowerBrowser = function () {
        var agent = navigator.userAgent.toLowerCase();
        if (agent.indexOf("msie") >= 0 && (navigator.appVersion.indexOf("MSIE 9") >= 0 || navigator.appVersion.indexOf("MSIE 8") >= 0) || navigator.appVersion.indexOf("MSIE 7") >= 0) {
            return true;
        } else {
            return false;
        }
    }
    this.LowerPlaceholder = function (obj) {
        if (CACommon.LowerBrowser()) {
            $(obj).find(".placeholder").removeAttr("placeholder");
            $(obj).find("input").change(function () { if ($.trim($(this).val()).length > 0) { $("label[for='" + $(this).attr("id") + "']").hide(); } });
        } else {
            $(obj).find("input").removeAttr("class");
            $(obj).find("label").remove();
        }
    }
    this.ieBrowser = function () {
        var agent = navigator.userAgent.toLowerCase();
        return (navigator.appName == 'Netscape' && navigator.userAgent.search('Trident') != -1) || (agent.indexOf("msie") != -1) ? true : false;
    }
    this.isMobile = function () {
        var agent = navigator.userAgent || navigator.vendor || window.opera;
        var isMobile = /android.+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od|ad)|iris|kindle|lge |maemo|midp|mmp|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(agent) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|e\-|e\/|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|xda(\-|2|g)|yas\-|your|zeto|zte\-/i.test(agent.substr(0, 4));
        return isMobile;
    }
    this.a2sSetClickLog = function () {
        try {
            if ($h && $h.a2s) {
                $h.a2s.setClickLog(); //a
                $(document).on("click", 'button[data-a2s="click"]', function () { CACommon.a2sSendClickLog(this); });                
            }
        } catch (e) { }
    }
    this.a2sSendClickLog = function (obj, object, option) {
        try { ($h && $h.a2s) ? $h.a2s.sendClickLog(object != undefined && object != null && object.length > 0 ? object : $(obj).attr("data-object"), option != undefined && option != null && option.length > 0 ? option : $(obj).attr("data-option")) : ""; } catch (e) { }
    }
    this.isJsonData = function (data) {
        try { return (typeof JSON.parse(JSON.stringify(data)) === 'object'); } catch (e) { return false; }
    }
}


var CAImage = {
    compressedImageBlob: null,
    max_size: 1240,
    img_quality: 0.7,
    selectfile: null,
    targetobj: null,
    changefiles: null,
    max_filesize: (4 * 1024 * 1024), //-- 4MB

    load_image: async function (e) {
        this.targetobj = e.target == undefined ? e : e.target;
        this.targetfiles = this.targetobj.files;
        this.changefiles = new DataTransfer();
        const filesArr = Array.prototype.slice.call(this.targetfiles);

        let promise = new Promise((resolve, reject) => {
            filesArr.forEach((file) => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const image = new Image();
                    image.src = e.target.result;

                    image.onload = (e) => {
                        this.resize_image(image);
                        if (this.compressedImageBlob.size > 0) {
                            this.changefiles.items.add(new File([this.compressedImageBlob], this.selectfile.name, { type: this.compressedImageBlob.type, lastModified: this.selectfile.lastModified }));
                            this.targetobj.files = this.changefiles.files;
                        }
                        resolve(this.targetobj);
                    }
                }
                reader.readAsDataURL(file);
                this.selectfile = file;
            });
        });
        let result = await promise;
    }

    , resize_image: function (image) {
        let canvas = document.createElement("canvas"), width = image.width, height = image.height;
        if (width > height) { // 가로가 길 경우
            if (width > this.max_size) {
                height *= this.max_size / width;
                width = this.max_size;
            }
        } else { // 세로가 길 경우                                    
            if (height > this.max_size) {
                width *= this.max_size / height;
                height = this.max_size;
            }
        }

        canvas.width = width;
        canvas.height = height;
        canvas.getContext("2d").drawImage(image, 0, 0, width, height);
        let dataUrl = canvas.toDataURL(this.selectfile.type);        
        if (this.dataURLToBlob(dataUrl).size > CAImage.max_filesize)
            dataUrl = canvas.toDataURL(this.selectfile.type, this.img_quality); //max_filesize 넘으면 퀄리티/용량 다운
        this.compressedImageBlob = this.dataURLToBlob(dataUrl);
    }
    , dataURLToBlob: function (dataURL) {
        const BASE64_MARKER = ";base64,";
        // base64로 인코딩 되어있지 않을 경우            
        if (dataURL.indexOf(BASE64_MARKER) === -1) {
            const parts = dataURL.split(",");
            const contentType = parts[0].split(":")[1];
            const raw = parts[1];
            return new Blob([raw], { type: contentType });
        }
        // base64로 인코딩 된 이진데이터일 경우            

        const parts = dataURL.split(BASE64_MARKER);
        const contentType = parts[0].split(":")[1];
        const raw = window.atob(parts[1]);
        // atob()는 Base64를 디코딩하는 메서드            
        const rawLength = raw.length;
        // 부호 없는 1byte 정수 배열을 생성            
        const uInt8Array = new Uint8Array(rawLength);
        // 길이만 지정된 배열            
        let i = 0;
        while (i < rawLength) {
            uInt8Array[i] = raw.charCodeAt(i);
            i++;
        }
        return new Blob([uInt8Array], { type: contentType });
    }

}