<?PHP
class SmartyPaginate {

    /**
     * Class Constructor
     */
    function SmartyPaginate() { }

    /**
     * initialize the session data
     *
     * @param string $id the pagination id
     * @param string $formvar the variable containing submitted pagination information
     */
    function connect($id = 'default', $formvar = null) {
        if(!isset($_SESSION['SmartyPaginate'][$id])) {
            SmartyPaginate::reset($id);
        }
        
        // use $_GET by default unless otherwise specified
        $_formvar = isset($formvar) ? $formvar : $_GET;
        
        // set the current page
        $_total = SmartyPaginate::getTotal($id);
        if(isset($_formvar[SmartyPaginate::getUrlVar($id)]) && $_formvar[SmartyPaginate::getUrlVar($id)] > 0 && (!isset($_total) || $_formvar[SmartyPaginate::getUrlVar($id)] <= $_total))
            $_SESSION['SmartyPaginate'][$id]['current_item'] = $_formvar[$_SESSION['SmartyPaginate'][$id]['urlvar']];
    }

    /**
     * see if session has been initialized
     *
     * @param string $id the pagination id
     */
    function isConnected($id = 'default') {
        return isset($_SESSION['SmartyPaginate'][$id]);
    }    
        
    /**
     * reset/init the session data
     *
     * @param string $id the pagination id
     */
    function reset($id = 'default') {
        $_SESSION['SmartyPaginate'][$id] = array(
            'item_limit' => 10,
            'item_total' => null,
            'current_item' => 1,
            'urlvar' => 'next',
            'url' => $_SERVER['PHP_SELF'],
            'prev_text' => 'prev',
            'next_text' => 'next',
            'first_text' => 'first',
            'last_text' => 'last'
            );
    }
    
    /**
     * clear the SmartyPaginate session data
     *
     * @param string $id the pagination id
     */
    function disconnect($id = null) {
        if(isset($id))
            unset($_SESSION['SmartyPaginate'][$id]);
        else
            unset($_SESSION['SmartyPaginate']);
    }

    /**
     * set maximum number of items per page
     *
     * @param string $id the pagination id
     */
    function setLimit($limit, $id = 'default') {
        if(!preg_match('!^\d+$!', $limit)) {
            trigger_error('SmartyPaginate setLimit: limit must be an integer.');
            return false;
        }
        settype($limit, 'integer');
        if($limit < 1) {
            trigger_error('SmartyPaginate setLimit: limit must be greater than zero.');
            return false;
        }
        $_SESSION['SmartyPaginate'][$id]['item_limit'] = $limit;
    }    

    /**
     * get maximum number of items per page
     *
     * @param string $id the pagination id
     */
    function getLimit($id = 'default') {
        return $_SESSION['SmartyPaginate'][$id]['item_limit'];
    }    
            
    /**
     * set the total number of items
     *
     * @param int $total the total number of items
     * @param string $id the pagination id
     */
    function setTotal($total, $id = 'default') {
        if(!preg_match('!^\d+$!', $total)) {
            trigger_error('SmartyPaginate setTotal: total must be an integer.');
            return false;
        }
        settype($total, 'integer');
        if($total < 0) {
            trigger_error('SmartyPaginate setTotal: total must be positive.');
            return false;
        }
        $_SESSION['SmartyPaginate'][$id]['item_total'] = $total;
    }

    /**
     * get the total number of items
     *
     * @param string $id the pagination id
     */
    function getTotal($id = 'default') {
        return $_SESSION['SmartyPaginate'][$id]['item_total'];
    }    

    /**
     * set the url used in the links, default is $PHP_SELF
     *
     * @param string $url the pagination url
     * @param string $id the pagination id
     */
    function setUrl($url, $id = 'default') {
        $_SESSION['SmartyPaginate'][$id]['url'] = $url;
    }

    /**
     * get the url variable
     *
     * @param string $id the pagination id
     */
    function getUrl($id = 'default') {
        return $_SESSION['SmartyPaginate'][$id]['url'];
    }    
    
    /**
     * set the url variable ie. ?next=10
     *                           ^^^^
     * @param string $url url pagination varname
     * @param string $id the pagination id
     */
    function setUrlVar($urlvar, $id = 'default') {
        $_SESSION['SmartyPaginate'][$id]['urlvar'] = $urlvar;
    }

