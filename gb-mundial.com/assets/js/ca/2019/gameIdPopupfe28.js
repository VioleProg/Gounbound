function setTooltip(type,txt){
    TweenMax.fromTo(".layer_gameid .tooltip", 0.2, { opacity:0 }, { opacity:1 });
    document.querySelector('.layer_gameid .tooltip').className = `tooltip ${type}`;
    document.querySelector('.layer_gameid .tooltip p').textContent = txt;
}

function openGameIdPopup(obj) {
    $obj = $('#' + obj);
    $obj.stop().fadeIn(300);
}

function closeGameIdPopup(obj) {
    $obj = $('#' + obj);
    $obj.stop().fadeOut(300);
}

function insertLayer(){
    const layerCreate = document.createElement('div');
    layerCreate.className = 'layer_gameid';
    layerCreate.id = 'layerCreateGameId';
    layerCreate.style.display = 'none';
    layerCreate.innerHTML = `
        <span class="dim"></span>
        <div class="modal_wrap">
            <div class="modal_header">
                <h2>크레이지 아케이드 게임 ID를 생성해주세요!</h2>
            </div>
            <div class="modal_contents">
                <form class="content create_gameId">
                    <h4 class="title server">플레이 할 서버를 선택해주세요.</h4>
                    <div class="select_server">
                        <input type="radio" id="s_happy" name="server" checked>
                        <label for="s_happy" class="s_happy">해피</label>
                        <input type="radio" id="s_dream" name="server">
                        <label for="s_dream" class="s_dream">드림</label>
                    </div>

                    <h4 class="title input_id">사용할 게임ID를 입력해주세요.</h4>
                    <div class="input_id_box">
                        <input type="text" id="game_id" placeholder="ID를 입력해주세요." autocomplete="off">
                        <button type="button" class="check_same">중복확인</button>
                    </div>

                    <div class="tooltip warning">
                        <p class="tooltip_txt">한글 2자리 이상 6자리 이하, 영문 12자 이하로 입력해주세요. </p>
                    </div>
                    <div class="notice">일정 시간 다수 게임ID 생성 시 크레이지 아케이드 홈페이지 접근이 차단됩니다.</div>
                </form>
                <div class="gm_id_chars">
                    <span class="char01"></span>
                    <span class="char02"></span>
                    <span class="char03"></span>
                    <span class="char04"></span>
                    <span class="char05"></span>
                    <span class="char06"></span>
                    <span class="char07"></span>
                </div>
                <button type="button" class="btn_create">게임 ID 생성하기</button>
            </div>
            <button type="button" class="icon btn_close" onclick="closeGameIdPopup('layerCreateGameId')">레이어 닫기</button>
        </div>`

    const layerComplete = document.createElement('div');
    layerComplete.className = 'layer_gameid';
    layerComplete.id = 'layerCompleteGameId';
    layerComplete.style.display = 'none';
    layerComplete.innerHTML = `
        <span class="dim"></span>
        <div class="modal_wrap">
            <div class="modal_header">
                <h2>크레이지 아케이드 게임 ID를 생성하였습니다. 재미있는 크레이지 아케이드를 시작해보세요!</h2>
            </div>
            <div class="modal_contents">
                <div class="content info">
                    <h4 class="title server_title">서버</h4>
                    <p class="server">해피</p>
                    <hr>
                    <h4 class="title gameid_title">게임ID</h4>
                    <p class="gameid">게임ID</p>
                    <hr>
                </div>
                <div class="gm_id_chars">
                    <span class="char01"></span>
                    <span class="char02"></span>
                    <span class="char03"></span>
                    <span class="char04"></span>
                    <span class="char05"></span>
                    <span class="char06"></span>
                    <span class="char07"></span>
                </div>
                <button type="button" class="btn_start">게임 시작하기</button>
            </div>
            <button type="button" class="icon btn_close" onclick="closeGameIdPopup('layerCompleteGameId')">레이어 닫기</button>
        </div>
    `
    document.body.appendChild(layerCreate);
    document.body.appendChild(layerComplete);
}

function toggleIDList(){
    Array.from(document.querySelectorAll('#layerGameIdList .acc_list .btn_toggle'))
    ?.forEach((button) => {
        button.addEventListener('click',() => {
            const accountList = button.closest('.acc_list');
            if(accountList.classList.contains('open')){
                accountList.classList.remove('open')
            }else{
                accountList.classList.add('open')
            }
        })
    })
}