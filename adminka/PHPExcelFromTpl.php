<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PHPExcelFromTpl
 *
 * @author kotov
 */
class PHPExcelFromTpl
{
    public function __construct()
    {
        
    }
    public static function convert($file, $data=array())
    {
            //--------------вспомогательные ф-ции --------------------------------------//
            
   function getheight_t($str, $size_pole, $height_need) {
       $len = iconv_strlen($str,'UTF-8');
if ($len>$size_pole-9) {
$size_h=(($len-$len%$size_pole)/$size_pole)+1;
} else $size_h=1;
return $size_h*$height_need;
}  


   
        function num2str($num) {
	$nul='ноль';
	$ten=array(
		array('','один','два','три','четыре','пять','шесть','семь', 'восемь','девять'),
		array('','одна','две','три','четыре','пять','шесть','семь', 'восемь','девять'),
	);
	$a20=array('десять','одиннадцать','двенадцать','тринадцать','четырнадцать' ,'пятнадцать','шестнадцать','семнадцать','восемнадцать','девятнадцать');
	$tens=array(2=>'двадцать','тридцать','сорок','пятьдесят','шестьдесят','семьдесят' ,'восемьдесят','девяносто');
	$hundred=array('','сто','двести','триста','четыреста','пятьсот','шестьсот', 'семьсот','восемьсот','девятьсот');
	$unit=array( // Units
		array('копейка' ,'копейки' ,'копеек',	 1),
		array('рубль'   ,'рубля'   ,'рублей'    ,0),
		array('тысяча'  ,'тысячи'  ,'тысяч'     ,1),
		array('миллион' ,'миллиона','миллионов' ,0),
		array('миллиард','милиарда','миллиардов',0),
	);
	//
	list($rub,$kop) = explode('.',sprintf("%015.2f", floatval($num)));
	$out = array();
	if (intval($rub)>0) {
		foreach(str_split($rub,3) as $uk=>$v) { // by 3 symbols
			if (!intval($v)) continue;
			$uk = sizeof($unit)-$uk-1; // unit key
			$gender = $unit[$uk][3];
			list($i1,$i2,$i3) = array_map('intval',str_split($v,1));
			// mega-logic
			$out[] = $hundred[$i1]; # 1xx-9xx
			if ($i2>1) $out[]= $tens[$i2].' '.$ten[$gender][$i3]; # 20-99
			else $out[]= $i2>0 ? $a20[$i3] : $ten[$gender][$i3]; # 10-19 | 1-9
			// units without rub & kop
			if ($uk>1) $out[]= morph($v,$unit[$uk][0],$unit[$uk][1],$unit[$uk][2]);
		} //foreach
	}
	else $out[] = $nul;
	$out[] = morph(intval($rub), $unit[1][0],$unit[1][1],$unit[1][2]); // rub
	$out[] = $kop.' '.morph($kop,$unit[0][0],$unit[0][1],$unit[0][2]); // kop
	return trim(preg_replace('/ {2,}/', ' ', join(' ',$out)));
}

/**
 * Склоняем словоформу
 * @ author runcore
 */
function morph($n, $f1, $f2, $f5) {
	$n = abs(intval($n)) % 100;
	if ($n>10 && $n<20) return $f5;
	$n = $n % 10;
	if ($n>1 && $n<5) return $f2;
	if ($n==1) return $f1;
	return $f5;
}
        
        $cnt = count ($data['nameg']); 
        if ($cnt == 0) return;
        
       	$objPHPExcel = PHPExcel_IOFactory::load( $file );
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw");
        $objPHPExcel->getProperties()->setLastModifiedBy("Maarten Balliauw");
        $objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
        $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
        $objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");
        $objPHPExcel->setActiveSheetIndex(0);
        $aSheet = $objPHPExcel->getActiveSheet();
        if ($cnt > 1)
        {
            $aSheet->insertNewRowBefore(23, $cnt-1);
            for ($str=23;$str<23+$cnt-1;$str++)
            {
               $aSheet->mergeCellsByColumnAndRow(1, $str, 2,$str);
               $aSheet->mergeCellsByColumnAndRow(3, $str, 20,$str);
               $aSheet->mergeCellsByColumnAndRow(21, $str, 23,$str);
               $aSheet->mergeCellsByColumnAndRow(24, $str, 26,$str);
               $aSheet->mergeCellsByColumnAndRow(27, $str, 31,$str);
               $aSheet->mergeCellsByColumnAndRow(32, $str, 37,$str);
               
               
            }
        }
        
        foreach($aSheet->getRowIterator() as $row)
        {
           $cellIterator = $row->getCellIterator();
           foreach($cellIterator as $cell)
           {
                $val = $cell->getValue();
                if (preg_match( "#^%([^%]+)%$#sei", $val, $match ))
                {
                   $column = $cell->getColumn();
                   $row = $cell->getRow();
                   $key_insert = $match['1'];
                   if ($key_insert == 'total')
                    {
                       $cell->setValue('=SUM(AG22:AG'.(22+$cnt-1).')');
                       $summ = $cell->getCalculatedValue() ;
                        
                    }
                    if ($key_insert == 'text')
                    {                       
                        if (!empty($_GET['shipping']) && is_int($_GET['shipping'] + 0))
                           $summ+= $_GET['shipping'];
                        $cell->setValue('Всего наименований '.$cnt.', на сумму '.$summ.' руб.');

                       $aSheet->SetCellValue('B'.($row+1), num2str($summ));
                    }
                    if ($key_insert == 'nameg')
                       {
                           $crew_template = $aSheet->getStyle($column.$row);
                           $idx =1;
                           foreach ($data[$key_insert] as $_colVal) 
                           {
                                
                                $aSheet->duplicateStyle($crew_template,$column.$row);
                                $aSheet->getStyle($column.$row)->getAlignment()->setWrapText(true);
                                $aSheet->SetCellValue('B'.$row, $idx++);
								$aSheet->SetCellValue('Y'.$row, 'шт');
                                $aSheet->SetCellValue('V'.$row, $_colVal['col']);
                                $aSheet->SetCellValue('AB'.$row, $_colVal['price']);
                                $aSheet->SetCellValue('AG'.$row,'=V'.$row.'*AB'.$row);
                                $aSheet->SetCellValue($column.$row, $_colVal['name']);
                                $aSheet->SetCellValue($column.$row, $_colVal['name']);
                                $aSheet->getRowDimension($row)->setRowHeight(getheight_t($_colVal['name'], 55, 12));
                                $row++;
                           }
                       }
                   
                   if (isset ($data[$key_insert]) && is_string($data[$key_insert])) 
                   {
			$cell->setValue ($data[$key_insert]);
                   }

                    }
                }
                   
            }
            
        $objPHPExcel->setActiveSheetIndex(1);
        $aSheet = $objPHPExcel->getActiveSheet();
         if ($cnt > 1)
        {
            $aSheet->insertNewRowBefore(24, $cnt-1);
             for ($str=24;$str<24+$cnt-1;$str++)
            {
               $aSheet->mergeCellsByColumnAndRow(2, $str, 6,$str);
               $aSheet->mergeCellsByColumnAndRow(8, $str, 11,$str);
               $aSheet->mergeCellsByColumnAndRow(14, $str, 16,$str);
               $aSheet->mergeCellsByColumnAndRow(17, $str, 19,$str);
               $aSheet->mergeCellsByColumnAndRow(20, $str, 22,$str);
               $aSheet->mergeCellsByColumnAndRow(23, $str, 24,$str);
               $aSheet->mergeCellsByColumnAndRow(25, $str, 27,$str);
               $aSheet->mergeCellsByColumnAndRow(28, $str, 33,$str);
               $aSheet->mergeCellsByColumnAndRow(35, $str, 37,$str);
               $aSheet->mergeCellsByColumnAndRow(38, $str, 39,$str); 
            }
        }
       foreach($aSheet->getRowIterator() as $row)
        {
           $cellIterator = $row->getCellIterator();
           foreach($cellIterator as $cell)
           {
                $val = $cell->getValue();
                if (preg_match( "#^%([^%]+)%$#sei", $val, $match ))
                {
                   $column = $cell->getColumn();
                   $row = $cell->getRow();
                   $key_insert = $match['1'];
				    if ($key_insert == 'total')
                    {
                       $cell->setValue('=SUM(AC23:AC'.(23+$cnt-1).')');
					   
                       $summ = $cell->getCalculatedValue();
					   $aSheet->setCellValue('AM'.$row,'=AC'.$row.'+AJ'.$row);
					   $aSheet->setCellValue('AM'.($row+1),'=AM'.$row);
					   $aSheet->setCellValue('AC'.($row+1),'=AC'.$row);
					   $aSheet->setCellValue('R'.$row,'=SUM(R23:R'.(23+$cnt-1).')');
					   $aSheet->setCellValue('R'.($row+1),'=R'.$row);
                        
                    }
                   
				    if ($key_insert == 'text')
                    {                       
                        if (!empty($_GET['shipping']) && is_int($_GET['shipping'] + 0))
                           $summ+= $_GET['shipping'];

                       $cell->setValue(num2str($summ));
                    }
                
                    if ($key_insert == 'nameg')
                       {
                           $crew_template = $aSheet->getStyle($column.$row);
                           $idx =1;
                           foreach ($data[$key_insert] as $_colVal) 
                           {
                               $aSheet->duplicateStyle($crew_template,$column.$row);
                               

                                $aSheet->getStyle($column.$row)->getAlignment()->setWrapText(true);
                                $aSheet->SetCellValue('B'.$row, $idx++);
								$aSheet->SetCellValue('I'.$row, 'шт');
								$aSheet->SetCellValue('M'.$row, '796');
                                $aSheet->SetCellValue('R'.$row, $_colVal['col']);
                                $aSheet->SetCellValue('Z'.$row, $_colVal['price']);
                                $aSheet->SetCellValue('N'.$row, '-');
                                $aSheet->SetCellValue('O'.$row, '-');
                                $aSheet->SetCellValue('U'.$row, '-');
                                $aSheet->SetCellValue('X'.$row, '-');
                                $aSheet->SetCellValue('AH'.$row, '-');
                                $aSheet->SetCellValue('AI'.$row, '-');
    
                                $aSheet->SetCellValue('AC'.$row,'=R'.$row.'*Z'.$row);
								$aSheet->SetCellValue('AM'.$row, '=AC'.$row);
                                
                                $aSheet->SetCellValue($column.$row, $_colVal['name']);
                                $aSheet->getRowDimension($row)->setRowHeight(getheight_t($_colVal['name'], 55, 12));
                                //$aSheet->getRowDimension($row)->setRowHeight(55);
                                $row++;
                           }
                           $key_insert = '';
                       }
					if ($key_insert == 'number')
                    {     
					$mystr = num2str($cnt);

                       $cell->setValue(substr($mystr,0, strpos($mystr,'руб')-1));
                    }
                if (isset ($data[$key_insert]) && is_string($data[$key_insert])) 
                {
                    $cell->setValue ($data[$key_insert]);
                }
            }
          }
        }
        
    $objPHPExcel->setActiveSheetIndex(0);        
            
       // $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
		
       // $objWriter->save(dirname($file).'/file.xlsx');

   //     $objPHPExcel->disconnectWorksheets();
    //    unset($objPHPExcel);
 header ( "Expires: Mon, 1 Apr 1974 05:00:00 GMT" );
 header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
 header ( "Cache-Control: no-cache, must-revalidate" );
 header ( "Pragma: no-cache" );
 header ( "Content-type: application/vnd.ms-excel" );
 header ( "Content-Disposition: attachment; filename=Закак№".$data['order']."от".date('d.m.Y').".xls" );
 
// Выводим содержимое файла
 $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
 $objWriter->save('php://output');
	       
 }
}