    /**
     * get the url variable
     *
     * @param string $id the pagination id
     */
    function getUrlVar($id = 'default') {
        return $_SESSION['SmartyPaginate'][$id]['urlvar'];
    }    
        
    /**
     * set the current item (usually done automatically by next/prev links)
     *
     * @param int $item index of the current item
     * @param string $id the pagination id
     */
    function setCurrentItem($item, $id = 'default') {
        $_SESSION['SmartyPaginate'][$id]['current_item'] = $item;
    }

    /**
     * get the current item
     *
     * @param string $id the pagination id
     */
    function getCurrentItem($id = 'default') {
        return $_SESSION['SmartyPaginate'][$id]['current_item'];
    }    

    /**
     * get the current item index
     *
     * @param string $id the pagination id
     */
    function getCurrentIndex($id = 'default') {
        return $_SESSION['SmartyPaginate'][$id]['current_item'] - 1;
    }    
    
    /**
     * get the last displayed item
     *
     * @param string $id the pagination id
     */
    function getLastItem($id = 'default') {
        $_total = SmartyPaginate::getTotal($id);
        $_limit = SmartyPaginate::getLimit($id);
        $_last = SmartyPaginate::getCurrentItem($id) + $_limit - 1;
        return ($_last <= $_total) ? $_last : $_total; 
    }    
    
    /**
     * assign $paginate var values
     *
     * @param obj &$smarty the smarty object reference
     * @param string $var the name of the assigned var
     * @param string $id the pagination id
     */
    function assign($var = 'paginate', $id = 'default') {
        
            $_paginate['total'] = SmartyPaginate::getTotal($id);
            $_paginate['first'] = SmartyPaginate::getCurrentItem($id);
            $_paginate['last'] = SmartyPaginate::getLastItem($id);
            $_paginate['page_current'] = ceil(SmartyPaginate::getLastItem($id) / SmartyPaginate::getLimit($id));
            $_paginate['page_total'] = ceil(SmartyPaginate::getTotal($id)/SmartyPaginate::getLimit($id));
            $_paginate['size'] = $_paginate['last'] - $_paginate['first'];
            $_paginate['url'] = SmartyPaginate::getUrl($id);
            $_paginate['urlvar'] = SmartyPaginate::getUrlVar($id);
            $_paginate['current_item'] = SmartyPaginate::getCurrentItem($id);
            $_paginate['prev_text'] = SmartyPaginate::getPrevText($id);
            $_paginate['next_text'] = SmartyPaginate::getNextText($id);
            $_paginate['limit'] = SmartyPaginate::getLimit($id);
            $_paginate['id'] = $id;
            $_item = 1;
            $_page = 1;
            while($_item <= $_paginate['total'])           {
                $_paginate['page'][$_page]['number'] = $_page;   
                $_paginate['page'][$_page]['item_start'] = $_item;
                $_paginate['page'][$_page]['item_end'] = ($_item + $_paginate['limit'] - 1 <= $_paginate['total']) ? $_item + $_paginate['limit'] - 1 : $_paginate['total'];
                $_paginate['page'][$_page]['is_current'] = ($_item == $_paginate['current_item']);
                $_item += $_paginate['limit'];
                $_page++;
            }
            return $_paginate;
            
    }    


    /**
     * set the default text for the "previous" page link
     *
     * @param string $text index of the current item
     * @param string $id the pagination id
     */
    function setPrevText($text, $id = 'default') {
        $_SESSION['SmartyPaginate'][$id]['prev_text'] = $text;
    }

    /**
     * get the default text for the "previous" page link
     *
     * @param string $id the pagination id
     */
    function getPrevText($id = 'default') {
        return $_SESSION['SmartyPaginate'][$id]['prev_text'];
    }    
    
    /**
     * set the text for the "next" page link
     *
     * @param string $text index of the current item
     * @param string $id the pagination id
     */
    function setNextText($text, $id = 'default') {
        $_SESSION['SmartyPaginate'][$id]['next_text'] = $text;
    }
    
