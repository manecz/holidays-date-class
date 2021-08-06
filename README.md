
# holidays-date-class

Simple PHP class to calculate holidays from a period of time
## Authors

- [@manecz](https://www.github.com/manecz)

  
## Badges

[![MIT License](https://img.shields.io/apm/l/atomic-design-ui.svg?)](https://github.com/tterb/atomic-design-ui/blob/master/LICENSEs)

  
## Features

- Calculate and list business days between two dates
- Possibility to include an array list of country holidays
- Static Methods
- Check if is weekend
- Check is a valid date format
- Calculate the next business day after holidays ended

  
## Installation


```bash
  include_once("Diautil.class.php");
```
    
## Usage/Examples

```php
  //Instantiate object
  $p1 = new Diautil('2021-08-04','2021-08-04');

  //List of holidays
  $holidays = ['2021-07-06','2021-07-04','2021-07-03', '2021-08-15'];

  //Set holidays
  $p1->set_reserved_dates($holidays);

 //Do stuff

 echo 'Exemplo <br>';

//Cria objeto para um determinado periodo
$feriados = ['2021-07-06','2021-07-04','2021-07-03', '2021-08-15'];
$p1 = new Diautil('2021-08-04','2021-08-04');
$p1->set_reserved_dates($dias_reservados);
echo 'Devolve próximo dia útil de um determinado periodo <br>';
echo $p1->getNextBusinessDay()->format('d-m-Y');

//Imprime data de inicio no formato especificado
echo '<br>Data Inicio: '.$p1->get_start_date()->format('d-m-Y').'<br>';

//Imprime data de fim no formato especificado
echo 'Data Fim: '.$p1->get_end_date()->format('d-m-Y').'<br>';

//Exemplo de listagem de periodo com dias uteis, feriados e fins de semana
echo '<br>listagem do periodo com dias uteis, feriados (inventados) e fins de semana <br>';
foreach($p1->list_business_days() as $date => $type){
    switch($type){
        case 'wh':
            echo $date . ' - Fim de semana e Feriado<br>';
            break;
        case 'w':
            echo $date . ' - Fim de semana<br>';
            break;
        case 'h':
            echo $date . ' - Feriado<br>';
            break;
        default:
            echo $date . ' - Dia útil<br>';
    }
}

//Devolve número de dias úteis
echo '<br>Nº de dias úteis: '.$p1->count_business_days().'<br>';

//Exemplo de listagem dos feriados
echo '<br>Feriados do array (pode vir da BD)<br>';
foreach($p1->get_reserved_dates() as $value){
    echo $value . '<br>';
}

//Helpers da Class
echo '<br>Helpers da Class <br>';

//Verifica se uma data é válida em formato string
echo 'Verifica se uma data é válida em formato string<br>';
$d1 = '22-05-2020';
$d2 = '22-05-20201';
try{
    if(Diautil::isValidDate($d1)){
        echo $d1. ' É válido'.'<br>';
    }
} catch(Exception $e){
    echo $d1. ' -> ', $e->getMessage().'<br>';
}
try{
    if(Diautil::isValidDate($d2)){
        echo $d2. ' É válido'.'<br>';
    }
} catch(Exception $e){
    echo $d2. ' -> ', $e->getMessage().'<br>';
}

//Verifica se uma data é fim de semana
echo '<br>  Verifica se uma data é fim de semana<br>';
echo (Diautil::isWeekendDay('4-7-2021'))? 'É fim de semana': 'Não é fim de semana';



//Exemplo 2
echo '<br>Exemplo 2<br>';

//Cria objeto para um determinado periodo
$feriados2 = ['2021-01-01','2021-04-02','2021-04-04','2021-04-25','2021-05-01','2021-06-03','2021-06-10','2021-08-15','2021-10-05','2021-11-01','2021-12-01','2021-12-08','2021-12-25'];
$p2 = new Diautil('2021-01-01','2021-12-31', $feriados2);

echo '<br>listagem do periodo com dias uteis, feriados  e fins de semana Ano 2021 <br>';
// foreach($p2->list_business_days() as $date => $type){
//     switch($type){
//         case 'wh':
//             echo $date . ' - Fim de semana e Feriado<br>';
//             break;
//         case 'w':
//             echo $date . ' - Fim de semana<br>';
//             break;
//         case 'h':
//             echo $date . ' - Feriado<br>';
//             break;
//         default:
//             echo $date . ' - Dia útil<br>';
//     }
// }

//Devolve próximo dia útil de um determinado periodo
echo 'Devolve próximo dia útil de um determinado periodo';
echo $p2->getNextBusinessDay()->format('d-m-Y');
```

  
