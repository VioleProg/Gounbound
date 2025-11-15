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
                <h2>í¬ë ˆì´ì§€ ì•„ì¼€ì´ë“œ ê²Œìž„ IDë¥¼ ìƒì„±í•´ì£¼ì„¸ìš”!</h2>
            </div>
            <div class="modal_contents">
                <form class="content create_gameId">
                    <h4 class="title server">í”Œë ˆì´ í•  ì„œë²„ë¥¼ ì„ íƒí•´ì£¼ì„¸ìš”.</h4>
                    <div class="select_server">
                        <input type="radio" id="s_happy" name="server" checked>
                        <label for="s_happy" class="s_happy">í•´í”¼</label>
                        <input type="radio" id="s_dream" name="server">
                        <label for="s_dream" class="s_dream">ë“œë¦¼</label>
                    </div>

                    <h4 class="title input_id">ì‚¬ìš©í•  ê²Œìž„IDë¥¼ ìž…ë ¥í•´ì£¼ì„¸ìš”.</h4>
                    <div class="input_id_box">
                        <input type="text" id="game_id" placeholder="IDë¥¼ ìž…ë ¥í•´ì£¼ì„¸ìš”." autocomplete="off">
                        <button type="button" class="check_same">ì¤‘ë³µí™•ì¸</button>
                    </div>

                    <div class="tooltip warning">
                        <p class="tooltip_txt">í•œê¸€ 2ìžë¦¬ ì´ìƒ 6ìžë¦¬ ì´í•˜, ì˜ë¬¸ 12ìž ì´í•˜ë¡œ ìž…ë ¥í•´ì£¼ì„¸ìš”. </p>
                    </div>
                    <div class="notice">ì¼ì • ì‹œê°„ ë‹¤ìˆ˜ ê²Œìž„ID ìƒì„± ì‹œ í¬ë ˆì´ì§€ ì•„ì¼€ì´ë“œ í™ˆíŽ˜ì´ì§€ ì ‘ê·¼ì´ ì°¨ë‹¨ë©ë‹ˆë‹¤.</div>
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
                <button type="button" class="btn_create">ê²Œìž„ ID ìƒì„±í•˜ê¸°</button>
            </div>
            <button type="button" class="icon btn_close" onclick="closeGameIdPopup('layerCreateGameId')">ë ˆì´ì–´ ë‹«ê¸°</button>
        </div>`

    const layerComplete = document.createElement('div');
    layerComplete.className = 'layer_gameid';
    layerComplete.id = 'layerCompleteGameId';
    layerComplete.style.display = 'none';
    layerComplete.innerHTML = `
        <span class="dim"></span>
        <div class="modal_wrap">
            <div class="modal_header">
                <h2>í¬ë ˆì´ì§€ ì•„ì¼€ì´ë“œ ê²Œìž„ IDë¥¼ ìƒì„±í•˜ì˜€ìŠµë‹ˆë‹¤. ìž¬ë¯¸ìžˆëŠ” í¬ë ˆì´ì§€ ì•„ì¼€ì´ë“œë¥¼ ì‹œìž‘í•´ë³´ì„¸ìš”!</h2>
            </div>
            <div class="modal_contents">
                <div class="content info">
                    <h4 class="title server_title">ì„œë²„</h4>
                    <p class="server">í•´í”¼</p>
                    <hr>
                    <h4 class="title gameid_title">ê²Œìž„ID</h4>
                    <p class="gameid">ê²Œìž„ID</p>
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
                <button type="button" class="btn_start">ê²Œìž„ ì‹œìž‘í•˜ê¸°</button>
            </div>
            <button type="button" class="icon btn_close" onclick="closeGameIdPopup('layerCompleteGameId')">ë ˆì´ì–´ ë‹«ê¸°</button>
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