    /**
     * get the default text for the "next" page link
     *
     * @param string $id the pagination id
     */
    function getNextText($id = 'default') {
        return $_SESSION['SmartyPaginate'][$id]['next_text'];
    }    

    /**
     * set the text for the "first" page link
     *
     * @param string $text index of the current item
     * @param string $id the pagination id
     */
    function setFirstText($text, $id = 'default') {
        $_SESSION['SmartyPaginate'][$id]['first_text'] = $text;
    }
    
    /**
     * get the default text for the "first" page link
     *
     * @param string $id the pagination id
     */
    function getFirstText($id = 'default') {
        return $_SESSION['SmartyPaginate'][$id]['first_text'];
    }    
    
    /**
     * set the text for the "last" page link
     *
     * @param string $text index of the current item
     * @param string $id the pagination id
     */
    function setLastText($text, $id = 'default') {
        $_SESSION['SmartyPaginate'][$id]['last_text'] = $text;
    }
    
    /**
     * get the default text for the "last" page link
     *
     * @param string $id the pagination id
     */
    function getLastText($id = 'default') {
        return $_SESSION['SmartyPaginate'][$id]['last_text'];
    }    
    
    /**
     * set default number of page groupings in {paginate_middle}
     *
     * @param string $id the pagination id
     */
    function setPageLimit($limit, $id = 'default') {
        if(!preg_match('!^\d+$!', $limit)) {
            trigger_error('SmartyPaginate setPageLimit: limit must be an integer.');
            return false;
        }
        settype($limit, 'integer');
        if($limit < 1) {
            trigger_error('SmartyPaginate setPageLimit: limit must be greater than zero.');
            return false;
        }
        $_SESSION['SmartyPaginate'][$id]['page_limit'] = $limit;
    }    

    /**
     * get default number of page groupings in {paginate_middle}
     *
     * @param string $id the pagination id
     */
    function getPageLimit($id = 'default') {
        return $_SESSION['SmartyPaginate'][$id]['page_limit'];
    }
            
    /**
     * get the previous page of items
     *
     * @param string $id the pagination id
     */
    function _getPrevPageItem($id = 'default') {
        
        $_prev_item = $_SESSION['SmartyPaginate'][$id]['current_item'] - $_SESSION['SmartyPaginate'][$id]['item_limit'];
        
        return ($_prev_item > 0) ? $_prev_item : false; 
    }    

    /**
     * get the previous page of items
     *
     * @param string $id the pagination id
     */
    function _getNextPageItem($id = 'default') {
                
        $_next_item = $_SESSION['SmartyPaginate'][$id]['current_item'] + $_SESSION['SmartyPaginate'][$id]['item_limit'];
        
        return ($_next_item <= $_SESSION['SmartyPaginate'][$id]['item_total']) ? $_next_item : false; 
    }    
    
                
            
}

  function paginate_prev($data) {
  $params =SmartyPaginate::assign('paginate',$data);
  
	$_id = isset($params['id']) ? $params['id'] : 'default';
    
    if (!class_exists('SmartyPaginate')) {
        echo("paginate_prev: missing SmartyPaginate class");
        return;
    }
    if (!isset($_SESSION['SmartyPaginate'])) {
        echo("paginate_prev: SmartyPaginate is not initialized, use connect() first");
        return;        
    }
    if (!isset($_SESSION['SmartyPaginate'][$_id]['item_total'])) {
        echo("paginate_prev: total was not set");
        return;        
    }
    
    $_url = $_SESSION['SmartyPaginate'][$_id]['url'];
    
    if(($_item = SmartyPaginate::_getPrevPageItem($_id)) !== false) {
        $_show = true;
	
        $_text = isset($params['prev_text']) ? $params['prev_text'] : $_SESSION['SmartyPaginate'][$_id]['prev_text'] ;
        $_url .= (strpos($_url, '?') === false) ? '?' : '&';
        $_url .= SmartyPaginate::getUrlVar($data) . '=' . $_item;
	
    } else {
        $_show = false;   
    }
    
    return  $_show ? '<a href="' . $_url . '">' . $_text . '</a>' : '';
	
}

