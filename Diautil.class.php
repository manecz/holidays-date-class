<?php
class Diautil {
    
    protected $start_date;
    protected $end_date;
    private $reserved_dates; //Datas reservadas sejam fins de semana ou feriados
    
    function __construct($start_date, $end_date, array $reserved = null){
        //$this->start_date           = new DateTime($start_date);
        //$this->end_date             = new DateTime($end_date);
        $this->set_start_date($start_date);
        $this->set_end_date($end_date);
        $this->set_reserved_dates($reserved);
    }

    //Metodos
    function get_start_date(){
        return $this->start_date;
    }

    function get_end_date(){
        return $this->end_date;
    }

    protected function set_start_date($d){
        try{
            if(self::isValidDate($d)){
                $this->start_date = new DateTime($d);
            }
        } catch(Exception $e){
            echo 'Start Date -> ', $e->getMessage();
        }
    }

    protected function set_end_date($d){
        try{
            if(self::isValidDate($d)){
                $this->end_date = new DateTime($d);
            }
        } catch(Exception $e){
            echo 'End Date -> ', $e->getMessage();
        }
    }

    function get_reserved_dates(){
        return $this->reserved_dates;
    }

    function set_reserved_dates($d){
        $this->reserved_dates = $d;
    }

    //Devolve os dias uteis entre dois periodos tendo em conta feriados e fins-de-semana
    function list_business_days(){
        $arr = [];

        //Inicializa variavel com valor inicial do periodo
        $temp_start_date = clone $this->get_start_date();

        //Adiciona um dia na data final para o ultimo dia ficar incluido
        $temp_end_date = clone $this->get_end_date();
        $temp_end_date = $temp_end_date->add(new \DateInterval("P1D"));

        while($temp_start_date->diff($temp_end_date)->days > 0){

            if(self::isWeekendDay($temp_start_date) === 1 && in_array($temp_start_date->format('Y-m-d'), $this->reserved_dates)){
                $arr[$temp_start_date->format('d-m-Y')] = 'wh';
            }
            else if(in_array($temp_start_date->format('Y-m-d'), $this->reserved_dates)){
                $arr[$temp_start_date->format('d-m-Y')] = 'h';
            }
            else if(self::isWeekendDay($temp_start_date) === 1){
                $arr[$temp_start_date->format('d-m-Y')] = 'w';
            }
             else {
                $arr[$temp_start_date->format('d-m-Y')] = 'b';
            }
            //Modifica data de inicio com mais um dia dentro do loop
            $temp_start_date = $temp_start_date->add(new \DateInterval("P1D"));
        }
        return $arr;
    }

    //Conta os dias uteis entre dois periodos tendo em conta feriados e fins-de-semana
    function count_business_days(){
        $total = 0;

        //Inicializa variavel com valor inicial do periodo
        $temp_start_date = clone $this->get_start_date();

        //Adiciona um dia na data final para o ultimo dia ficar incluido
        $temp_end_date = clone $this->get_end_date();
        $temp_end_date = $temp_end_date->add(new \DateInterval("P1D"));

        while($temp_start_date->diff($temp_end_date)->days > 0){

            if(!(self::isWeekendDay($temp_start_date) === 1 || in_array($temp_start_date->format('Y-m-d'), $this->reserved_dates))){
                $total += 1;
            }
            //Modifica data de inicio com mais um dia dentro do loop
            $temp_start_date = $temp_start_date->add(new \DateInterval("P1D"));
        }
        return $total;
    }

    public static function isWeekendDay($date){
        $value = null;
        if($date instanceof DateTime){
            $value = $date;
        } else{
            $value = (strtotime($date))? new DateTime($date): null;
        }
        return (bool)(($value->format('N') == 6 || $value->format('N') == 7) && $value)? 1 : 0;
    }

    public static function isValidDate($date){
        if(!strtotime($date)){
            throw new Exception('Invalid date');
        }
        return true;
    }

    public static function formatDate($date, $format){
        $date = new DateTime($date);
        return $date->format($format);
    }

    public function getNextBusinessDay(){
        $temp = clone $this->get_end_date();
        do{
            $temp = $temp->add(new \DateInterval("P1D"));
            if(!self::isWeekendDay($temp) == 1 && !in_array($temp->format('Y-m-d'), $this->reserved_dates)){
                break;
            }
        } while(true);
        return $temp;
    }

 
    function __destruct() {
        //echo "Object destructed";
    }
}
