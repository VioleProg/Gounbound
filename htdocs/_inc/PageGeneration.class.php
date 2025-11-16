<?PHP
    class page_gen {
   
        var $_start_time;
        var $_stop_time;
        var $_gen_time;
 
        var $round_to;

        function page_gen() {
            if (!isset($this->round_to)) {
                $this->round_to = 4;
            }
        }

        function start() {
            $microstart = explode(' ',microtime());
            $this->_start_time = $microstart[0] + $microstart[1];
        }
        
  
        function stop() {
            $microstop = explode(' ',microtime());
            $this->_stop_time = $microstop[0] + $microstop[1];
        }
     
        function gen() {
            $this->_gen_time = round($this->_stop_time - $this->_start_time,$this->round_to);
            return $this->_gen_time;
        }
    }
?>