function paginate_next($data) {
	$params =SmartyPaginate::assign('paginate',$data);
    $_id = isset($params['id']) ? $params['id'] : 'default';
    
    if (!class_exists('SmartyPaginate')) {
        echo("paginate_next: missing SmartyPaginate class");
        return;
    }
    if (!isset($_SESSION['SmartyPaginate'])) {
        echo("paginate_next: SmartyPaginate is not initialized, use connect() first");
        return;        
    }
    if (!isset($_SESSION['SmartyPaginate'][$_id]['item_total'])) {
        echo("paginate_next: total was not set");
        return;        
    }
    
    $_url = $_SESSION['SmartyPaginate'][$_id]['url'];
    
    if(($_item = SmartyPaginate::_getNextPageItem($_id)) !== false) {
        $_show = true;
        $_text = isset($params['next_text']) ? $params['next_text'] : $_SESSION['SmartyPaginate'][$_id]['next_text'];
        $_url .= (strpos($_url, '?') === false) ? '?' : '&';
        $_url .= SmartyPaginate::getUrlVar($data) . '=' . $_item;
    } else {
        $_show = false;   
    }
    return $_show ? '<td class="movie2"> <a href="' . $_url . '">' . $_text . '</a></td>' : '';
}
function paginate_middle($data = 'default') {
    $params =SmartyPaginate::assign('paginate',$data);
    $_id = $data;
    $_prefix = '';
    $_suffix = '';
    $_link_prefix = '<span class="rank_pgnavi_box"><b>';
    $_link_suffix = '</b></span>'; 
    $_page_limit = null;
    $_attrs = array();

    if (!class_exists('SmartyPaginate')) {
        $smarty->trigger_error("paginate_middle: missing SmartyPaginate class");
        return;
    }
    if (!isset($_SESSION['SmartyPaginate'])) {
        $smarty->trigger_error("paginate_middle: SmartyPaginate is not initialized, use connect() first");
        return;        
    }
        
    foreach($params as $_key => $_val) {
        switch($_key) {
            case 'id':
                if (!SmartyPaginate::isConnected($_val)) {
                    $smarty->trigger_error("paginate_middle: unknown id '$_val'");
                    return;        
                }
                $_id = $_val;
                break;
            case 'prefix':
                $_prefix = $_val;
                break;
            case 'suffix':
                $_suffix = $_val;
                break;
            case 'link_prefix':
                $_link_prefix = $_val;
                break;
            case 'link_suffix':
                $_link_suffix = $_val;
                break; 
            case 'page_limit';
                $_page_limit = $_val;
                break;
            case 'format':
                break;
            default:
                $_attrs[] = $_key . '="' . $_val . '"';
                break;   
        }
    }
    
    if (!isset($_SESSION['SmartyPaginate'][$_id]['item_total'])) {
        $smarty->trigger_error("paginate_middle: total was not set");
        return;        
    }
    
    if(!isset($_page_limit) && isset($_SESSION['SmartyPaginate'][$_id]['page_limit'])) {
        $_page_limit = $_SESSION['SmartyPaginate'][$_id]['page_limit'];
    }
        
    $_url = $_SESSION['SmartyPaginate'][$_id]['url'];
    
    $_total = SmartyPaginate::getTotal($_id);
    $_curr_item = SmartyPaginate::getCurrentItem($_id);
    $_limit = SmartyPaginate::getLimit($_id);
    
    $_item = 1;
    $_page = 1;
    $_displayed_pages = 0;
    
    $_attrs = !empty($_attrs) ? ' ' . implode(' ', $_attrs) : '';
    
    if(isset($_page_limit)) {
        // find halfway point
        $_page_limit_half = floor($_page_limit / 2);
        // determine what item/page we start with
        $_item_start = $_curr_item - $_limit * $_page_limit_half;
        if( ($_view = ceil(($_total - $_item_start) / $_limit)) < $_page_limit) {
            $_item_start -= ($_limit * ( $_page_limit - $_view ));
        }
        $_item = ($_item_start >= 1) ? $_item_start : 1;
        $_page = ceil($_item / $_limit);
    }
            $_ret = '';
			$_display_pages = '';
    while($_item <= $_total) {
        if(@$params['format'] == 'page') {
            $_text = $_prefix . $_page . $_suffix;            
        } else {
            $_text = $_prefix . $_item . '-';
            $_text .= ($_item + $_limit - 1 <= $_total) ? $_item + $_limit - 1 : $_total;
            $_text .= $_suffix;
        }
        if($_item != $_curr_item) {
            $_this_url = $_url;
            $_this_url .= (strpos($_url, '?') === false) ? '?' : '&';
            $_this_url .= SmartyPaginate::getUrlVar($_id) . '=' . $_item;
            $_ret .= $_link_prefix . '<a href="' . str_replace('&', '&amp;', $_this_url) . '"' . $_attrs . '>' . $_text . '</a>' . $_link_suffix;
        } else {
            $_ret .= $_link_prefix . $_text . $_link_suffix;
        }
        $_item += $_limit;
        $_page++;
        $_display_pages++;
        if(isset($_page_limit) && $_display_pages == $_page_limit)
            break;
    }
    
    return $_ret;
    
}
function paginate_last($data) {
$params =SmartyPaginate::assign('paginate',$data);
    $_id = 'default';
    $_attrs = array();
    
    if (!class_exists('SmartyPaginate')) {
        echo("paginate_last: missing SmartyPaginate class");
        return;
    }
    if (!isset($_SESSION['SmartyPaginate'])) {
        echo("paginate_last: SmartyPaginate is not initialized, use connect() first");
        return;        
    }

    foreach($params as $_key => $_val) {
        switch($_key) {
            case 'id':
                if (!SmartyPaginate::isConnected($_val)) {
                    echo("paginate_last: unknown id '$_val'");
                    return;        
                }
                $_id = $_val;
                break;
            default:
                $_attrs[] = $_key . '="' . $_val . '"';
                break;   
        }
    }
    
    if (SmartyPaginate::getTotal($_id) === false) {
        echo("paginate_last: total was not set");
        return;        
    }
    
    $_url = SmartyPaginate::getURL($_id);
    $_total = SmartyPaginate::getTotal($_id);
    $_limit = SmartyPaginate::getLimit($_id);
    
    $_attrs = !empty($_attrs) ? ' ' . implode(' ', $_attrs) : '';    
    
    $_text = isset($params['text']) ? $params['text'] : SmartyPaginate::getLastText($_id);
    $_url .= (strpos($_url, '?') === false) ? '?' : '&';
    $_url .= SmartyPaginate::getUrlVar($_id) . '=';
    $_url .= ($_total % $_limit > 0) ? $_total - ( $_total % $_limit ) + 1 : $_total - $_limit + 1;
    
    return '<a href="' . str_replace('&','&amp;', $_url) . '"' . $_attrs . '>' . $_text . '</a>';
    
}
function paginate_first($data) {
$params =SmartyPaginate::assign('paginate',$data);
    $_id = 'default';
    $_attrs = array();
    
    if (!class_exists('SmartyPaginate')) {
        echo("paginate_first: missing SmartyPaginate class");
        return;
    }
    if (!isset($_SESSION['SmartyPaginate'])) {
        echo("paginate_first: SmartyPaginate is not initialized, use connect() first");
        return;        
    }

    foreach($params as $_key => $_val) {
        switch($_key) {
            case 'id':
                if (!SmartyPaginate::isConnected($_val)) {
                    echo("paginate_first: unknown id '$_val'");
                    return;        
                }
                $_id = $_val;
                break;
            default:
                $_attrs[] = $_key . '="' . $_val . '"';
                break;   
        }
    }
    
    if (SmartyPaginate::getTotal($_id) === false) {
        echo("paginate_first: total was not set");
        return;        
    }
    
    $_url = SmartyPaginate::getURL($_id);
    
    $_attrs = !empty($_attrs) ? ' ' . implode(' ', $_attrs) : '';    
    
    $_text = isset($params['text']) ? $params['text'] : SmartyPaginate::getFirstText($_id);
    $_url .= (strpos($_url, '?') === false) ? '?' : '&';
    $_url .= SmartyPaginate::getUrlVar($_id) . '=1';
    
    return '<a href="' . str_replace('&','&amp;', $_url) . '"' . $_attrs . '>' . $_text . '</a>';
}
?>